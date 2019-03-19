@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.auth.loan.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.auth.loan.store'))->class('form-horizontal')->open() }}
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
                            {{ html()->label('Name')->class('col-md-2 form-control-label')->for('name') }}

                            <div class="col-md-10">
                                {{ html()->text('name')
                                    ->class('form-control')
                                    ->placeholder('Name')
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->
                <div class="row mt-4 mb-4">
                    <div class="col">
                        <div class="form-group row">
                            {{ html()->label('User')->class('col-md-2 form-control-label')->for('user_id') }}

                            <div class="col-md-10">
                                <select class="form-control" name="user_id" readonly="true">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{Auth::getUser()->id === $user->id ? 'selected="true"' : ''}}>{{ $user->full_name }}</option>
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
                                        <option value="{{ $book->id }}" >{{ $book->name }}</option>
                                    @endforeach
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
    {{ html()->form()->close() }}
@endsection
