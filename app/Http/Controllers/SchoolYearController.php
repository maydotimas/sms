<?php

namespace App\Http\Controllers;

use App\Http\Resources\SchoolYearConfigResource;
use App\Http\Resources\SchoolYearResource;
use App\Laravue\Models\SchoolYear;
use App\Laravue\Models\SchoolYearConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('title') && $request->input('title') != '') {
            $data = SchoolYear::search($request->title)
                ->with('schoolYearConfig')
                ->paginate($request->limit);
        } else if ($request->has('active') && $request->input('active') == 'true') {
            $data = SchoolYear::active()
                ->with('schoolYearConfig')
                ->paginate($request->limit);
        } else {
            $data = SchoolYear::with('schoolYearConfig')
                ->paginate($request->limit);
        }
        return SchoolYearResource::collection(['data' => $data]);
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
            $record = SchoolYear::create([
                'name' => $params['name'],
                'year' => $params['year'],
                'start_month' => $params['start_month'],
                'end_month' => $params['end_month'],
                'status' => $params['status'],
                'payment_mode_id' => $params['payment_mode_id'],
            ]);

            // Create school year configuration
            $fees = $params['fees'];
            $keys = array_keys($fees);

            foreach ($keys as $key) {
                if ($fees[$key] != null) {
                    SchoolYearConfig::create([
                        'school_year_id' => $record->id,
                        'department_id' => $key,
                        'fee_id' => $fees[$key],
                    ]);
                }
            }
            return new SchoolYearResource($record);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Laravue\Models\SchoolYear $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Laravue\Models\SchoolYear $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Laravue\Models\SchoolYear $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolYear $schoolYear)
    {
        if ($schoolYear === null) {
            return response()->json(['error' => 'School Year not found'], 404);
        }
        $params = $request->all();
        if (isset($params['is_locked'])) {
            $validator = Validator::make(
                $request->all(),
                [
                    'is_locked' => ['required']
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 403);
            } else {

                /* Update school year details */
                $schoolYear->is_locked = $params['is_locked'] == 'lock' ? 'YES' : 'NO';
                $schoolYear->save();

            }
        } else if (isset($params['is_active'])) {
            $validator = Validator::make(
                $request->all(),
                [
                    'is_active' => ['required']
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 403);
            } else {
                //deactivate first
                if ($params['is_active'] == 'activate') {
                    SchoolYear::where('id', '>', '0')->update(['status' => '0']);
                }
                /* Update school year details */
                $schoolYear->status = $params['is_active'] == 'activate' ? '1' : '0';
                $schoolYear->save();

            }
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => ['required']
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 403);
            } else {

                /* Update school year details */
                $schoolYear->name = $params['name'];
                $schoolYear->year = $params['year'];
                $schoolYear->start_month = $params['start_month'];
                $schoolYear->end_month = $params['end_month'];
                $schoolYear->status = $params['status'];
                $schoolYear->save();

                /* Update school year config */
            }

        }

        return new SchoolYearResource($schoolYear);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Laravue\Models\SchoolYear $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolYear $schoolYear)
    {
        try {
            $schoolYear->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }

    /**
     * Get school year config payment details
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function get_payment_details(Request $request)
    {
        $data = SchoolYearConfig::search($request->id);

        return SchoolYearConfigResource::collection(['data' => $data]);
    }
}
