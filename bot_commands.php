<?php 

/**
 * List all of bot commands
 */

$this->do_command("call_command", "!addmessage {message}", function($bot, $message){
    return $bot->say("You added message: '" . $message . "'!");
});

$this->do_command("call_command", "Hello robot", function($bot){
    
    return $bot->ask("What's your name", function($answer, $bot)
    {   
        printvar($answer);
        exit();

        if( $answer == 'Jussi' )
        {
            return $bot->say("Oh, hello Jussi. Its really good name!");
        }
        else if( is_string($answer) && !empty($answer) ) {
            return $bot->say("Hello. So you are ".$answer.". Not bad name.");
        }
        else {
            return $bot->say("Hmm... i dont know your name.");
        }
    });

    return $bot->say("Hello mate! I'm Robot of JussiNet Chat! What's your name?");
});

$this->do_command("call_command", "What are you doing?", function($bot){
    return $bot->say("I'm talking with you. If you have any questions you can ask from me. I can answer!");
});
