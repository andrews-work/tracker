<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TodoListController extends Controller {

    // view
    public function show(){
        log::info('-----------------------');
        log::info('TodoList Controller - show');
        $todoList = TodoList::where('user_id', auth()->user()->id)->get();
        log::info('response:', [$todoList]);
        return response()->json($todoList);
    }

    // create
    function store(Request $request) {

        log::info('-----------------------');
        log::info('TodoList Controller - create list');
        // validated data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|string',
            'importance' => 'nullable|string',
            'date' => 'nullable|date',
            'color' => 'nullable|string',
            'items' => 'required|array',
            'folder' => 'nullable|string|max:255',
            'subFolder' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'user_id' => 'exists:users,id',
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        log::info('validated form:', $validatedData);

        // create a new TodoList instance and save it to the database
        $todoList = TodoList::create([
            'name' => $validatedData['name'],
            'category' => $validatedData['category'],
            'importance' => $validatedData['importance'] ?? null,
            'date' => $validatedData['date'] ?? null,
            'color' => $validatedData['color'] ?? null,
            'items' => json_encode($validatedData['items']),
            'folder' => $validatedData['folder'] ?? null,
            'subFolder' => $validatedData['subFolder'] ?? null,
            'tag' => $validatedData['tag'] ?? null,
            'user_id' => $validatedData['user_id'],
        ]);
        

        Log::info('TodoList created successfully with ID: ' . $todoList->id);
        session()->flash('success', 'Todo list created successfully.');

        // Redirect the user to the todoList.show route
        return redirect()->route('todoList.show');
    }

    // delete
    public function destroy(TodoList $todoList) {
        log::info('-----------------------');
        log::info('TodoList Controller - delete list');
        $todoList->delete();
        return redirect()->route('todoList.show')->with('success', 'Todo list deleted successfully.');
    }
    
}