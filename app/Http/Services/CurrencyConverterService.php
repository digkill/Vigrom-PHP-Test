<?php

namespace App\Services;

use App\Enum\Currency;
use App\Enum\Rate;

class CurrencyConverterService
{
    private $amount;
    private $from;
    private $to;

    public function __construct($amount, $from, $to)
    {
        $this->amount = $amount;
        $this->from = $from;
        $this->to = $to;
    }


    public function convert()
    {
        if ($this->from === Currency::USD && $this->to === Currency::RUB) {
            return bcmul(Rate::USD, $this->amount, 2);
        }
        if ($this->from === Currency::RUB && $this->to === Currency::USD) {
            return bcdiv($this->amount, Rate::USD, 2);
        }

        throw new \Exception('Never operation');
    }
}
