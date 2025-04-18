<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Category;
use App\Models\MonthlyReport;
use App\Notifications\AdminNewUserNotification;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $todos = Todo::where(['user_id' => $userId])->get();
        return view('todo.list', ['todos' => $todos]);
        return view('todo');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todo.add');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('user_create');
    
        $userData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);
    
        $userData['start_at'] = Carbon::createFromFormat('m/d/Y', $request->start_at)->format('Y-m-d');
        $userData['password'] = bcrypt($request->password);
    
        $user = User::create($userData);
        $user->roles()->sync($request->input('roles', []));
    
        Project::create([
            'user_id' => $user->id,
            'name' => 'Demo project 1',
        ]);
        Category::create([
            'user_id' => $user->id,
            'name' => 'Demo category 1',
        ]);
        Category::create([
            'user_id' => $user->id,
            'name' => 'Demo category 2',
        ]);
    
        MonthlyReport::where('month', now()->format('Y-m'))->increment('users_count');
        $user->sendEmailVerificationNotification();
    
        $admins = User::where('is_admin', 1)->get();
        Notification::send($admins, new AdminNewUserNotification($user));
    
        return response()->json([
            'result' => 'success',
            'data' => $user,
        ], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userId = Auth::user()->id;
        $todo = Todo::where(['user_id' => $userId, 'id' => $id])->first();
        if (!$todo) {
            return redirect('todo')->with('error', 'Todo not found');
        }
        return view('todo.view', ['todo' => $todo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $userId = Auth::user()->id;
        $todo = Todo::where(['user_id' => $userId, 'id' => $id])->first();
        if ($todo) {
            return view('todo.edit', ['todo' => $todo]);
        } else {
            return redirect('todo')->with('error', 'Todo not found');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userId = Auth::user()->id;
        $todo = Todo::find($id);
        if (!$todo) {
            return redirect('todo')->with('error', 'Todo not found.');
        }
        $input = $request->input();
        $input['user_id'] = $userId;
        $todoStatus = $todo->update($input);
        if ($todoStatus) {
            return redirect('todo')->with('success', 'Todo successfully updated.');
        } else {
            return redirect('todo')->with('error', 'Oops something went wrong. Todo not updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userId = Auth::user()->id;
        $todo = Todo::where(['user_id' => $userId, 'id' => $id])->first();
        $respStatus = $respMsg = '';
        if (!$todo) {
            $respStatus = 'error';
            $respMsg = 'Todo not found';
        }
        $todoDelStatus = $todo->delete();
        if ($todoDelStatus) {
            $respStatus = 'success';
            $respMsg = 'Todo deleted successfully';
        } else {
            $respStatus = 'error';
            $respMsg = 'Oops something went wrong. Todo not deleted successfully';
        }
        return redirect('todo')->with($respStatus, $respMsg);
    }
}