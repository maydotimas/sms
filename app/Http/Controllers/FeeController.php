<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeeResource;
use App\Laravue\Models\Fee;
use App\Laravue\Models\SubFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
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
            $data = Fee::search($request->title)
                ->paginate($request->limit);
        } else {
            $data = Fee::paginate($request->limit);
        }

        return FeeResource::collection(['data' => $data]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'tuition' => ['required'],
                'misc' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $fee = Fee::create([
                'name' => $params['name'],
                'code' => strtolower($params['name']) . time(), // Just to make sure this value is unique
                'description' => $params['description'],
            ]);

            SubFee::create([
                'name' => 'Regular',
                'code' => $fee->code,
                'type' => 'Regular',
                'tuition' => $params['tuition'],
                'misc' => $params['misc'],
                'description' => 'Regular fee for '. $params['tuition'],
                'fee_id' => $fee->id
            ]);

            return new FeeResource($fee);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function show(Fee $fee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function edit(Fee $fee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fee $fee)
    {
        if ($fee === null) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $fee->name = $params['name'];
            $fee->description = $params['description'];
            $fee->save();
        }

        return new FeeResource($fee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fee $fee)
    {
        try {
            $fee->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
