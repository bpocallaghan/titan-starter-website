@extends('admin.admin')

@section('content')
    <div class="card <!--card-outline--> card-primary">
        <div class="card-header">
            <h3 class="card-title">Faqs - {{ $item->name }}</h3>

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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $item->question }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col col-md-6">
                            <section class="form-group">
                                <label>Category</label>
                                <input type="text" class="form-control" value="{{ $item->category->name }}" readonly>
                            </section>
                        </div>
                    </div>

                    <section class="form-group">
                        <label>Answer</label>
                        <div class="card card-body bg-light">
                            {!! $item->answer !!}
                        </div>
                    </section>
                </fieldset>
            </form>
        </div>
        @include('admin.partials.form.form_footer', ['submit' => false])
    </div>
@endsection
