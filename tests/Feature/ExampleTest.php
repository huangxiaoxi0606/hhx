<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
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
        $response = $this->json('POST', '/user', ['name' => 'Sally']);

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'created' => true,
            ]);
    }
    public function testA(){
        Artisan::command('question', function () {
            $name = $this->ask('What is your name?');
            $language = $this->choice('Which language do you program in?', [
                'PHP',
                'Ruby',
                'Python',
            ]);

            $this->line('Your name is '.$name.' and you program in '.$language.'.');
        });
    }

    public function testDatabase()
    {
        // Make call to application...
        $this->assertDatabaseHas('damais', [
            'actors' => '田馥甄'
        ]);
    }


}
