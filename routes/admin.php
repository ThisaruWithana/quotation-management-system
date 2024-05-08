<?php

use App\Http\Controllers\QuotationController;
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
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\StockController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard',[ProfileController::class,'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:admin'])->group(function(){
        // Route::resource('user',UserController::class);
        // Route::resource('role',RoleController::class);
        Route::resource('permission',PermissionController::class);
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
    Route::post('department/get-subdepartments-by-departments', [DepartmentController::class, 'getSubDepartmentByDept'])->name('department.get-subdepartments-by-departments');
    Route::post('department/get-vat-value', [DepartmentController::class, 'getVatValue'])->name('department.get-vat-value');


    Route::resource('customer',CustomerController::class);
    Route::post('customer/change-status', [CustomerController::class, 'changeStatus'])->name('customer.change-status');
    Route::post('customer/get-details', [CustomerController::class, 'getDetails'])->name('customer.get-details');

    Route::post('user/change-status', [UserController::class, 'changeStatus'])->name('user.change-status');
    Route::post('role/change-status', [RoleController::class, 'changeStatus'])->name('role.change-status');
    Route::post('permission/change-status', [PermissionController::class, 'changeStatus'])->name('permission.change-status');
    
    
    Route::resource('bundle',BundleController::class);
    Route::post('bundle/add-items', [BundleController::class, 'addItems'])->name('bundle.add-items');
    Route::post('bundle/update-display-status', [BundleController::class, 'updateDisplayStatus'])->name('bundle.update-display-status');
    Route::post('bundle/delete-item', [BundleController::class, 'deleteItem'])->name('bundle.delete-item');
    Route::post('bundle/change-status', [BundleController::class, 'changeStatus'])->name('bundle.change-status');
    Route::post('bundle/item-update', [BundleController::class, 'itemUpdate'])->name('bundle.item-update');
    Route::post('bundle/get-details', [BundleController::class, 'getDetails'])->name('bundle.get-details');
    Route::post('bundle/update-bundle-item-order', [BundleController::class, 'updateBundleItemOrder'])->name('bundle.update-bundle-item-order');

    Route::prefix('item')->group(function(){

        Route::get('/', [ItemController::class, 'index'])->name('item');
        Route::get('create', [ItemController::class, 'create'])->name('item.create');
        Route::get('edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
        Route::get('detail/{id}', [ItemController::class, 'viewItemDetails'])->name('item.detail');
        Route::get('download-barcode/{id}', [ItemController::class, 'downloadBarcode'])->name('item.download-barcode');

        Route::post('store', [ItemController::class, 'store'])->name('item.store');
        Route::post('store-details', [ItemController::class, 'storeItemDetails'])->name('item.store-details');
        Route::post('store-stock-settings', [ItemController::class, 'updateStockSettings'])->name('item.store-stock-settings');
        Route::post('store-item-pricing', [ItemController::class, 'updatePriceDetails'])->name('item.store-item-pricing');
        Route::post('change-status', [ItemController::class, 'changeStatus'])->name('item.change-status');
        Route::post('update', [ItemController::class, 'update'])->name('item.update');
        Route::post('calculate-margin', [ItemController::class, 'calculateMargin'])->name('item.calculate-margin');
        Route::post('search', [ItemController::class, 'search'])->name('item.search');
        Route::post('update-mandatory-status', [ItemController::class, 'updateMandatoryStatus'])->name('item.update-mandatory-status');
        Route::post('store-sub-items', [ItemController::class, 'storeSubItems'])->name('item.store-sub-items');
        Route::post('get-sub-items', [ItemController::class, 'getSubItems'])->name('item.get-sub-items');
    });

    Route::prefix('quotation')->group(function(){

        Route::get('/', [QuotationController::class, 'index'])->name('quotation');
        Route::get('create', [QuotationController::class, 'create'])->name('quotation.create');
        Route::get('edit/{id}', [QuotationController::class, 'edit'])->name('quotation.edit');

        Route::post('store', [QuotationController::class, 'store'])->name('quotation.store');
        Route::post('add-items', [QuotationController::class, 'addItems'])->name('quotation.add-items');
        Route::post('update-display-status', [QuotationController::class, 'updateDisplayStatus'])->name('quotation.update-display-status');
        Route::post('delete-item', [QuotationController::class, 'deleteItem'])->name('quotation.delete-item');
        Route::post('change-status', [QuotationController::class, 'changeStatus'])->name('quotation.change-status');
        Route::post('item-update', [QuotationController::class, 'itemUpdate'])->name('quotation.item-update');
        Route::post('update-price-info', [QuotationController::class, 'updatePriceInfo'])->name('quotation.update-price-info');
        Route::post('add-bundle', [QuotationController::class, 'addBundle'])->name('quotation.add-bundle');
        Route::post('edit-bundle', [QuotationController::class, 'editBundle'])->name('quotation.edit-bundle');
        Route::post('update-quotation-item-order', [QuotationController::class, 'updateQuotationItemOrder'])->name('quotation.update-quotation-item-order');

    });

    Route::prefix('opf')->group(function(){

        Route::get('{id}', [QuotationController::class, 'opf'])->name('opf');

        Route::post('update', [QuotationController::class, 'updateOpf'])->name('opf.update');
        Route::post('add-items', [QuotationController::class, 'opfAddItems'])->name('opf.add-items');
        Route::post('delete-item', [QuotationController::class, 'opfDeleteItem'])->name('opf.delete-item');
        Route::post('item-update', [QuotationController::class, 'opfItemUpdate'])->name('opf.item-update');
        Route::post('add-bundle', [QuotationController::class, 'opfAddBundle'])->name('opf.add-bundle');
        Route::post('edit-bundle', [QuotationController::class, 'opfEditBundle'])->name('opf.edit-bundle');

    });

    Route::prefix('po')->group(function(){

        Route::get('/', [StockController::class, 'index'])->name('po');
        Route::get('create', [StockController::class, 'create'])->name('po.create');
        Route::get('edit/{id}', [StockController::class, 'edit'])->name('po.edit');

        Route::get('deliveries', [StockController::class, 'purchaseDelivery'])->name('po.deliveries');

        Route::post('store', [StockController::class, 'store'])->name('po.store');
        Route::post('add-items', [StockController::class, 'addItems'])->name('po.add-items');
        Route::post('delete-item', [StockController::class, 'deleteItem'])->name('po.delete-item');
        Route::post('item-update', [StockController::class, 'itemUpdate'])->name('po.item-update');
        Route::post('change-status', [StockController::class, 'changeStatus'])->name('po.change-status');
        Route::post('send-order', [StockController::class, 'sendOrder'])->name('po.send-order');
        
    });

});

Route::get('/barcode', [VatController::class, 'barcode']);