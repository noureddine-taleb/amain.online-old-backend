<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [

            'data' => $this->collection,
            
            'meta' => [

                'current_page' => $this->currentPage(),
                "from" => $this->firstItem(),
                "to" => $this->lastItem(),

                'page_size' => $this->perPage(),
                'total' => $this->total(),
                "last_page" => $this->lastPage(),
            ],

            'links' => [
                'current' => $this->url($this->currentPage()),
                "next" => $this->nextPageUrl(),
                "prev" => $this->previousPageUrl(),
                "first" => $this->url(1),
                "last" => $this->url($this->lastPage()),
            ],

        ];

    }
}
