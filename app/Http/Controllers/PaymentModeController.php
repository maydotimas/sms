<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeeResource;
use App\Http\Resources\PaymentModeResource;
use App\Laravue\Models\Fee;
use App\Laravue\Models\PaymentMode;
use App\Laravue\Models\PaymentModeType;
use App\Laravue\Models\SubFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentModeController extends Controller
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
            $data = PaymentMode::search($request->title)
                ->paginate($request->limit);
        } else {
            $data = PaymentMode::paginate($request->limit);
        }

        return PaymentModeResource::collection(['data' => $data]);
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
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $payment_mode = PaymentMode::create([
                'name' => $params['name'],
                'code' => strtolower($params['name']) . time(), // Just to make sure this value is unique
                'description' => $params['description'],
                'penalty' => $params['penalty'],
                'grace_period' => $params['grace_period'],
                'payment_cut_off' => $params['payment_cut_off'],
            ]);

            PaymentModeType::create([
                'name' => 'Annual',
                'code' => $params['name']. ' Annual' . time(), // Just to make sure this value is unique
                'description' => $params['description'],
                'percentage' => '0',
                'payable_in' => 1,
                'payment_mode_id' => $payment_mode->id,
            ]);

            return new PaymentModeResource($payment_mode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\PaymentMode  $paymentMode
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMode $paymentMode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\PaymentMode  $paymentMode
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMode $paymentMode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\PaymentMode  $paymentMode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMode $paymentMode)
    {
        if ($paymentMode === null) {
            return response()->json(['error' => 'Payment Mode not found'], 404);
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
            $paymentMode->name = $params['name'];
            $paymentMode->description = $params['description'];
            $paymentMode->penalty = $params['penalty'];
            $paymentMode->grace_period = $params['grace_period'];
            $paymentMode->payment_cut_off = $params['payment_cut_off'];
            $paymentMode->save();
        }

        return new PaymentModeResource($paymentMode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\PaymentMode  $paymentMode
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMode $paymentMode)
    {
        try {
            $paymentMode->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
