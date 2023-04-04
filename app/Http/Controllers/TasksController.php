<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TasksResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return TasksResource::collection(
            Task::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreTaskRequest $request): TasksResource
    {
        $request->validated();
        echo "create===> ";
        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority
        ]);

        return new TasksResource($task);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id): ?TasksResource
    {
        $task = Task::find($id);
        if ($task) {
            return new TasksResource($task);
        }
        return null;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest $request, $id): ?TasksResource
    {
       $this->isNotAuthorized();

        $task = Task::find($id);
        if($task == null){
            return null;
        }
        $task->update($request->all());

        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->isNotAuthorized();
        $task = Task::find($id);
        if($task == null){
            return null;
        }
        return $task->delete();
    }

    private function isNotAuthorized(): void
    {
        if(!Auth::user()->id) {
            $this->error('', 'You are not authorized to make this request', 403);
        }
    }
}
