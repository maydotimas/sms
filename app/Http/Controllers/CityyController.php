<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Laravue\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('title') && $request->input('title') != '') {
            $data = City::select('citymunCode as link', DB::raw('citymunDesc as value'))
                ->search($request->title)
                ->paginate($request->limit);
        } else {
            $data = City::select('citymunCode as link', DB::raw('citymunDesc as value'))
                ->paginate($request->limit);
        }

        return CityResource::collection(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Laravue\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Laravue\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Laravue\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Laravue\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
