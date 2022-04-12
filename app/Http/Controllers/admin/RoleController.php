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
            // dd($role['title']);
            $button .= '<a href="'.route('role.role_show',$role['id']).'"><button class="role_show btn btn-sm btn-success m-1"  data-id="'.$role['id'].'" > 
            <i class="mdi mdi-view-module"></i>
            </button></a>';
            if(in_array("11", permission())){
                $button .= '<button class="role_edit btn btn-sm btn-success m-1" data-id="'.$role['id'].'" > 
                <i class="mdi mdi-square-edit-outline"></i>
                </button>';
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
        
        $role_t = Role::where('title',$request['title'])->first();
        
        if(is_null($role_t) && $request['id']==0){
            $role = new Role();
            echo json_encode('inserted');
        }else{
            $role = Role::where('id','=',$request['id'])->with('role_role_permission')->first();
            DB::table('role__permissions')->where('role_id', $request['id'])->delete();
            echo 'updated';
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
        Role_permission::insert($permissions);
       
    }

    public function show(Request $request)
    {
        $id=$request['id'];
        $role = Role::where('id',$id)->with('role_role_permission')->first();
        if(!empty($role)){
            $i=0;
            foreach($role->role_role_permission as $permission){
                $p_id[$i]=$permission->permission_id;
                $i++;
            }
            $title=$role->title;
            $data = array("title"=>$title, "p_id"=>$p_id);
            echo json_encode($data);
        }else{
            return redirect(route('role.dashboard'));
        }
        
    }

    public function delete(Request $request)
    {
        $id=$request['id'];
        // dd($request['id']);
        $role = role::where('id',$id)->first();
        if(!empty($role) && $role['status']==1){
            $role->status = 2;
            $role->update();
            echo 'deleted';
        }else{
            return redirect(route('role.dashboard'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function role_show(Role $role)
    {
        $id = $role['id'];
        $role_ = Role::where('id',$id)->with('role_role_permission')->first(); 
        // dd($role_);
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

   

    public function update(Request $request, $id)
    {
        //
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
