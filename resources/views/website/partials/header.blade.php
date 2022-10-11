<div class="sticky-top navbar-light bg-white">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a href="/" class="navbar-brand logo" title="{{ config('app.name') }}">
                <img src="/images/logo.png" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @if(isset($navigation))
                        @include('website.partials.navigation.top_level', ['collection' => $navigation['root'], 'navigation' => $navigation])
                    @endif
                </ul>
                @if(!auth()->check())
                    <a href="/auth/login" class="btn btn-sm btn-outline-primary mr-1" {{--data-toggle="modal" data-target="#modal-login"--}}>
                        <i class="fa fa-sign-in"></i>
                        Login
                    </a>
                    <a href="/auth/register" class="btn btn-sm btn-outline-secondary" data-icon="fa-edit">
                        Register
                    </a>
                @else
                    @if(impersonate()->isActive())
                        <small>
                            <a href="{{ route('impersonate.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('impersonate-logout-form').submit();">
                                return to original user
                            </a>
                        </small>
                        <form id="impersonate-logout-form" class="d-none" action="{{ route('impersonate.logout') }}" method="post">
                            {{ csrf_field() }}
                        </form>
                    @endif

                    @if(auth()->check() && user()->isAdmin())
                        <a href="/admin" class="btn btn-link" data-toggle="tooltip" title="Admin" data-original-title="Admin"><i class="fa fa-user-secret"></i></a>
                    @endif
                @endif
            </div>
        </nav>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            $('#form-search').on('submit', function () {
                var search = $("#form-search input[name='search']").val();
                window.location.href = "https://www.google.com.na/search?q={{ config('app.url') }}+" + encodeURI(search);
                return false;
            });
        })
    </script>
@endsection
