<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Application;
use App\Models\Interview;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /* display pending application view */
    public function index()
    {
        $tls = Admin::where('status',1)->whereHas('role', function($query) {
            $query->where('title', 'Team Leader');
        })->get();
        return view('pages.admin.applicationPending',compact('tls'));
    }

    /* listing of pending application */
    public function listing()
    {
        $data['applications']= Application::where('status',0)->with('candidate')->with('opening')->get();
        $data_result = [];
        $id=0;
        foreach ($data['applications'] as $application) {
            $id++;
            $button = '';
            $year = intdiv($application['experience'],12);
            $month = $application['experience']%12;
            $experience= $year.' year '.$month.' month ';
            if(in_array("22", permission())){
            $button.='<div class="btn btn-primary add_interview m-1" data-id="'.$application['id'].'"><i class="mdi mdi-plus-outline"></i></div>';
            }
            if(in_array("20", permission())){
            $button.='<div class="btn btn-danger reject m-1" data-id="'.$application['id'].'"><i class="mdi mdi-close-outline"></i></div>';
            }
            $cv='<a href="'.asset('/assets/images/users/users_cv').'/'.$application['cv'].'" download><p>'.$application['cv'].'</p></a>';
            $data_result[] = array( 
            "id"=>$id, 
            "post"=>$application->opening['title'],
            "name"=>$application->candidate['full_name'],
            "phone"=>$application->candidate['phone'],
            "email"=>$application->candidate['email'],
            "cv"=>$cv,
            "description"=>mb_strimwidth($application['description'], 0, 50, "..."),
            "experience"=>$experience,
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

    /* display interview modal */
    public function nameShow(Request $request)
    {
        $data['applications']= Application::where('id',$request['id'])->with('candidate')->with('opening')->first();
        if(!empty($data['applications'])){
            $responce = [
                'status'=>true,
                'message'=>"Success",
                'name' => $data['applications']->candidate['full_name']
            ];
            echo json_encode($responce);
            exit;
        }else{
            $responce = [
                'status'=>false,
                'message'=>"This data is not available for interview",
                'redirect_url'=>"",
            ];
            echo json_encode($responce);
            exit;
        }
    }

    /* reject the application */
    public function applicationReject(Request $request)
    {
        $id = $request['id'];
        $data= Application::where('id',$id)->where('status','!=',3)->first();
        if(!is_null($data)) {
            $data->status=3;
            $data->reason=$request['reason'];
            $data->updated_at=now();
            $data->update();
            if($data->update()){
                if(!is_null($request['i_id'])){
                    $interview = Interview::where('id',$request['i_id'])->first();
                    if(!is_null($interview)){
                        $interview->status = 0;
                        $interview->updated_at = now();
                        $interview->update();
                    }
                }
                $responce = [
                    'status'=>true,
                    'message'=>"Success",
                ];
                echo json_encode($responce);
                exit;
            }else{
                $responce = [
                    'status'=>false,
                    'message'=>"Fail in updating status",
                    'redirect_url'=>"",
                ];
                echo json_encode($responce);
                exit;
            }
        }else{
            $responce = [
                'status'=>false,
                'message'=>"this application is not avialable for any rejection",
                'redirect_url'=>"",
            ];
            echo json_encode($responce);
            exit;
        }
    }

    /* display rejected application view */
    public function indexReject()
    {
        $tls = Admin::where('status',1)->whereHas('role', function($query) {
            $query->where('title', 'Team Leader');
        })->get();
        return view('pages.admin.applicationReject',compact('tls'));
    }

    /* listing of rejected application */
    public function listingReject()
    {
        $data['applications']= Application::where('status',3)->with('candidate')->with('opening')->get();
        $data_result = [];
        $id=0;
        foreach ($data['applications'] as $application) {
            $id++;
            $year = intdiv($application['experience'],12);
            $month = $application['experience']%12;
            $experience= $year.' year '.$month.' month ';
            $cv='<a href="'.asset('/assets/images/users/users_cv').'/'.$application['cv'].'" download><p>'.$application['cv'].'</p></a>';
            $data_result[] = array( 
            "id"=>$id, 
            "post"=>$application->opening['title'],
            "name"=>$application->candidate['full_name'],
            "phone"=>$application->candidate['phone'],
            "email"=>$application->candidate['email'],
            "cv"=>$cv,
            "description"=>mb_strimwidth($application['description'], 0, 50, "..."),
            "experience"=>$experience,
            "reason"=>$application['reason']
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

    /* display selected application view */
    public function indexSelect()
    {
        $tls = Admin::where('status',1)->whereHas('role', function($query) {
            $query->where('title', 'Team Leader');
        })->get();
        return view('pages.admin.applicationSelect',compact('tls'));
    }

    /* listing of selected application */
    public function listingSelect()
    {
        $data['applications']= Application::where('status',2)->with('candidate')->with('opening')->get();
        $data_result = [];
        $id=0;
        foreach ($data['applications'] as $application) {
            $id++;
            $button = '';
            $year = intdiv($application['experience'],12);
            $month = $application['experience']%12;
            $experience= $year.' year '.$month.' month ';
            
            $cv='<a href="'.asset('/assets/images/users/users_cv').'/'.$application['cv'].'" download><p>'.$application['cv'].'</p></a>';
            $data_result[] = array( 
            "id"=>$id, 
            "post"=>$application->opening['title'],
            "name"=>$application->candidate['full_name'],
            "phone"=>$application->candidate['phone'],
            "email"=>$application->candidate['email'],
            "cv"=>$cv,
            "experience"=>$experience,
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
}