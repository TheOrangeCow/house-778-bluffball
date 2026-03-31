<?php

if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        putenv($line);
    }
}

$apiKey = getenv('bluff_ball_api');

$host = "127.0.0.1:3306";
$user = getenv('db_user');
$pass = getenv('db_pass');
$db = "bluffball";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dateTo = date('Y-m-d');
$dateFrom = date('Y-m-d', strtotime('-7 days'));

$competitionCodes = "PL,FAC";

$apiUrl = "https://api.football-data.org/v4/matches?dateFrom=$dateFrom&dateTo=$dateTo&competitions=$competitionCodes";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "X-Auth-Token: $apiKey"
    ],
]);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo "cURL error: " . curl_error($curl);
    curl_close($curl);
    exit;
}

curl_close($curl);

$data = json_decode($response, true);

if (!isset($data['matches']) || empty($data['matches'])) {
    echo "No matches found for the specified criteria.\n";
    exit;
}

$filteredMatches = array_map(function ($match) {
    return [
        'utcDate' => $match['utcDate'],
        'competition' => $match['competition']['name'],
        'homeTeam' => $match['homeTeam']['name'],
        'awayTeam' => $match['awayTeam']['name'],
        'score' => json_encode($match['score']['fullTime'])
    ];
}, $data['matches']);

usort($filteredMatches, function ($a, $b) {
    return strtotime($a['utcDate']) - strtotime($b['utcDate']);
});

$stmt = $conn->prepare("INSERT INTO matches (utcDate, competition, homeTeam, awayTeam, score) VALUES (?, ?, ?, ?, ?)");

foreach ($filteredMatches as $match) {
    $stmt->bind_param("sssss", $match['utcDate'], $match['competition'], $match['homeTeam'], $match['awayTeam'], $match['score']);
    if ($stmt->execute()) {
        echo "Match inserted successfully\n";
    } else {
        echo "Failed to insert match: " . $stmt->error . "\n";
    }
}

$stmt->close();
$conn->close();
?>
