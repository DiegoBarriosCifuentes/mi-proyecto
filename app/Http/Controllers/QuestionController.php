<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\Category;

class QuestionController extends Controller
{
    public function show(Question $question)
    {
        $question->load(['answers', 'category', 'user']);
        return view('questions.show', compact('question'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string', 'max:2000'],
        ]);

        $q = new Question();
        $q->category_id = $validated['category_id'];
        $q->user_id     = Auth::id();
        $q->title       = $validated['title'];
        $q->content     = $validated['content'];
        $q->save();

        return redirect()->route('question.show', $q)
            ->with('status', 'Pregunta publicada correctamente.');
    }

    public function edit(Question $question)
    {
        $this->authorize('update', $question);

        $categories = Category::orderBy('name')->get();
        return view('questions.edit', [
            'question'   => $question,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string', 'max:2000'],
        ]);

        $question->category_id = $validated['category_id'];
        $question->title       = $validated['title'];
        $question->content     = $validated['content'];
        $question->save();

        return redirect()->route('question.show', $question)
            ->with('status', 'Pregunta actualizada correctamente.');
    }

    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);

        $question->delete();
        return redirect()->route('home')->with('status', 'Pregunta eliminada.');
    }
}
