<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;      // ← add this
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCreated implements ShouldBroadcastNow            // ← implement
{
    use Dispatchable, InteractsWithSockets, SerializesModels;  // ← include all

    public $product;

    // public function __construct(Product $product)
    // {
    //     $this->product = $product;
    // }
    public function __construct()
    {

    }

    public function broadcastOn(): Channel
    {
        return new Channel('products');
    }

    public function broadcastWith(): array
    {
        return [
            'test' => 'test',
            // 'id'       => $this->product->id,
            // 'name'     => $this->product->name,
            // 'sku'      => $this->product->sku,
            // 'quantity' => $this->product->quantity,
        ];
    }

    public function broadcastAs(): string
    {
        return 'product.created';
    }
}
