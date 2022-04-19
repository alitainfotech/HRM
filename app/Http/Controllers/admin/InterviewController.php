<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Application;
use App\Models\Interview;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    /* display interview view */
    public function index()
    {
        $tls = Admin::where('status',1)->whereHas('role', function($query) {
            $query->where('title', 'Team Leader');
        })->get();
        return view('pages.admin.interview',compact('tls'));
    }

    /* listing of interview */
    public function listing()
    {
        $role = Admin::with(['role'])->find(Auth::guard('admin')->id())->role->title;
        if($role=='team leader'){
            $interviews= Interview::where('status',1)->where('tl_id',Auth::guard('admin')->user()->id)->with('application')->with('tl')->get();
            $review='tl_review';
        }
        else{
            $interviews= Interview::where('status',1)->with('application')->with('tl')->get();
            $review='hr_review';
        }

        $data_result = [];
        $id=0;
        foreach ($interviews as $interview) {
            
            $candidate = $interview->application->load('candidate')->candidate;
            $opening = $interview->application->load('opening')->opening;
            $id++;
            $button = '';
            if(in_array("23", permission())){
                $button.='<div class="btn btn-success edit_interview m-1" data-id="'.$interview['id'].'"><i class="mdi mdi-square-edit-outline"></i></div>';
             }
            if(in_array("20", permission())){
                $button.='<div class="btn btn-danger reject m-1" data-i_id="'.$interview['id'].'" data-id="'.$interview->application['id'].'" ><i class="mdi mdi-close-outline"></i></div>';
            }
            if(in_array("20", permission())){
                $button.='<div class="btn btn-info add_review m-1" data-i_id="'.$interview['id'].'" data-id="'.$interview->application['id'].'"><i class="mdi mdi-book"></i></div>';
            }
            $date = date('d-m-Y  g:i:s a',strtotime($interview['date']));
            $cv='<a href="'.asset('/assets/candidates/candidates_cv').'/'.$interview->application['cv'].'" download><p>'.$interview->application['cv'].'</p></a>';
            $data_result[] = array( 
            "id"=>$id, 
            "post"=>$opening['title'],
            "Interviewer"=>$interview->tl['full_name'],
            "Interviewee"=>$candidate['full_name'],
            "date"=>$date,
            "cv"=>$cv,
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

    /* adding interview data to database */
    public function store(Request $request)
    {
        $request->validate(
            [
                'id' => 'required',
                'i_id' => 'required',
                'leader' => 'required',
                'date' => 'required',
            ]
        );
        if($request['i_id']==0){
            $old_interview = Interview::where('status',1)->where('a_id',$request['id'])->first();
            if(is_null($old_interview)){
                $interview = new Interview();
                $interview->a_id = $request['id'];
                $interview->created_at =now();
            }else{
                $responce = [
                    'status'=>false,
                    'message'=>"Already scheduled interview!",
                    'redirect_url'=>"",
                ];
                echo json_encode($responce);
                exit;
            }
        }else{
            $interview = Interview::where('status',1)->where('id',$request['i_id'])->first();
        }
        $interview->tl_id = $request['leader'];
        $interview->date = $request['date'];
        $interview->updated_at =now();
        $interview->save();
        if($interview->save()){
            $data= Application::where('id',$interview['a_id'])->first();
            $data->status=1;
            $data->updated_at =now();
            $data->save();
            $responce = [
                'status'=>true,
                'message'=>"Success",
            ];
            echo json_encode($responce);
            exit;
        }else{
            $responce = [
                'status'=>false,
                'message'=>"Fail in scheduling interview",
                'redirect_url'=>"",
            ];
            echo json_encode($responce);
            exit;
        }
    }

    /* display data of interview for updating data */
    public function show(Request $request)
    {
        $interview= Interview::where('id',$request['id'])->with('application')->with('tl')->first();
        $candidate = $interview->application->load('candidate')->candidate;
        if(!is_null($interview) && !is_null($candidate)){
            $responce = [
                'status'=>true,
                'message'=>"Success",
                'name' => $candidate->full_name,
                'id' => $interview->tl->id,
                'date' => $interview->date
            ];
            echo json_encode($responce);
            exit;
        }else{
            $responce = [
                'status'=>false,
                'message'=>"This data is not available for update",
                'redirect_url'=>"",
            ];
            echo json_encode($responce);
            exit;
        }
    }
}
