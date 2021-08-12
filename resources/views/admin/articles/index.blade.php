@extends('admin.admin')

@section('content')

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">List All Articles</h3>
                </div>

                <div class="card-body">

                    @include('admin.partials.card.info')

                    @include('admin.partials.card.buttons')

                    <table id="tbl-list" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="desktop">Summary</th>
                            <th>Category</th>
                            <th>Active From</th>
                            <th>Active To</th>
                            <th>Cover Photo</th>
                            <th style="min-width: 125px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{!! $item->summary !!}</td>
                                <td>{{ ($item->category)? $item->category->name:'-' }}</td>
                                <td>{{ format_date($item->active_from) }}</td>
                                <td>{{ isset($item->active_to)? format_date($item->active_to):'-' }}</td>
                                <td>
                                    @if($item->cover_photo)
                                      {!! image_row_link($item->cover_photo->name, $item->cover_photo->thumb, $item->cover_photo->filename) !!}
                                    @endif
                                </td>
                                <td>
                                    {!! action_row($selectedNavigation->url, $item->id, $item->name, [['photo-video' => '/admin/news/articles/'.$item->id.'/resources'], 'show', 'edit', 'delete']) !!}
                                    {!! $item->date_badge !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

@endsection
