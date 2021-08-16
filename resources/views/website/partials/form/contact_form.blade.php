<form id="form-contact-us" accept-charset="UTF-8" action="/contact/submit" method="POST" class="needs-validation" novalidate>
    <input type="hidden" name="contactable_id" value="{{ $resourceable->id }}">
    <input type="hidden" name="contactable_type" value="{{ get_class($resourceable) }}">
    <input type="hidden" name="contactable_type_name" value="{{ (new \ReflectionClass($resourceable))->getShortName() }}">
    <input type="hidden" name="contactable_name" value="{{ isset($resourceable->name) && $resourceable->name != ''? $resourceable->name : (isset($resourceable->sectionable)? $resourceable->sectionable->name : 'Contact Us') }}">
    {!! csrf_field() !!}

    <div class="form-group form-row">
        <div class="col">
            <label class="sr-only">First name</label>
            <input type="text" class="form-control form-control-lg validate" name="firstname" id="firstname" placeholder="First name" required>
        </div>
        <div class="col">
            <label class="sr-only">Last name</label>
            <input type="text" class="form-control form-control-lg validate" name="lastname" id="lastname" placeholder="Last name" required>
        </div>
    </div>
    <div class="form-group form-row">
        <div class="col">
            <label class="sr-only">Email Address</label>
            <input type="email" class="form-control form-control-lg validate" name="email" id="email" placeholder="Email Address" required>
        </div>
        <div class="col">
            <label class="sr-only">Telephone Number</label>
            <input type="text" class="form-control form-control-lg validate" name="phone" id="phone" placeholder="Telephone Number">
        </div>
    </div>
    <div class="form-group form-row">
        <div class="col">
            <label class="sr-only">Your Message</label>
            <textarea class="form-control form-control-lg validate" rows="3" name="content" id="content" placeholder="Any additional comments" required></textarea>
        </div>
    </div>
    <div class="form-group form-row">
        <div class="col">
            <button type="submit" id="g-recaptcha-contact" class="btn btn-block btn-lg btn-outline-primary g-recaptcha" data-widget-id="0"><span>Submit</span></button>
        </div>
    </div>

    @include('website.partials.form.feedback')
</form>
