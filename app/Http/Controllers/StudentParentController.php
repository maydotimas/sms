<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentParentResource;
use App\Laravue\Models\Student;
use App\Laravue\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentParentController extends Controller
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
            $data = StudentParent::search($request->title)
                ->paginate($request->limit);
        } else {
            $data = StudentParent::paginate($request->limit);
        }

        return StudentParentResource::collection(['data' => $data]);
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
                'occupation' => ['required'],
                'email' => ['required'],
                'mobile' => ['required'],
                'type' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $parents = StudentParent::all();
            $parent_count = $parents->count()+1;
            $parent_no = 'PN-'.str_pad($parent_count,4,'0',STR_PAD_LEFT);

            $fee = StudentParent::create([
                'parent_no' => $parent_no,
                'first_name' => $params['first_name'],
                'middle_name' => $params['middle_name'],
                'last_name' => $params['last_name'],
                'suffix' => $params['suffix'],
                'occupation' => $params['occupation'],
                'office_address' => $params['office_address'],
                'email' => $params['email'],
                'mobile' => $params['mobile'],
                'type' => $params['type'],
            ]);

            return new StudentParentResource($fee);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\StudentParent  $studentParent
     * @return \Illuminate\Http\Response
     */
    public function show(StudentParent $studentParent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\StudentParent  $studentParent
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentParent $studentParent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\StudentParent  $studentParent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentParent $studentParent)
    {
        if ($studentParent === null) {
            return response()->json(['error' => 'Student parent not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'occupation' => ['required'],
                'email' => ['required'],
                'mobile' => ['required'],
                'type' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $studentParent->first_name = $params['first_name'];
            $studentParent->middle_name = $params['middle_name'];
            $studentParent->last_name = $params['last_name'];
            $studentParent->suffix = $params['suffix'];
            $studentParent->occupation = $params['occupation'];
            $studentParent->street = $params['street'];
            $studentParent->town = $params['town'];
            $studentParent->province = $params['province'];
            $studentParent->email = $params['email'];
            $studentParent->mobile = $params['mobile'];
            $studentParent->type = $params['type'];
            $studentParent->save();
        }

        return new StudentParentResource($studentParent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\StudentParent  $studentParent
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentParent $studentParent)
    {
        try {
            $studentParent->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
