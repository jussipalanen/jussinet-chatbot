<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# Load functions and calsses
include_once("functions.php");
include_once("JussiNet.class.php");
$js = new JussiNet();
$js->init();
?>
<!DOCTYPE html>
<html>
<head>
    <title>JussiNet Bot</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

<h2>Jussinet Bot</h2>
<form action="/" id="chat" method="post">
    <input type="text" name="message" value="">
    <input type="submit" value="Lähetä">
</form>

<div id="robot-response">
</div>

<script type="text/javascript">
    $("#chat").submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "?ajax=1",
            data: {
                method: "sendMessage",
                form: $(this).serialize()
            },
            dataType: "json",
            success: function (response) {
                if( response.success )
                {
                    console.log( response.data );
                    $("#robot-response").html("<p>" + response.data + "</p>" );
                }
            }
        });
    });
</script>

</body>
</html>