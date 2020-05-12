@extends('admin.admin')

@section('content')
    <div class="card  card-primary">
        <div class="card-header">
            <h3 class="card-title">List All Clients</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @include('admin.partials.card.info')

            @include('admin.partials.card.buttons')

            <table id="tbl-list" data-page-length="25" class="dt-table table table-sm table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th><i class="fa fa-fw fa-user text-muted"></i> Name</th>
                    <th><i class="fa fa-fw fa-envelope text-muted"></i> Email</th>
                    <th><i class="fa fa-fw fa-mobile-phone text-muted"></i> Cellphone</th>
                    <th>Roles</th>
                    <th><i class="fa fa-fw fa-calendar text-muted"></i> Last Login</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->fullname }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->cellphone }}</td>
                        <td>{{ $item->roles_string }}</td>
                        <td>{{ ($item->logged_in_at)? $item->logged_in_at->diffForHumans():'-' }}</td>
                        <td>
                            {!! action_row($selectedNavigation->url, $item->id, $item->fullname, ['edit', 'delete'], false) !!}

                            @if($item->email_verified_at)
                                <div class="btn-group">
                                    <form id="impersonate-login-form-{{ $item->id }}" action="{{ route('impersonate.login', $item->id) }}" method="post">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <a data-form="impersonate-login-form-{{ $item->id }}" class="btn btn-warning btn-xs btn-confirm-modal-row" data-toggle="tooltip" title="Impersonate {{ $item->fullname }}">
                                            <i class="fa fa-user-secret"></i>
                                        </a>
                                    </form>
                                </div>
                            @endif

                            <span class="badge badge-{{ $item->email_verified_at ? 'success':'warning' }}">
                                {{ $item->email_verified_at ? 'Verified ' . $item->email_verified_at->format('d M Y') : 'Not confirmed yet' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
