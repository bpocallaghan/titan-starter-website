@extends('admin.admin')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span><i class="fa fa-eye"></i></span>
                        <span>Role - {{ $item->name }}</span>
                    </h3>
                </div>

                <div class="box-body no-padding">

                    @include('admin.partials.info')

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

                                <div class="form-group">
                                	<label>Description</label>
                                	<input type="text" class="form-control" value="{{ $item->description }}" readonly>
                                </div>
                            </div>
                        </fieldset>

                        @include('admin.partials.form.form_footer', ['submit' => false])

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
