<?php

use App\Models\User;

beforeEach(function (){
    $this->user = User::factory()->create();

    $this->payload = [
        'name' => 'Hannan Miah',
        'email' => 'hannan@admin.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ];
});

describe('register',function (){
    test('user can register',function (){
        $res = $this->postJson(route('auth.register'),$this->payload);

        $res->assertStatus(201);

        // json response should have token
        $res->assertJsonStructure(['token']);
    });

    test('invalid email format',function (){
        $this->payload['email'] = 'invalid_email';

        $res = $this->postJson(route('auth.register'),$this->payload);

        $res->assertStatus(422);
        $res->assertJsonValidationErrors(['email']);
    });
});

describe('login',function (){
    test('user can login',function (){
        $res = $this->postJson(route('auth.login'),['email' => $this->user->email,'password' => 'password']);

        $res->assertStatus(200);
        $res->assertJsonStructure(['token']);
    });

    test('invalid credentials',function (){
        $this->payload['password'] = 'wrong_password';

        $res = $this->postJson(route('auth.login'),$this->payload);

        $res->assertStatus(401);
    });
});

describe('logout',function (){
    test('user can logout',function (){
        $this->actingAs($this->user);

        $res = $this->postJson(route('auth.logout'));

        $res->assertStatus(204);
    });

    test('user cannot logout when not authenticated',function (){
        $res = $this->postJson(route('auth.logout'));

        $res->assertStatus(401);
    });
});