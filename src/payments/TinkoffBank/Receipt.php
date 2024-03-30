<?php

namespace marksync_libs\payments\TinkoffBank;

use JsonSerializable;
use marksync\provider\Mark;

#[Mark(mode: Mark::LOCAL)]
class Receipt implements JsonSerializable {

    private $email;
    private $phone;
    private Taxition $taxation;



    public $fullAmount = 0;
    private $items = [];

    
    function set(string $email, string $phone, Taxition $taxation)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->taxation = $taxation;
    }

    /**
     * @param string $name 
     * - Наименование товара
     * @param int $price 
     * - Цена в копейках
     * @param int $quantity
     * - Количество/вес:
     * - целая часть не более 5 знаков;
     * - дробная часть не более 3 знаков для Атол, не более 2 знаков для CloudPayments.
     * @param int $amount
     * - Сумма в копейках. Целочисленное значение не более 10 знаков
     */
    function addItem(string $name, int $price, int $quantity, int $amount, Tax $tax = Tax::none)
    {
        $this->fullAmount += ($amount * $quantity);

        $this->items[] = [
            "Name" => $name,
            "Price" => $price,
            "Quantity" => $quantity,
            "Amount" => $amount,
            "Tax" => $tax->value,
        ];
        return $this;
    }


    function jsonSerialize() {
        return [
            "Email" => $this->email,
            "Phone" => $this->phone,
            "Taxation" => $this->taxation->value,
            "Items" =>  $this->items
        ];
    }
}