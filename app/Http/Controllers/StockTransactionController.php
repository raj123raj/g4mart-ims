<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StockTransactionController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'performer'])
            ->latest()->paginate(15);

        return view('stock-transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('stock-transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'transaction_type' => ['required', Rule::in(['stock_in', 'stock_out', 'adjustment'])],
            'quantity' => ['required', 'integer', 'min:1'],
            'reference' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $transaction = DB::transaction(function () use ($validated, $request) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()->firstOrFail();

            $before = (int) $product->quantity;
            $amount = (int) $validated['quantity'];

            if ($validated['transaction_type'] === 'stock_in') {
                $after = $before + $amount;
            } elseif ($validated['transaction_type'] === 'stock_out') {
                if ($amount > $before) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'quantity' => 'Insufficient stock. Available quantity: '.$before,
                    ]);
                }
                $after = $before - $amount;
            } else {
                // Adjustment sets the stock to the entered counted quantity.
                $after = $amount;
            }

            $product->quantity = $after;
            $product->save();

            $transaction = StockTransaction::create([
                'product_id' => $product->id,
                'transaction_type' => $validated['transaction_type'],
                'quantity' => $amount,
                'quantity_before' => $before,
                'quantity_after' => $after,
                'reference' => $validated['reference'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'performed_by' => $request->user()->id,
            ]);

            AuditLog::create([
                'user_id' => $request->user()->id,
                'action' => 'stock.'.$validated['transaction_type'],
                'auditable_type' => Product::class,
                'auditable_id' => $product->id,
                'old_values' => ['quantity' => $before],
                'new_values' => ['quantity' => $after, 'transaction_id' => $transaction->id],
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 1000),
                'created_at' => now(),
            ]);

            return $transaction;
        });

        return redirect()->route('stock-transactions.index')
            ->with('success', 'Stock transaction recorded successfully.');
    }
}
