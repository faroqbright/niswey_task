<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get("/",[HomeController::class,'index'])->name("welcome");
Route::delete('/file/delete/{id}', [HomeController::class, 'delete'])->name('file.delete');
Route::delete('/contact/delete/{id}', [HomeController::class, 'contact_delete'])->name('contact.delete');
Route::get("/contacts/{id}",[HomeController::class,'contacts'])->name("contacts.view");
Route::post("/submit",[HomeController::class,'submit'])->name("form.submit");
