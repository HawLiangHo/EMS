<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
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
Route::get('/', [LoginController::class, 'index'])->name("login");
Route::post('/', [LoginController::class, 'store']);

Route::get('/logout', [LogoutController::class, "index"])->name("logout");

Route::get('/register', [RegisterController::class, 'registration'])->name("register");
Route::post('/register', [RegisterController::class, 'addUser']);

Route::get('/editProfile',[UserController::class, 'editProfile'])->name("editProfile");
Route::post('/editProfile',[UserController::class, 'updateProfile']);
Route::get('/changePassword',[UserController::class, 'openChangePassword'])->name("changePassword");
Route::post('/changePassword',[UserController::class, 'changePassword']);
Route::get('/billing',[UserController::class, 'openBilling'])->name("billing");
Route::get('/reloadCredit',[UserController::class, 'reloadCreditPage'])->name("reloadCredit");
Route::post('/reloadCredit',[UserController::class, 'reloadCreditAction'])->name("reloadCreditAction");
Route::get('/manageUsers/{id}', [UserController::class, 'manageUsers'])->name('manageUsers');
Route::get('/addUsers/{id}', [UserController::class, 'addUsersPage'])->name('addUsers');
Route::post('/addUsers/{id}',[UserController::class, 'createAssistant']);
Route::get('/editUser/{id}/{user_id}',[UserController::class, 'editUser'])->name('editUser');
Route::post('/editUser/{id}/{user_id}',[UserController::class, 'updateAssistant']);
Route::get('/assistantEvent',[UserController::class, 'assistantEvent'])->name('assistantEvent');
Route::get('/manageUsers/deleteAssistant/{eventID}/{id}', [UserController::class, 'deleteAssistant']);
Route::get('/myTickets',[UserController::class, 'myTickets'])->name("myTickets");
Route::get('/viewMyTicket/{id}',[UserController::class, 'viewTicket'])->name("viewMyTicket");
Route::get('/myTickets/deleteRegisteredTicket/{id}', [UserController::class, 'deleteRegisteredTicket']);

Route::get('/home', [EventController::class, 'index'])->name("home");
Route::get('/homeOngoing', [EventController::class, 'index2']);
Route::get('/homePast', [EventController::class, 'index3']);
Route::get('/createEvent', [EventController::class, 'createEvent'])->name("createEvent");
Route::post('/search', [EventController::class, 'homepageSearch'])->name("homeSearch");
Route::post('/searchOngoing', [EventController::class, 'homepageSearch2'])->name("homeSearch2");
Route::post('/searchPast', [EventController::class, 'homepageSearch3'])->name("homeSearch3");
Route::post('/createEvent', [EventController::class, 'create']);
Route::get('/manageEvents', [EventController::class, 'manageEvent'])->name("manageEvents");
Route::get('/manageEvents/{id}', [EventController::class, 'deleteEvent']);
Route::get('/eventDetails/{id}', [EventController::class, 'showDetails'])->name("eventDetails");
Route::post('/eventDetails/{id}', [EventController::class, 'updateDetails']);
Route::get('/publishEvent/{id}', [EventController::class, 'publishEventPage'])->name("publishEvent");
Route::post('/publishEvent/{id}', [EventController::class, 'publishEventAction'])->name('publishEventAction');
Route::get('/dashboard/{id}', [EventController::class, 'openDashboard'])->name("dashboard");
Route::get('/viewEvents/{id}',[EventController::class, 'eventDetails'])->name('viewEvents');
Route::get('/checkout/{id}',[EventController::class, 'showCheckout'])->name('checkout');
Route::post('/checkout/{id}',[EventController::class, 'checkoutRegister']);
Route::get('/checkoutConfirm/{id}',[EventController::class, 'checkoutConfirmPage'])->name('checkoutConfirm');
Route::post('/checkoutConfirm/{id}',[EventController::class, 'confirmFinalCheckout'])->name('confirmFinalCheckout');

Route::get('/manageTickets/{id}',[TicketController::class, 'manageTickets'])->name('manageTickets');
Route::get('/addTickets/{id}', [TicketController::class, 'addTicketsPage'])->name('addTickets');
Route::post('/addTickets/{id}', [TicketController::class, 'saveTicket']);
Route::get('/editTicket/{id}/{ticket_id}', [TicketController::class, 'editTicket'])->name('editTicket');
Route::post('/editTicket/{id}/{ticket_id}',[TicketController::class, 'updateTicket']);
Route::get('/manageTickets/deleteTicket/{eventID}/{id}', [TicketController::class, 'deleteTicket']);

