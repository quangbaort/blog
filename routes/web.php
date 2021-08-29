<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('home');
});
Route::get('/logout', function () {
    Auth::logout();
    return back();
})->name('logout');
// ------------------------------
Route::middleware('login')->group(function () {
    Route::get('/auth/login', [App\Http\Controllers\Users\AuthController::class, 'index'])->name('user.login');
    Route::get('/auth/register', [App\Http\Controllers\Users\AuthController::class , 'register'])->name('user.register');
});
Route::get('/test', function () {
    return view('test');
});
Route::get('/tags/{slug}', [App\Http\Controllers\TagController::class, 'index'])->name('tag');
Route::get('/category/{slug}', [App\Http\Controllers\CategoryController::class, 'index'])->name('category');
Route::get('/post/{slug}', [App\Http\Controllers\ArticleController::class, 'index'])->name('article');

// ------------------------------
// người dùng chưa đăng nhập
Route::middleware('userLogined')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Users\AuthController::class , 'profile'])->name('user.profile');
});
// Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
//     ->name('ckfinder_connector');

// Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
//     ->name('ckfinder_browser');
// ---------------------------------
// người dùng đã đăng nhập
Route::middleware(['adminLogined' , 'role:admin|editor'])->prefix('admin')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\Admin\AuthController::class , 'profile'])->name('admin.profile');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class , 'dashboard'])->name('admin.dashboard');
    Route::post('/update-avatar', [\App\Http\Controllers\Admin\AuthController::class , 'updateAvatar'])->name('admin.updateAvatar');
    Route::post('/update-infomation', [\App\Http\Controllers\Admin\AuthController::class , 'updateInfo'])->name('admin.updateInfo');
    Route::post('/update-password', [\App\Http\Controllers\Admin\AuthController::class , 'updatePassword'])->name('admin.updatePassword');
    Route::get('/user', [App\Http\Controllers\Admin\UserController::class , 'index'])->name('admin.users')->middleware('permission:view user');
    Route::post('/add-user', [App\Http\Controllers\Admin\UserController::class , 'store'])->name('admin.addUser')->middleware('permission:create user');
    Route::post('/update-user/{id}', [App\Http\Controllers\Admin\UserController::class , 'update'])->name('admin.updateUser')->middleware('permission:edit user');
    Route::post('/change-password/{id}', [App\Http\Controllers\Admin\UserController::class , 'changePasswordUser'])->name('admin.changePasswordUser')->middleware('permission:edit user');
    Route::get('/delete-user/{id}', [App\Http\Controllers\Admin\UserController::class , 'destroy'])->name('admin.deleteUser')->middleware('permission:delete user');
    Route::get('/role' , [App\Http\Controllers\Admin\RoleController::class , 'index'])->name('admin.role')->middleware('permission:user grant');
    Route::post('/add-role' , [App\Http\Controllers\Admin\RoleController::class , 'store'])->name('admin.addRole')->middleware('permission:user grant');
    Route::post('/update-role/{id}' , [App\Http\Controllers\Admin\RoleController::class , 'update'])->name('admin.updateRole')->middleware('permission:user grant');
    Route::get('/delete-role/{id}' , [App\Http\Controllers\Admin\RoleController::class , 'destroy'])->name('admin.deleteRole')->middleware('permission:user grant');
    Route::get('/permissions' , [App\Http\Controllers\Admin\PermissionController::class , 'index'])->name('admin.permissions')->middleware('permission:user grant');
    Route::get('/delete/permission/{id}' , [App\Http\Controllers\Admin\PermissionController::class , 'destroy'])->name('admin.deletePermission')->middleware('permission:user grant');
    Route::post('/add-permission' , [App\Http\Controllers\Admin\PermissionController::class , 'store'])->name('admin.addPermission')->middleware('permission:user grant');
    Route::get('/category' , [App\Http\Controllers\Admin\CategoryController::class , 'index'])->name('admin.category')->middleware('permission:view category');
    Route::post('/add-categoty' , [App\Http\Controllers\Admin\CategoryController::class , 'store'])->name('admin.addCategory')->middleware('permission:create category');
    Route::post('/update-category/{id}' , [App\Http\Controllers\Admin\CategoryController::class , 'update'])->name('admin.updateCategory')->middleware('permission:update category');
    Route::get('/delete-category/{id}' , [App\Http\Controllers\Admin\CategoryController::class , 'destroy'])->name('admin.deleteCategory')->middleware('permission:delete category');
    Route::get('/tag' , [App\Http\Controllers\Admin\TagController::class , 'index'])->name('admin.tag')->middleware('permission:view tag');
    Route::post('/add-tag' , [App\Http\Controllers\Admin\TagController::class , 'store'])->name('admin.addTag')->middleware('permission:create tag');
    Route::post('/update-tag/{id}' , [App\Http\Controllers\Admin\TagController::class , 'update'])->name('admin.updateTag')->middleware('permission:update tag');
    Route::get('/delete-tag/{id}' , [App\Http\Controllers\Admin\TagController::class , 'destroy'])->name('admin.deleteTag')->middleware('permission:delete tag');
    Route::get('/post' , [App\Http\Controllers\Admin\ArticleController::class , 'index'])->name('admin.article')->middleware('permission:view post|create post|delete post');
    Route::get('/create-article' , [App\Http\Controllers\Admin\ArticleController::class , 'create'])->name('admin.createArticle')->middleware('permission:create post');
    Route::post('/add-article' , [App\Http\Controllers\Admin\ArticleController::class , 'store'])->name('admin.addArticle')->middleware('permission:create post');
    Route::post('/update-article/{id}' , [App\Http\Controllers\Admin\ArticleController::class , 'update'])->name('admin.updateArticle')->middleware('permission:edit post');
    Route::get('/delete-article/{id}' , [App\Http\Controllers\Admin\ArticleController::class , 'destroy'])->name('admin.deleteArticle')->middleware('permission:delete post');
    Route::get('/edit-article/{id}' , [App\Http\Controllers\Admin\ArticleController::class , 'edit'])->name('admin.editArticle')->middleware('permission:edit post');

});
// admin đã đăng nhập
// -------------------------------------
Route::middleware('adminLogin')->prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class , 'login'])->name('admin.login');
    Route::post('/postlogin', [App\Http\Controllers\Admin\AuthController::class , 'postLogin'])->name('admin.postLogin');


});
// ------------------------------
// admin chưa đăng nhập
// -----------------------------------------
// route test