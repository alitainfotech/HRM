<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Application;
use App\Models\Interview;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\RejectApplication;
use Mail;

class ReviewController extends Controller
{
    public function index()
    {
        return view('pages.admin.review');
    }

     /* listing of reviews */
    public function listing()
    {
        // $interviews= Interview::where('status',1)->with('application')->with('tl')->with('reviews')->get();
        $review = Review::get();
        $data_result = [];
        $id=0;
        $hr_des='';
        $hr_review='';
        $tl_des='';
        $tl_review='';
        foreach ($review as $row) {
            if($row->status==0){
                $tl_review = $row->review;
                $tl_des = $row->description;
                $hr_des='';
                $hr_review='';
            }else{
                $hr_review = $row->review;
                $hr_des = $row->description;
                $tl_des='';
                $tl_review='';
            }
            $candidate = $row->getInterview->application->load('candidate')->candidate;
            $opening = $row->getInterview->application->load('opening')->opening;
            $id++;
            $button = '';
            if($row->getInterview->status == 1){     
                if(in_array("32", permission())){
                     $button.='<div class="btn btn-icon btn-danger reject_candidate m-1" data-id="'.$row->i_id.'" data-a_id="'.$row->getInterview->application['id'].'"><i class="mdi mdi-close-outline"></i></div>';
                }
                if(in_array("31", permission())){
                    $button.='<div class="btn btn-icon btn-success select_candidate m-1" data-id="'.$row->i_id.'" data-a_id="'.$row->getInterview->application['id'].'"><i class="mdi mdi-check-outline"></i></div>';
                }
            }
            $data_result[] = array( 
            "id"=>$id, 
            "post"=>$opening['title'],
            "name"=>$candidate['full_name'],
            "tl_review"=>$tl_review,
            "tl_des"=>$tl_des,
            "hr_review"=>$hr_review,
            "hr_des"=>$hr_des,
            "action"=>$button
            );
        }
        $dataset = array(
            "echo" => 1,
            "totalrecords" => count($data_result),
            "totaldisplayrecords" => count($data_result),
            "data" => $data_result
        ); 
        echo json_encode($dataset);
    }
     
    /* adding review data to database */
    public function store(Request $request)
    {
        $request->validate(
            [
                'review' => 'required',
                'description' => 'required',
            ]
        );
        
        $status=(Admin::with(['role'])->find(Auth::guard('admin')->id())->role->title=='HR') ? '1' : '0';
        $review_old = Review::where('status',$status)->where('id',$request['review_id'])->where('i_id',$request['i_id'])->first();
        // if(is_null($review_old)){
            $review= new Review;
            $message = 'Review added successfully';
            if(!empty($review_old)){
                $review = $review_old;
                $message = 'Review updated successfully';
            }
            $review->i_id=$request['i_id'];
            $range=$request['review'];
            if($range<5){
                $review_r= 'rejected';
            }elseif($range>5 && $range<7){
                $review_r= 'average';
            }else{
                $review_r= 'excellent';
            }
            $review->rating=$request['review'];
            $review->review=$review_r;
            $review->description=$request['description'];
            $review->status=$status;
            if($review->save()){
                $response = [
                    'status' => true,
                    'message' => $message,
                    'icon' => 'success',
                    'redirect_url' => "",
                ];
                echo json_encode($response);
                exit;
            }
        // }else{
        //     $responce = [
        //         'status'=>false,
        //         'message'=>"Already upload reviews!",
        //         'icon' => 'error',
        //         'redirect_url'=>"",
        //     ];
        //     echo json_encode($responce);
        //     exit;
        // }
    }
    
    /* reject the application */
    public function reject(Request $request)
    {
        $id = $request['id'];
        $data= Interview::where('id',$id)->where('status','!=',0)->first();
        if(!is_null($data)) {
            $data->status=0;
            $data->updated_at=now();
            $data->update();
            if($data->update()){
                $application = Application::where('id',$request['a_id'])->first();
                if(!is_null($application)){
                    $application->status = 3;
                    $application->reason = $request['reason'];
                    if($application->update()){

                        $body = [
                            'full_name' => !empty($application->candidate) ? $application->candidate->full_name : '',
                            'job_title' => !empty($application->opening) ? $application->opening->title : '',
                            'reason' => $request['reason']
                        ];
                        $email = !empty($application->candidate) ? $application->candidate->email : '';
                        if($email != ''){
                            Mail::to($email)->send(new RejectApplication($body));
                        }

                        $response = [
                            'status' => true,
                            'message' => 'Candidate rejected Successfully',
                            'icon' => 'success',
                            'redirect_url' => "",
                        ];
                        echo json_encode($response);
                        exit;
                    }else{
                        $response = [
                            'status' => false,
                            'message' => "error in updating",
                            'icon' => 'error',
                            'redirect_url' => "",
                        ];
                        echo json_encode($response);
                        exit;
                    }
                }
            }else{
                $response = [
                    'status' => false,
                    'message' => "error in updating",
                    'icon' => 'error',
                    'redirect_url' => "",
                ];
                echo json_encode($response);
                exit;
            }
        }
    }

    /* select the application */
    public function select(Request $request)
    {
        $id = $request['id'];
        $data= Interview::where('id',$id)->where('status','!=',0)->first();
        if(!is_null($data)) {
            $data->status=0;
            if($data->update()){
                $application = Application::where('id',$request['a_id'])->first();
                if(!is_null($application)){
                    $application->status = 2;
                    $application->reason = $request['reason'];
                    if($application->update()){
                        $response = [
                            'status' => true,
                            'message' => 'Candidate Selected Successfully',
                            'icon' => 'success',
                            'redirect_url' => "",
                        ];
                        echo json_encode($response);
                        exit;
                    }else{
                        $response = [
                            'status' => false,
                            'message' => "error in updating",
                            'icon' => 'error',
                            'redirect_url' => "",
                        ];
                        echo json_encode($response);
                        exit;
                    }
                }
            }else{
                $response = [
                    'status' => false,
                    'message' => "error in updating",
                    'icon' => 'error',
                    'redirect_url' => "",
                ];
                echo json_encode($response);
                exit;
            }
        }else{
            $response = [
                'status' => false,
                'message' => "error in updating",
                'icon' => 'error',
                'redirect_url' => "",
            ];
            echo json_encode($response);
            exit;
        }
    }
}