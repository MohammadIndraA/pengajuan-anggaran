<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\FundingSourceController;
use App\Http\Controllers\KroController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProvinceBudgetRequestsController;
use App\Http\Controllers\ProvinceImportController;
use App\Http\Controllers\RoController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\PengajuanAnggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pengajuan_anggaran.add');
// });

Route::get('/',[AuthController::class, 'login'])->name('login');
Route::post('/login',[AuthController::class, 'postLogin'])->name('login.post');
Route::middleware('auth')->group(function () {

  //  role province, departement, regency
  Route::middleware('pengajuan_anggaran')->group(function () {
    // Pengajuan Anggaran
          Route::get('/province-budget-requests',[ProvinceBudgetRequestsController::class, 'index'])->name('province-budget-requests.index');
          Route::get('/province-budget-requests/create',[ProvinceBudgetRequestsController::class, 'create'])->name('province-budget-requests.create');
          Route::post('/province-budget-requests/store',[ProvinceBudgetRequestsController::class, 'store'])->name('province-budget-requests.store');
          Route::get('/province-budget-requests/edit/{id}',[ProvinceBudgetRequestsController::class, 'edit'])->name('province-budget-requests.edit');
          Route::get('/province-budget-requests/destroy/{id}',[ProvinceBudgetRequestsController::class, 'destroy'])->name('province-budget-requests.destroy');

          //databse import
          Route::get('province-imports/{id}', [ProvinceImportController::class, 'index'])->name('province-imports.index');
          Route::get('province-imports/create', [ProvinceImportController::class, 'create'])->name('province-imports.create');
          Route::post('province-imports', [ProvinceImportController::class, 'store'])->name('province-imports.store');
 });

  Route::middleware(['role:admin,province,pusat,departement'])->group(function () {
         // dashboard
         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User
        Route::get('/user', [UserController::class, 'index']);
        Route::get('/user-create', [UserController::class, 'create']);
        Route::get('/user-edit/{id}', [UserController::class, 'edit']);
        Route::post('/user-store', [UserController::class, 'store']);
        Route::post('/user-update/{id}', [UserController::class, 'update']);
        Route::post('/user-delete', [UserController::class, 'delete']);
      
        Route::middleware('departement')->group(function () {
                // Kelola akun di departemen
                Route::get('/manage-account-province', [UserController::class, 'data_show']);
                Route::get('/manage-account-regency', [UserController::class, 'data_show']);

                 // Pengajuan Anggaran
                Route::get('/pengajuan-anggaran-departement/province',[ProvinceBudgetRequestsController::class, 'data_show'])->name('pengajuan-anggaran-departement');
                Route::get('/pengajuan-anggaran-departement/regency',[ProvinceBudgetRequestsController::class, 'data_show'])->name('pengajuan-anggaran-departement');
                Route::get('/pengajuan-anggaran-province/edit/{id}',[ProvinceBudgetRequestsController::class, 'data_edit'])->name('pengajuan-anggaran.edit');
                Route::get('/pengajuan-anggaran-regency/edit/{id}',[ProvinceBudgetRequestsController::class, 'data_edit'])->name('pengajuan-anggaran.edit');
                Route::post('/pengajuan-anggaran/update/{id}',[ProvinceBudgetRequestsController::class, 'update'])->name('pengajuan-anggaran.update');
        });

        Route::middleware('role:admin,pusat,departement')->group(function () {
               // Unit
              Route::get('unit', [UnitController::class, 'index']);
              Route::post('unit-store', [UnitController::class, 'store']);
              Route::post('unit-edit', [UnitController::class, 'edit']);
              Route::post('unit-delete', [UnitController::class, 'destroy']);

              // Departement
              Route::get('departement', [DepartementController::class, 'index']);
              Route::post('departement-store', [DepartementController::class, 'store']);
              Route::post('departement-edit', [DepartementController::class, 'edit']);
              Route::post('departement-delete', [DepartementController::class, 'destroy']);

              // funding-source
              Route::get('funding-source', [FundingSourceController::class, 'index']);
              Route::post('funding-source-store', [FundingSourceController::class, 'store']);
              Route::post('funding-source-edit', [FundingSourceController::class, 'edit']);
              Route::post('funding-source-delete', [FundingSourceController::class, 'destroy']);

              // Program
              Route::get('/program', [ProgramController::class, 'index']);
              Route::post('/program-store', [ProgramController::class, 'store']);
              Route::post('/program-edit', [ProgramController::class, 'edit']);
              Route::post('/program-delete', [ProgramController::class, 'destroy']);

              // KRO
              Route::get('/kro', [KroController::class, 'index']);
              Route::post('/kro-store', [KroController::class, 'store']);
              Route::post('/kro-edit', [KroController::class, 'edit']);
              Route::post('/kro-delete', [KroController::class, 'destroy']);

              // RO
              Route::get('/ro', [RoController::class, 'index']);
              Route::post('/ro-store', [RoController::class, 'store']);
              Route::post('/ro-edit', [RoController::class, 'edit']);
              Route::post('/ro-delete', [RoController::class, 'destroy']);

              // Component
              Route::get('/component', [ComponentController::class, 'index']);
              Route::post('/component-store', [ComponentController::class, 'store']);
              Route::post('/component-edit', [ComponentController::class, 'edit']);
              Route::post('/component-delete', [ComponentController::class, 'destroy']);

              // Activity
              Route::get('/activity', [ActivityController::class, 'index']);
              Route::post('/activity-store', [ActivityController::class, 'store']);
              Route::post('/activity-edit', [ActivityController::class, 'edit']);
              Route::post('/activity-delete', [ActivityController::class, 'destroy']);

        });


  });

    

     // Auth Logout
     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
