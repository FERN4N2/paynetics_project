<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id_project
     * @return JsonResponse
     */
    public function index($id_project): \Illuminate\Http\JsonResponse
    {
        if (!$this->validateProjectID($id_project))
            return response()->json([
                "code" => -1,
                'message' => "Incorrect ID parameters supplied",
                "data" => []
            ]);

        return response()->json([
            "code" => 0,
            "data" => Task::where('id_project', $id_project)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $id_project
     * @param Request $request
     * @return JsonResponse
     */
    public function store($id_project, Request $request): \Illuminate\Http\JsonResponse
    {
        if (!$this->validateProjectID($id_project))
            return response()->json([
                "code" => -1,
                'message' => "Incorrect ID parameters supplied",
                "data" => []
            ]);

        $input = $request->all();

        $validator = Validator::make($input, $this->getValidationRules());

        if ($validator->fails()){
            return response()->json([
                "code" => -1,
                "data" => [],
                "validation_errors" => $validator->errors()
            ]);
        }

        $task = Task::create($input + ['id_project' => $id_project]);

        return response()->json([
            "code" => 0,
            "message" => "Task created successfully.",
            "data" => $task
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param $id_project
     * @param int $id
     * @return JsonResponse
     */
    public function show($id_project, int $id): \Illuminate\Http\JsonResponse
    {
        if (!$this->validateProjectID($id_project, $id))
            return response()->json([
                "code" => -1,
                'message' => "Incorrect ID parameters supplied",
                "data" => []
            ]);


        $task = Task::find($id);

        if (is_null($task)) {
            return response()->json([
                "code" => -1,
                "error" => "Task not found.",
                "data" => []
            ]);
        }

        return response()->json([
            "code" => 0,
            "data" => $task
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id_project
     * @param Request $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update($id_project, Request $request, Task $task): JsonResponse
    {
        if (!$this->validateProjectID($id_project))
            return response()->json([
                "code" => -1,
                'message' => "Incorrect ID parameters supplied",
                "data" => []
            ]);

        $input = $request->all();

        $validator = Validator::make($input, $this->getValidationRules());

        if ($validator->fails()){
            return response()->json([
                "code" => -1,
                "data" => [],
                "validation_errors" => $validator->errors()
            ]);
        }

        $task->update([
            'name'      => $input['name'],
            'completed' => $input['completed'],
            'id_project' => $input['id_project'] ?? $id_project,
        ]);

        return response()->json([
            "code" => 0,
            "data" => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id_project
     * @param Task $task
     * @return JsonResponse
     */
    public function destroy($id_project, Task $task): JsonResponse
    {
        if (!$this->validateProjectID($id_project))
            return response()->json([
                "code" => -1,
                'message' => "Incorrect ID parameters supplied",
                "data" => []
            ]);

        $task->delete();

        return response()->json([
            "code" => 0,
        ]);
    }

    /**
     * Return the rules for the current handled model
     *
     * @return string[]
     */
    private function getValidationRules(): array
    {
        return [
            'name'       => 'required|max:255',
            'completed'  => 'required|boolean',
            'id_project' => 'nullable|exists:pgsql.dbuser.projects,id',
        ];
    }

    /**
     * Validate the ids of the project and task supplied are valid and related to each other
     *
     * @param $id_project
     * @param int|null $id_task
     * @return bool
     */
    private function validateProjectID($id_project, int $id_task = null): bool
    {
        return is_numeric($id_project) && Project::where(['id' => $id_project])->count() > 0 && (is_null($id_task) || Task::where(['id_project' => $id_project, 'id' => $id_task])->count() > 0);
    }
}
