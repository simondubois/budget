<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Resources\AccountCollection;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AccountCollection(
            Account::orderBy('name')->get()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return new AccountResource(
            $account
        );
    }
}
