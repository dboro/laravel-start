<?php


namespace Dboro\LaravelStart\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class StartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = parent::toArray($request);

        return $array;
    }
}