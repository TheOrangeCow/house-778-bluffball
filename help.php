<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="image/iconW.ico">
    <title>Bluffball - Help</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .hidden {
            display: none!important;
        }
        .visible {
            display: block;
        }
        
        .message {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }


        
    </style>
</head>
<body class="container">
    <div>
        <div class="header">
            <div class="title">
                <img src="image/icon.webp" alt="Title Icon">
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

        <center>
            <h1>Help</h1>
            <div class="messages">
                <div class="message red visible" id="message-0.5">
                    <div class="text-bubble">
                        What do you need help with?
                    </div>
                    <div class="avatar">
                        <img src="image/iconUser.png" alt="User Avatar">
                    </div>
                </div>
                
                <div class="message green visible" id="message-1">
                    <div class="avatar">
                        <img src="image/iconUser2.png" alt="User Avatar">
                    </div>
                    <div class="text-bubble">
                        <textarea id="helpInput" name="helpInput" rows="4" cols="40" required></textarea><br id ="stupidthing">
                        <button id="submitButton">Submit</button>
                        <div id="text" class=" hidden">
                        </div>
                    </div>
                </div>

                <div class="message red hidden" id="message-2">
                    <div class="text-bubble">
                        Sorry, I cannot help with that, but I can pass it on. However, if it breaks our terms and conditions, you may be suspended. Please enter your email and your username separated by a space.
                    </div>
                    <div class="avatar">
                        <img src="image/iconUser.png" alt="User Avatar">
                    </div>
                </div>
                
             
                <div class="message green hidden" id="message-3">
                    <div class="avatar">
                        <img src="image/iconUser2.png" alt="User Avatar">
                    </div>
                    <div class="text-bubble">
                        <textarea id="helpInput3" name="helpInput" rows="4" cols="40" required></textarea><br id ="stupidthing3">
                        <button id="submitButton3">Submit</button>
                        <div id="text3" class=" hidden">
                        </div>
                    </div>
                </div>


                <div class="message red hidden" id="message-4">
                    <div class="text-bubble">
                        Sent to someone who can help.
                    </div>
                    <div class="avatar">
                        <img src="image/iconUser.png" alt="User Avatar">
                    </div>
                </div>
            </div>
        </center>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const submitButton = document.getElementById('submitButton');
            const message1 = document.getElementById('message-1');
            const message2 = document.getElementById('message-2');
            const message3 = document.getElementById('message-3');
            const message4 = document.getElementById('message-4');
            const helpInput = document.getElementById('helpInput');
            const stupidthing = document.getElementById('stupidthing');
            const helpInput3 = document.getElementById('helpInput3');
            const stupidthing3 = document.getElementById('stupidthing3');
            const submitButton3 = document.getElementById('submitButton3');

            if (message2) {
                message2.classList.add('hidden');
            }
            if (message1) {
                message1.classList.add('visible');
            }

            submitButton.addEventListener('click', function () {
                const text = document.getElementById('text');
                if (text) {
                    text.innerHTML = helpInput.value;
                    text.classList.remove('hidden');
                }
                if (helpInput) helpInput.classList.add('hidden');
                if (stupidthing) stupidthing.classList.add('hidden');
                if (submitButton) submitButton.classList.add('hidden');
                if (message2) {
                    message2.classList.remove('hidden');
                    message2.classList.add('visible');
                }
                if (message3) message3.classList.remove('hidden');

                
            });
            
            
           submitButton3.addEventListener('click', function () {
                const userMessage = helpInput.value.trim();
                const userMessage3 = helpInput3.value.trim();

                const emailUsernamePattern = /^[\w._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}\s+[\w]+$/;

            
                if (!emailUsernamePattern.test(userMessage3)) {

                    alert("You need to format it properly. Please enter the email and username separated by a space.");
            

                    const newInputBox = document.createElement('textarea');
                    newInputBox.id = 'helpInput3';
                    newInputBox.name = 'helpInput3';
                    newInputBox.rows = 4;
                    newInputBox.cols = 40;
            
                    
                    const oldInputBox = document.getElementById('helpInput3');
                    if (oldInputBox) {
                        oldInputBox.replaceWith(newInputBox);
                    }
            

                    newInputBox.focus();
                    return;
                }
            
                if (userMessage === "") {
                    alert("Please enter a message.");
                    return;
                }
            
                const formData = new FormData();
                formData.append('helpInput', userMessage);
                formData.append('helpUser', userMessage3);
            
                fetch('send.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        const text3 = document.getElementById('text3');
                        if (text) {
                            text3.innerHTML = helpInput3.value;
                            text3.classList.remove('hidden');
                        }
                        if (helpInput3) helpInput3.classList.add('hidden');
                        if (stupidthing3) stupidthing3.classList.add('hidden');
                        if (submitButton3) submitButton3.classList.add('hidden');
                        if (message4) {
                            message4.classList.remove('hidden');
                            message4.classList.add('visible');
                        }
                    } else {
                        alert('Failed to send. Please try again.');
                    }
                })
                .catch(error => {
                    alert('An error occurred: ' + error.message);
                });
            });

        });
    </script>
</body>
</html>
