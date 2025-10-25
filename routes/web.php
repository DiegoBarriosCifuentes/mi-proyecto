<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;

// Home
Route::get('/', [PageController::class, 'index'])->name('home');

// Detalle público
Route::get('/question/{question}', [QuestionController::class, 'show'])->name('question.show');

// (si usas respuestas) - recomendable proteger también
Route::post('/answers/{question}', [AnswerController::class, 'store'])
    ->middleware('auth')
    ->name('answers.store');

// Rutas con autenticación
Route::middleware('auth')->group(function () {
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');

    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    // Cerrar sesión
    Route::post('/logout', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');

    // Cambiar de usuario (cerrar y llevar a login)
    Route::post('/switch-user', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('status', 'Sesión cerrada. Inicia con otra cuenta.');
    })->name('switch.user');
});

// === FIX al error "Route [dashboard] not defined" ===
// Muchos scaffolds de auth redirigen a 'dashboard' tras login/registro.
// Si no tienes vista dashboard, define esta ruta como redirect al home:
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
