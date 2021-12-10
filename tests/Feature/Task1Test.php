<?php

namespace Tests\Feature;

use App\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;

class Task1Test extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    protected $modelFields = [
        "first_name",
        "last_name",
        "middle_name"
    ];
    protected $modelClass = Person::class;
    protected $modelPluralName = "people";
    protected $modelSingleName = "person";

    /* Checks json model updating */
    public function testUpdateOk()
    {
        $model = factory($this->modelClass)->create();
        $data = factory($this->modelClass)->make()->toArray();
        $routeName = $this->modelPluralName . ".update";
        $response = $this->putJson(route($routeName, [$this->modelSingleName => $model->id]), $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => $this->modelFields]);
        $response->assertJsonFragment($data);
    }

//    /* Checks json model updating validation */
    public function testUpdateError()
    {
        $model = factory($this->modelClass)->create();
        $routeName = $this->modelPluralName . ".update";
        $response = $this->putJson(route($routeName, [$this->modelSingleName => $model->id]), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['message', 'errors'=>$this->modelFields]);
    }

    /* Checks json model showing */
    public function testShow()
    {
        $model = factory($this->modelClass)->create();
        $routeName = $this->modelPluralName . ".show";
        $response = $this->getJson(route($routeName, [$this->modelSingleName => $model->id]));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => $this->modelFields]);
    }

    /* Checks json model showing error */
    public function testShowError()
    {
        $routeName = $this->modelPluralName . ".show";
        $response = $this->getJson(route($routeName, [$this->modelSingleName => 1]));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => "Not found"]);
    }

    /* Checks json model deleting error*/
    public function testDeleteError()
    {
        $routeName = $this->modelPluralName . ".destroy";
        $response = $this->deleteJson(route($routeName, [$this->modelSingleName => 1]));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => "Not found"]);
    }

//    /* Checks json model deleting */
    public function testDelete()
    {
        $model = factory(Person::class)->create();
        $routeName = $this->modelPluralName . ".destroy";
        $response = $this->deleteJson(route($routeName, [$this->modelSingleName => $model->id]));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => $this->modelFields
        ]);

    }

}