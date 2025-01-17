<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/pet', [ApiController::class, 'getPet'])->name('pet.get');
Route::post('/pet', [ApiController::class, 'addPet'])->name('pet.add');
Route::put('/pet', [ApiController::class, 'updatePet'])->name('pet.update');
Route::delete('/pet', [ApiController::class, 'deletePet'])->name('pet.delete');
Route::post('/pet/{petId}/uploadImage', [ApiController::class, 'uploadPetImage'])->name('pet.uploadImage');
Route::get('/pet/findByStatus', [ApiController::class, 'findPetsByStatus'])->name('pet.findByStatus');
Route::post('/pet/update-name-and-status', [ApiController::class, 'updatePetNameAndStatus'])->name('pet.updateNameAndStatus');
