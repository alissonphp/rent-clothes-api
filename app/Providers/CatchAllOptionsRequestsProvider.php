<?php

namespace App\Providers;


class CatchAllOptionsRequestsProvider
{

    public function register()
    {
        $request = app('request');
        if ($request->isMethod('OPTIONS'))
        {
            app()->options($request->path(), function() { return response('', 200); });
        }
    }

}