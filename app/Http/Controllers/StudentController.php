<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Laravue\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
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
            $data = Student::search($request->title)
                ->paginate($request->limit);
        } else {
            $data = Student::paginate($request->limit);
        }

        return StudentResource::collection(['data' => $data]);
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
                'first_name' => ['required'],
                'last_name' => ['required'],
                'gender' => ['required'],
                'birthdate' => ['required'],
                'handedness' => ['required'],
                'religion' => ['required'],
                'email' => ['required'],
                'mobile' => ['required'],
                'street' => ['required'],
                'province' => ['required'],
                'town' => ['required'],
                'brgy' => ['required'],
                'emergency_contact' => ['required'],
                'father' => ['required'],
                'mother' => ['required'],
                'guardian' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            // new student
            if($params['type']=='1'){
                $students = Student::all();
                $student_count = $students->count() + 1;
                $student_no = date('Y').'-' . str_pad($student_count, 4, '0', STR_PAD_LEFT);
            }else{
                $student_no = $params['student_no'];
            }

            $student = Student::create([
                'lrn' => $params['lrn'],
                'student_no' => $student_no,
                'first_name' => $params['first_name'],
                'middle_name' => $params['middle_name'],
                'last_name' => $params['last_name'],
                'suffix' => $params['suffix'],
                'nickname' => $params['nickname'],
                'handedness' => $params['handedness'],
                'religion' => $params['religion'],
                'street' => $params['street'],
                'brgy' => $params['brgy'],
                'town' => $params['town'],
                'province' => $params['province'],
                'mobile' => $params['mobile'],
                'email' => $params['email'],
                'gender' => $params['gender'],
                'birthdate' => $params['birthdate'],
                'emergency_contact' => $params['emergency_contact'],
                'avatar' => 'uploads\default.png',
            ]);

            return new StudentResource($student);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function avatar(Request $request)
    {
        /*Get parent Record*/
        $student = Student::find($request->input('id'));

        /* Upload */
        $file = $request->file('img');
        $destinationPath = 'uploads';
        $avatar_name = $student->student_no . date('YmdHis') . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $avatar_name);

        /* Upload */
        $student->avatar = 'uploads\\' . $avatar_name;
        $student->save();

        return new StudentResource($student);
    }
}
