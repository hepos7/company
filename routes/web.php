<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\mailController;


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
    return view('companies.index');
});

Route::get('/companies/getcompanies', [CompanyController::class, 'getCompanies'])->name('companies.getcompanies');
Route::resource('companies', CompanyController::class);

Route::get('/employees/getemplyees', [EmployeeController::class, 'getEmplyees'])->name('employees.getemplyees');
Route::resource('employees', EmployeeController::class);

Route::get('send-email/{name}/{reciver}', [mailController::class, 'sendMail'])->name('email.send');



Route::get('send-emailss', function(){
    $mailData = [
        "name" => "Test NAME",
        "dob" => "12/12/1990"
    ];
    Mail::to("hello@example.com")->send(new WelcomeEmail($mailData));

    dd("Mail Sent Successfully!");
});