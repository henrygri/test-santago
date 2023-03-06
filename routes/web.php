<?php

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
    return redirect('home');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'],function(){ 
    Route::middleware(['can:admin'])->group(function () {
        // CRUD Collaboratori
        Route::get('/collaboratori', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('/aggiungi-collaboratore', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
        Route::post('/salva-collaboratore', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
        Route::get('/modifica-collaboratore/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
        Route::post('/aggiorna-collaboratore/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
        Route::delete('/elimina-collaboratore/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.delete');
        Route::post('/collaboratori/remove-rows', [App\Http\Controllers\UserController::class, 'removeRows']);
    });

    Route::group(['prefix' => 'list'], function() {
        Route::get('/{stato}', [App\Http\Controllers\CustomerController::class, 'list']);
        Route::get('/{stato}/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('contatto.create');
        Route::get('/{stato}/export', [App\Http\Controllers\CustomerController::class, 'export']);
        Route::post('/{stato}/import', [App\Http\Controllers\CustomerController::class, 'import']);
        Route::get('/{stato}/download', [App\Http\Controllers\CustomerController::class, 'download']);
        Route::get('/{stato}/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('clienti.show');
    });
    Route::post('/customer/remove-rows', [App\Http\Controllers\CustomerController::class, 'removeRows']);
    Route::post('/salva-clente', [App\Http\Controllers\CustomerController::class, 'store'])->name('clienti.store');
    Route::get('/{stato}/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('clienti.edit');
    Route::post('/aggiorna-cliente/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('clienti.update');
    Route::delete('/elimina-cliente/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('clienti.destroy');
    Route::get('/duplica-cliente/{id}', [App\Http\Controllers\CustomerController::class, 'clone'])->name('clienti.clone');
    Route::get('/converti-cliente/{id}', [App\Http\Controllers\CustomerController::class, 'convert'])->name('clienti.convert');

    Route::get('/aziende-dropdown', [App\Http\Controllers\CompanyController::class, 'getList']);
    Route::post('/nuova-azienda-short', [App\Http\Controllers\CompanyController::class, 'newCompany']);

    Route::post('/customers-dropdown', [App\Http\Controllers\CustomerController::class, 'getListByCompanyId']);
    Route::post('/customer-save-data', [App\Http\Controllers\CustomerController::class, 'newCustomer']);

    Route::resource('/aziende', App\Http\Controllers\CompanyController::class);
    Route::post('/azienda-details', [App\Http\Controllers\CompanyController::class, 'getCompanyById']);
    Route::post('/azienda-save-data', [App\Http\Controllers\CompanyController::class, 'storeCompanyData']);
    Route::get('/azienda/{id}/offerta', [App\Http\Controllers\CompanyController::class, 'createOfferta']);
    Route::get('/azienda/{id}/contatto', [App\Http\Controllers\CompanyController::class, 'createContatto']);
    Route::post('/aziende/remove-rows', [App\Http\Controllers\CompanyController::class, 'removeRows']);
    Route::get('/azienda/export', [App\Http\Controllers\CompanyController::class, 'export'])->name('aziende.export');


    Route::resource('/offerte', App\Http\Controllers\OfferteController::class);
    Route::post('/offerta-details', [App\Http\Controllers\OfferteController::class, 'getOffertaById']);
    Route::post('/offerte/remove-rows', [App\Http\Controllers\OfferteController::class, 'removeRows']);
    Route::get('/offerta/export', [App\Http\Controllers\OfferteController::class, 'export'])->name('offerte.export');
    Route::get('/offerta/accetta/{id}', [App\Http\Controllers\OfferteController::class, 'accept'])->name('offerte.accept');
    Route::get('/offerta/{id}/commessa', [App\Http\Controllers\OfferteController::class, 'createCommessa']);

    Route::resource('/commesse', App\Http\Controllers\CommessaController::class);
    Route::post('/commessa-details', [App\Http\Controllers\CommessaController::class, 'getCommessaById']);
    Route::get('/commessa/{id}/incarico', [App\Http\Controllers\CommessaController::class, 'createIncarico']);
    Route::post('/commesse/remove-rows', [App\Http\Controllers\CommessaController::class, 'removeRows']);
    Route::get('/commessa/export', [App\Http\Controllers\CommessaController::class, 'export'])->name('commesse.export');

    Route::resource('/incarichi', App\Http\Controllers\IncaricoController::class);
    Route::post('/incarichi/remove-rows', [App\Http\Controllers\IncaricoController::class, 'removeRows']);
    Route::get('/incarico/export', [App\Http\Controllers\IncaricoController::class, 'export'])->name('incarichi.export');

    Route::resource('/fornitori', App\Http\Controllers\FornitoreController::class);
    Route::post('/fornitori/remove-rows', [App\Http\Controllers\FornitoreController::class, 'removeRows']);
    Route::get('/fornitore/export', [App\Http\Controllers\FornitoreController::class, 'export'])->name('fornitori.export');

    Route::resource('/bandi', App\Http\Controllers\BandoController::class);
    Route::post('/bandi/remove-rows', [App\Http\Controllers\BandoController::class, 'removeRows']);
    Route::get('/bando/export', [App\Http\Controllers\BandoController::class, 'export'])->name('bandi.export');

    Route::resource('/corsi', App\Http\Controllers\CorsiController::class);
    Route::post('/corsi/remove-rows', [App\Http\Controllers\CorsiController::class, 'removeRows']);
    Route::post('/courses-data', [App\Http\Controllers\CorsiController::class, 'getCoursesById']);
    Route::post('/editions-data', [App\Http\Controllers\CorsiController::class, 'getEditionsById']);
    Route::post('/new-course', [App\Http\Controllers\CorsiController::class, 'newCourse']);

    //Route::post('/check-company', [App\Http\Controllers\CompanyController::class, 'checkCompany']);

    Route::get('/prospect/{id}/show', [App\Http\Controllers\CustomerController::class, 'showProspect'])->name('prospect.show');
    Route::get('/prospect/export', [App\Http\Controllers\CustomerController::class, 'export_prospect'])->name('customer.export_prospect');
    Route::get('/cliente/{id}/show', [App\Http\Controllers\CustomerController::class, 'showClient'])->name('cliente.show');
    Route::get('/clienti/export', [App\Http\Controllers\CustomerController::class, 'export_clienti'])->name('customer.export_clienti');


    Route::post('/search', [App\Http\Controllers\SearchController::class, 'search']);

    Route::group(['prefix' => 'profile'], function(){
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
        Route::post('/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('change-password');
    });

});
