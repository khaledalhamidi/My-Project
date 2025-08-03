<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class); // هذا يضيف trait بشكل عام لكل الاختبارات

it('can insert a product successfully into database ', function () {

    $user = User::factory()->create();

    $payload = [
        'name' => 'Test Product',
        'sku' => 'abc-123',
        'mpn' => '999-XYZ',
        'quantity' => 50,
        'is_active' => true,
    ];

    $response = $this->actingAs($user, 'sanctum')  // Authenticate as user  //note: function will just work if you have sanctum installed will work without auth token
        ->postJson('/api/products', $payload);   // Send POST request

    $response->assertStatus(201)                  // Check HTTP 201 Created
        ->assertJsonFragment([
            'sku' => 'abc-123',
            'mpn' => '999-XYZ',
            'quantity' => 50,
            'is_active' => true,
        ]);

    $this->assertDatabaseHas('products', [       // Check data exists in DB
        'sku' => 'abc-123',
        'mpn' => '999-XYZ',
        'quantity' => 50,
        'is_active' => true,
    ]);
});

