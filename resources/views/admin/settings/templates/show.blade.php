@extends('admin.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Templates - {{ $item->name }}</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @include('admin.partials.card.info')

            <form>
                <fieldset>
                    <div class="row">
                        <div class="col col-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ $item->name }}" readonly>
                            </div>
                        </div>

                        <div class="col col-4">
                            <div class="form-group">
                                <label>Template Name</label>
                                <input type="text" class="form-control" value="{{ $item->template }}" readonly>
                            </div>
                        </div>

                        <div class="col col-4">
                            <div class="form-group">
                                <label>Controller Action</label>
                                <input type="text" class="form-control" value="{{ $item->controller_action }}" readonly>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>

        @include('admin.partials.form.form_footer', ['submit' => false])

    </div>
@endsection
