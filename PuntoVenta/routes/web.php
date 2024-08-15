<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\SupplierController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DatabaseBackupController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PosController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CRUDOrderController;
use App\Http\Controllers\Dashboard\CompraController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PaymentMethodController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\InvoiceController;

Route::post('/invoice/pdf', [InvoiceController::class, 'generatePDF'])->name('invoice.generatePDF');



// DEFAULT DASHBOARD & PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});

// ====== USERS ======
Route::middleware(['permission:user.menu'])->group(function () {
    Route::resource('/users', UserController::class)->except(['show']);
});

// ====== CUSTOMERS ======
Route::middleware(['permission:customer.menu'])->group(function () {
    Route::resource('/customers', CustomerController::class);
});

Route::get('/customers/export', [CustomerController::class, 'exportData'])->name('customers.exportData');

// ====== SUPPLIERS ======
Route::middleware(['permission:supplier.menu'])->group(function () {
    Route::resource('/suppliers', SupplierController::class);
});

// ====== EMPLOYEES ======
Route::middleware(['permission:employee.menu'])->group(function () {
    Route::resource('/employees', EmployeeController::class);
});



// ====== PRODUCTS ======
Route::middleware(['permission:product.menu'])->group(function () {
    Route::get('/products/import', [ProductController::class, 'importView'])->name('products.importView');
    Route::post('/products/import', [ProductController::class, 'importStore'])->name('products.importStore');
    Route::get('/products/export', [ProductController::class, 'exportData'])->name('products.exportData');
    Route::resource('/products', ProductController::class);

});


Route::get('/products/manage-stock', [ProductController::class, 'manageStock'])->name('products.manageStock');
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/stock/manage', [StockController::class, 'manage'])->name('stock.manage');
Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
// Ruta para el índice de stock
Route::resource('stocks', StockController::class);
Route::resource('stocks', StockController::class)->middleware('can:pos.menu');
Route::get('/stock/export', [StockController::class, 'exportData'])->name('stock.exportData');
// Ruta para el índice de stocK
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
// Ruta para el formulario de crear movimiento de stock
Route::post('/stock', [StockController::class, 'store'])->name('stock.store');


// ====== CATEGORY PRODUCTS ======
Route::middleware(['permission:category.menu'])->group(function () {
    Route::resource('/categories', CategoryController::class);
});

// ====== POS ======
Route::middleware(['permission:pos.menu'])->group(function () {
    Route::get('/pos', [PosController::class,'index'])->name('pos.index');
    Route::post('/pos/add', [PosController::class, 'addCart'])->name('pos.addCart');
    Route::post('/pos/update/{rowId}', [PosController::class, 'updateCart'])->name('pos.updateCart');
    Route::get('/pos/delete/{rowId}', [PosController::class, 'deleteCart'])->name('pos.deleteCart');
    Route::post('/pos/invoice/create', [PosController::class, 'createInvoice'])->name('pos.createInvoice');
    //Route::post('/pos/invoice/print', [PosController::class, 'printInvoice'])->name('pos.printInvoice');

    // Create Order
    Route::post('/pos/order', [OrderController::class, 'storeOrder'])->name('pos.storeOrder');
});

