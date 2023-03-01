<?php

use App\Http\Controllers\Firma\EkleController;
use App\Http\Controllers\Firma\FirmaController;
use App\Http\Controllers\Firma\ListController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesEkleController;
use App\Http\Controllers\RolesListController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/private', [HomeController::class, 'private'])->name('private');

Route::get('/', [HomeController::class, 'index'])->name('index');

// Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
// });

Route::middleware(['auth', 'user'])->prefix('user')->group(function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/firma/list', function () {
        return view('list');
    });

    Route::get('/excel/indir', [FirmaController::class, 'indir'])
        ->name('excel.indir')
        ->middleware('can:excel-indir');

    Route::post('/excel/yukle', [FirmaController::class, 'excelYukle'])
        ->name('excel.yukle')
        ->middleware('can:excel-yukle');

    Route::get('/firma/ekle', [EkleController::class, 'index'])
        ->middleware('can:firma-ekle');

    Route::post('/firma/ekle', [EkleController::class, 'ekle'])
        ->name('firma.ekle')
        ->middleware('can:firma-ekle');

    Route::get('/firma/listele', [ListController::class, 'index'])
        ->name('firma.listele')
        ->middleware('can:firma-listele');

    Route::get('/firma/listele/data', [ListController::class, 'firmaListele'])
        ->name('firma.listele.data')
        ->middleware('can:firma-listele');

    Route::get('/firma/detay/{id}', [ListController::class, 'firmaDetay'])
        ->middleware('can:firma-detay');

    Route::put('/firma/guncelle/{id}', [ListController::class, 'firmaGuncelle'])
        ->name('firma.guncelle')
        ->middleware('can:firma-guncelle');

    Route::delete('/firma/sil/{id}', [ListController::class, 'firmaSil'])
        ->middleware('can:firma-sil');

    Route::get('/users', [UserController::class, 'index'])
        ->name('user.listele')
        ->middleware('can:user-listele');

    Route::get('/users/listele/data', [UserController::class, 'userListele'])
        ->name('user.listele.data')
        ->middleware('can:user-listele');

    Route::post('/user/detay/{id}', [UserController::class, 'userDetay'])
        ->middleware('can:user-detay');

    Route::put('/user/guncelle/{id}', [UserController::class, 'userGuncelle'])
        ->name('user.guncelle')
        ->middleware('can:user-guncelle');

    Route::delete('/user/sil/{id}', [UserController::class, 'userSil'])
        ->middleware('can:user-sil');

    Route::get('/roles/ekle', [RolesEkleController::class, 'index'])
        ->middleware('can:roles-ekle');

    Route::post('/roles/ekle', [RolesEkleController::class, 'ekle'])
        ->name('roles.ekle')
        ->middleware('can:roles-ekle');

    Route::get('/roles/listele', [RolesListController::class, 'index'])
        ->name('roles.listele')
        ->middleware('can:roles-listele');

    Route::get('/roles/listele/data', [RolesListController::class, 'rolesListele'])
        ->name('roles.listele.data')
        ->middleware('can:roles-listele');

    Route::get('/roles/detay/{id}', [RolesListController::class, 'rolesDetay'])
        ->middleware('can:roles-detay');

    Route::put('/roles/guncelle/{id}', [RolesListController::class, 'rolesGuncelle'])
        ->name('roles.guncelle')
        ->middleware('can:roles-guncelle');

    Route::delete('/roles/sil/{id}', [RolesListController::class, 'rolesSil'])
        ->middleware('can:roles-sil');

    Route::get('/save-user-roles', [UserController::class, 'saveUserRoles'])
        ->name('save.user.roles')
        ->middleware('can:save-roles');

    Route::get('/user/roles/{id}', [UserController::class, 'userRoles'])
        ->name('user.roles')
        ->middleware('can:get-user-roles');
});
