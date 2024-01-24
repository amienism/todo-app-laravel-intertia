<?php

namespace App\Http\Controllers;

use App\Models\Todos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $todos = Todos::when($request->query('search_term'), function ($query) use ($request) {
            return $query->where('todo_name', 'LIKE', '%'.$request->query('search_term').'%');
        });

        $todos = $todos->paginate(10);

        return Inertia::render(
            'Index', ['todos' => $todos]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'todo_name' => 'required|string|max:255',
            'is_completed' => 'nullable|sometimes|boolean',
        ]);

        Todos::create([
            'todo_name' => $request->todo_name,
        ]);

        return redirect('/')->with('message', 'Todo Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Todos $todos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todos $todos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        Todos::where('id', $id)->update([
            'is_completed' => $request->is_completed,
        ]);

        return;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todos $todos, int $id)
    {
        Todos::where('id', $id)->delete();

        // return redirect('/')->with('message', 'Todo Deleted Successfully');
        return;
    }
}
