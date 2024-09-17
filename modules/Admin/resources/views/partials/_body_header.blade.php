<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
    <div class="container-fluid navbar-inner">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto  navbar-list mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a href="#" class="search-toggle nav-link" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="https://flagsapi.com/{{ $currentFlag['folder'] }}/flat/64.png" class="img-fluid"
                            alt="user"
                            style="height: 25px; min-width: 25px; width: 40px; box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);object-fit: contain;">
                        <span class="bg-primary"></span>
                    </a>
                    <div class="sub-drop dropdown-menu dropdown-menu-end p-0" aria-labelledby="dropdownMenuButton2">
                        <div class="card shadow-none m-0 border-0">
                            <div class="p-0">
                                <ul class="list-group list-group-flush">
                                    @foreach ($langs as $locale)
                                        <li class="iq-sub-card list-group-item" style="padding: 0 !important"><a
                                                style="display:block;padding: .75rem 1.25rem !important;"
                                                href="{{ route('admin.lang', $locale['code']) }}"><img
                                                    src="https://flagsapi.com/{{ $locale['folder'] }}/flat/64.png"
                                                    alt="img-flaf" class="img-fluid me-2"
                                                    style="width: 15px;height: 15px;min-width: 15px;" />{{ $locale['name'] }}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link py-0 d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/avatars/01.png') }}" alt="User-Profile"
                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_1.png') }}" alt="User-Profile"
                            class="theme-color-purple-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_2.png') }}" alt="User-Profile"
                            class="theme-color-blue-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_4.png') }}" alt="User-Profile"
                            class="theme-color-green-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_5.png') }}" alt="User-Profile"
                            class="theme-color-yellow-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_3.png') }}" alt="User-Profile"
                            class="theme-color-pink-img img-fluid avatar avatar-50 avatar-rounded">
                        <div class="caption ms-3 d-none d-md-block ">
                            <h6 class="mb-0 caption-title">Austin Robertson</h6>
                            <p class="mb-0 caption-sub-title text-capitalize">
                                Marketing Administrator</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="">{{ __('Profile') }}</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="">
                                @csrf
                                <a href="javascript:void(0)" class="dropdown-item"
                                    onclick="event.preventDefault();
              this.closest('form').submit();">
                                    {{ __('Log out') }}
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
