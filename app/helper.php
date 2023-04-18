 <?php

use App\Models\Admin;
use App\Models\Application;
use App\Models\Role_Permission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    function active_class($path, $active = 'active') {
      return call_user_func_array('Request::is', (array)$path) ? $active : '';
    }
      
    function is_active_route($path) {
      return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
    }
      
    function show_class($path) {
      return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
    }

    function enableAfterThreeMonthOpening($opningId){ 
      $getApplication = Application::where(['c_id' => Auth::user()->id,'o_id' => $opningId])->where("created_at",">", Carbon::now()->subMonths(3))->latest()->first();
      if(!empty($getApplication)){
        return true;
      }
      return false;
    }
 ?>