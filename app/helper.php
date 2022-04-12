 <?php

use App\Models\Admin;
use App\Models\Role_Permission;
use Illuminate\Support\Facades\Auth;

    if(!function_exists('permissions')){
        function permission(){
            $role_id = Auth::guard('admin')->user()->role_id;
            $permissions = Role_Permission::select('permission_id')->where('role_id',$role_id)->get();
            foreach($permissions as $permission){
                $p[] = $permission->permission_id;
            }
            return($p);
        }
    }
 ?>