@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.loan.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Loan Management
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.auth.loan.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Book</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td>{{ $loan->user->full_name }}</td>
                                <td>{{ $loan->copy->book->name }}</td>
                                <td>
                                    @if($loan->status === 0)
                                        <span class="badge badge-pill badge-primary">Pending</span>
                                    @endif
                                    @if($loan->status === 1)
                                        <span class="badge badge-pill badge-success">Approved</span>
                                    @endif
                                    @if($loan->status === 2)
                                        <span class="badge badge-pill badge-dark">Restored</span>
                                    @endif
                                </td>
                                <td>{{ $loan->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.auth.loan.delete-permanently', $loan) }} " name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.users.delete_permanently').'"></i></a>
                                    <a href="{{ route('admin.auth.loan.edit', $loan) }}" data-toggle="tooltip" data-placement="top" title="" class="btn btn-primary"><i class="fas fa-edit"></i></a>

                                    @if($isAdmin)
                                        @if($loan->status === 0)
                                            <a href="{{ route('admin.auth.loan.approve', $loan) }}" data-toggle="tooltip" data-placement="top" title="Approve request" class="btn btn-success"><i class="fas fa-share-square"></i></a>
                                        @endif
                                        @if($loan->status === 1)
                                            <a href="{{ route('admin.auth.loan.back', $loan) }}" data-toggle="tooltip" data-placement="top" title="Get back book" class="btn btn-warning"><i class="fas fa-arrow-alt-circle-left"></i></a>
                                        @endif
                                    @endif
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
                    {!! $loans->total() !!} Loans total
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $loans->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
