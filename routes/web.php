<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

// frontend 
Route::get('/', function () {
    return view('welcome');
});


// admin 
Route::get('/admin-login', [Admin\AuthController::class, 'login'])->name('admin.login');
Route::post('/admin-loginAction', [Admin\AuthController::class, 'loginAction'])->name('admin.login.action');
Route::get('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

Route::get('/category-wise-sub-category/{id}', [CommonController::class, 'category_wise_sub_category']);

Route::group(['middleware' => 'admin_auth', 'prefix' => 'admin-panel', 'as' => 'admin.'], function () {
    
    Route::get('/', [Admin\MasterController::class, 'master'])->name('master');

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('category', Admin\CategoryController::class);
    Route::resource('subcategory', Admin\SubCategoryController::class);
    Route::resource('product', Admin\ProductController::class);
    Route::resource('roles', Admin\RoleController::class);
    Route::resource('rolePermissions', Admin\RolePermissionController::class);
    Route::resource('generalSettings', Admin\SettingController::class);
    Route::resource('profileSettings', Admin\ProfileSettingController::class);

    Route::get('user-list', [Admin\UserAccessController::class, 'index'])->name('user.list');
    Route::get('user/edit-role', [Admin\UserAccessController::class, 'edit'])->name('user.edit_role');
    Route::post('user/update-role', [Admin\UserAccessController::class, 'update'])->name('user.role_update');
    
    Route::get('test', [TestController::class, 'index'])->name('test');

});

