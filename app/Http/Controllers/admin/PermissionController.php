<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /* display permission dashboard */
    public function index()
    {
        return view('pages.admin.permission');
    }

    /* listing of permissions */
    public function listing()
    {
        $data['permissions']= Permission::where('status',1)->get();
        $data_result = [];
        $id = 0;
        foreach ($data['permissions'] as $permission) {
            $button = '';
            if(in_array("15", permission())){
                $button .= '<button class="permission_edit btn btn-sm btn-success m-1" data-id="'.$permission['id'].'" > 
                <i class="mdi mdi-square-edit-outline"></i>
                </button>';
            }
            if(in_array("16", permission())){
                $button .= '<button class="permission_delete btn btn-sm btn-danger m-1" data-id="'.$permission['id'].'"> 
                <i class="mdi mdi-delete"></i>
                </button>';
            }
            $id++;
            $data_result[] = array(  
            "id"=>$id,      
            "name"=>$permission['name'],
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

    /* storing permission to dataabse */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
            ]
        );
           
        if($request['id']==0){
            $old_p = Permission::where('status',1)->where('name',$request->name)->first();
            if(is_null($old_p)){
                $permission = new Permission();
                $permission->created_at =now();
            }else{
                $responce = [
                    'status'=>false,
                    'message'=>"Already create this permission!",
                    'redirect_url'=>"",
                ];
                echo json_encode($responce);
                exit;
            } 
        }else{
            $permission = Permission::where('id','=',$request['id'])->first();
        }
        $permission->name = $request['name'];
        $permission->created_at =now();
        $permission->updated_at =now();
        $permission->save();
        if($permission->save()){
            $responce = [
                'status'=>true,
                'message'=>"Success",
            ];
            echo json_encode($responce);
            exit;
        }else{
            $responce = [
                'status'=>false,
                'message'=>"Fail in adding permission",
                'redirect_url'=>"",
            ];
            echo json_encode($responce);
            exit;
        }
    }

    /* display permission for updating */
    public function show(Request $request)
    {
        $permission = Permission::where('id',$request['id'])->first(); 
        if(!is_null($permission) ){
            $data['responce'] = [
                'status'=>true,
                'message'=>"Success",
            ];
            $data['permission'] = $permission;
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

    /* for deleting permission */
    public function delete(Request $request)
    {
        $permission = Permission::where('id',$request['id'])->first();
        if(!is_null($permission) && $permission['status']==1){
            $permission->status = 2;
            $permission->update();
            $permission->updated_at=now();
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
