<?php

namespace App\Http\Controllers;

use App\Laravue\Models\StudentPayment;
use Illuminate\Http\Request;
use App\Http\Resources\StudentPayment as StudentPaymentResource;

class StudentPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('title') && $request->input('title') != '') {
            $data = StudentPayment::search($request->title)
                ->with('student')
                ->with('enrollment')
                ->with('schoolYear')
                ->paginate($request->limit);
        } else if (($request->has('title') && $request->input('title') != '') ||
            ($request->has('school_year_id') && $request->input('school_year_id') != '')) {
            $data = StudentPayment::filterSearch($request->title, $request->school_year_id)
                ->with('student')
                ->with('enrollment')
                ->with('schoolYear')
                ->paginate($request->limit);
        } else {
            $data = StudentPayment::with('student')
                ->with('enrollment')
                ->with('schoolYear')
                ->paginate($request->limit);
        }
        return StudentPaymentResource::collection(['data' => $data]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function show(StudentPayment $studentPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentPayment $studentPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentPayment $studentPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentPayment $studentPayment)
    {
        //
    }
}
