<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\ApplicationController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\InterviewController;
use App\Http\Controllers\admin\OpeningController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\frontend\CandidateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

/* admin routes */
Route::group(['prefix' => 'admin'], function(){
    Route::get('/login',[AdminController::class,'index'])->name('admin.login_form');
    Route::post('/login',[AdminController::class,'store'])->name('admin.login'); 
    Route::get('/dashboard',[AdminController::class,'dashboard'])->middleware('admin')->name('admin.dashboard');
    Route::post('/logout',[AdminController::class,'destroy'])->name('admin.logout');
    Route::get('profile',[AdminController::class,'profile'])->name('admin.profile');
});

/* admin dashboard routes */
Route::group(['prefix' => 'admin/dashboard'], function(){
    Route::post('/value',[AdminController::class,'value']);
});

/* opening routes */
Route::group(['prefix' => 'admin/opening'], function(){
    Route::get('/',[OpeningController::class,'index'])->name('opening.dashboard');
    Route::post('/store',[OpeningController::class,'store'])->name('opening.store');
    Route::post('/listing',[OpeningController::class,'listing']);
    Route::post('/show',[OpeningController::class,'show']);
    Route::post('/delete',[OpeningController::class,'delete']);
});

/* user routes */
Route::group(['prefix' => 'admin/user'], function(){
    Route::get('/',[AdminUserController::class,'index'])->name('user.dashboard');
    Route::post('/listing',[AdminUserController::class,'listing']);
    Route::post('/delete',[AdminUserController::class,'delete']);
    Route::post('/emailcheck',[AdminUserController::class, 'emailcheck' ]);
    Route::post('/store',[AdminUserController::class, 'store' ]);
    Route::post('/show',[AdminUserController::class,'show']);
    Route::post('/updatePassword',[AdminUserController::class,'password']);
});

/* permission routes */
Route::group(['prefix' => 'admin/permission'], function(){
    Route::get('/',[PermissionController::class,'index'])->name('permission.dashboard');
    Route::post('/listing',[PermissionController::class,'listing']);
    Route::post('/store',[PermissionController::class,'store'])->name('permission.store');
    Route::post('/show',[PermissionController::class,'show']);
    Route::post('/delete',[PermissionController::class,'delete']);
});

/* role routes */
Route::group(['prefix' => 'admin/role'], function(){
    Route::get('/',[RoleController::class,'index'])->name('role.dashboard');
    Route::post('/listing',[RoleController::class,'listing']);
    Route::get('/add',[RoleController::class,'roleAdd'])->name('role.add');
    Route::post('/store',[RoleController::class,'store'])->name('role.store');
    Route::get('/edit/{role}',[RoleController::class,'edit'])->name('role.edit');
    Route::get('/role_show/{role}',[RoleController::class,'role_show'])->name('role.role_show');
    Route::post('/delete',[RoleController::class,'delete']);
});

/* pending applications routes */
Route::group(['prefix' => 'admin/application/pending'], function(){
    Route::get('/',[ApplicationController::class,'index'])->name('application.pending');
    Route::post('/listing',[ApplicationController::class,'listing']);
    Route::post('/name/show',[ApplicationController::class,'nameShow']);
    Route::post('/reject',[ApplicationController::class,'applicationReject']);
});

/* rejected applications routes */
Route::group(['prefix' => 'admin/application/rejected'], function(){
    Route::get('/',[ApplicationController::class,'indexReject'])->name('application.reject');
    Route::post('/listing',[ApplicationController::class,'listingReject']);
});

/* selected applications routes */
Route::group(['prefix' => 'admin/application/selected'], function(){
    Route::get('/',[ApplicationController::class,'indexSelect'])->name('application.select');
    Route::post('/listing',[ApplicationController::class,'listingSelect']);
});

/* interviews route */
Route::group(['prefix' => 'admin/interview'], function(){
    Route::get('/',[InterviewController::class,'index'])->name('interview.dashboard');
    Route::post('/listing',[InterviewController::class,'listing']);
    Route::post('/show',[InterviewController::class,'show']);
    Route::post('/store',[InterviewController::class,'store']);
});

/* departments route */
Route::group(['prefix' => 'admin/department'], function(){
    Route::get('/',[DepartmentController::class,'index'])->name('department.dashboard');
    Route::post('/listing',[DepartmentController::class,'listing']);
    Route::post('/show',[DepartmentController::class,'show']);
    Route::post('/store',[DepartmentController::class,'store']);
    Route::post('/delete',[DepartmentController::class,'delete']);
});

/* review route */
Route::group(['prefix' => 'admin/review'], function(){
    Route::get('/',[ReviewController::class,'index'])->name('review.dashboard');
    Route::post('/listing',[ReviewController::class,'listing']);
    Route::post('/show',[ReviewController::class,'show']);
    Route::post('/store',[ReviewController::class,'store']);
    Route::post('/delete',[DepartmentController::class,'delete']);
});


// candidates routes
Route::get('/dashboard', [CandidateController::class,'index'])->middleware(['auth'])->name('dashboard');
Route::post('/candidate/emailcheck',[CandidateController::class, 'emailcheck' ]);
Route::post('/application/store',[CandidateController::class,'store']);
Route::get('/user/application', [CandidateController::class,'dashboard'])->middleware(['auth'])->name('user.application');
Route::post('/application/listing', [CandidateController::class,'listing'])->middleware(['auth'])->name('user.listing');
Route::get('profile',[CandidateController::class,'profile'])->name('candidate.profile');
Route::post('/candidate/profile/update', [CandidateController::class,'update']);




require __DIR__.'/auth.php';
