<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    public function index(): JsonResponse
    {
        $expenses = Expense::orderByDesc('date')->get();
        return ExpenseResource::collection($expenses)->response();
    }

    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = Expense::create($request->validated());
        return (new ExpenseResource($expense))->response()->setStatusCode(201);
    }

    public function show(Expense $expense): JsonResponse
    {
        return (new ExpenseResource($expense))->response();
    }
}
