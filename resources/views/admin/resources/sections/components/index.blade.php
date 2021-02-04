@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span>List All Content</span>
            </h3>
        </div>

        <div class="card-body">

            @include('admin.partials.card.info')

            <table id="tbl-list" data-server="false" class="dt-table table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Heading</th>
                    <th>Belongs To</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    @php
                        $url = '/admin/'.strtolower(\Str::plural((new \ReflectionClass($item->sections->first()->sectionable))->getShortName())).'/'.$item->sections->first()->sectionable->id.'/'.strtolower(\Str::plural((new \ReflectionClass($item->sections->first()))->getShortName())).'/'.$item->sections->first()->id.'/content/';
                        if(isset($item->sections) && $item->sections->count() > 0){
                            $actions = ['edit', 'delete'];
                        }else {
                            $actions = [];
                        }
                    @endphp
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>
                            @foreach($item->sections as $section)
                                {!! (($section->name)? $section->name:$section->summary).' <small>('.(isset($section)? (new \ReflectionClass($section))->getShortName() : 'The item this belonged to was removed.').')</small> - '.$section->sectionable->name.' <small>('.(isset($section->sectionable)? (new \ReflectionClass($section->sectionable))->getShortName() : 'The item this belonged to was removed.').')</small><br>' !!}
                            @endforeach
                        </td>
                        <td>{{ format_date($item->created_at) }}</td>
                        <td>{!! action_row($url, $item->id, $item->name, ['edit', 'delete']) !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
