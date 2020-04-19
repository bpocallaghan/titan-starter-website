<h2 class="d-none">Header</h2>
<nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    @include('admin.partials.breadcrumb')

    <ul class="navbar-nav ml-auto">
        @if (impersonate()->isActive())
            <li class="nav-item">
                <a href="{{ route('impersonate.logout') }}" class="nav-link"
                   onclick="event.preventDefault(); document.getElementById('impersonate-logout-form').submit();">
                    Return to original user
                </a>

                <form id="impersonate-logout-form" action="{{ route('impersonate.logout') }}" method="post" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endif

        <li class="nav-item">
            <a id="js-notifications" href="#" class="nav-link" data-toggle="modal" data-target="#modal-notifications">
                <i class="far fa-envelope"></i>
                <span data-user="{{ user()->id }}" id="js-notifications-badge" class="badge badge-success navbar-badge" style="display: none;"></span>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a data-type="activities" class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span id="js-activities-badge" class="badge badge-info navbar-badge" style="display: none;"></span>
            </a>
            <div id="js-activities-list" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="text-xs">
                    <a href="#" class="dropdown-item">
                        <div class="row">
                            <div class="col-md-8">
                                Name of Activity
                            </div>
                            <div class="col-md-4">
                                <span class="float-right text-muted ">3 minutes ago</span>
                            </div>
                        </div>
                        <span class="text-muted">Description of Activity</span>
                    </a>
                    <div class="dropdown-divider"></div>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ profile_image() }}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{!! user()->fullname !!}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ profile_image() }}" class="img-circle elevation-2" alt="User Image">
                    <p>
                        {!! user()->fullname !!}
                        <small>Member since {{ user()->created_at->format('d F Y') }}</small>
                    </p>
                </li>
                <li class="user-footer">
                    <a href="{{ url('/admin/profile') }}" class="btn btn-light btn-flat">Profile</a>
                    <a href="{{ route('logout') }}" class="btn btn-light btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                        out</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
