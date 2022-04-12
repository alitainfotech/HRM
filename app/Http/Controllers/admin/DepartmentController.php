<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /* display department view */
    public function index()
    {
        return view('pages.admin.department');
    }

    /* listing of department */
    public function listing()
    {
        $data['departments']= Department::where('status',1)->get();
        $data_result = [];
        $id = 0;
        foreach ($data['departments'] as $department) {
            $button = '';
            if(in_array("27", permission())){
                $button .= '<button class="department_edit btn btn-sm btn-success m-1" data-id="'.$department['id'].'" > 
                <i class="mdi mdi-square-edit-outline"></i>
                </button>';
            }
            if(in_array("28", permission())){
                $button .= '<button class="department_delete btn btn-sm btn-danger m-1" data-id="'.$department['id'].'"> 
                <i class="mdi mdi-delete"></i>
                </button>';
            }
            $id++;
            $data_result[] = array(  
            "id"=>$id,      
            "name"=>$department['name'],
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

    /* adding and updating data to database */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
            ]
        );

        if($request['id']==0){
            $old_d = Department::where('status',1)->where('name',$request->name)->first();
            if(is_null($old_d)){
                $department = new Department();
                $department->created_at =now();
            }else{
                $responce = [
                    'status'=>false,
                    'message'=>"Already create this department!",
                    'redirect_url'=>"",
                ];
                echo json_encode($responce);
                exit;
            } 
        }else{
            $department = Department::where('id','=',$request['id'])->first();
        }
        $department->name = $request['name'];
        $department->updated_at =now();
        $department->save();
        if($department->save()){
            $responce = [
                'status'=>true,
                'message'=>"Success",
            ];
            echo json_encode($responce);
            exit;
        }else{
            $responce = [
                'status'=>false,
                'message'=>"Fail in adding department",
                'redirect_url'=>"",
            ];
            echo json_encode($responce);
            exit;
        }
    }
    
    /* display data of department for updating data */
    public function show(Request $request)
    {
        $department= Department::where('id',$request['id'])->first();
        if(!is_null($department) ){
            $data['responce'] = [
                'status'=>true,
                'message'=>"Success",
            ];
            $data['department'] = $department;
            echo json_encode($data);
            exit;
        }else{
            $data['responce'] = [
                'status'=>false,
                'message'=>"This data is not available for update",
                'redirect_url'=>"",
            ];
            echo json_encode($data);
            exit;
        }
    }

    /* deleting of department */
    public function delete(Request $request)
    {
        $id=$request['id'];
        $department = Department::where('id',$id)->first();
        if(!is_null($department) && $department['status']==1){
            $department->status = 2;
            $department->update();
            $department->updated_at=now();
            $responce = [
                'status'=>true,
                'message'=>"Success",
            ];
            echo json_encode($responce);
            exit;
        }else{
            $responce = [
                'status'=>false,
                'message'=>"This data is not available for delete",
                'redirect_url'=>"",
            ];
            echo json_encode($responce);
            exit;
        }
    }
}
