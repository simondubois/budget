<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MoneyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->amounts->map(function (float $amount) : float {
            return round($amount, 2);
        });
    }
}
