<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
    <select name="role_id" id="role_id" class="form-select">
        <option value="">Select Role</option>
        @if ($roles->isNotEmpty())
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        @endif

    </select>
</div>