// ====== ORDERS ======
Route::middleware(['permission:orders.menu'])->group(function () {
    Route::get('/orders/pending', [OrderController::class, 'pendingOrders'])->name('order.pendingOrders');
    Route::get('/orders/complete', [OrderController::class, 'completeOrders'])->name('order.completeOrders');
    Route::get('/orders/details/{order_id}', [OrderController::class, 'orderDetails'])->name('order.orderDetails');
    Route::put('/orders/update/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::get('/orders/invoice/download/{order_id}', [OrderController::class, 'invoiceDownload'])->name('order.invoiceDownload');

    // Pending Due
    Route::get('/pending/due', [OrderController::class, 'pendingDue'])->name('order.pendingDue');
    Route::get('/order/due/{id}', [OrderController::class, 'orderDueAjax'])->name('order.orderDueAjax');
    Route::post('/update/due', [OrderController::class, 'updateDue'])->name('order.updateDue');

    // Stock Management
    Route::get('/stock', [OrderController::class, 'stockManage'])->name('order.stockManage');
});

// ====== DATABASE BACKUP ======
Route::middleware(['permission:database.menu'])->group(function () {
    Route::get('/database/backup', [DatabaseBackupController::class, 'index'])->name('backup.index');
    Route::get('/database/backup/now', [DatabaseBackupController::class, 'create'])->name('backup.create');
    Route::get('/database/backup/download/{getFileName}', [DatabaseBackupController::class, 'download'])->name('backup.download');
    Route::get('/database/backup/delete/{getFileName}', [DatabaseBackupController::class, 'delete'])->name('backup.delete');
});

// ====== ROLE CONTROLLER ======
Route::middleware(['permission:roles.menu'])->group(function () {
    // Permissions
    Route::get('/permission', [RoleController::class, 'permissionIndex'])->name('permission.index');
    Route::get('/permission/create', [RoleController::class, 'permissionCreate'])->name('permission.create');
    Route::post('/permission', [RoleController::class, 'permissionStore'])->name('permission.store');
    Route::get('/permission/edit/{id}', [RoleController::class, 'permissionEdit'])->name('permission.edit');
    Route::put('/permission/{id}', [RoleController::class, 'permissionUpdate'])->name('permission.update');
    Route::delete('/permission/{id}', [RoleController::class, 'permissionDestroy'])->name('permission.destroy');

    // Roles
    Route::get('/role', [RoleController::class, 'roleIndex'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'roleCreate'])->name('role.create');
    Route::post('/role', [RoleController::class, 'roleStore'])->name('role.store');
    Route::get('/role/edit/{id}', [RoleController::class, 'roleEdit'])->name('role.edit');
    Route::put('/role/{id}', [RoleController::class, 'roleUpdate'])->name('role.update');
    Route::delete('/role/{id}', [RoleController::class, 'roleDestroy'])->name('role.destroy');

    // Role Permissions
    Route::get('/role/permission', [RoleController::class, 'rolePermissionIndex'])->name('rolePermission.index');
    Route::get('/role/permission/create', [RoleController::class, 'rolePermissionCreate'])->name('rolePermission.create');
    Route::post('/role/permission', [RoleController::class, 'rolePermissionStore'])->name('rolePermission.store');
    Route::get('/role/permission/{id}', [RoleController::class, 'rolePermissionEdit'])->name('rolePermission.edit');
    Route::put('/role/permission/{id}', [RoleController::class, 'rolePermissionUpdate'])->name('rolePermission.update');
    Route::delete('/role/permission/{id}', [RoleController::class, 'rolePermissionDestroy'])->name('rolePermission.destroy');
});

Route::post('/save-customer-in-session', function (Illuminate\Http\Request $request) {
    session(['customer_id' => $request->customer_id]);
    return response()->json(['status' => 'success']);
});

Route::post('/orders', [PosController::class, 'store'])->name('orders.store');

Route::resource('payment_methods', PaymentMethodController::class);

Route::resource('crudorders', CRUDOrderController::class);
// Rutas adicionales para imprimir y ver detalles
Route::get('crudorders/{order}/print', [CRUDOrderController::class, 'print'])->name('crudorders.print');
Route::get('crudorders/{order}', [CRUDOrderController::class, 'show'])->name('crudorders.show');

Route::post('/generate-order-pdf', [InvoiceController::class, 'generateOrderPDF'])->name('order.generatePDF');

Route::get('/compra', [CompraController::class, 'index'])->name('compra.index');



Route::get('/compra/manage', [CompraController::class, 'create'])->name('compra.manage');
Route::post('/compra', [CompraController::class, 'store'])->name('compra.store');
Route::get('/compra/export', [CompraController::class, 'exportData'])->name('compra.exportData');


Route::get('/categorias/exportar', [CategoryController::class, 'exportData'])->name('categories.exportData');
Route::get('/metodos-de-pago/exportar', [PaymentMethodController::class, 'exportData'])->name('payment_methods.exportData');
Route::get('/ordenes/exportar', [CRUDOrderController::class, 'exportData'])->name('crudorders.exportData');
Route::get('/vendedores/exportar', [EmployeeController::class, 'exportData'])->name('employees.exportData');
Route::get('/clientes/exportar', [CustomerController::class, 'exportData'])->name('customers.exportData');


require __DIR__.'/auth.php';
