<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Jobs\SendReminderNotification;
use Illuminate\Http\Request;

use App\Notifications\TaskNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{

    protected $user_id;

    public function __construct()
    {
        $this->user_id = Auth::id();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskData = Task::where('user_id', $this->user_id)->get();
        return view('index', ['taskData' => $taskData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create-task');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required',
            'title' => 'required|string|max:255',
            'desc' => 'required',
            'deadline' => 'required|nullable|date',
            'deadlineTime' => 'required',
        ]);
        $deadline = $validatedData['deadline'] . ' ' . $validatedData['deadlineTime'] . ':00';
        try {
            $task = Task::create([
                'category' => $validatedData['category'],
                'title' => $validatedData['title'],
                'description' => $validatedData['desc'],
                'deadline' => $deadline,
                'user_id' => $this->user_id
            ]);
            // send reminder
            $reminderTime = Carbon::parse($deadline)->subMinutes(2);
            SendReminderNotification::dispatch($task)->delay($reminderTime);
            // send notification
            $user = Auth::user() ?? User::first();
            $user->notify(new TaskNotification('A new task has been created: ' . $task->title));
            return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            Log::error('Error sending notification: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
            ]);
            return redirect()->route('tasks.index')->with('error', 'Error saving data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Task::find($id);
        return view('create-task', ['task' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task, $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Task::find($id)->update([
            'category' => $request->category,
            'title' => $request->title,
            'description' => $request->desc,
            'deadline' => $request->deadline . ' ' . $request->deadlineTime,
            'is_completed' => $request->has('completed') ? 1 : 0
        ]);
        if ($data) {
            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        } else {
            return redirect()->route('tasks.index')->with('success', 'Error updating task.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Task::find($id)->delete();
        if ($data) {
            return redirect()->back()->with('success', 'Task deleted successfully.');
        }
    }

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('tasks.index');
    }
}
