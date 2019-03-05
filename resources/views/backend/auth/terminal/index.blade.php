@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.terminal.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Terminal Management
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.auth.terminal.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.access.users.table.name')</th>
                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($terminals as $terminal)
                            <tr>
                                <td>{{ $terminal->name }}</td>
                                <td>
                                    <a href="{{ route('admin.auth.terminal.delete-permanently', $terminal) }} " name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.users.delete_permanently').'"></i></a>
                                    <a href="{{ route('admin.auth.terminal.edit', $terminal) }}" data-toggle="tooltip" data-placement="top" title="" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $terminals->total() !!} Terminals total
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $terminals->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
