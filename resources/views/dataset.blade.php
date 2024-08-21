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
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#tambahModal">Crawling</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-body">
            <table id="myTable" class="table text-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Apps</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Average Rate</th>
                        <th>Total Review</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datasets as $dataset)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dataset->name }}</td>
                            <td>{{ $dataset->category }}</td>
                            <td>{{ $dataset->desc }}</td>
                            <td>{{ $dataset->average_rating }}</td>
                            <td>{{ $dataset->total_reviews }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Crawling Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="crawlingForm">
                        <div class="mb-3">
                            <label for="appSelect" class="form-label">Pilih Aplikasi</label>
                            <select class="form-select" id="appSelect" name="app_select">
                                <option value="1">Gojek</option>
                                <option value="2">Grab</option>
                                <option value="3">InDrive</option>
                            </select>
                        </div>
                        <button type="button" id="startCrawlingBtn" class="btn btn-primary">Mulai Crawling</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('startCrawlingBtn').addEventListener('click', function() {
            const appSelect = document.getElementById('appSelect').value;

            // Menjalankan AJAX request
            fetch('http://localhost:5000/scrape', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Hapus jika token tidak diperlukan
                    },
                    body: JSON.stringify({
                        app_select: appSelect
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Crawling gagal: ' + data.error);
                    } else {
                        alert('Crawling berhasil dimulai.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
