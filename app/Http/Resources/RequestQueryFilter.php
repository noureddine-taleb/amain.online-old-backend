<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RequestQueryFilter extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }


    public function attach($resource, Request $request = null)
    {
        $request = $request ?? request();        return tap($resource, function($resource) use($request) {
            $this->getRequestIncludes($request)->each(function($include) use($resource) {
                $resource->load($include);
            });
        });
    }    
    
    protected function getRequestIncludes(Request $request)
    {
        return collect(data_get($request->input(), 'include', []));
    }
}
