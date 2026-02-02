@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded p-6 max-w-md mx-auto">
        <h2 class="text-lg font-semibold mb-4">Crear usuario para {{ $persona->nombre }} {{ $persona->apellido }}</h2>

        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_persona" value="{{ $persona->id_persona }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" value="{{ old('username', $defaultUsername) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                @error('username')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="password" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                @error('password')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('usuarios.index') }}" class="mr-2 px-4 py-2 rounded border">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded">Crear usuario</button>
            </div>
        </form>
    </div>
@endsection
