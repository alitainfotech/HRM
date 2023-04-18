<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class CandidateReviewController extends Controller
{
    public function index()
    {
        return view('pages.admin.review-list');
    }

    /* listing of reviews */
    public function listing()
    {
        $review = Review::select('*',\DB::raw('(CASE 
        WHEN type = "0" THEN "-"
        WHEN type = "1" THEN "HR Review"
        WHEN type = "2" THEN "Verble Review"
        WHEN type = "3" THEN "Technical Review"
        ELSE "-"
        END) AS type'))->get();
        $data_result = [];
        $id=0;
        foreach ($review as $row) {
            
            $candidate = $row->getInterview->application->load('candidate')->candidate;
            $opening = $row->getInterview->application->load('opening')->opening;
            $id++;
            // $button = '';
            // if($row->getInterview->status == 1){     
            //     if(in_array("32", permission())){
            //          $button.='<div class="btn btn-icon btn-danger reject_candidate m-1" data-id="'.$row->i_id.'" data-a_id="'.$row->getInterview->application['id'].'"><i class="mdi mdi-close-outline"></i></div>';
            //     }
            //     if(in_array("31", permission())){
            //         $button.='<div class="btn btn-icon btn-success select_candidate m-1" data-id="'.$row->i_id.'" data-a_id="'.$row->getInterview->application['id'].'"><i class="mdi mdi-check-outline"></i></div>';
            //     }
            // }
            $data_result[] = array( 
            "id"=>$id, 
            "post"=>$opening['title'],
            "name"=>$candidate['full_name'],
            "review_type"=>$row->type,
            "review"=>$row->review,
            "description"=>$row->description,
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