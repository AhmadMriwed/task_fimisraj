<?php

namespace App\Models;

use App\Events\Notification\SendNotificationEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'amount',
        'start_date',
        'end_date'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::created(function ($expense) {
            $expense->checkBudgetOverrun();
        });

        static::updated(function ($expense) {
            $expense->checkBudgetOverrun();
        });
    }

    public function checkBudgetOverrun()
    {
        $budgets = Budget::where('user_id', $this->user_id)->get();

        foreach ($budgets as $budget) {
            $totalExpenses = Expense::where('user_id', $budget->user_id)
                ->where('category', $budget->category)
                ->sum('amount');

            if ($totalExpenses > $budget->amount) {
              
               $title = "Budget Overrun";
               $body = "You have exceeded the budget allocated for category {$budget->category}.";

               event(new SendNotificationEvent((object)[
                   'user_id' => $budget->user_id,
                   'title' => $title,
                   'body' => $body
               ]));
                Log::info("Budget overrun alert: User ID {$budget->user_id}, Category {$budget->category}");
            }
        }
    }
}
