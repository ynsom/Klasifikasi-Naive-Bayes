@extends('layouts.main')

@section('content')
    <div class="row mt-3">
        <div class="col">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-12 mb-3">
        <div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-dark fw-bold">{{ $title }}</h3>
                </div>
                <div>
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('review.index') }}">Review</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('sentimen.index') }}">Sentimen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-body">
            <table id="myTable" class="table text-nowrap w-full mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Review</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sentimens as $sentimen)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sentimen->Review->user_name }}</td>
                            <td>{{ $sentimen->score }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
