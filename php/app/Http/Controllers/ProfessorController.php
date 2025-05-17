<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {
        return Professor::with('user')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'idUsuario' => 'required|exists:users,id',
        ]);

        return Professor::create($request->all());
    }

    public function show($id)
    {
        return Professor::with('user')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);
        $professor->update($request->all());
        return $professor;
    }

    public function destroy($id)
    {
        return Professor::destroy($id);
    }
}

