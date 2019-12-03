<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function testBasicExample()
    {
        $response = $this->withHeaders([
            'X-Header' => 'LaravelAcademy',
        ])->json('POST', '/texts', ['name' => '学院君']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }
}
