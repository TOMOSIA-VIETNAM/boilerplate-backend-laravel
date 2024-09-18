<x-admin::app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ __('New Admin Account') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <form method="POST" action="{{ route('admin.management.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" placeholder="Email" name="email" value="{{ old('email') }}">
                                    <x-admin::input-error :messages="$errors->first('email')" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">User Role:</label>
                                    <select name="role_user"
                                        class="selectpicker form-control @error('role_user') is-invalid @enderror"
                                        data-style="py-0">
                                        <option value="">Selected</option>

                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected(old('role_user') == $role->id)>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-admin::input-error :messages="$errors->first('role_user')" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="pass">{{ __('Password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="pass" name="password" placeholder="Password">
                                    <x-admin::input-error :messages="$errors->first('password')" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="rpass">{{ __('Repeat Password') }}</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="rpass" placeholder="Repeat Password" name="password_confirmation">
                                    <x-admin::input-error :messages="$errors->first('password_confirmation')" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Add New Admin') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin::app-layout>
