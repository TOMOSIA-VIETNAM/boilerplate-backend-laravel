<div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar"
                data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button>
        <a class="c-header-brand d-sm-none" href="#">
            <img class="c-header-brand" src="{{ url('/assets/brand/coreui-base.svg') }}" width="97" height="46"
                 alt="CoreUI Logo">
        </a>
        <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar"
                data-class="c-sidebar-lg-show" responsive="true">
            <span class="c-header-toggler-icon"></span>
        </button>
        <ul class="c-header-nav ml-auto mr-4">
            <li class="c-sidebar-nav-item dropdown">
                <span class="c-sidebar-nav-link">
                    <span class="text-capitalize">Admin</span>
                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <div class="c-avatar">
                            <img class="c-avatar-img" src="{{ url('/assets/img/avatars/admin.jpg') }}" alt="user@email.com">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0 pb-0 my-0">
                        <form action="{{ url('/logout') }}" method="POST">
                            @csrf
                            <div class="dropdown-item">
                                <svg class="c-icon">
                                    <use xlink:href="{{ url('/icons/sprites/free.svg#cil-account-logout') }}"></use>
                                </svg>
                                <button type="submit" class="btn btn-block">Logout</button>
                            </div>
                        </form>
                    </div>
                </span>
            </li>
        </ul>
