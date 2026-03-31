<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="image\iconW.ico">
    <title>Bluffball - it crowd</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <div>
        <div class="header">
            <div class="title">
                <img src="image\icon.webp" alt="Title Icon">
                <br>
            </div>
        </div>
        
        <div class="nav header" id ="nav">
            <a href="index.php">Home</a>
            <a href="itcrowed.php">About</a>
            <a href="page.php">Table</a>
            <a href="help.php">Help</a>
            <a href="/dater">Update</a>
        </div>
        <center>
            <div id ="about">
                <h1>About</h1>
                <p>This website is inspired by The IT Crowd (Season 3, Episode 2). In this hilarious episode, a new football website helps Roy and Moss convincingly pass as "proper" men for a few unforgettable days. Inspired by their experience, we at House-778 decided to bring this concept to life.</p>
            </div>
            <div class="messages">
                <div class="message green">
                    <div class="avatar">
                        <img src="image\iconUser2.png" alt="User Avatar">
                    </div>
                    <div class="text-bubble">
                        <div class="text">Did you see that ludicrous display last night?</div>
                    </div>
                </div>
                
                <div class="message red">
                    <div class="text-bubble">
                        <div class="text">What's Wenger doing sending Walcott on that early?</div>
                    </div>
                    <div class="avatar">
                        <img src="image\iconUser.png" alt="User Avatar">
                    </div>
                </div>
                
                <div class="message green">
                    <div class="avatar">
                        <img src="image\iconUser2.png" alt="User Avatar">
                    </div>
                    <div class="text-bubble">
                        <div class="text">Thing about Arsenal, they always try to walk it in.</div>
                    </div>
                </div>
            </div>
            <a href="#" id="hideLink">Hide info</a>
        </center>
    </div>
<script>
  document.getElementById("hideLink").addEventListener("click", function (event) {
    event.preventDefault(); 
    document.getElementById("about").style.display = "none";
    document.getElementById("nav").style.display = "none";
     document.getElementById("hideLink").style.display = "none";
  });
</script>

</body>
</html>
