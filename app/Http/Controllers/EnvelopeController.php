<?php

namespace App\Http\Controllers;

use App\Envelope;
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
        return EnvelopeResource::collection(
            Envelope::orderBy('name')->get()
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
}
