<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "code" => 0,
            "data" => Project::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, $this->getValidationRules());

        if ($validator->fails()){
            return response()->json([
                "code" => -1,
                "data" => [],
                "validation_errors" => $validator->errors()
            ]);
        }

        $project = Project::create($input);

        return response()->json([
            "code" => 0,
            "message" => "Project created successfully.",
            "data" => $project
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $project = Project::find($id);

        if (is_null($project)) {
            return response()->json([
                "code" => -1,
                "error" => "Project not found.",
                "data" => []
            ]);
        }

        return response()->json([
            "code" => 0,
            "data" => $project
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update(Request $request, Project $project): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, $this->getValidationRules());

        if ($validator->fails()){
            return response()->json([
                "code" => -1,
                "data" => [],
                "validation_errors" => $validator->errors()
            ]);
        }

        $project->update([
            'title'       => $input['title'],
            'description' => $input['description'],
            'client'      => $input['client'],
            'company'     => $input['company'],
            'begin_at'    => $input['begin_at'],
            'finish_at'   => $input['finish_at'],
        ]);

        return response()->json([
            "code" => 0,
            "data" => $project
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

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
            'title'       => 'required|max:255',
            'description' => 'required|max:255',
            'client'      => 'exclude_unless:company,null|required|max:255',
            'company'     => 'exclude_unless:client,null|required|max:255',
            'begin_at'    => 'required|date|before:finish_at',
            'finish_at'   => 'required|date|after:begin_at',
        ];
    }
}
