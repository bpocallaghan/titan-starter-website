@extends('admin.admin')

@section('content')
    <div class="card  card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-eye"></i></span>
                <span>Banner - {{ $item->name }}</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <form>
            <div class="card-body">

                @include('admin.partials.card.info')


                <fieldset>
                    <div class="row">
                        <section class="col col-6">
                            <section class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ $item->name }}" readonly>
                            </section>
                        </section>

                        <section class="col col-6">
                            <section class="form-group">
                                <label>Summary</label>
                                <input type="text" class="form-control" value="{{ $item->summary }}" readonly>
                            </section>
                        </section>
                    </div>

                    <div class="row">
                        <div class="col col-6">
                            <section class="form-group">
                                <label>Action Name</label>
                                <input type="text" class="form-control" value="{{ $item->action_name }}" readonly>
                            </section>
                        </div>

                        <div class="col col-6">
                            <section class="form-group">
                                <label>Action Url</label>
                                <input type="text" class="form-control" value="{{ $item->action_url }}" readonly>
                            </section>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-6">
                            <section class="form-group">
                                <label>Active From</label>
                                <input type="text" class="form-control" value="{{ $item->active_from }}" readonly>
                            </section>
                        </div>

                        <div class="col col-6">
                            <section class="form-group">
                                <label>Active To</label>
                                <input type="text" class="form-control" value="{{ $item->active_to }}" readonly>
                            </section>
                        </div>
                    </div>

                    @if(isset($item) && $item && $item->image)
                        <section>
                            <img src="{{ uploaded_images_url($item->image) }}" style="max-height: 300px;">
                            <input type="hidden" name="image" value="{{ $item->image }}">
                        </section>
                    @endif
                </fieldset>


            </div>
            @include('admin.partials.form.form_footer', ['submit' => false])
        </form>
    </div>
@endsection
