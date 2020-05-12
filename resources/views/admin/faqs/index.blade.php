@extends('admin.admin')

@section('content')
    <div class="card <!--card-outline--> card-primary">
        <div class="card-header">
            <h3 class="card-title">List All Faqs</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @include('admin.partials.card.info')

            @include('admin.partials.card.buttons', ['order' => true])

            <table id="tbl-list" data-page-length="25" class="dt-table table table-sm table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Category</th>
                    <th>Totals</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->question }}</td>
                        <td>{!! $item->answer_summary !!}</td>
                        <td>{!! $item->category->name !!}</td>
                        <td>
                            <span title="Total Reads" data-toggle="tooltip" class="badge badge-info"><i class="fa fa-eye"></i> {{ $item->total_read }}</span>
                            <span title="Helpful Yes" data-toggle="tooltip" class="badge badge-success"><i class="fa fa-thumbs-up"></i> {{ $item->helpful_yes }}</span>
                            <span title="Helpful No" data-toggle="tooltip" class="badge badge-danger"><i class="fa fa-thumbs-up"></i> {{ $item->helpful_no }}</span>
                        </td>
                        <td>{{ format_date($item->updated_at) }}</td>
                        <td>{!! action_row($selectedNavigation->url, $item->id, $item->title, ['show', 'edit', 'delete']) !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
