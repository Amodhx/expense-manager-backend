<?php

use App\Http\Controllers\Api\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::apiResource('expenses', ExpenseController::class)->only(['index', 'store', 'show']);
