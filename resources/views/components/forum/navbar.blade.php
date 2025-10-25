<nav class="flex items-center justify-between h-16">
    <div>
        <a href="{{ route('home') }}">
            <x-forum.logo />
        </a>
    </div>

    <div class="flex gap-4">
        <a href="#" class="text-sm font-semibold">Foro</a>
        <a href="#" class="text-sm font-semibold">Blog</a>
    </div>

    <div class="relative">
    @auth
        <details class="relative">
            <summary class="list-none cursor-pointer text-sm font-semibold">
                Hola, {{ auth()->user()->name }}
            </summary>
            <div class="absolute right-0 mt-2 w-48 rounded-md border bg-white shadow">
                <a href="{{ route('questions.create') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">
                    Preguntar
                </a>
                <form method="POST" action="{{ route('logout') }}" class="border-t">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50">
                        Cerrar sesión
                    </button>
                </form>
                <form method="POST" action="{{ route('switch.user') }}" class="border-t">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50">
                        Cambiar de usuario
                    </button>
                </form>
            </div>
        </details>
    @else
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-sm font-semibold">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="text-sm font-semibold">Crear cuenta</a>
        </div>
    @endauth
</div>

</nav>
