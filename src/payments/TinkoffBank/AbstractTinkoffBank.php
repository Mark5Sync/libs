<?php

namespace marksync_libs\payments\TinkoffBank;

use marksync_libs\_markers\payments;


/**
 * @property-read Receipt $receipt
*/
abstract class AbstractTinkoffBank {
    use payments;

    protected $baseUrl = 'https://securepay.tinkoff.ru/v2';
    protected ?int $terminalId  = null;
    protected ?string $password = null;

    protected string $language = 'ru';
    protected array $main = [];

    function fetch(string $method, array $props)
    {
        if (is_null($this->terminalId))
            throw new \Exception("TerminalId не должен быть NULL", 701);

        if (is_null($this->password))
            throw new \Exception("password не должен быть NULL", 702);
        
        $main = [
            'TerminalKey' => $this->terminalId,
            "Language" => $this->language,
        ];

        $postdata = $this->injectToken([
            ...$main,
            ...$this->main,
            ...$props,
            'Amount' =>  $this->receipt->fullAmount,
            'Receipt' => $this->receipt,
        ]);


        $opts = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-Type: application/json',
                'content' => json_encode($postdata)
            ]
        ];

        $context = stream_context_create($opts);

        $url = "$this->baseUrl/$method";

        $stream = fopen($url, 'r', false, $context);
        $data = stream_get_contents($stream);
        fclose($stream);

        $result = json_decode($data, true);
        return $result;
    }



    private function injectToken(array $props)
    {
        // https://tokentcs.web.app - для проверки
        // $json = json_encode($props);

        $keys = [...array_diff(array_keys($props), ['Receipt', 'DATA']), 'Password']; 
        sort($keys);

        $tokenBody = array_map(fn($key) => $key == 'Password' ? $this->password : $props[$key], $keys);

        $TOKEN = hash('sha256', implode('', $tokenBody));

        return [
            ...$props,
            "Token" => $TOKEN,
        ];
    }
}