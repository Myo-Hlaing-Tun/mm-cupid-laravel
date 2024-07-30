<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Cities\CitiesController;
use App\Http\Controllers\Hobbies\HobbiesController;
use App\Http\Controllers\Members\MembersController;
use App\Http\Controllers\Points\PointsController;
use App\Http\Controllers\Posts\PostsController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Registration\RegistrationController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\User\UsersController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\TestController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::group(['prefix'=>'/','middleware'=>'admin'],function(){
//     Route::get('/student',[TestController::class, 'test']);
//     Route::post('/student/store',[TestController::class,'formRequestStore'])->name('form.post.store');
//     Route::get('/student/edit/{id}',[TestController::class,'editCity']);
//     Route::post('/student/update',[TestController::class,'formRequestUpdate'])->name('form.post.update');
//     Route::get('/student/delete/{id}',[TestController::class,'deleteCity']);
// });
// Route::get('/login',[AuthController::class, 'loginForm']);
// Route::post('/login',[AuthController::class, 'login'])->name('login');
// Route::get('/logout',[AuthController::class, 'getLogout']);
Route::get('/admin-backend',[AdminLoginController::class, 'getLogin']);
Route::post('/admin-backend',[AdminLoginController::class, 'adminLogin'])->name('admin.login');
Route::get('/register',[MembersController::class, 'register']);
Route::get('/confirm-email',[MembersController::class, 'emailConfirm']);
Route::get('/forget-password',[MembersController::class, 'getInput']);
Route::post('/reset-password',[MembersController::class, 'sendCode'])->name('reset.password');
Route::get('/reset-password',[MembersController::class,'getSendCode']);
Route::get('/new-password/{token}',[MembersController::class,'getChangePassword']);
Route::post('/new-password',[MembersController::class,'changePassword'])->name('password.renew');
Route::get('/login',[MembersController::class, 'getlogin']);
Route::get('/logout',[MembersController::class, 'logout']);
Route::post('/login',[MembersController::class, 'login'])->name('member.login');
Route::group(['prefix'=>'/','middleware'=>'member'],function(){
    Route::get('home',[MembersController::class, 'getIndex']);
    Route::get('profile',[ProfileController::class,'getProfile']);
    Route::get('user/{username}/{id}',[MembersController::class,'viewMember']);
    Route::post('point/purchase',[ProfileController::class,'purchasePoint'])->name('point.purchase');
    Route::group(['prefix'=>'api/'],function(){
        Route::post('sync-members',[MembersController::class, 'syncMembers']);
        Route::post('photo/update',[ProfileController::class,'editPhoto']);
        Route::post('photo/delete',[ProfileController::class,'deletePhoto']);
        Route::post('photo/verify',[ProfileController::class,'verifyPhoto']);
        Route::post('invitation/respond',[ProfileController::class,'respondInvitation']);
        Route::post('viewcount/update',[MembersController::class,'updateViewCount']);
        Route::post('date/request',[MembersController::class,'requestDate']);
        Route::post('sync_login_member',[ProfileController::class,'syncMember']);
        Route::post('member/edit',[ProfileController::class,'editMember']);
        Route::post('password/change',[ProfileController::class,'changePassword']);
    });
});
Route::group(['prefix'=>'/api/'],function(){
    Route::get('getCities',[MembersController::class, 'getCities']);
    Route::get('getHobbies',[MembersController::class, 'getHobbies']);
    Route::get('checkEmail/{email}',[MembersController::class, 'matchEmail']);
    Route::post('registerData',[MembersController::class,'registerData']);
    Route::post('send-code',[MembersController::class,'confirmCode']);
});
Route::get('/confirmaccount',[RegistrationController::class, 'index']);
Route::group(['prefix'=>'/admin-backend/','middleware'=>'admin'],function(){
    Route::get('index',[AdminDashboardController::class,'dashboard']);
    Route::post('point/update',[PointsController::class,'storePoints'])->name('point.update');
    Route::get('api/registrations',[MembersController::class,'getTodayMembers']);
    Route::group(['prefix'=>'user/'],function(){
        Route::get('create',[UsersController::class,'createUser']);
        Route::get('index',[UsersController::class,'getUsers']);
        Route::get('edit/{id}',[UsersController::class,'getEditUser']);
        Route::get('password/edit/{id}',[UsersController::class,'getPasswordChanger']);
        Route::get('delete/{id}',[UsersController::class,'deleteUser'])->name('user.delete');
        Route::get('ban/{id}',[UsersController::class,'banUser'])->name('user.ban');
        Route::get('unban/{id}',[UsersController::class,'unbanUser'])->name('user.unban');
        Route::post('store',[UsersController::class,'storeUser'])->name('user.store');
        Route::post('update',[UsersController::class,'updateUser'])->name('user.update');
        Route::post('password/change',[UsersController::class,"changePassword"])->name('password.update');
    });
    Route::group(['prefix'=>'city/'],function(){
        Route::get('create',[CitiesController::class,'createCity']);
        Route::get('index',[CitiesController::class,'getCities']);
        Route::get('edit/{id}',[CitiesController::class,'getEditCity']);
        Route::post('store',[CitiesController::class,'storeCity'])->name('city.store');
        Route::post('update',[CitiesController::class,'updateCity'])->name('city.update');
    });
    Route::group(['prefix'=>'setting/'],function(){
        Route::get('index',[SettingController::class,'index']);
        Route::get('edit',[SettingController::class,'getEdit']);
        Route::post('update',[SettingController::class,'update'])->name('setting.update');
        Route::post('create',[SettingController::class,'create'])->name('setting.store');
    });
    Route::group(['prefix'=>'hobby/'],function(){
        Route::get('index',[HobbiesController::class,'index']);
        Route::get('create',[HobbiesController::class,'createHobby']);
        Route::post('store',[HobbiesController::class,'storeHobby'])->name('hobby.store');
        Route::get('edit/{id}',[HobbiesController::class,'getEditHobby']);
        Route::post('update',[HobbiesController::class,'updateHobby'])->name('hobby.update');
    });
    Route::group(['prefix'=>'member/'],function(){
        Route::get('index',[MembersController::class,'getMembers']);
        Route::get('filter/{keyword}',[MembersController::class,'filterMembers'])->name('member.filter');
        Route::get('delete/{id}',[MembersController::class,'deleteMember'])->name('member.delete');
        Route::get('confirm/{id}',[MembersController::class,'confirmMember'])->name('member.confirm');
        Route::get('{id}',[MembersController::class,'viewMemberDetails']);
    });
    Route::group(['prefix'=>'post/'],function(){
        Route::get('index',[PostsController::class,'index']);
        Route::get('create',[PostsController::class,'createPost']);
        Route::get('edit/{id}',[PostsController::class,'getEditPost']);
        Route::post('store',[PostsController::class,'storePost'])->name('post.store');
        Route::post('update',[PostsController::class,'updatePost'])->name('post.update');
        Route::get('delete/{id}',[PostsController::class,'deletePost'])->name('post.delete');
    });
    Route::group(['prefix'=>'pointpurchase/'],function(){
        Route::get('index',[PointsController::class,'index']);
        Route::get('{id}',[PointsController::class,'viewDetails']);
        Route::post('confirm',[PointsController::class,'confirmPurchase'])->name('point.confirm');
        Route::get('reject/{id}',[PointsController::class,'rejectPurchase'])->name('purchase.reject');
    });
    Route::group(['prefix'=>'point/'],function(){
        Route::get('subtract/{id}',[PointsController::class,'editPoints']);
        Route::get('log',[PointsController::class,'showPoints']);
    });
    Route::group(['prefix'=>'dating/'],function(){
        Route::get('index',[MembersController::class,'showDatingRequests']);
        Route::get('details/{invite_id}/{accept_id}',[MembersController::class,'showDatingMembers']);
        Route::get('confirm/{id}',[MembersController::class,'approveDating'])->name('dating.approve');
    });
});
Route::get('/admin-backend/logout',[AdminLoginController::class,'adminLogout']);
