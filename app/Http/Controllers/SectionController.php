<?php

namespace App\Http\Controllers;

use App\Http\Resources\GradeLevelResource;
use App\Http\Resources\SectionResource;
use App\Laravue\Models\GradeLevel;
use App\Laravue\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SectionResource::collection(Section::with('grade_level')->get());
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
                'grade_level_id' => ['required','exists:grade_levels,id']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $result = Section::create([
                'name' => $params['name'],
                'code' => strtolower($params['name']) . time(), // Just to make sure this value is unique
                'description' => $params['description'],
                'grade_level_id' => $params['grade_level_id'],
            ]);

            return new SectionResource($result);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        if ($section === null) {
            return response()->json(['error' => 'Section not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'grade_level_id' => ['required','exists:grade_levels,id']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $section->name = $params['name'];
            $section->description = $params['description'];
            $section->grade_level_id = $params['grade_level_id'];
            $section->save();
        }

        return new SectionResource($section);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        try {
            $section->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
