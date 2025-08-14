<!-- resources/views/admin/users/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Usuario</h1>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electr\u00F3nico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contrase\u00F1a</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contrase\u00F1a</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Tel\u00E9fono (opcional)</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number">
        </div>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
</div>
@endsection
