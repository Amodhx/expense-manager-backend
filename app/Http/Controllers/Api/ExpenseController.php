<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['sometimes', 'in:travel,food,other'],
        ]);

        $expenses = Expense::query()
            ->when($request->filled('type'), fn ($query) => $query->where('expense_type', $request->query('type')))
            ->orderByDesc('date')
            ->get();

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
