<?php

namespace App\Http\Controllers;

use App\Http\Resources\EnrollmentResource;
use App\Laravue\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
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
            $data = Enrollment::search($request->title)
                ->with('student')
                ->with('schoolYear')
                ->with('gradeLevel')
                ->with('section')
                ->paginate($request->limit);
        } else if (($request->has('title') && $request->input('title') != '') ||
            ($request->has('school_year_id') && $request->input('school_year_id') != '')){
            $data = Enrollment::filterSearch($request->title,$request->school_year_id)
                ->with('student')
                ->with('schoolYear')
                ->with('gradeLevel')
                ->with('section')
                ->paginate($request->limit);
        } else {
            $data = Enrollment::with('gradeLevel')
                ->with('student')
                ->with('schoolYear')
                ->with('section')
                ->paginate($request->limit);
        }
        return EnrollmentResource::collection(['data' => $data]);
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
        return dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'student_id' => ['required'],
                'school_year_id' => ['required'],
                'grade_level_id' => ['required'],
                'section_id' => ['required'],
                'reservation_amount' => ['required'],
                'payment_receipt' => ['required'],
                'type' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $record = Enrollment::create([
                'reservation_code' => \Illuminate\Support\Str::random(6),
                'student_id' => $params['student_id'],
                'school_year_id' => $params['school_year_id'],
                'grade_level_id' => $params['grade_level_id'],
                'section_id' => $params['section_id'],
                'student_type' => $params['type'],
                'reservation_amount' => $params['reservation_amount'],
                'payment_receipt' => $params['payment_receipt'],
                'status' => 'RESERVED',
            ]);

            return new EnrollmentResource($record);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enrollment $enrollment)
    {
        try {
            $enrollment->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }

    public function receipt(Request $request)
    {
        /* Upload */
        $file = $request->file('file');
        $destinationPath = 'uploads';
        $avatar_name = date('YmdHis') . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $avatar_name);
        $payment_receipt = 'uploads\\enrollment\\'.date('Ymd').'\\'. $avatar_name;
        return $payment_receipt;

    }
}
