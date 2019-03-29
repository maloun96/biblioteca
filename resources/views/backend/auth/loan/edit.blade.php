@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.edit'))

@section('breadcrumb-links')
    @include('backend.auth.loan.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($loan, 'PATCH', route('admin.auth.loan.update', $loan->id))->class('form-horizontal')->open() }}
    <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Loan management
                    <small class="text-muted">Create loan</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <hr>

        <div class="row mt-4 mb-4">
            <div class="col">
                <div class="form-group row">
                    {{ html()->label('User')->class('col-md-2 form-control-label')->for('user_id') }}

                    <div class="col-md-10">
                        <select class="form-control" name="user_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{$loan->user->id === $user->id ? 'selected="true"' : ''}}>{{ $user->full_name }}</option>
                            @endforeach
                        </select>
                    </div><!--col-->
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->
        <div class="row mt-4 mb-4">
            <div class="col">
                <div class="form-group row">
                    {{ html()->label('Book')->class('col-md-2 form-control-label')->for('book_id') }}

                    <div class="col-md-10">
                        <select class="form-control" name="book_id">
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ $loan->book->id === $book->id ? 'selected="true"' : '' }}>{{ $book->name }}</option>
                            @endforeach
                        </select>
                    </div><!--col-->
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->
        <div class="row mt-4 mb-4">
            <div class="col">
                <div class="form-group row">
                    {{ html()->label('Status')->class('col-md-2 form-control-label')->for('status') }}
                    <div class="col-md-10">
                        <select class="form-control" name="status">
                            <option value="0" {{ $loan->status == 0 ? 'selected="true"' : '' }}>Pending</option>
                            <option value="1" {{ $loan->status == 1 ? 'selected="true"' : '' }}>Approved</option>
                            <option value="2" {{ $loan->status == 2 ? 'selected="true"' : '' }}>Restored</option>
                        </select>
                    </div><!--col-->
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->

    <div class="card-footer clearfix">
        <div class="row">
            <div class="col">
                {{ form_cancel(route('admin.auth.loan.index'), __('buttons.general.cancel')) }}
            </div><!--col-->

            <div class="col text-right">
                {{ form_submit(__('buttons.general.crud.create')) }}
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer-->
</div><!--card-->
{{ html()->closeModelForm() }}
@endsection
