<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use App\Http\Requests\taskRequest;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskTerminedNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Console\View\Components\Task as ComponentsTask;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->created_task;
        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }
    public function MyTask()
    {
        $tasks = Auth::user()->assigned;
        return view('tasks.TaskAssigned', [
            'tasks' => $tasks
        ]);
    }
    public function create()
    {

        return view('tasks.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'min:3'],
            'start_date' => ['required', 'date', 'after:tomorrow'],
            'due_date' => ['required', 'date', 'after:start_date'],
            'description' => ['required', 'min:5'],
        ]);


        Task::create([
            'name' => $request->input('name'),
            'start_date' => $request->input('start_date'),
            'due_date' => $request->input('due_date'),
            'description' => $request->input('description'),
            'user_created_by' => Auth::user()->id
        ]);
        return redirect()->route('task.index')->with('sucess', 'votre tache a bien ete cree');
    }

    public function edit(Task $task)
    {

        return view('tasks.edit', ['task' => $task]);
    }
    public function update(Task $task, Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3'],
            'start_date' => ['required', 'date', 'after:tomorrow'],
            'due_date' => ['required', 'date', 'after:start_date'],
            'description' => ['required', 'min:5'],
        ]);

        $task->update($request->all());
        return redirect()->route('task.index')->with('success', 'votre tache a bien ete editer');
    }

    public function remove(task $task)
    {
        $task->delete();
        return redirect()->route('task.index')->with('sucess', 'votre tache a bien ete supprimer');
    }

    public function assignView(Task $task)
    {

        $users = User::whereDoesntHave('roles', function (Builder $query) {
            $query->whereIn('name', ['admin', 'create']);
        })->get();
        return View(
            'tasks.assigned-view',
            compact('users', 'task')

        );
    }

    public function assign(Request $request, Task $task)
    {
        $request->validate([
            'user_assigned_to' => ['required', 'exists:users,id']
        ]);
        $user_assigned_to = $request->input('user_assigned_to');

        $user = User::findOrFail($user_assigned_to);


        $occuped = $user->assigned()
            ->where(function (Builder $query) use ($task) {
                $query->where(function ($sub) {
                    $sub->where('status', 'en cours')
                        ->orWhere('status', 'en attente');
                })
                    ->where('start_date', '<', $task->due_date)
                    ->where('due_date', '>', $task->start_date);
            })->exists();
        if ($occuped) {
            return redirect()->route('task.assign', ['task' => $task->id])->with('errors', "l'utilisateur $user->name est occupé pour cette période");
        }
        $task->user_assigned_to = $user_assigned_to;
        $task->status = 'en cours';
        $task->save();
        $user->notify(new TaskAssignedNotification($task));
        return redirect()->route('task.index')->with('success', "la tache a bien ete attribuer a $user->name");
    }
    public function show(Task $task)
    {
        $user =User::find(Auth::user()->id);
        $notification = $user->notifications()->where(function($query) use ($task){
            $query->where('data->task_id', $task->id)
            ->where('read_at', null);
        })->first();

        if($notification){
            $notification->markAsRead();
        }
        return view('tasks.show', compact('task'));
    }

    public function startTask(Task $task)
    {
        $task->status = 'en cours';
        $task->save();
        return redirect()->route('task.MyTask');
    }
    public function maskAsTermined(Task $task)
    {
        $user = User::find($task->user_created_by);
        $task->status = 'terminer';
        $task->save();
        $user->notify(new TaskTerminedNotification($task));
        return redirect()->route('task.MyTask');
    }
}
