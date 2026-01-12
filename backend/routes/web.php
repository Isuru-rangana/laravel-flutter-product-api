<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return ['message' => 'Laravel Product API is running!', 'status' => 'success'];
});