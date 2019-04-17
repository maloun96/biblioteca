@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class="fas fa-tachometer-alt"></i> Books
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $book)
                                        <tr>
                                            <td>{{$book->book->name}}</td>
                                            <td>{{$book->cod}}</td>
                                            <td>
                                                @if($book->available)
                                                    <span class="badge badge-pill badge-success">Available</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Not available</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($book->available)
                                                    <a href="{{ route('frontend.user.dashboard.loan', $book->id) }}" class="btn btn-info"><i class="fas fa-cart-plus" data-toggle="tooltip" data-placement="top" title="Get Book"></i></a>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Not available</span>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- card-body -->
            </div><!-- card -->
            <br />
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class="fas fa-tachometer-alt"></i> My Loans
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Book</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userLoans as $loan)
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
                                        <td>{{ $loan->updated_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- card-body -->
            </div><!-- card -->
        </div><!-- row -->
    </div><!-- row -->
@endsection
