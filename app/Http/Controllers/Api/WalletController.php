<?php

namespace App\Http\Controllers\Api;

use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiWalletBalanceRequest;
use App\Http\Requests\ApiWalletChangeBalanceRequest;
use App\Http\Requests\ApiWalletCreateRequest;
use App\Logger;
use App\Services\CurrencyConverterService;
use App\Traits\UserTrait;
use App\Wallet;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class WalletController extends Controller
{
    use UserTrait;

    public function create(ApiWalletCreateRequest $request)
    {
        /**
         * @var Wallet $wallet
         */
        $wallet = new Wallet();
        $wallet->currency = $request->input('currency');
        $wallet->user_id = $request->input('user_id'); // $this->getUserId();
        $wallet->save();

        return response()->json($wallet);
    }

    public function balance(ApiWalletBalanceRequest $request)
    {
        $walletId = $request->input('wallet_id');
        /**
         * @var Wallet $wallet
         */
        $wallet = Wallet::findOrFail($walletId);
        return response()->json(['balance' => $wallet->balance]);
    }

    public function changeBalance(ApiWalletChangeBalanceRequest $request)
    {
        DB::transaction(function () use ($request) {
            $walletId = $request->input('wallet_id');
            $amount = $request->input('amount');
            $currency = $request->input('currency');
            $transactionType = $request->input('transaction_type');
            $cause = $request->input('cause');

            Wallet::where('id', '=', $walletId)->lockForUpdate()->get();

            /**
             * @var Wallet $wallet
             */
            $wallet = Wallet::findOrFail($walletId);

            if ($wallet->currency !== $currency) {
                $amount = (new CurrencyConverterService($amount, $currency, $wallet->currency))->convert();
            }

            switch ($transactionType) {
                case TransactionType::DEBIT:
                    $wallet->balance = bcadd($wallet->balance, $amount, 2);
                    $wallet->save();
                    break;

                case TransactionType::CREDIT:
                    $newBalance = bcsub($wallet->balance, $amount, 2);
                    if (bccomp($newBalance, 0) < 0) {
                        throw new UnprocessableEntityHttpException('It is impossible to write off more money than there is on the account');
                    }
                    $wallet->balance = $newBalance;
                    $wallet->save();
                    break;
            }

            $logger = new Logger();
            $logger->wallet_id = $walletId;
            $logger->cause = $cause;
            $logger->save();
        });

        return response()->json(['status' => 'ok']);
    }

}
