<?php

use App\Models\Todo;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TodoTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function add_new_todo()
    {
        $this->actingAs(factory(User::class)->create())
            ->post('/api/todo', [
                'name'      => 'Todo1',
                'completed' => true,
            ])->seeStatusCode(200)
            ->post('/api/todo', [
                'name'      => 'Todo1',
                'completed' => 'string',
            ])->seeStatusCode(302)
            ->post('/api/todo', [
                'name'      => '',
                'completed' => true,
            ])->seeStatusCode(302);

        $this->seeInDatabase('todos', [
            'name'      => 'Todo1',
            'completed' => true,
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_or_cannot_edit_delete_todo()
    {
        $user_good = factory(User::class)->create();
        $user_bad  = factory(User::class)->create();

        $this->actingAs($user_good)
            ->post('/api/todo', [
                'name'      => 'Todo1',
                'completed' => true,
            ])->seeStatusCode(200);

        $todo = Todo::where('name', 'Todo1')->first();

        $this->actingAs($user_bad)
            ->put('/api/todo/' . $todo->id, [
                'name'      => 'Todo1',
                'completed' => true,
            ])->seeStatusCode(403);

        $this->actingAs($user_bad)
            ->delete('/api/todo/' . $todo->id)->seeStatusCode(403);

        $this->actingAs($user_good)
            ->delete('/api/todo/' . $todo->id)->seeStatusCode(200);
    }
}
