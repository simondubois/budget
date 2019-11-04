<?php

namespace App\Observers;

use App\Account;
use App\Envelope;
use App\Operation;
use Carbon\Carbon;

class OperationObserver
{
    /**
     * Handle the operation "created" event.
     *
     * @param  \App\Operation  $operation
     * @return void
     */
    public function created(Operation $operation)
    {
        if ($operation->originAccount) {
            $operation->originAccount->updateAggregates($operation->date);
        }
        if ($operation->originEnvelope) {
            $operation->originEnvelope->updateAggregates($operation->date);
        }
        if ($operation->recipientAccount) {
            $operation->recipientAccount->updateAggregates($operation->date);
        }
        if ($operation->recipientEnvelope) {
            $operation->recipientEnvelope->updateAggregates($operation->date);
        }
    }

    /**
     * Handle the operation "updated" event.
     *
     * @param  \App\Operation  $operation
     * @return void
     */
    public function updated(Operation $operation)
    {
        $this->updatedAggregatable($operation, Account::class, 'from_account_id');
        $this->updatedAggregatable($operation, Envelope::class, 'from_envelope_id');
        $this->updatedAggregatable($operation, Account::class, 'to_account_id');
        $this->updatedAggregatable($operation, Envelope::class, 'to_envelope_id');
    }

    /**
     * Handle the operation "updated" event for the given aggregatable.
     *
     * @param  \App\Operation  $operation
     * @param  string  $className
     * @param  string  $keyName
     * @return void
     */
    public function updatedAggregatable(Operation $operation, string $className = null, string $keyName)
    {
        $oldAggregatable = $className::find($operation->getOriginal($keyName));
        $newAggregatable = $className::find($operation->$keyName);

        $newDate = $operation->date;
        $oldDate = new Carbon($operation->getOriginal('date'));

        optional($newAggregatable)->updateAggregates($newDate);
        if ($newDate->notEqualTo($oldDate)) {
            optional($newAggregatable)->updateAggregates($oldDate);
        }

        if (optional($oldAggregatable)->isNot($newAggregatable)) {
            optional($oldAggregatable)->updateAggregates($newDate);
            if ($newDate->notEqualTo($oldDate)) {
                optional($oldAggregatable)->updateAggregates($oldDate);
            }
        }
    }

    /**
     * Handle the operation "deleted" event.
     *
     * @param  \App\Operation  $operation
     * @return void
     */
    public function deleted(Operation $operation)
    {
        if ($operation->originAccount) {
            $operation->originAccount->updateAggregates($operation->date);
        }
        if ($operation->originEnvelope) {
            $operation->originEnvelope->updateAggregates($operation->date);
        }
        if ($operation->recipientAccount) {
            $operation->recipientAccount->updateAggregates($operation->date);
        }
        if ($operation->recipientEnvelope) {
            $operation->recipientEnvelope->updateAggregates($operation->date);
        }
    }
}
