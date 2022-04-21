<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Application;
use App\Models\Interview;
use App\Models\Opening;
use App\Models\User;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    
    /* display log in page */
    public function index()
    {
        return view('pages.admin.login');
    }

    /* display dashboard for admin */
    public function dashboard()
    {
        return view('pages.admin.dashboard');
    }

    /* add user of admin panel */
    public function store(Request $request)
    {
        
        $check = $request->all();
        if(Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password'] ])){
            return redirect(route('admin.dashboard'));
        }else{
            $error= 'Please enter valid email and password!';
             return (View('pages.admin.login',compact('error')));
        }
    }

    /* view of profile */
    public function profile()
    {
        $admin_user = Admin::with(['role'])->with('department')->find(Auth::guard('admin')->id());
        return view('pages.admin.profile',compact('admin_user'));
    }
    
    /* return value for dashboard */
    public function value()
    {
        $data['openings_active']= count(Opening::where('status',1)->get());
        $data['users_active']= count(User::where('status',1)->get());
        $data['users_inactive']= count(User::where('status',0)->get());
        $data['application_pending']= count(Application::where('status',0)->get());
        $data['application_reviewed']= count(Application::where('status',1)->get());
        $data['application_rejected']= count(Application::where('status',3)->get());
        $data['application_selected']= count(Application::where('status',2)->get());
        $data['interviews_active']= count(Interview::where('status',1)->get());
        $data['interviews_inactive']= count(Interview::where('status',0)->get());
        echo json_encode($data); 
    }

    /* logout */
   public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }

    /* profile update */
    public function update(Request $request)
    {
        {
            $request->validate(
                [
                    'name' => 'required',
                    'email' => 'required',
                ]
            );
                
            $user =Admin::where('id',$request->id)->first();
            $user->full_name=$request->name;
            if(!is_null($request->image)){
                
                $p_image=$request->image;
                $name = $p_image->getClientOriginalName();
                $allowedp_imageExtension=['png','jpg','jpeg'];
                $extension = $p_image->getClientOriginalExtension();
                $check=in_array($extension,$allowedp_imageExtension);
                if($check){
                    $image['filePath'] = $name;
                    $p_image->move(public_path().'/assets/images/admin_users/admin_users_profile_photo/', $name);
                    $user->image = $name;
                }
            }
            if(!is_null($request->bio)){
                $user->bio=$request->bio;
            }
            if(!is_null($request->phone)){
                $user->phone=$request->phone;
            }
            if(!is_null($request->dob)){
                $user->dob=date('Y-m-d',strtotime($request->dob));
            }
            if(!is_null($request->address)){
                $user->address=$request->address;
            }
            $user->save();
        }
    }
    
}
