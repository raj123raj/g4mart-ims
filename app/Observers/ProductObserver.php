<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProductObserver
{
    public function created(Product $product): void
    {
        $this->write('product.created', $product, [], $product->getAttributes());
    }

    public function updated(Product $product): void
    {
        $this->write('product.updated', $product, $product->getOriginal(), $product->getChanges());
    }

    public function deleted(Product $product): void
    {
        $this->write('product.deleted', $product, $product->getOriginal(), []);
    }

    private function write(string $action, Product $product, array $old, array $new): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'auditable_type' => Product::class,
            'auditable_id' => $product->id,
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => Request::ip(),
            'user_agent' => substr((string) Request::userAgent(), 0, 1000),
            'created_at' => now(),
        ]);
    }
}
