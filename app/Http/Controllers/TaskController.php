<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    // private $taskList = [
    //     'first' => 'Sleep',
    //     'second' => 'Eat',
    //     'third' => 'Work'
    // ];

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('is_admin');
    }

    public function index(Request $request) {

        // if ($request->search) {
        //     return $this->taskList[$request->search];
        // }
        // return $this->taskList;

        if ($request->search) {
            $tasks = Task::where('tasks', 'LIKE', "%$request->search%")
                // ->get();
                ->paginate(5);

            $tasks = Task::paginate(5);
            return view('task.index', [
                'data' => $tasks
            ]);
        }   

        // $tasks = Task::all();
        $tasks = Task::paginate(5);
        return view('task.index', [
            'data' => $tasks
        ]);
    }

    public function create() {
        return view('task.create');
    }

    public function store(TaskRequest $request) {
        // $this->taskList[$request->label] = $request->task;

        // return $this->taskList;

        // DB::table('tasks')->insert([
        //     'task' => $request->task,
        //     'user' => $request->user
        // ]);

          Task::create([
            'tasks' => $request->tasks,
            'user' => $request->user
        ]);

        return redirect('/tasks/index');

    }

    public function show($id) {

        // return $this->taskList[$param];

        // $task = DB::table('tasks')->where('id', $id)->first();
        $task = Task::find($id);
        return $task;
        // ddd($task);

    }

    public function edit($id) {
        $task = Task::find($id);
        return view('task.edit', compact('task'));
    }

    public function update(TaskRequest $request, $id) {
        // $this->taskList[$key] = $request->task;
        // return $this->taskList;

        $task = Task::find($id);
         // $task = DB::table('tasks')->where('id', $id)->update([
        $task->update([

            'tasks' => $request->tasks,
            'user' => $request->user

         ]);
        
        return redirect('/tasks/index');
    }

    public function destroy($id) {
        // unset($this->taskList[$key]);
        // return $this->taskList;

        $task = Task::find($id);
        // DB::table('tasks')
        //     ->where('id', $id)
        //     ->delete();

        $task->delete();
        
        return redirect('/tasks/index');
    }


}
