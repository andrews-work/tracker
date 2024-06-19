<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TodoListController extends Controller
{
    // view
    public function show()
    {
        Log::info('-----------------------');
        Log::info('TodoList Controller - show');
        $todoList = TodoList::where('user_id', auth()->user()->id)->get();
        Log::info('response:', [$todoList]);
        return response()->json($todoList);
    }

    public function store(Request $request)
    {
        Log::info('-----------------------');
        Log::info('TodoList Controller - create list');
    
        // Validate the data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|string',
            'importance' => 'nullable|string',
            'date' => 'nullable|date',
            'color' => 'nullable|string',
            'items' => 'required|string',
            'folder' => 'nullable|string|max:255',
            'subFolder' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'user_id' => 'exists:users,id',
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        Log::info('validated form:', $validatedData);
    
        // Create a new TodoList instance and save it to the database
        $todoList = TodoList::create([
            'name' => $validatedData['name'],
            'category' => $validatedData['category'],
            'importance' => $validatedData['importance'] ?? null,
            'date' => $validatedData['date'] ?? null,
            'color' => $validatedData['color'] ?? null,
            'folder' => $validatedData['folder'] ?? null,
            'subFolder' => $validatedData['subFolder'] ?? null,
            'tag' => $validatedData['tag'] ?? null,
            'user_id' => $validatedData['user_id'],
            'items' => json_encode($validatedData['items']),
        ]);
    
        Log::info('TodoList created successfully with ID: ' . $todoList->id);
        session()->flash('success', 'Todo list created successfully.');
    
        // Redirect the user to the todoList.show route
        return redirect()->route('todoList.show');
    }    

    // delete
    public function destroy(TodoList $todoList)
    {
        Log::info('-----------------------');
        Log::info('TodoList Controller - delete list');
        $todoList->delete();
        return redirect()->route('todoList.show')->with('success', 'Todo list deleted successfully.');
    }
}
