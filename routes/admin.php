<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCateoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\VatController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CustomerController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard',[ProfileController::class,'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:admin'])->group(function(){
        // Route::resource('user',UserController::class);
        // Route::resource('role',RoleController::class);
        Route::resource('permission',PermissionController::class);
        Route::resource('category',CategoryController::class);
        Route::resource('subcategory',SubCateoryController::class);
        Route::resource('collection',CollectionController::class);
        Route::resource('product',ProductController::class);
        Route::get('/get/subcategory',[ProductController::class,'getsubcategory'])->name('getsubcategory');
        Route::get('/remove-external-img/{id}',[ProductController::class,'removeImage'])->name('remove.image');
    });

    Route::middleware(['check-permission'])->group(function(){
        Route::resource('user',UserController::class);
        Route::resource('role',RoleController::class);
        Route::resource('location',LocationController::class);
        Route::post('location/change-status', [LocationController::class, 'changeStatus'])->name('location.change-status');
    });

    Route::resource('vat',VatController::class);

    Route::resource('supplier',SupplierController::class);
    Route::post('supplier/change-status', [SupplierController::class, 'changeStatus'])->name('supplier.change-status');

    
    Route::resource('department',DepartmentController::class);
    Route::post('department/change-status', [DepartmentController::class, 'changeStatus'])->name('department.change-status');

    Route::get('department/sub/index', [DepartmentController::class, 'listSubDepartment'])->name('department.sub.index');
    Route::get('department/sub/create', [DepartmentController::class, 'createSubDepartment'])->name('department.sub.create');
    Route::post('department/sub/store', [DepartmentController::class, 'storeSubDepartment'])->name('department.sub.store');
    Route::get('department/sub/edit/{id}', [DepartmentController::class, 'editSubDepartment'])->name('department.sub.edit');
    Route::post('department/sub/change-status', [DepartmentController::class, 'changeStatusSubDepartments'])->name('department.sub.change-status');
    
    Route::resource('customer',CustomerController::class);
    Route::post('customer/change-status', [CustomerController::class, 'changeStatus'])->name('customer.change-status');
    Route::post('user/change-status', [UserController::class, 'changeStatus'])->name('user.change-status');
    Route::post('role/change-status', [RoleController::class, 'changeStatus'])->name('role.change-status');
    Route::post('permission/change-status', [PermissionController::class, 'changeStatus'])->name('permission.change-status');
});
