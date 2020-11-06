<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeeResource;
use App\Http\Resources\SubFeeResource;
use App\Laravue\Models\Fee;
use App\Laravue\Models\SubFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubFeeController extends Controller
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
            $data = SubFee::search($request->title)
                ->fee($request->fee_id)
                ->with('fee')
                ->paginate($request->limit);
        } else {
            $data = SubFee::with('fee')
                ->fee($request->fee_id)
                ->paginate($request->limit);
        }

        return SubFeeResource::collection(['data' => $data]);
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

            $fee = SubFee::create([
                'name' => $params['name'],
                'code' => strtolower($params['name']) . time(), // Just to make sure this value is unique
                'description' => $params['description'],
                'type' => $params['type'],
                'discount' => $params['discount'],
                'fee_id' => $params['fee_id'],
            ]);


            return new SubFeeResource($fee);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Laravue\Models\SubFee $subFee
     * @return \Illuminate\Http\Response
     */
    public function show(SubFee $subFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Laravue\Models\SubFee $subFee
     * @return \Illuminate\Http\Response
     */
    public function edit(SubFee $subFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Laravue\Models\SubFee $subFee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubFee $subFee)
    {
        if ($subFee === null) {
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
            if($params['type']==='REGULAR'){
                $subFee->name = $params['name'];
                $subFee->description = $params['description'];
                $subFee->tuition = $params['tuition'];
                $subFee->misc = $params['misc'];
            }else{
                $subFee->name = $params['name'];
                $subFee->description = $params['description'];
                $subFee->type = $params['type'];
                $subFee->discount = $params['discount'];
            }

            $subFee->save();
        }

        return new SubFeeResource($subFee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Laravue\Models\SubFee $subFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubFee $subFee)
    {
        try {
            $subFee->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
