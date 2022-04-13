<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /* display user dashboard */
    public function index()
    {
        $data['roles'] = Role::where('status',1)->where('id','!=',1)->get();
        $data['departments'] = Department::where('status',1)->get();
        return view('pages.admin.adminUser',compact('data'));
    }

    /* listing of user */
    public function listing()
    {
        $data['admin_users']= Admin::where('status',1)->where('role_id','!=',1)->with('role')->with('department')->get();
        $data_result = [];
        foreach ($data['admin_users'] as $admin_user) {
            $button = '';
            if(in_array("7", permission())){
                $button .= '<button class="user_edit btn btn-sm btn-success m-1" data-id="'.$admin_user['id'].'" > 
                <i class="mdi mdi-square-edit-outline"></i>
                </button>';
            }if(in_array("8", permission())){
                $button .= '<button class="user_delete btn btn-sm btn-danger m-1" data-id="'.$admin_user['id'].'"> 
                <i class="mdi mdi-delete"></i>
                </button>';
            }
            $joining_date=date('d-m-Y',strtotime($admin_user['created_at']));
            $data_result[] = array(    
            "full_name"=>$admin_user['full_name'],
            "email"=>$admin_user['email'],
            "department"=>$admin_user->department->name,
            "j_date"=>$joining_date,
            "designation"=>$admin_user['designation'],
            "role"=>$admin_user->role->title,
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

    /* store user to database */
    public function store(Request $request)
    {
        
        $request->validate(
            [
                'fullname' => 'required',
                'u_email' => 'required',
                'designation' => 'required',
                'role' => 'required',
                'department' => 'required',
            ]
        );
        if($request['id']==0){
            $request->validate(
                [
                    'password' => 'required',
                ]
            );
            $user = new Admin();
        }else{
            $user = Admin::where('id','=',$request['id'])->first();
            echo 'updated';
        }
        $user->full_name =$request['fullname'];
        $user->email =$request['u_email'];
        $user->password = Hash::make($request['password']);
        $user->designation = $request['designation'];
        $user->role_id = $request['role'];
        $user->d_id = $request['department'];
        $user->created_at =now();
        $user->updated_at =now();
        $user->save();
    
    }

    /* checking email for availability */
    public function emailcheck(){
        $email = $_POST['email'];
        $user = Admin::where('email', $email)->first();
        echo $user;
    }
     
    /* display user for updating */
    public function show(Request $request)
    {
        $id=$request['id'];
        $user = Admin::where('id',$id)->first(); 
        if(!empty($user)){
            echo json_encode($user);
        }else{
            return redirect(route('user.dashboard'));
        }
    }

    /* for deleting user */
    public function delete(Request $request)
    {
        $id=$request['id'];
        $user = Admin::where('id',$id)->first();
        if(!empty($user) && $user['status']==1){
            $user->status = 0;
            $user->update();
            echo 'deleted';
        }else{
            return redirect(route('user.dashboard'));
        }
    }
}
