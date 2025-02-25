<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
           
        ]);

        $transaction = Transaction::create($request->all());
      
        // return response()->json($transaction, 201);
    }

    public function index()
    {
        return response()->json(Transaction::all(), 200);
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transaction, 200);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $request->validate([
            'type' => 'in:income,expense',
            'category' => 'string',
            'amount' => 'numeric',
            'transaction_date' => 'date',
            'description' => 'nullable|string',
        ]);

        $transaction->update($request->all());

        return response()->json($transaction, 200);
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully'], 200);
    }

    public function getMonthlyReport($year, $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $income = Transaction::where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $expense = Transaction::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $balance = $income - $expense;

        return response()->json([
            'month' => $month,
            'year' => $year,
            'total_income' => $income,
            'total_expense' => $expense,
            'total_balance' => $balance,
        ], 200);
    }

    public function getTotalBalance()
    {
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'total_balance' => $balance,
        ], 200);
    }

    public function hello()
    {
        return response()->json(['message' => 'Hello, Imtiaz!'], 200);
    }

}
