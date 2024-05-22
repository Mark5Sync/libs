<?php

namespace marksync_libs\payments\AlphaBank;


abstract class AbstractAlphaBank
{

    protected $baseUrl = 'https://payment.alfabank.ru/payment/rest';
    protected string $token;


    /** 
     * orderNumber
     * amount
     * returnUrl
     * failUrl
     * description
     * token
     * sessionTimeoutSecs
     * language
     * pageView
     */
    protected array $main = [];
    public $callBackRuOperations = [
        'approved' => 'операция удержания (холдирования) суммы',
        'reversed' => 'операция отмены',
        'refunded' => 'операция возврата',
        'declinedByTimeout' => 'истекло время, отпущенное на оплату заказа',
    ];

    /** 
     * Зарегистрировать транзакцию
     */
    function register(...$props)
    {
        return $this->fetch('register.do', $props);
    }


    /** 
     * Получить статус транзакции
     */
    function getOrderStatus(...$props)
    {
        return $this->fetch('getOrderStatus.do', $props);
    }


    function fetch(string $method, array $props)
    {
        $url = $this->getUrl($method, $props);
        $result = json_decode(file_get_contents($url), true);

        return $result;
    }


    private function getUrl(string $method, array $props)
    {
        $url = "{$this->baseUrl}/$method?" . http_build_query([
            ...$this->main,
            ...$props,
        ]);

        return $url;
    }
}
