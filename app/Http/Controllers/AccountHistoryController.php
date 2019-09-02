<?php

namespace App\Http\Controllers;

use App\Account;
use App\Envelope;
use App\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountHistoryController extends HistoryController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dates = $this->computeDates(collect($request->dates));

        return $this->formatResponse([
            'allocations' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Envelope::computeGlobal('allocations', $min, $max);
            }),
            'cumulated_balance' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Account::computeGlobal('balance', Carbon::minValue(), $max);
            }),
            'cumulated_savings' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Money::sum(collect([
                    Account::computeGlobal('directIncomes', Carbon::minValue(), $max),
                    Envelope::computeGlobal('allocations', Carbon::minValue(), $max)->opposite()
                ]));
            }),
            'expenses' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Account::computeGlobal('expenses', $min, $max);
            }),
            'incomes' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Account::computeGlobal('directIncomes', $min, $max);
            }),
            'period_balance' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Account::computeGlobal('balance', $min, $max);
            }),
            'period_savings' => $dates->mapSpread(function (Carbon $min, Carbon $max) : Money {
                return Money::sum(collect([
                    Account::computeGlobal('directIncomes', $min, $max),
                    Envelope::computeGlobal('allocations', $min, $max)->opposite()
                ]));
            }),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Account $account)
    {
        $dates = $this->computeDates(collect($request->dates));

        return $this->formatResponse([
            'cumulated_balance' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($account) : Money {
                return $account->compute('balance', Carbon::minValue(), $max);
            }),
            'expenses' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($account) : Money {
                return $account->compute('expenses', $min, $max);
            }),
            'incomes' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($account) : Money {
                return $account->compute('directIncomes', $min, $max);
            }),
            'incomingTransfers' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($account) : Money {
                return $account->compute('incomingTransfers', $min, $max);
            }),
            'outgoingTransfers' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($account) : Money {
                return $account->compute('outgoingTransfers', $min, $max);
            }),
            'period_balance' => $dates->mapSpread(function (Carbon $min, Carbon $max) use ($account) : Money {
                return $account->compute('balance', $min, $max);
            }),
        ]);
    }
}
