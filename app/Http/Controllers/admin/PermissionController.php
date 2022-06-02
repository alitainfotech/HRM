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
            }else{
                $response = [
                    'status' => false,
                    'message' => "Already added this permission",
                    'icon' => 'info',
                    'redirect_url' => "",
                ];
                echo json_encode($response);
                exit;
            } 
        }else{
            $permission = Permission::where('id','=',$request['id'])->first();
        }
        $permission->name = $request['name'];
        $result = ($request['id'] == 0) ? $permission->save() : $permission->update();
        if ($result) {
            $response = [
                'status' => true,
                'message' => 'Permission '.($request['id']==0 ? 'Added' : 'Updated ').' Successfully',
                'icon' => 'success',
                'redirect_url' => "",
            ];
            echo json_encode($response);
            exit;
        }else{
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

    /* display permission for updating */
    public function show(Request $request)
    {
        $permission = Permission::where('id',$request['id'])->first(); 
        if(!is_null($permission) ){
            $response = [
                'status'=>true,
                'name' => $permission->name,
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

    /* for deleting permission */
    public function delete(Request $request)
    {
        $permission = Permission::where('id',$request['id'])->first();
        if(!is_null($permission) && $permission['status']==1){
            $permission->status = 2;
        }
        if($permission->update()){
            $response = [
                'status' => true,
                'message' => "Permission deleted successfully",
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
