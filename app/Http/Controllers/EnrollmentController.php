<?php

namespace App\Http\Controllers;

use App\Http\Resources\EnrollmentResource;
use App\Laravue\Models\Enrollment;
use App\Laravue\Models\PaymentMode;
use App\Laravue\Models\PaymentModeType;
use App\Laravue\Models\Reservation;
use App\Laravue\Models\SchoolYear;
use App\Laravue\Models\Student;
use App\Laravue\Models\StudentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        } else if (($request->has('id') && $request->input('id') != '')) {
            $data = Enrollment::search($request->id)
                ->with('student')
                ->with('schoolYear')
                ->with('gradeLevel')
                ->with('section')
                ->with('paymentModeType')
                ->get();
            $student_id = $data[0]->student_id;
            $enrollment_id = $data[0]->id;
            $payments = StudentPayment::where('student_id','=',$student_id)
                ->where('enrollment_id','=',$enrollment_id)
                ->where('status','=',0)
                ->get();
            $balance = 0;
//            $balance = $data[0]->enrollment_amount;
            foreach($payments as $payment)
            {
                $date1 = $payment->payment_due;
                $date2 = date('Y-m-d');

                $ts1 = strtotime($date1);
                $ts2 = strtotime($date2);

                $year1 = date('Y', $ts1);
                $year2 = date('Y', $ts2);

                $month1 = date('m', $ts1);
                $month2 = date('m', $ts2);

                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

                $penalty = 0;
                if($diff > 0){
                    $penalty = $payment->payment_amount_due + ($payment->payment_amount_due * ($diff * 0.03));
                }else{
                    $penalty =  $payment->payment_amount_due;
                }

                $balance += $penalty;
            }
//            $balance = $data[0]->enrollment_amount - $total_paid;
            $data[0]->balance = $balance;
        } else if (($request->has('student_no') && $request->input('student_no') != '') &&
            ($request->has('school_year_id') && $request->input('school_year_id') != '')) {
            $student = Student::where('student_no','=',$request->student_no)->get();
            $student_id = $student[0]->id;
            $data = Enrollment::enrollmentSearch($student_id, $request->school_year_id)->get();
        } else if (($request->has('title') && $request->input('title') != '') ||
            ($request->has('school_year_id') && $request->input('school_year_id') != '')) {
            $data = Enrollment::filterSearch($request->title, $request->school_year_id)
                ->with('student')
                ->with('schoolYear')
                ->with('gradeLevel')
                ->with('section')
                ->paginate($request->limit);
        }  else {
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'student_id' => ['required'],
                'school_year_id' => ['required'],
                'grade_level_id' => ['required'],
                'section_id' => ['required'],
                'sub_fee_id' => ['required'],
                'payment_mode_type_id' => ['required'],
                'student_type' => ['required'],
                'enrollment_fee' => ['required'],
                'type' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $record = Enrollment::create([
                'enrollment_code' => \Illuminate\Support\Str::random(6),
                'student_id' => $params['student_id'],
                'school_year_id' => $params['school_year_id'],
                'grade_level_id' => $params['grade_level_id'],
                'section_id' => $params['section_id'],
                'sub_fee_id' => $params['sub_fee_id'],
                'payment_mode_type_id' => $params['payment_mode_type_id'],
                'student_type' => $params['student_type'],
                'enrollment_amount' => $params['enrollment_fee'],
                'payment_receipt' => 'na',
                'status' => 'ENROLLED',
            ]);
            // get payment mode details
            $payment_mode = PaymentModeType::where('id', '=', $params['payment_mode_type_id'])->get();
            $payable_in = $payment_mode[0]->payable_in;

            // get payment details
            $payment_option = PaymentMode::where('id','=',$payment_mode[0]->payment_mode_id)->get();
            $monthly_due = $payment_option[0]->payment_cut_off;
            $monthly_grace_due = $payment_option[0]->payment_cut_off + $payment_option[0]->grace_period;

            // get school year details
            $schoolyear = SchoolYear::where('id', '=', $params['school_year_id'])->get();
            $sy_data = $schoolyear[0];

            // months array
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'October', 'November', 'December'];

            // count months
            $start_month = $sy_data->start_month;
            $end_month = $sy_data->end_month;
            $start_year = $sy_data->year;
            $end_year = $sy_data->year;
            $count_months = 0;

            // get index of month
            $start_month_key = array_search($start_month, $months);
            $end_month_key = array_search($end_month, $months);
            if ($end_month_key < $start_month_key) {
                $end_year = $start_year + 1;
                $count_months = 12 - $start_month_key + $end_month_key;
            } else {
                $count_months = $end_month_key - $start_month_key;
            }

            $has_reservation = 0;

            // check if has reservation
            $reservation = Reservation::where('school_year_id','=',$params['school_year_id'])
                ->where('student_id','=',$params['student_id'])
                ->get();

            if(count($reservation)>0){
                $has_reservation = 1;
                // create student payment
                StudentPayment::create([
                    'student_id' => $params['student_id'],
                    'school_year_id' => $params['school_year_id'],
                    'enrollment_id' => $record->id,
                    'payment_no' => $has_reservation,
                    'payment_amount_due' => $reservation[0]->reservation_amount,
                    'payment_amount' => $reservation[0]->reservation_amount,
                    'payment_date' => $reservation[0]->created_at,
                    'payment_due' =>  $reservation[0]->created_at,
                    'remarks' => 'RESERVATION',
                    'type' => 'RESERVATION',
                    'status' => 1 // PAID - 1 UNPAID - 0
                ]);
            }
            // compute monthly fee
            $monthly = $params['enrollment_fee'] / $payable_in;

            // count number of months and create payment
            $ctr = 1;
            for ($ctr == 1; $ctr <= $payable_in; $ctr++) {
                if($start_month_key > 13){
                    $payment_due = $start_year + 1 .'-01-'.$monthly_grace_due;
                    $start_month_key = 1;
                }else{
                    if($start_month_key > 9){
                        $payment_due = $start_year + 1 .'-'.$start_month_key.'-'.$monthly_grace_due;
                    }else{
                        $payment_due = $start_year + 1 .'-0'.$start_month_key.'-'.$monthly_grace_due;
                    }
                }
                $start_month_key = $start_month_key + 1;
                StudentPayment::create([
                    'student_id' => $params['student_id'],
                    'school_year_id' => $params['school_year_id'],
                    'enrollment_id' => $record->id,
                    'payment_no' => $ctr+$has_reservation,
                    'payment_amount_due' => $monthly,
                    'payment_amount' => '',
                    'payment_date' => '',
                    'payment_due' =>  $payment_due,
                    'remarks' => '',
                    'type' => 'PAYMENT',
                    'status' => 0 // PAID - 1 UNPAID - 0
                ]);

            }

            // save records in student payments


            return new EnrollmentResource($record);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Laravue\Models\Enrollment $enrollment
     * @return \Illuminate\Http\Response
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Laravue\Models\Enrollment $enrollment
     * @return \Illuminate\Http\Response
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Laravue\Models\Enrollment $enrollment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Laravue\Models\Enrollment $enrollment
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
        $payment_receipt = 'uploads\\enrollment\\' . date('Ymd') . '\\' . $avatar_name;
        return $payment_receipt;
    }
}
