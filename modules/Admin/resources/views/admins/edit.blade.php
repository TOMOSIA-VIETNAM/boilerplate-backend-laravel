<x-admin::app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ __('Edit Role Admin') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <form method="POST" action="{{ route('admin.management.update', $admin->id) }}">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">User Role:</label>
                                    <select name="role_user" class="selectpicker form-control" data-style="py-0">
                                        <option value="">Selected</option>

                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected(old('role_user', $admin->hasRole($role->name)))>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Update Admin Role') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin::app-layout>
