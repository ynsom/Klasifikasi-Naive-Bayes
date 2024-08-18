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
                            <a class="nav-link active" aria-current="page" href="{{ route('review.index') }}">Review</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('sentimen.index') }}">Sentimen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-body">
            <table id="myTable2" class="table text-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Aplikasi</th>
                        <th>Nama User</th>
                        <th>Rating</th>
                        <th>Review Text</th>
                        <th>Sentimen</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function() {
            var table = $('#myTable2').DataTable({
                processing: true,
                scrollX: true,
                serverSide: true,
                ajax: '{{ route('review.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'application_name',
                        name: 'application_name'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'rating',
                        name: 'rating'
                    },
                    {
                        data: 'review_text',
                        name: 'review_text'
                    },
                    {
                        data: 'sentiment',
                        name: 'sentiment'
                    },
                ]
            });
        });
    </script>
@endsection
