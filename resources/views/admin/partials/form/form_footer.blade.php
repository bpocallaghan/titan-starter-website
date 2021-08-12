<div class="card-footer form-footer">
    @if(isset($submit) == false || $submit == true)
        <button class="btn btn-primary btn-submit float-right">
            <i class="fa fa-fw fa-save"></i> Submit
        </button>
    @endif

    @if(isset($order) && isset($orderUrl) && $orderUrl != '')
        <a class="btn btn-light float-right" href="{{ $orderUrl }}">
            <span><i class="fa fa-align-center" aria-hidden="true"></i> {{ $order }} Order</span>
        </a>
    @endif

    <a href="{{ isset($back)? $back : ((isset($selectedNavigation->url) && $selectedNavigation->url != '')? $selectedNavigation->url : "javascript:window.history.back();") }}" class="btn btn-secondary ">
        <i class="fa fa-fw fa-chevron-left"></i> Back
    </a>
</div>
