<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOperationRequest;
use App\Http\Requests\UpdateOperationRequest;
use App\Http\Resources\OperationResource;
use App\Operation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return OperationResource::collection(
            Operation::query()
                ->when($request->account_id, function (Builder $query, $accountId) : Builder {
                    return $query->where(function (Builder $query) use ($accountId) : Builder {
                        return $query->where('from_account_id', $accountId)
                            ->orWhere('to_account_id', $accountId);
                    });
                })
                ->when($request->envelope_id, function (Builder $query, $envelopeId) : Builder {
                    return $query->where(function (Builder $query) use ($envelopeId) : Builder {
                        return $query->where('from_envelope_id', $envelopeId)
                            ->orWhere('to_envelope_id', $envelopeId);
                    });
                })
                ->when($request->date, function (Builder $query, $date) : Builder {
                    return $query->whereDate('date', new Carbon($date));
                })
                ->when($request->min_date, function (Builder $query, $minDate) : Builder {
                    return $query->whereDate('date', '>=', new Carbon($minDate));
                })
                ->when($request->max_date, function (Builder $query, $maxDate) : Builder {
                    return $query->whereDate('date', '<=', new Carbon($maxDate));
                })
                ->when($request->name, function (Builder $query, $name) : Builder {
                    return $query->where('name', 'LIKE', '%' . $name . '%');
                })
                ->latest('date')
                ->latest('id')
                ->get()
                ->when(is_array($request->types), function (Collection $operations) use ($request) : Collection {
                    return $operations->whereIn('type_name', $request->types);
                })
                ->when($request->per_page, function (Collection $operations) use ($request) : LengthAwarePaginator {
                    return new LengthAwarePaginator(
                        $operations->slice($request->per_page * $request->page, $request->per_page),
                        $operations->count(),
                        intval($request->per_page)
                    );
                })
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Http\Requests\StoreOperationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOperationRequest $request)
    {
        return new OperationResource(
            Operation::create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function show(Operation $operation)
    {
        return new OperationResource(
            $operation
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOperationRequest  $request
     * @param  \App\Operation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOperationRequest $request, Operation $operation)
    {
        return new OperationResource(
            tap($operation)->update($request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Operation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operation $operation)
    {
        $operation->delete();

        return response()->noContent();
    }
}
