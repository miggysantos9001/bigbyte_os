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

Route::get('/','LoginController@index')->name('login1');
Route::post('login-new','LoginController@store')->name('pasok');
Route::get('logout','LoginController@logout')->name('gawas');

Route::get('/dashboard','DashboardController@index')->name('dashboard.index');
Route::get('/dashboard/changepassword/{id}','DashboardController@view_changepassword');
Route::post('/dashboard/changepassword/{id}','DashboardController@post_changepassword');

Route::get('loadsubtwo','ProductController@loadsubtwo');
Route::get('loadsubtwo_lf','ProductController@loadsubtwo_lf');
Route::get('loadsubone','ProductController@loadsubone');
Route::get('loadproducts','ProductController@loadproducts');

Route::resource('/agents','AgentController');
Route::resource('/branches','BranchController');
Route::resource('/case-statuses','CaseStatusController');
Route::resource('/hospitals','HospitalController');
Route::resource('/product-categories','ProductCategoryController');
Route::resource('/product-subone-categories','ProductSubOneCategoryController');
Route::resource('/product-subtwo-categories','ProductSubTwoCategoryController');
Route::resource('/products','ProductController');
Route::resource('/settings','SettingController');
Route::resource('/suppliers','SupplierController');
Route::resource('/surgeons','SurgeonController');
Route::resource('/users','UserController');
Route::resource('/usertypes','UsertypeController');

Route::get('/implant-case/view-subcase/{id}','ImplantCaseController@subcase_index')->name('implant-cases.subcase');
Route::get('/implant-case/view-loaner-form/{id}','ImplantCaseController@loanerform_index')->name('implant-cases.loaner-form');
Route::get('/implant-case/create-loaner-form/{id}','ImplantCaseController@loanerform_create')->name('implant-cases.create-loaner-form');
Route::get('/implant-case/update-loaner-form/{id}','ImplantCaseController@loanerform_edit')->name('implant-cases.update-loaner-form');
Route::get('/implant-case/view-loaner-form-items/{id}','ImplantCaseController@loanerform_view_items')->name('implant-cases.view-items');
Route::get('/implant-case/delete-loaner-form-items/{id}','ImplantCaseController@loanerform_delete_item')->name('implant-cases.delete-item');

Route::post('/implant-case/store-subcase/{id}','ImplantCaseController@subcase_store');
Route::post('/implant-case/create-loaner-form/{id}','ImplantCaseController@loanerform_store');
Route::patch('/implant-case/update-subcase/{id}','ImplantCaseController@subcase_update');
Route::patch('/implant-case/update-loaner-form/{id}','ImplantCaseController@loanerform_update');
Route::resource('/implant-cases','ImplantCaseController');

Route::get('loadsubcases','CaseSetupController@loadsubcases');

Route::get('/case-setup/view-loaner-form/{id}','CaseSetupController@view_loaner_form')->name('cs.view-lf');
Route::get('/case-setup/case_pullout/{id}','CaseSetupController@set_case_pullout')->name('cs.pullout');
Route::get('/case-setup/print_voucher/{id}','CaseSetupController@print_voucher')->name('cs.voucher');
Route::get('/case-setup/set-paid/{id}','CaseSetupController@set_paid')->name('cs.paid');
Route::get('/case-setup/delete-case/{id}','CaseSetupController@delete_case')->name('cs.delete-case');
Route::get('/case-setup/delete-voucher/{id}','CaseSetupController@delete_voucher')->name('cs.delete-voucher');

Route::post('/case-setup/assign-technician/{id}','CaseSetupController@post_assign_technician');
Route::post('/case-setup/create-voucher/{id}','CaseSetupController@post_voucher');

Route::get('/case-setup/view-loaner-form-items/{case_setup_id}/{lf_id}','CaseSetupController@view_loaner_form_items')->name('cs.view-lf-items');
Route::post('/case-setup/view-loaner-form-items/{case_setup_id}/{lf_id}','CaseSetupController@post_loaner_form_items');

Route::resource('/case-setups','CaseSetupController');

