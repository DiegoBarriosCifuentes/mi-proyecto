<x-forum.layouts.app>

@if (session('status'))
    <div class="my-4 rounded-md bg-green-100 text-green-800 px-4 py-2 text-sm">
        {{ session('status') }}
    </div>
@endif

<div class="max-w-3xl mx-auto my-8 space-y-6">

    {{-- Encabezado + acciones (solo dueño) --}}
    <header>
        <div class="flex items-start gap-3">
            <livewire:heart :heartable="$question" />

            <div class="flex-1">
                <h1 class="text-2xl md:text-3xl font-bold">{{ $question->title }}</h1>
                <p class="text-xs text-gray-500">
                    <span class="font-semibold">{{ $question->user->name }}</span> ·
                    {{ $question->category->name }} ·
                    {{ $question->created_at->diffForHumans() }}
                </p>
            </div>

            @can('update', $question)
                <div class="flex items-center gap-2">
                    <a href="{{ route('questions.edit', $question) }}"
                       class="rounded-md bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-3 py-1.5">
                        Editar
                    </a>
                    @can('delete', $question)
                        <form action="{{ route('questions.destroy', $question) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta pregunta?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="rounded-md bg-red-600 hover:bg-red-500 text-white text-xs px-3 py-1.5">
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            @endcan
        </div>
    </header>

    {{-- Contenido de la pregunta (una sola vez) --}}
    <article class="prose max-w-none">
        {!! nl2br(e($question->content)) !!}
    </article>

    {{-- Comentarios sobre la pregunta --}}
    <livewire:comment :commentable="$question" />

    {{-- Respuestas --}}
    <ul class="space-y-4">
        @foreach($question->answers as $answer)
            <li>
                <div class="flex items-start gap-2">
                    <livewire:heart :heartable="$answer" wire:key="answer-heart-{{ $answer->id }}" />
                    <div>
                        <p class="text-sm text-gray-300">{{ $answer->content }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $answer->user->name }} · {{ $answer->created_at->diffForHumans() }}
                        </p>

                        {{-- clave distinta para evitar colisión con el heart --}}
                        <livewire:comment :commentable="$answer" wire:key="answer-comment-{{ $answer->id }}" />
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    {{-- Formulario para responder (solo autenticados) --}}
    @auth
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-2">Tu Respuesta...</h3>
            <form action="{{ route('answers.store', $question) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <textarea name="content" rows="6" class="w-full p-2 border rounded-md text-xs" required></textarea>
                    @error('content')<span class="block text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="rounded-md bg-blue-600 hover:bg-blue-500 px-4 py-2 text-white cursor-pointer">
                    Enviar Respuesta
                </button>
            </form>
        </div>
    @else
        <div class="mt-8 text-sm">
            <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">Inicia sesión para responder</a>
        </div>
    @endauth

</div>
</x-forum.layouts.app>
