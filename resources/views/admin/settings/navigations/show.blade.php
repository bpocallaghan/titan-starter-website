@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-eye"></i></span>
                <span>Role - {{ $item->name }}</span>
            </h3>
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
                                <label>Slug</label>
                                <input type="text" class="form-control" value="{{ $item->slug }}" readonly>
                            </section>
                        </section>

                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" value="{{ $item->description }}" readonly>
                        </div>
                    </div>
                </fieldset>
            </div>
            @include('admin.partials.form.form_footer', ['submit' => false])

        </form>
    </div>

@endsection
