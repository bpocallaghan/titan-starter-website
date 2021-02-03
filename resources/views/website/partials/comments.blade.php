@if($commentable->allow_comments == 1)
    <!-- COMMENTS -->
    <section class="border rounded p-2 p-sm-4 ">
        <h5>Comments</h5>
        <form id="form-comments" accept-charset="UTF-8" action="/comments/submit" method="POST" class="needs-validation" novalidate>
            {!! csrf_field() !!}
            <input type="hidden" name="commentable_id" value="{{ $commentable->id }}">
            <input type="hidden" name="commentable_type" value="{{ get_class($commentable) }}">
            <input type="hidden" name="commentable_type_name" value="{{ (new \ReflectionClass($commentable))->getShortName() }}">

            <div class="form-row mb-3">
                <div class="col">
                    <input type="text" name="name" class="form-control validate" placeholder="Name">
                </div>
                <div class="col">
                    <input type="email" name="email" class="form-control validate" placeholder="Email Address">
                </div>
            </div>

            <div class="chat-type mb-2">
                <div class="chat-textarea">
                    <div class="input-group">
                        <textarea id="textarea" name="content" class="form-control validate" rows="1" placeholder="Write your message here" required></textarea>
                        <div class="input-group-append">
                            <button type="submit" id="g-recaptcha-comments" class="btn btn-primary chat-send animate g-recaptcha" data-widget-id="3" title="Submit"><i class="fa fa-fw fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            @include('website.partials.form.feedback')
        </form>

        <p class="small text-center mb-3" data-icon="fa fa-fw fa-info-circle">NOTE: Your comment will need to be approved by an administrator first.</p>
        @if(isset($commentable->comments))
            <div class="messages">

                @foreach($commentable->comments as $comment)
                    <div class="row message align-items-start">
                        <div class="col-auto user pr-0 d-none d-sm-block"><figure data-icon="fa fa-fw fa-user-circle"></figure></div>
                        <div class="col text">
                            <p class="small m-0"><strong>{{ ($comment->createdBy)? $comment->createdBy->fullname : (($comment->name)? $comment->name : 'Anonymous') }}</strong> wrote on {{ $comment->created_at->format('d M Y, H:i') }}</p>
                            <p class="content m-0">{{ $comment->content }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif

    </section>
@endif
