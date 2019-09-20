<?php

namespace App\Http\Controllers;

use App\Envelope;
use App\Http\Requests\StoreEnvelopeRequest;
use App\Http\Requests\UpdateEnvelopeRequest;
use App\Http\Resources\EnvelopeCollection;
use App\Http\Resources\EnvelopeResource;
use Illuminate\Http\Request;

class EnvelopeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new EnvelopeCollection(
            Envelope::orderBy('name')->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEnvelopeRequest $request)
    {
        return new EnvelopeResource(
            Envelope::create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  Envelope  $envelope
     * @return \Illuminate\Http\Response
     */
    public function show(Envelope $envelope)
    {
        return new EnvelopeResource(
            $envelope
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEnvelopeRequest  $request
     * @param  \App\Envelope
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEnvelopeRequest $request, Envelope $envelope)
    {
        return new EnvelopeResource(
            tap($envelope)->update($request->validated())
        );
    }
}
