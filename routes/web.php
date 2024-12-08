<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\FundingSourceController;
use App\Http\Controllers\KroController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProvinceBudgetRequestsController;
use App\Http\Controllers\ProvinceImportController;
use App\Http\Controllers\RoController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\PengajuanAnggaran;
use App\Models\ProvinceBudgetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pengajuan_anggaran.add');
// });



Route::get('/', function () {
      return view('home.index');
});

Route::get('/login-page', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::middleware('auth')->group(function () {

      //Profile
      Route::prefix('profile')->group(function () {
            Route::get('/{id}', [ProfileController::class, 'show'])->name('profile'); // Show profile
            Route::put('/{id}/update', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
            Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword'); // Change password
      });
      // show proposal
      Route::get('/view-pdf/{filename}', [ProvinceBudgetRequestsController::class, 'show_proposal']);
      Route::get('/view-excel/{filename}', [ProvinceBudgetRequestsController::class, 'show_excel']);
      //  role province, departement, regency
      Route::middleware('pengajuan_anggaran')->group(function () {
            // Pengajuan Anggaran
            Route::get('/pengajuan-anggaran', [ProvinceBudgetRequestsController::class, 'index'])->name('pengajuan-anggaran.index');
            Route::get('/pengajuan-anggaran/create', [ProvinceBudgetRequestsController::class, 'create'])->name('pengajuan-anggaran.create');
            Route::post('/pengajuan-anggaran/store', [ProvinceBudgetRequestsController::class, 'store'])->name('pengajuan-anggaran.store');
            Route::get('/pengajuan-anggaran/edit/{id}', [ProvinceBudgetRequestsController::class, 'edit']);
            Route::get('/pengajuan-anggaran/edit-data/{id}', [ProvinceImportController::class, 'editData'])->name('pengajuan-anggaran.edit-data');
            Route::post('/pengajuan-anggaran/update-data/{id}', [ProvinceImportController::class, 'updateData'])->name('pengajuan-anggaran.update-data');

            //databse import
            Route::get('pengajuan-anggaran-import/{id}', [ProvinceImportController::class, 'index'])->name('pengajuan-anggaran-import.index');
            Route::get('pengajuan-anggaran-import/create', [ProvinceImportController::class, 'create'])->name('pengajuan-anggaran-import.create');
            Route::get('pengajuan-anggaran-import/edit/{id}/{ids}', [ProvinceImportController::class, 'edit'])->name('pengajuan-anggaran-import.edit');
            Route::post('pengajuan-anggaran-import', [ProvinceImportController::class, 'store'])->name('pengajuan-anggaran-import.store');
            Route::post('pengajuan-anggaran-import/update/{id}', [ProvinceImportController::class, 'update'])->name('pengajuan-anggaran-import.update');
      });

      // Kelola Pengajuan Anggaran
      Route::get('/pengajuan-anggaran/destroy/{id}/{type}', [ProvinceBudgetRequestsController::class, 'destroy'])->name('pengajuan-anggaran.destroy');
      Route::get('/pengajuan-anggaran/exort/{id}/{type}', [ProvinceBudgetRequestsController::class, 'export_data'])->name('pengajuan-anggaran.exort');
      Route::get('/proposal/{filename}', [ProvinceBudgetRequestsController::class, 'show_proposal'])->name('proposal');

      Route::middleware(['role:province,pusat,departement'])->group(function () {
            // dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            // User
            Route::get('/user', [UserController::class, 'index']);
            Route::get('/user-create', [UserController::class, 'create']);
            Route::get('/user-edit/{id}', [UserController::class, 'edit']);
            Route::post('/user-store', [UserController::class, 'store']);
            Route::post('/user-update/{id}', [UserController::class, 'update']);
            Route::post('/user-delete', [UserController::class, 'delete']);

            // Kelola akun di province
            Route::get('/manage-account-regency', [UserController::class, 'data_show'])->name('manage-account');

            //  Laporan
            Route::get('/pengajuan-anggaran-laporan',[LaporanController::class, 'index'])->name('pengajuan-anggaran-laporan');
            Route::post('/generate-pdf', [LaporanController::class, 'generatePDF']);
            Route::get('/downloadExcelAsZip', [LaporanController::class, 'downloadExcelAsZip']);
            
            // Pengajuan Anggaran
            Route::get('/pengajuan-anggaran-departement/regency', [ProvinceBudgetRequestsController::class, 'data_show'])->name('pengajuan-anggaran-departement');
            Route::get('/pengajuan-anggaran-regency/edit/{id}', [ProvinceBudgetRequestsController::class, 'data_edit'])->name('pengajuan-anggaran.edit');
            Route::post('/pengajuan-anggaran/update/{id}', [ProvinceBudgetRequestsController::class, 'update'])->name('pengajuan-anggaran.update');

            // Kelola akun di pusat
            Route::middleware('role:pusat,departement')->group(function () {
                  // akun departement
                  Route::get('/manage-account-departement', [UserController::class, 'data_show'])->name('manage-account');
                  // akun divisi
                  Route::get('/manage-account-division', [UserController::class, 'data_show'])->name('manage-account');
                  // kelola akun province
                     Route::get('/manage-account-province', [UserController::class, 'data_show'])->name('manage-account');
                  // Pengajuan Anggaran departement
                  Route::get('/pengajuan-anggaran-departement/departement',[ProvinceBudgetRequestsController::class, 'data_show'])->name('pengajuan-anggaran-departement');
                  Route::get('/pengajuan-anggaran-departement/edit/{id}',[ProvinceBudgetRequestsController::class, 'data_edit'])->name('pengajuan-anggaran.edit');
                 
                    // pengajuan anggaran province
                    Route::get('/pengajuan-anggaran-departement/province', [ProvinceBudgetRequestsController::class, 'data_show'])->name('pengajuan-anggaran-departement');
                    Route::get('/pengajuan-anggaran-province/edit/{id}', [ProvinceBudgetRequestsController::class, 'data_edit'])->name('pengajuan-anggaran.edit');
                 
            });


            Route::middleware('role:pusat')->group(function () {
                
                   // Pengajuan Anggaran division
                   Route::get('/pengajuan-anggaran-departement/division',[ProvinceBudgetRequestsController::class, 'data_show'])->name('pengajuan-anggaran-departement');
                   Route::get('/pengajuan-anggaran-division/edit/{id}',[ProvinceBudgetRequestsController::class, 'data_edit'])->name('pengajuan-anggaran.edit');
               

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
