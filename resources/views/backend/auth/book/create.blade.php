@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.auth.book.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.auth.book.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Book management
                            <small class="text-muted">Create book</small>
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
                <div class="copies">
                    <div class="row mt-4 mb-4 copy" id="first-copy">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label('Cod unic')->class('col-md-2 form-control-label')->for('cod_unic[]') }}
                                <div class="col-md-9">
                                    {{ html()->text('cod_unic[]')
                                        ->class('form-control')
                                        ->placeholder('Cod unic')
                                        ->attribute('maxlength', 191)
                                        ->required()
                                        ->autofocus() }}
                                </div><!--col-->
                                <div class="col-md-1 remove-cod-unic" style="display: none">
                                    <button class="btn btn-danger remove-copy"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="Remove"></i></button>
                                </div>
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->
                </div>

                <button id="add-new-copy" class="btn btn-success">Add new copy</button>
            </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.auth.book.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection
@push('after-scripts')
    <script>
        $(document).ready(function () {
            console.log('Ready');

            $("#add-new-copy").on('click', function (e) {
                e.preventDefault();

                const c = $('#first-copy').clone();
                c.find('.remove-cod-unic').show();
                c.find('input').val('');
                c.appendTo( ".copies" );
            });

            $('.copies').on('click', '.remove-copy',function (e) {
                e.preventDefault();
                $(this).closest('.copy').remove();
            })
        })
    </script>
@endpush
