<x-forum.layouts.app>
    <div class="max-w-3xl mx-auto my-8">
        <h1 class="text-2xl font-bold mb-6">Crear pregunta</h1>

        <form action="{{ route('questions.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Categoría</label>
                <select name="category_id" required
                        class="w-full border rounded-md px-3 py-2 text-sm bg-white text-gray-900">
                    <option value="" disabled selected>— Selecciona una categoría —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<span class="block text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Título</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full border rounded-md px-3 py-2 text-sm bg-white text-gray-900" />
                @error('title')<span class="block text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Contenido</label>
                <textarea name="content" rows="8" required
                          class="w-full border rounded-md px-3 py-2 text-sm bg-white text-gray-900">{{ old('content') }}</textarea>
                @error('content')<span class="block text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="rounded-md bg-blue-600 hover:bg-blue-500 px-4 py-2 text-white">
                    Publicar
                </button>
                <a href="{{ route('home') }}" class="text-sm hover:underline">Cancelar</a>
            </div>
        </form>
    </div>
</x-forum.layouts.app>
