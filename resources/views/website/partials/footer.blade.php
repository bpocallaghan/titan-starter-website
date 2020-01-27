<footer class="pt-5 bg-secondary mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 text-left">
                <a href="/" class="logo" title="{{ config('app.name') }}">
                    <img src="/images/logo.png">
                </a>
                <hr>
                <small>
                    Website by <a href="https://github.com/bpocallaghan" target="_blank">{!! env('APP_AUTHOR') !!}</a>
                </small>
            </div>
            <div class="col-sm-8 text-center">
                <div class="row text-left">

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-3 bg-dark mt-3">
        {{--<p class="text-right float-right text-muted small">
            Copyright &copy; {{config('app.name') . ' ' . date('Y')}}
        </p>--}}
        <div class="text-center">
            <a class="text-muted small" href="/privacy-policy">Privacy Policy</a> |
            <a class="text-muted small" href="/terms-and-conditions">Terms and Conditions </a> |
            <a class="text-muted small" href="/faq">FAQs</a>
        </div>
    </div>
</footer>
