<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
        return view('pages.admin.applicant.index');
    }

    /* listing of applicant */
    public function listing(Request $request)
    {
        $applicationData = Application::with('candidate')->with('opening')->get();
        $data_result = [];
        $id=0;
        foreach ($applicationData as $application) {
            $id++;
            $year = intdiv($application['experience'],12);
            $month = $application['experience']%12;
            $experience= $year.' year '.$month.' month ';
            if($application['status']==0){
               $status="pending";$class="badge bg-warning text-dark";}
               elseif($application['status']==1){
               $status="reviewed";$class="badge bg-info text-dark";}
               elseif($application['status']==2){
               $status="selected";$class="badge bg-success";}
               elseif($application['status']==3){
               $status="rejected";$class="badge bg-danger";}
               $status_div= '<div class="btn mx-2 '.$class.' ">'. $status .'</div>';
               $date=date('d-m-Y ',strtotime($application['created_at']));
            $data_result[] = array( 
            "id"=>$id, 
            "post"=>$application->opening['title'],
            "name"=>$application->candidate['full_name'],
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
}