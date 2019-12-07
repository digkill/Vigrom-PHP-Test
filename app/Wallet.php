<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Wallet
 *
 * @property int $id
 * @property int $user_id
 * @property string $currency
 * @property float $balance
 */
class Wallet extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wallets';

    protected $fillable = [
        'currency', 'balance'
    ];
}
