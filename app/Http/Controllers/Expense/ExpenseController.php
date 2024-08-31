<?php

namespace App\Http\Controllers\Expense;

use App\Exports\ExpensesExport;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
   // Display Expenses
    public function index()
    {
    
        $expenses = Expense::where('user_id', Auth::id())->get();

        return response()->json(['expenses' => $expenses]);
    }

    // Add Expense
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $expense = Expense::create([
            'user_id' => Auth::id(),
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'description' => $validated['description'],
        ]);

      
        return response()->json(['expense' => $expense, 'message' => 'Expense created successfully!'], 201);
    }

      // Export Expense File
      public function export()
      {
          return Excel::download(new ExpensesExport(Auth::id()), 'expenses.xlsx');
      }

        // Export Expense Reports
    public function exportReport()
    {
        return Excel::download(new ExpensesExport(Auth::id()), 'expense_report.xlsx');
    }
  
    public function show(Expense $expense)
    {
        $this->authorize('view', $expense);

        return response()->json(['expense' => $expense]);
    }

 
    public function update(Request $request, Expense $expense)
    {
   
        $this->authorize('update', $expense);

       
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);


        $expense->update($validated);

        return response()->json(['expense' => $expense, 'message' => 'Expense updated successfully!']);
    }


    public function destroy(Expense $expense)
    {
  
        $this->authorize('delete', $expense);

     
        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully!']);
    }

    public function showInvestmentRecommendations()
{
    $userId = Auth::id();
    $expenses = Expense::where('user_id', $userId)->get();

 
    $recommendations = $this->generateInvestmentRecommendations($expenses);

    return response()->json([
        'recommendations' => $recommendations
    ]);
}

private function generateInvestmentRecommendations($expenses)
{
    $recommendations = [];
    $totalAmount = $expenses->sum('amount');
    
 
    if ($totalAmount < 1000) {
        $recommendations[] = 'You might consider exploring low-risk investment options such as savings accounts or bonds.';
    } elseif ($totalAmount >= 1000 && $totalAmount < 5000) {
        $recommendations[] = 'A balanced investment strategy including a mix of stocks and bonds might be suitable for you.';
    } else {
        $recommendations[] = 'You may want to look into high-growth investments or diversified portfolios to potentially maximize returns.';
    }

    return $recommendations;
}
}
