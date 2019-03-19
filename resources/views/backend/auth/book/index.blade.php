@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.book.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Book Management
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.auth.book.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Copies</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td>{{ $book->name }}</td>
                                <td>{{ $book->copies }}</td>
                                <td>
                                    <a href="{{ route('admin.auth.book.delete-permanently', $book) }} " name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.users.delete_permanently').'"></i></a>
                                    <a href="{{ route('admin.auth.book.edit', $book) }}" data-toggle="tooltip" data-placement="top" title="" class="btn btn-primary"><i class="fas fa-edit"></i></a>
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
                    {!! $books->total() !!} Book total
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $books->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
