<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\application as MailApplication;
use App\Models\Application;
use App\Models\Opening;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NewApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job_openings = Opening::with(['application'=>function($q){
            $q->where('c_id',Auth::user()->id);
        }])->where('status','=',1)->get();
        return view('pages.candidate.dashboard',compact('job_openings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('pages.candidate.listing');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'phone' => 'required',
                'o_id' => 'required',
                'cv' => 'required',
                'experience_year' => 'required',
                'experience_month' => 'required',
                'description' => 'required'
            ]
        );
            
        $application = new Application();
        $c_id = $request['c_id'];
        $cv = $request['cv'];
        if(isset($cv) && !empty($cv)) {

            $name = $cv->getClientOriginalName();
            $allowedcvExtension=['pdf','docx'];
            $extension = $cv->getClientOriginalExtension();
            $check=in_array($extension,$allowedcvExtension);
            if($check){
                $image['filePath'] = $name;
                $cv->move(public_path().'/assets/images/users/users_cv/', $name);
                $application->cv = $name;
            }else{
            $err="please upload 'pdf','docx'";
            return view('dashboard',compact('err'));
            }
        }
        $experience = ($request['experience_year']*12)+$request['experience_month'];
        $candidate = User::where('id', $c_id)->first();
        $fullname=$candidate->full_name;
        $candidate->phone = $request['phone'];
        $candidate->updated_at =now();
        $candidate->update();
        $application->c_id = $c_id;
        $application->o_id = $request['o_id'];
        $application->description = addslashes($request['description']);
        $application->experience = $experience;  
        $application->created_at =now();
        $application->updated_at =now();
        $application->save();
        if($application->save()){
            // event(new NewApplication($fullname));
            // Mail::to($candidate->email)->send(new MailApplication($request['o_id'],$fullname));
        }
        

    
    }

    public function listing()
     {
         $data['applications']= Application::where('c_id',Auth::user()->id)->with('candidate')->with('opening')->get();
         $data_result = [];
         $id=0;
         foreach ($data['applications'] as $application) {
             
             $id++;
             $year = intdiv($application['experience'],12);
             $month = $application['experience']%12;
             $experience= $year.' year '.$month.' month ';
             if($application['status']==0){
                $status="pending";$class="btn-info";}
                elseif($application['status']==1){
                $status="reviewed";$class="btn-info";}
                elseif($application['status']==2){
                $status="selected";$class="btn-success";}
                elseif($application['status']==3){
                $status="rejected";$class="btn-danger";}
                $status_div= '<div class="btn mx-2 '.$class.' ">'. $status .'</div>';
                $date=date('d-m-Y ',strtotime($application['created_at']));
             $data_result[] = array( 
             "id"=>$id, 
             "title"=>$application->opening['title'],
             "date"=>$date,
             "experience"=>$experience,
             "status"=>$status_div
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

     /* checking email for availability */
    public function emailcheck(){
        $email = $_POST['email'];
        $user = User::where('email', $email)->first();
        echo $user;
     }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('pages.candidate.profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        {
            $request->validate(
                [
                    'name' => 'required',
                    'email' => 'required',
                ]
            );
                
            $user =User::where('id',$request->id)->first();
            $user->full_name=$request->name;
            $user->email=$request->email;
            if(!is_null($request->image)){
                
                $p_image=$request->image;
                $name = $p_image->getClientOriginalName();
                $allowedp_imageExtension=['png','jpg','jpeg'];
                $extension = $p_image->getClientOriginalExtension();
                $check=in_array($extension,$allowedp_imageExtension);
                if($check){
                    $image['filePath'] = $name;
                    $p_image->move(public_path().'/assets/images/users/users_profile_photo/', $name);
                    $user->image = $name;
                }
            }
            if(!is_null($request->bio)){
                $user->bio=$request->bio;
            }
            if(!is_null($request->phone)){
                $user->phone=$request->phone;
            }
            $user->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
