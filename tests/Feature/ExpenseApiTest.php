<?php

namespace Tests\Feature;

use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseApiTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_filters_expenses_by_type(): void
    {
        Expense::factory()->create(['expense_type' => 'travel']);
        Expense::factory()->create(['expense_type' => 'food']);
        Expense::factory()->create(['expense_type' => 'food']);

        $response = $this->getJson('/api/expenses?type=food');

        $response->assertOk()->assertJsonCount(2, 'data');
        $this->assertSame('food', $response->json('data.0.expense_type'));
    }

    public function test_it_rejects_an_invalid_filter_type(): void
    {
        $response = $this->getJson('/api/expenses?type=not-a-real-type');

        $response->assertStatus(422);
    }

    public function test_it_lists_expenses(): void
    {
        Expense::factory()->count(3)->create();

        $response = $this->getJson('/api/expenses');

        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_it_creates_an_expense(): void
    {
        $payload = [
            'date' => '2026-01-15',
            'cost' => 42.50,
            'description' => 'Train to London',
            'expense_type' => 'travel',
        ];

        $response = $this->postJson('/api/expenses', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.description', 'Train to London')
            ->assertJsonPath('data.expense_type', 'travel');

        $this->assertDatabaseHas('expenses', ['description' => 'Train to London']);
    }

    public function test_it_rejects_an_invalid_expense(): void
    {
        $response = $this->postJson('/api/expenses', [
            'date' => '2026-01-15',
            'cost' => -5,
            'description' => '',
            'expense_type' => 'invalid-type',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['cost', 'description', 'expense_type']);
    }

    public function test_it_shows_a_single_expense(): void
    {
        $expense = Expense::factory()->create(['description' => 'Coffee']);

        $response = $this->getJson("/api/expenses/{$expense->id}");

        $response->assertOk()->assertJsonPath('data.description', 'Coffee');
    }

    public function test_it_returns_404_for_missing_expense(): void
    {
        $response = $this->getJson('/api/expenses/999');

        $response->assertStatus(404);
    }
}
