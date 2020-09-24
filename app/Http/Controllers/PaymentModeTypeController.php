<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentModeTypeResource;
use App\Laravue\Models\PaymentModeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentModeTypeController extends Controller
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
            $data = PaymentModeType::search($request->title)
                ->paymentMode($request->payment_mode_id)
                ->with('fee')
                ->paginate($request->limit);
        } else {
            $data = PaymentModeType::with('paymentMode')
                ->paymentMode($request->payment_mode_id)
                ->paginate($request->limit);
        }
        return PaymentModeTypeResource::collection(['data' => $data]);
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
            $fee = PaymentModeType::create([
                'name' => $params['name'],
                'code' => strtolower($params['name']) . time(), // Just to make sure this value is unique
                'description' => $params['description'],
                'percentage' => $params['percentage'],
                'payable_in' => $params['payable_in'],
                'payment_mode_id' => $params['payment_mode_id'],
            ]);


            return new PaymentModeTypeResource($fee);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Laravue\Models\PaymentModeType $paymentModeType
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentModeType $paymentModeType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Laravue\Models\PaymentModeType $paymentModeType
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentModeType $paymentModeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Laravue\Models\PaymentModeType $paymentModeType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentModeType $paymentModeType)
    {
        if ($paymentModeType === null) {
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
            $paymentModeType->name = $params['name'];
            $paymentModeType->description = $params['description'];
            $paymentModeType->percentage = $params['percentage'];
            $paymentModeType->payable_in = $params['payable_in'];
            $paymentModeType->save();
        }

        return new PaymentModeTypeResource($paymentModeType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Laravue\Models\PaymentModeType $paymentModeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentModeType $paymentModeType)
    {
        try {
            $paymentModeType->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
