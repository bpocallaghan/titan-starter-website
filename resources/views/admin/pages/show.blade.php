@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-eye"></i></span>
                <span>Pages - {{ $item->name }}</span>
            </h3>
        </div>

        <div class="card-body">

            @include('admin.partials.card.info')

            <form>
                <fieldset>
                    <div class="row">
                        <section class="col col-6">
                            <section class="form-group">
                                <label>Page</label>
                                <input type="text" class="form-control" value="{{ $item->name }}" readonly>
                            </section>
                        </section>

                        <section class="col col-6">
                            <section class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" value="{{ $item->slug }}" readonly>
                            </section>
                        </section>
                    </div>

                    <section class="form-group">
                        <label>Description</label>
                        <div class="well well-light well-form-description">
                            {!! $item->description !!}
                        </div>
                    </section>
                </fieldset>

                @include('admin.partials.form.form_footer', ['submit' => false])
            </form>
        </div>
    </div>
@endsection
