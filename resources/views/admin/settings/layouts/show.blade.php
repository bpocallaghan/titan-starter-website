@extends('admin.admin')

@section('content')
    <div class="card  card-primary">
        <div class="card-header">
            <h3 class="card-title">Role - {{ $item->name }}</h3>

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
                    </div>

                    <div class="row">
                        <section class="col col-6">
                            <section class="form-group">
                                <label>Layout</label>
                                <input type="text" class="form-control" value="{{ $item->layout }}" readonly>
                            </section>
                        </section>

                        <section class="col col-6">
                            <section class="form-group">
                                <label>Templates</label>
                                <input type="text" class="form-control" value="{{ implode(", ",$item->templates) }}" readonly>
                            </section>
                        </section>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="card-footer">
            @include('admin.partials.form.form_footer', ['submit' => false])
        </div>
    </div>
@endsection
