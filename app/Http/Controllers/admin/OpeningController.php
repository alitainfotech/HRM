<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Opening;
use Illuminate\Http\Request;

class OpeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.opening');
    }

    /* storing job opening data to database */
    public function store(Request $request)
    {
        if($request->fresher=='on'){
            $request->validate(
                [
                    'title' => 'required',
                    'description' => 'required',
                    'number_openings' => 'required',
                ]
            );
            $min_experience=0;
            $max_experience=0;
            $fresher=1;
        }else{
            $request->validate(
                [
                    'title' => 'required',
                    'description' => 'required',
                    'number_openings' => 'required',
                    'max_experience' => 'required',
                    'min_experience' => 'required',
                ]
            );
            $fresher=0;
            $min_experience=$request['min_experience'];
            $max_experience=$request['max_experience'];
        }
        
        
        if($request['id']==0){
            $request->validate(
                [
                    'icon' => 'required',
                ]
            );
            $opening = new Opening();
        }else{
            $opening = Opening::where('id','=',$request['id'])->first();
        }
        if(isset($request['icon']) && !empty($request['icon'])) {
            $icon = $request['icon'];
            $name = $icon->getClientOriginalName();
            $allowediconExtension=['jpg','png','jpeg'];
            $extension = $icon->getClientOriginalExtension();
            $check=in_array($extension,$allowediconExtension);
            if($check){
                $image['filePath'] = $name;
                $icon->move(public_path().'/assets/images/openings/technology_icon/', $name);
                $opening->image = $name;
            }else{
            $err="please upload 'jpg','png','jpeg'";
            return view('dashboard',compact('err'));
            }
        }
        $opening->fresher=$fresher;
        $opening->title = addslashes($request['title']);
        $opening->description =addslashes($request['description']);
        $opening->number_openings = $request['number_openings'];
        $opening->min_experience = $min_experience;
        $opening->max_experience = $max_experience;
        $result = ($request['id'] == 0) ? $opening->save() : $opening->update();
        if ($result) {
            $response = [
                'status' => true,
                'message' => 'Opening '.($request['id']==0 ? 'Added' : 'Updated ').' Successfully',
                'icon' => 'success',
                'redirect_url' => "",
            ];
            echo json_encode($response);
            exit;
        } else {
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

    /* listing job opening data */
    public function listing()
    {
        $data['openings']= Opening::where('status',1)->with('application')->get();
        $data_result = [];
        $id=0;
        $i=0;
        foreach ($data['openings'] as $opening) {
            foreach($opening->application as $application){
                if($application->status==2){
                    $i++;
                }
            }
            $id++;
            $button = '';
            $min_year = intdiv($opening['min_experience'],12);
            $min_month = $opening['min_experience']%12;
            $year_min=($min_year==1) ? 'year' : 'years';
            $month_min=($min_month==1) ? 'month' : 'months';
            $min_experience= $min_year.' '.$year_min.' '.$min_month.' '.$month_min; 
            $max_year = intdiv($opening['max_experience'],12);
            $max_month = $opening['max_experience']%12;
            $year_max=($max_year==1) ? 'year' : 'years';
            $month_max=($max_month==1) ? 'month' : 'months';
            $max_experience= $max_year.' '.$year_max.' '.$max_month.' '.$month_max;
            if(in_array("3", permission())){
                $button .= '<button class="job_edit btn btn-sm btn-success m-1" data-id="'.$opening['id'].'" > 
                <i class="mdi mdi-square-edit-outline"></i>
                </button>';
            }
            if(in_array("4", permission())){
                $button .= '<button class="job_delete btn btn-sm btn-danger m-1" data-id="'.$opening['id'].'"> 
                <i class="mdi mdi-delete"></i>
                </button>';
            }
            $image= $opening['image'];
            $img = '<img src="'.asset('/assets/images/openings/technology_icon').'/'.$image.'" height="50px" width="50px" alt="">';
            $remaining = $opening['number_openings']-$i;
            $data_result[] = array( 
            "id"=>$id, 
            "title"=>$opening['title'],
            "description"=>mb_strimwidth($opening['description'], 0, 50, "..."),
            "number_openings"=>$opening['number_openings'],
            "remaining"=>$remaining,
            "min_experience"=>$min_experience,
            "max_experience"=>$max_experience,
            "technology"=>$img,
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
    
    /* display job opening data for updating */
    public function show(Request $request)
    {
        $id=$request['id'];
        $job = Opening::where('id',$id)->first(); 
        if(!empty($job)){
            $response = [
                'status'=>true,
                'title' => $job->title,
                'description' => $job->description,
                'fresher' => $job->fresher,
                'min_experience' => $job->min_experience,
                'max_experience' => $job->max_experience,
                'number_openings' => $job->number_openings,
            ];
            echo json_encode($response);
            exit;
        }else{
            $response = [
                'status' => false,
                'message' => "error in fetching",
                'icon' => 'error',
                'redirect_url' => "",
            ];
            echo json_encode($response);
            exit;
        }
    }

    /* deleting job opening data */
    public function delete(Request $request)
    {
        $id=$request['id'];
        
        $job = Opening::where('id',$id)->first();
        if(!empty($job) && $job['status']==1){
            $job->status = 2;
        }
        if($job->update()){
            $response = [
                'status' => true,
                'message' => "Opening deleted successfully",
                'icon' => 'success',
                'redirect_url' => "",
            ];
            echo json_encode($response);
            exit;
        }else{
            $response = [
                'status' => false,
                'message' => "error in deleting",
                'icon' => 'error',
                'redirect_url' => "",
            ];
            echo json_encode($response);
            exit;
        }
    }

}