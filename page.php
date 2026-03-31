<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        putenv($line);
    }
}

$host = "127.0.0.1:3306";
$user = getenv('db_user');
$pass = getenv('db_pass');
$db = "bluffball";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getRandomPhrase($options) {
    return $options[array_rand($options)];
}

function generateComment($match) {
    $home = $match['homeTeam'];
    $away = $match['awayTeam'];
    
    $score = json_decode($match['score'], true);

    if ($score === null) {
        return "Invalid score data for the match between $home and $away.";
    }

    $homeScore = $score['home'];
    $awayScore = $score['away'];

    if ($homeScore > $awayScore) {
        $resultQuote = getRandomPhrase([ 
            "$home took the win with a solid $homeScore-$awayScore score!",
            "$home clinched the victory with a convincing $homeScore-$awayScore performance!",
            "$home emerged victorious in a $homeScore-$awayScore showdown.",
            "A great performance by $home saw them win $homeScore-$awayScore.",
            "$home secured the match with a strong $homeScore-$awayScore finish!"
        ]);
    } elseif ($homeScore < $awayScore) {
        $resultQuote = getRandomPhrase([
            "$away came out on top with a dramatic $awayScore-$homeScore victory!",
            "$away triumphed over $home with an exciting $awayScore-$homeScore result!",
            "$away secured a hard-fought $awayScore-$homeScore win over $home.",
            "$away proved their strength with a $awayScore-$homeScore victory.",
            "$away edged past $home with a memorable $awayScore-$homeScore win."
        ]);
    } else {
        $resultQuote = getRandomPhrase([
            "It was a nail-biting draw between $home and $away, ending in a $homeScore-$awayScore tie.",
            "Neither team could break the deadlock, resulting in a thrilling $homeScore-$awayScore draw.",
            "The match ended in a $homeScore-$awayScore tie, with both teams giving their all.",
            "An intense battle ended in a $homeScore-$awayScore stalemate.",
            "Both teams walked away even, tied at $homeScore-$awayScore."
        ]);
    }

    if (abs($homeScore - $awayScore) >= 5) {
        if ($homeScore > $awayScore) {
            $resultQuote .= getRandomPhrase([
                " The $home team absolutely smashed $away.",
                " $home delivered an overwhelming performance, crushing $away.",
                " It was a landslide victory for $home against $away.",
                " $home utterly destroyed $away in a one-sided match.",
                " $home blew $away out of the water in an incredible victory."
            ]);
        } else {
            $resultQuote .= getRandomPhrase([
                " The $away team absolutely smashed $home.",
                " $away completely outplayed $home in a dominant display.",
                " $away dominated the game, leaving $home far behind.",
                " $away showed no mercy, annihilating $home.",
                " $away obliterated $home in an unforgettable match."
            ]);
        }
    }
    return $resultQuote;
}


$sql = "SELECT * FROM matches ORDER BY utcDate DESC";
$result = $conn->query($sql);

$html = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = date('d M Y, H:i', strtotime($row['utcDate']));
        $competition = $row['competition'];
        $homeTeam = $row['homeTeam'];
        $awayTeam = $row['awayTeam'];
        $score = json_decode($row['score'], true);
        $homeScore = $score['home'];
        $awayScore = $score['away'];
        $scoreText = "$homeScore - $awayScore";
        $comment = generateComment($row);

        $html .= "<tr>
                    <td>$date</td>
                    <td>$competition</td>
                    <td>$homeTeam</td>
                    <td>$awayTeam</td>
                    <td>$scoreText</td>
                    <td>$comment</td>
                  </tr>";
    }
} else {
    $html = "<tr><td colspan='6'>No matches found.</td></tr>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="image\iconW.ico">
    <title>Bluffball - Table</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <div>
        <div class="header">
            <div class="title">
                <img src="image\icon.webp">
                <br>
            </div>
        </div>

        <div class="nav header">
            <a href="index.php">Home</a>
            <a href="itcrowed.php">About</a>
            <a href="page.php">Table</a>
            <a href="help.php">Help</a>
            <a href="/dater">Update</a>
        </div>

        <div>
            <h2 style='text-align: center;'>UK</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Competition</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Score</th>
                    <th>Comment</th>
                </tr>
                
                <?php echo $html; ?>
            </table>
        </div>
    </div>
</body>
</html>
