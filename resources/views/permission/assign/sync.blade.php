@extends('layouts.global')

@section('title')
    Role
@endsection

@section('links')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    {{-- initialiaze select 2 --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Permissions"
            });
        });
    </script>
@endpush

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('assign.index') }}" class="btn btn-success">Back</a><br><br>

<div class="card card-primary card-outline mb-3">
    <div class="card-header">
    <h3 class="card-title">Assign Permission</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('assign.edit', $role) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="role">Role Name</label>
                <select type="text" name="role" id="role" class="form-control">
                    <option disabled selected>-- Pilih Role --</option>
                    @foreach ($roles as $item)
                        <option {{ $role->id == $item->id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('role')
                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="permissions">Permissions</label>
                <select name="permissions[]" id="permissions" class="form-control select2" multiple>
                    @foreach ($permissions as $permission)
                        <option {{ $role->permissions()->find($permission->id) ? 'selected' : '' }} value="{{ $permission->id }}">{{ $permission->name }}</option>
                    @endforeach
                </select>
                @error('permissions')
                <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror
            </div>

            <button type="submit" class="btn btn-primary">Sync</button>
        </form>
    </div>
    </div>
</div>

@endsection
