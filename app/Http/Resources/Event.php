<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Event extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dateTo'=> $this->dateTo,
            'dateFrom' => $this->dateFrom,
            'eventName' => $this->eventName,
            'weeks' => $this->weeks
        ];
    }
}
