<?php

/**
* 
*/
class Bot
{
    private $id = 1;
    private $name = 'Mr.Bot';
    private $params = [];

    function __construct()
    {
    }

    function set_param($key = false, $value = false)
    {
        $value = trim( $value );
        if( $value )
        {
            if( !$key )
            {
                $this->params[] = $value;
            }
            else {
                $this->params[$key] = $value;
            }
        }

    }

    function get_params()
    {
        return $this->params;
    }

    function set_params($params)
    {
        $this->params = $params;
    }

    function ask(String $string, Callable $bot)
    {
        return call_user_func_array( $bot, [$string,$this]);
    }

    function say(String $string)
    {
        return $string;
    }


}