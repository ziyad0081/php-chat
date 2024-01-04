<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anon Chats</title>
</head>
<body style="padding:0;background-color: #333; color:wheat; font-size: 1.2rem;display:flex; flex-direction:column; align-items:center;justify-content:space-between;font-family:Monocraft,system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
    <form action="send.php" method="post">
    <div style="background: transparent;width:100%; color:wheat; font-size:1.2rem; height:18rem; display:flex; flex-direction:column; align-items:center;justify-content:space-around;">
    <?php 
        // This displays the name and color input if user first time enters the app
        if(!isset($_SESSION['name'])){
            echo '<input placeholder="Your Name" name="name" type="text" style="padding: 0rem 1rem;background: transparent; border:2px solid wheat; border-radius:15px; height:3rem; color:wheat; font-size:1.2rem;font-family:Monocraft,system-ui, -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Oxygen, Ubuntu, Cantarell, \'Open Sans\', \'Helvetica Neue\', sans-serif;" required>
            <div style="display:flex; flex-direction:row; align-items:center; margin-bottom:1rem;">
                <label for="color" style="margin-right:1rem;">Choose a color :</label>
                <input type="color" name ="color" value="#DC143C" style="border:none;outline:none; width:2rem;height:2rem;border-color:transparent;" required>
            </div>
            ';
        }
        // Else display the logged user stats
        else{
            echo "<p> You are currently identified as : <span style='color:".$_SESSION['color'].";'>" . $_SESSION['name'] . "</span> </p>";
        }
        
    ?>
    
    
    <input placeholder="Message" name="msg" type="text" style="padding: 0rem 1rem;background: transparent; border:2px solid wheat; font-family:Monocraft,system-ui, -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Oxygen, Ubuntu, Cantarell, \'Open Sans\', \'Helvetica Neue\', sans-serif;border-radius:15px; height:3rem; color:wheat; font-size:1.2rem;" autocomplete="off" required>
    <div style="padding: 1rem; background: transparent; border:2px solid wheat; border-radius:15px; color:wheat; font-size:1.2rem;position:relative;">
    <svg xmlns="http://www.w3.org/2000/svg" height="21" width="21" viewBox="0 0 512 512"><path fill="wheat" d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480V396.4c0-4 1.5-7.8 4.2-10.7L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4z"/></svg>
    <input value="Send" type="submit" style="padding: 1rem; background: transparent; border:2px solid wheat; border-radius:15px; color:wheat; font-size:1.2rem;opacity:0;z-index:9999;position:absolute;top:0;left:-35%;height:100px;width:100px">
    </div>
    
    </div>
    </form>
    <div id="messages" style="overflow:scroll;padding:2rem 2rem;margin-top:2rem;background: transparent; border:2px solid wheat; border-radius:15px; height:40vh; color:wheat; font-size:1.2rem; display:flex; flex-direction:column; align-items:start;justify-content:start;width:40vw">
    <script>
        function update() {
            //This function requests message data from the end point and displays it
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) { // Check if the request is complete
                    if (xhr.status === 200) { // Check if the request was successful
                        var messages = JSON.parse(xhr.responseText);
                        var container = document.getElementById("messages");
                        container.innerHTML = '';

                        var added_html = '';
                        if(messages.length == 0){
                            added_html = 'No Messages Available !';
                        }
                        messages.forEach(function(message) {
                            added_html += message.sender == `<?php echo $_SESSION["name"]; ?>` ? `<p> By <span style='color: <?php echo $_SESSION['color']  ?>'>${message.sender}</span> at : ${message.sent_at} >> ${message.body}</p>` : `<p> By <span style='color: crimson'>${message.sender}</span> at : ${message.sent_at} >> ${message.body}</p>`;
                        });
                        container.innerHTML = added_html;
                    } else {
                        // Handle error
                        document.getElementById("messages").innerText = 'Error loading messages';
                    }
                }
            };
            xhr.open('GET', 'recieve.php', true);
            xhr.send();
        }

        update();
        setInterval(update, 1900);
    </script>
    
    </div>

</body>
</html>