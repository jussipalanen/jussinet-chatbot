<?php 

/**
* Test class for Jussinet
*/
class JussiNet
{
    

    public $commands = [];
    public $bot;
    function __construct()
    {

        include_once("Bot.class.php");
        $this->bot = new Bot();
    }

    function init()
    {

        # Include commands file here
        include_once("bot_commands.php");
        $this->do_ajax();
    }

    function do_ajax()
    {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 1 )
        {
            # Ajax calls
            $results = [];
            if(isset($_POST['method']) && $_POST['method'] == 'sendMessage')
            {
                $results = (object)[
                    'success' => false,
                    'data' => []
                ];

                if(isset($_POST['form']))
                {
                    parse_str( $_POST['form'], $input );
                    $message = $input['message'] ? $input['message'] : '';
                    $results->data = $this->call_command($message);
                    $results->success = true;
                }

            }

            echo json_encode($results);
            exit();
        }
    }


    function do_command(String $command, String $value, $callable)
    {
        $obj = (object) [
            'command' => $command,
            'value' => $value,
            'callable' => $callable
        ];
        $this->commands[] = $obj;
    }

    function call_command($message)
    {
        $fn_params = [];
        foreach ( $this->commands as $cmd) 
        {
            if( $cmd->command == 'call_command' )
            {

                $parts_msg = explode(" ", $message);
                if(isset($parts_msg[0][0]) && $parts_msg[0][0] == '!')
                {
                    $parts_value = explode(" ", $cmd->value);
                    foreach ($parts_value as $part_key => $part_value) {
                        if(isset($part_value[0]) == $parts_msg[0] )
                        {

                            $message = str_replace($parts_msg[0], "", $message);

                            $fn_params[] = $this->bot;
                            $fn_params[] = trim($message) ?? false;

                            return call_user_func_array($cmd->callable, $fn_params );
                        }
                    }
                }

                if( strtolower($cmd->value) == strtolower($message) )
                {
                    if(is_callable($cmd->callable))
                    {
                        $this->bot->set_params( $message );
                        $fn_params[] = $this->bot;
                        return call_user_func_array($cmd->callable, $fn_params);
                    }
                    else {
                        throw new Exception("$cmd->callable is not callable");
                    }

                }
            }
        }

        return "I dont know what command.";
    }

}

?>