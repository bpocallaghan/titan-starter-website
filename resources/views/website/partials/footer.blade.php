<footer class="pt-5 mt-auto bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="/" class="logo" title="{{ config('app.name') }}">
                    <img class="img-fluid" src="/images/logo-secondary.png">
                </a>
                <hr>
                <p>{{ $settings->description }}</p>
                <div class="zoom-icons mb-4">
                    @if(isset($settings->facebook))<a target="_blank" title="Facebook" href="{{ $settings->facebook }}"><i class="fab fa-facebook"></i> </a>@endif
                    @if(isset($settings->twitter))<a target="_blank" title="Twitter" href="{{ $settings->twitter }}"><i class="fab fa-twitter"></i> </a>@endif
                    @if(isset($settings->instagram))<a target="_blank" title="Instagram" href="{{ $settings->instagram }}"><i class="fab fa-instagram"></i> </a>@endif
                    @if(isset($settings->linkedin))<a target="_blank" title="LinkedIn" href="{{ $settings->linkedin }}"><i class="fab fa-linkedin"></i> </a>@endif
                    @if(isset($settings->youtube))<a target="_blank" title="Youtube" href="{{ $settings->youtube }}"><i class="fab fa-youtube"></i> </a>@endif
                </div>
                <small>
                    Website by <a href="https://github.com/bpocallaghan" target="_blank">{!! config('app.author') !!}</a>
                </small>
            </div>
            <div class="offset-md-1 col-md-4">
                <h3>Quick Links</h3>
                @if(isset($footerNavigation['root']))
                    <ul class="list-unstyled nav-footer">
                    @foreach($footerNavigation['root'] as $nav)
                            <li><a title="{{ $nav->title }}" href="{{ $nav->url }}">{{ $nav->title }}</a>
                            @if (isset($footerNavigation[$nav->id]))
                                <ul class="list-unstyled nav-footer">
                                    @foreach($footerNavigation[$nav->id] as $navItem)
                                        <li><a title="{{ $navItem->title }}" href="{{ $navItem->url }}">{{ $navItem->title }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                    </ul>
                @endif
            </div>

            <div class="col-sm-4">
                <h3>Get in Touch</h3>

                @if(isset($settings->telephone))<p data-icon="fa-phone fa-fw"> <strong class="sr-only">Phone </strong> <a href="tel:{{ trim($settings->telephone) }}">{{ $settings->telephone }}</a></p>@endif
                @if(isset($settings->cellphone))<p data-icon="fa-mobile-alt fa-fw"> <strong class="sr-only">Mobile </strong> <a href="tel:{{ trim($settings->cellphone) }}">{{ $settings->cellphone }}</a></p>@endif
                @if(isset($settings->email))<p data-icon="fa-envelope fa-fw"> <strong class="sr-only">Email </strong> <a href="mailto:{{ trim($settings->email) }}">{{ $settings->email }}</a></p>@endif
                @if(isset($settings->address))<p data-icon="fa-map-marker-alt fa-fw"> <strong class="sr-only">Physical Address</strong> {{ $settings->address }}</p>@endif
                @if(isset($settings->po_box))<p data-icon="fa-print fa-fw"> <strong class="sr-only">Postal Address</strong>{{ $settings->po_box }}</p>@endif
            </div>
        </div>
    </div>
    <div class="container-fluid p-3 mt-3 copyright bg-dark">
        {{--<p class="text-right float-left small">--}}
            {{--Copyright &copy; {{config('app.name') . ' ' . date('Y')}}--}}
        {{--</p>--}}
        <div class="text-center">
            <a class="small" href="/privacy-policy">Privacy Policy</a> |
            <a class="small" href="/terms-and-conditions">Terms and Conditions </a>
            {{--<a class="small" href="/faq">FAQs</a>--}}
        </div>
    </div>
</footer>
