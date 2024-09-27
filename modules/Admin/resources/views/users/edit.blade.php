<x-admin::app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ __('Edit User Information') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <form method="POST" action="{{ route('admin.user.update', $user->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <div class="profile-img-edit position-relative" x-data="imageHandler">
                                        <template x-if="imageSrc || @js($user->getImageUrl($user->avatar))">
                                            <img :src="imageSrc ? imageSrc : @js($user->getImageUrl($user->avatar))" id="user_avatar"
                                                class="theme-color-default-img profile-pic rounded avatar-100"
                                                alt="profile-pic" />
                                        </template>
                                        <label for="file-upload" class="upload-icone bg-primary"
                                            style="cursor: pointer;">
                                            <svg class="upload-button icon-14" width="14" viewBox="0 0 24 24">
                                                <path fill="#ffffff"
                                                    d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                                            </svg>
                                        </label>
                                        <input id="file-upload" x-ref="imageInstance" @change="preview"
                                            class="file-upload" type="file" name="avatar" accept="image/*"
                                            style="display: none;">
                                    </div>
                                    <x-admin::input-error :messages="$errors->first('avatar')" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" placeholder="Email" name="email"
                                        value="{{ old('email', $user->email) }}">
                                    <x-admin::input-error :messages="$errors->first('email')" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="pno">{{ __('Fullname') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="pno" placeholder="Fullname" name="name"
                                        value="{{ old('name', $user->name) }}">
                                    <x-admin::input-error :messages="$errors->first('name')" />
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
                            <button type="submit" class="btn btn-primary">{{ __('Update User') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin::app-layout>
