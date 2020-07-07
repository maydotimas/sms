<?php

namespace App\Http\Controllers;

use App\Http\Resources\GradeLevelResource;
use App\Laravue\Models\GradeLevel;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GradeLevelResource::collection(GradeLevel::with('department')->get());
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
     * @param  \App\Laravue\Models\GradeLevel  $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function show(GradeLevel $gradeLevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\GradeLevel  $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function edit(GradeLevel $gradeLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\GradeLevel  $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GradeLevel $gradeLevel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\GradeLevel  $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(GradeLevel $gradeLevel)
    {
        //
    }
}