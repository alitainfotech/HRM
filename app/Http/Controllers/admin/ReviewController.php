<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Interview;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        return view('pages.admin.review');
    }

     /* listing of reviews */
     public function listing()
     {
        $interviews= Interview::where('status',1)->with('application')->with('tl')->with('reviews')->get();
        dd($interviews);
         $data_result = [];
         $id=0;
         foreach ($interviews as $interview) {
             dd($interview->review);
             $candidate = $interview->application->load('candidate')->candidate;
             $opening = $interview->application->load('opening')->opening;
             $id++;
             $button = '';
              if(in_array("31", permission())){
                 $button.='<div class="btn btn-danger reject_candidate" data-id="'.$interview['id'].'" ><i class="mdi mdi-close-outline"></i></div>';
             }
             if(in_array("30", permission())){
                $button.='<div class="btn btn-success select_candidate" data-id="'.$interview['id'].'"><i class="mdi mdi-check-outline"></i></div>';
             }
             $data_result[] = array( 
             "id"=>$id, 
             "post"=>$opening['title'],
             "name"=>$candidate['full_name'],
            //  "hr_review"=>
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
        $review_old=Review::where('status',$status)->where('i_id',$request['i_id'])->first();
        if(is_null($review_old)){
            $review= new Review;
            $review->i_id=$request['i_id'];
            $range=$request['range'];
            if($range<5){
                $review_r= 'rejected';
            }
            $review_r=($range<5) ? 'rejected' : ($range>5 && $range<7) ? 'average' : 'excellent';
            $review->review=$review_r;
            $review->status=$status;
            $review->save();
            $responce = [
                'status'=>true,
                'message'=>"Success",
            ];
            echo json_encode($responce);
            exit;
        }else{
            $responce = [
                'status'=>false,
                'message'=>"Already upload reviews!",
                'redirect_url'=>"",
            ];
            echo json_encode($responce);
            exit;
        }
    }
}
