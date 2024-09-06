<?php

namespace marksync_libs\bots;


/**
 * https://core.telegram.org/methods
 */
abstract class Telegram
{

    protected int $chatId;
    protected string $token;


    /** 
     * https://core.telegram.org/method/messages.sendMessage
     */
    function send(string $message)
    {
        return $this->fetch(
            'sendMessage',
            chat_id: $this->chatId,
            text: $message,
        );
    }


    function fetch(string $method, ...$props)
    {
        $params = http_build_query($props);
        $result = file_get_contents("https://api.telegram.org/bot{$this->token}/{$method}?$params");

        if ($result)
            return json_decode($result, true);
    }
}
