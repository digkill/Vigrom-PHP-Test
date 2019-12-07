<?php

namespace App\Enum;

class TransactionType
{
    use EnumTrait;

    const DEBIT = 'debit';
    const CREDIT = 'credit';
}
