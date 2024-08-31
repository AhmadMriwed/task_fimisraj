<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * Display a listing of the budgets.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $budgets = Budget::where('user_id', Auth::id())->get();

        // إعادة الاستجابة كـ JSON
        return response()->json(['budgets' => $budgets]);
    }

    /**
     * Store a newly created budget in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // إنشاء الميزانية الجديدة وربطها بالمستخدم
        $budget = Budget::create([
            'user_id' => Auth::id(),
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        // إعادة الاستجابة كـ JSON
        return response()->json(['budget' => $budget, 'message' => 'Budget created successfully!'], 201);
    }

    /**
     * Display the specified budget.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Budget $budget)
    {

        $this->authorize('view', $budget);

  
        return response()->json(['budget' => $budget]);
    }

    /**
     * Update the specified budget in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Budget $budget)
    {
   
        $this->authorize('update', $budget);

      
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

    
        $budget->update($validated);


        return response()->json(['budget' => $budget, 'message' => 'Budget updated successfully!']);
    }

    /**
     * Remove the specified budget from storage.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Budget $budget)
    {
 
        $this->authorize('delete', $budget);

        $budget->delete();


        return response()->json(['message' => 'Budget deleted successfully!']);
    }

    
}

