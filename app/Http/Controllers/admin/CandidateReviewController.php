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
        $review = Review::get()->groupBy('i_id');
        // $review = Review::get();
        // dd($review);
        $data_result = [];
        $id=0;
        foreach ($review as $row) {
            // dd($row[0]['i_id']);
            $candidate = $row[0]->getInterview->application->load('candidate')->candidate;
            $opening = $row[0]->getInterview->application->load('opening')->opening;
            $id++;
            $button = '';
            if(in_array("35", permission())){
                $button.='<div class="btn btn-icon btn-info show-given-review m-1" data-i_id="'.($row[0]->i_id).'"><i class="mdi mdi-eye"></i><p class="d-none" id="given_review_'.$row[0]->i_id.'">'.$row[0]->getInterview->reviews.'</p></div>';
            }
            $data_result[] = array( 
                "id"=>$id, 
                "name"=>$candidate['full_name'],
                "post"=>$opening['title'],
                "action"=>$button,
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