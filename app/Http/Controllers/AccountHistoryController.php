<?php

namespace App\Http\Controllers;

use App\Account;
use App\Envelope;
use App\Money;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
        $periods = $this->computePeriods(collect($request->dates));

        return $this->formatResponse([
            'allocations' => $periods->map(function (CarbonPeriod $period) : Money {
                return Envelope::computeGlobal('allocations', $period);
            }),
            'cumulated_balance' => $periods->map(function (CarbonPeriod $period) : Money {
                return Account::computeGlobal(
                    'balance',
                    CarbonPeriod::create(Carbon::minValue(), $period->getEndDate())
                );
            }),
            'cumulated_savings' => $periods->map(function (CarbonPeriod $period) : Money {
                return Money::sum(collect([
                    Account::computeGlobal(
                        'balance',
                        CarbonPeriod::create(Carbon::minValue(), $period->getEndDate())
                    ),
                    Envelope::computeGlobal(
                        'balance',
                        CarbonPeriod::create(Carbon::minValue(), $period->getEndDate())
                    )->opposite()
                ]));
            }),
            'expenses' => $periods->map(function (CarbonPeriod $period) : Money {
                return Account::computeGlobal('expenses', $period);
            }),
            'incomes' => $periods->map(function (CarbonPeriod $period) : Money {
                return Account::computeGlobal('directIncomes', $period);
            }),
            'period_balance' => $periods->map(function (CarbonPeriod $period) : Money {
                return Account::computeGlobal('balance', $period);
            }),
            'period_savings' => $periods->map(function (CarbonPeriod $period) : Money {
                return Money::sum(collect([
                    Account::computeGlobal('balance', $period),
                    Envelope::computeGlobal('balance', $period)->opposite()
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
        $periods = $this->computePeriods(collect($request->dates));

        return $this->formatResponse([
            'cumulated_balance' => $periods->map(function (CarbonPeriod $period) use ($account) : Money {
                return $account->compute('balance', CarbonPeriod::create(Carbon::minValue(), $period->getEndDate()));
            }),
            'expenses' => $periods->map(function (CarbonPeriod $period) use ($account) : Money {
                return $account->compute('expenses', $period);
            }),
            'incomes' => $periods->map(function (CarbonPeriod $period) use ($account) : Money {
                return $account->compute('directIncomes', $period);
            }),
            'incomingTransfers' => $periods->map(function (CarbonPeriod $period) use ($account) : Money {
                return $account->compute('incomingTransfers', $period);
            }),
            'outgoingTransfers' => $periods->map(function (CarbonPeriod $period) use ($account) : Money {
                return $account->compute('outgoingTransfers', $period);
            }),
            'period_balance' => $periods->map(function (CarbonPeriod $period) use ($account) : Money {
                return $account->compute('balance', $period);
            }),
        ]);
    }
}
