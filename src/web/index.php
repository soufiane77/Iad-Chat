<?php
    use PHPRouter\Config;
    use PHPRouter\Router;
    require_once '../../bootstrap.php';
    $config = Config::loadFromFile(__DIR__.'/../Config/router.yaml');
    $router = Router::parseConfig($config);
    $router->matchCurrentRequest();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Iad Chat</title>
    <style>
        #chat{
            border: 3px solid black;
            margin: 14px auto;
            width: 500px;
            height: 500px;
        }

        body {
            list-style: none;
        }

        #formMessage {
            display: none;
        }

        #formMessage, #formLogin {
            margin-left: 10px;
        }

        #formMessage input[type=text], #formLogin input[type=text] {
            margin-right: 10px;
        }

        #formMessage input[type=text] {
            width: 300px;
        }

        #chat ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        #chat ul li {
            margin: 0;
            margin-bottom: 5px
        }

        #chat ul li:last-child {
            margin-bottom: 0;
        }

        #chat .messageBox {
            border: 2px solid blue;
            margin: 10px;
            padding: 5px;
            height: 400px;
            overflow: auto;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; margin-top: 15px;">IAD CHAT</h1>
    <div id="chat">
        <div class="messageBox">
            <ul></ul>
        </div>

        <?php if (!isset($_SESSION['uid'])) :?>
            <div id="formLogin">
                <input type="text" placeholder="Enter your login"/><button type="submit" onclick="login()">Login</button>
            </div>
        <?php endif ?>

        <div id="formMessage">
            <input type="text" placeholder="Message"/><button type="submit" onclick="sendMessage()">Send</button>
        </div>

    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript">
        var apiUrl = 'http://localhost:8000';

        function getMessages() {
            $.getJSON(apiUrl + '/messages', function( messages ) {
                messages.forEach(function(message) {
                    addMessage(message);
                });
            });
        }

        function onLogin() {
            $('#formLogin').hide();
            $('#formMessage').show().focus();
        }

        function onLogout() {
            $('#formLogin').show().focus();
            $('#formMessage').hide();
        }

        function login() {
            $.ajax({
                type: "POST",
                url: apiUrl + '/login',
                data: JSON.stringify({"name": $('#formLogin input').val()}),
                success: function (rep) {
                    onLogin();
                },
                error:function(err) {
                    console.log(err);
                },
                dataType: 'json'
            });
            $('#formLogin input').val('')
        }

        function ping()
        {
            $.getJSON(apiUrl + '/ping').fail(function () {
                onLogout();
            })
        }

        function sendMessage() {
            var msg = $('#formMessage input').val().trim();
            if (msg === '') {
                alert('Message is empty');s
            }

            $.ajax({
                type: "POST",
                url: apiUrl + '/messages',
                data: JSON.stringify({"message": msg}),
                success: function (message) {
                    console.log(message);
                    addMessage(message);
                },
                dataType: 'json'
            });

            $('#formMessage input').val('');
        }

        function addMessage(message) {
            if ($('#chat ul li[data-id=' + message.id + ']').length === 0) {
                var date = moment(message.created_at);
                var li = $('<li/>', {
                    html:  date.format('H:mm:ss') + ' <b>' + message.user.name + '</b>: ' + message.text,
                    'data-id': message.id
                });
                $('#chat ul').append(li);
            }
        }

        $(document).ready(function(){
            getMessages();
            setInterval(ping, 3000);
            setInterval(getMessages, 3000);

            $('#formLogin input').on('keypress',function(e) {
                if(e.which == 13) {
                    login();
                }
            });

            $('#formMessage input').on('keypress',function(e) {
                if(e.which == 13) {
                    sendMessage();
                }
            });
        });
    </script>
</body>
</html>
