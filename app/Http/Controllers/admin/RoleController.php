<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Role_Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $permissions = Permission::where('status',1)->get();
        return view('pages.admin.role',compact('permissions'));
    }

    public function listing()
    {
        $data['roles']= Role::where('status',1)->where('id','!=',1)->get();
        $data_result = [];
        $id = 0;
        foreach ($data['roles'] as $role) {
            $button = '';
            $button .= '<a href="'.route('role.role_show',$role['id']).'"><button class="role_show btn btn-sm btn-success m-1"  data-id="'.$role['id'].'" > 
            <i class="mdi mdi-view-module"></i>
            </button></a>';
            if(in_array("11", permission())){
                $button .= '<a href="'.route('role.edit',$role['id']).'"><button class="role_edit btn btn-sm btn-success m-1" data-id="'.$role['id'].'" > 
                <i class="mdi mdi-square-edit-outline"></i>
                </button></a>';
            }
            if(in_array("12", permission())){
                $button .= '<button class="role_delete btn btn-sm btn-danger m-1" data-id="'.$role['id'].'"> 
                <i class="mdi mdi-delete"></i>
                </button>';
            }
            $id++;
            $data_result[] = array(  
            "id"=>$id,      
            "title"=>$role['title'],
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

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'permission' => 'required|array',
                'permission.*' => 'required|min:1',
            ]
        );
        if($request['id']==0){
            $role_t = Role::where('title',$request['title'])->first();
            if(is_null($role_t)){
                $role = new Role();
                $role->created_at =now();
            }else{
                $responce = [
                    'status'=>false,
                    'message'=>"Already create this role!",
                    'redirect_url'=>"",
                ];
                echo json_encode($responce);
                exit;
            } 
        }else{
            $role = Role::where('id','=',$request['id'])->with('role_role_permission')->first();
            DB::table('role__permissions')->where('role_id', $request['id'])->delete();
        }
        $role->title = $request['title'];
        $role->created_at =now();
        $role->updated_at =now();
        $role->save();
        foreach($request['permission'] as $permission){
            $permissions[] = [
                "role_id" => $role['id'],
                "permission_id" => $permission
            ];
        }
        $x= Role_permission::insert($permissions);
        if($role->save() && $x){
            $responce = [
                'status'=>true,
                'message'=>"Success",
            ];
            echo json_encode($responce);
            exit;
        }else{
            $responce = [
                'status'=>false,
                'message'=>"Fail in adding role",
                'redirect_url'=>"",
            ];
            echo json_encode($responce);
            exit;
        }
    }

    // public function show(Request $request)
    // {
    //     $id=$request['id'];
    //     $role = Role::where('id',$id)->with('role_role_permission')->first();
    //     if(!is_null($role) ){
    //         $data['responce'] = [
    //             'status'=>true,
    //             'message'=>"Success",
    //         ];
    //         $i=0;
    //         foreach($role->role_role_permission as $permission){
    //             $p_id[$i]=$permission->permission_id;
    //             $i++;
    //         }
    //         $title=$role->title;
    //         $data['permission'] = array("title"=>$title, "p_id"=>$p_id);
    //         echo json_encode($data);
    //         exit;
    //     }else{
    //         $data['responce'] = [
    //             'status'=>false,
    //             'message'=>"This data is not available for update",
    //             'redirect_url'=>"",
    //         ];
    //         echo json_encode($data);
    //         exit;
    //     } 
    // }

    public function delete(Request $request)
    {
        $id=$request['id'];
        $role = role::where('id',$id)->first();
        if(!is_null($role) && $role['status']==1){
            $role->status = 2;
            $role->updated_at=now();
            $role->update();
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
    public function role_show(Role $role)
    {
        $id = $role['id'];
        $role_ = Role::where('id',$id)->with('role_role_permission')->first(); 
        if(!empty($role_)){
            $i=0;
            foreach($role_->role_role_permission as $role_permission){
                $permission = $role_permission->load('permission_role_permission')->permission_role_permission;
                $p_id[$i]=$permission->name;
                $i++;
            }
            $title=$role_permission->role_role_permission->title;
            $data = array("title"=>$title, "p_id"=>$p_id);
        }else{
            return redirect(route('role.dashboard'));
        }
        return view('pages.admin.role_show',compact('data'));
        
    }

    public function roleAdd()
    {
        $data['permissions'] = Permission::where('status',1)->get();
        $data['role']=null;
        $data['p_id']=null;
        return view('pages.admin.roleAdd',compact('data'));
    }

    public function edit(Role $role)
    {
        $id = $role['id'];
        $data['role'] = Role::where('id',$id)->with('role_role_permission')->first(); 
        $data['permissions'] = Permission::where('status',1)->get();
            if(!is_null($role) ){
                $i=0;
                foreach($role->role_role_permission as $permission){
                    $p_id[$i]=$permission->permission_id;
                    $i++;
                }
                $title=$role->title;
                $data['p_id'] = array("p_id"=>$p_id);
                return view('pages.admin.roleAdd',compact('data'));
            }else{
                return view('pages.admin.role');
            } 
        
    }
}
