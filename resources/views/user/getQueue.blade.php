<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Get Queue</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($currentCount >= 5)
                            <div class="alert alert-warning text-center" role="alert">
                                <strong>Max Queue!</strong>
                                <p class="mb-0">Max queue.</p>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="/user/list-queue" class="btn btn-info">All queue</a>
                                <a href="/" class="btn btn-outline-secondary">Back</a>
                            </div>
                        @else
                            <div class="text-center mb-4">
                                <small class="text-muted d-block mb-2">Your queue:</small>
                                <div class="display-2 fw-bold text-primary">{{ $nextQueueNo }}</div>
                                {{-- <small class="text-muted d-block mt-2">Current Queue: {{ $currentCount }}/5</small> --}}
                            </div>

                            {{-- <div class="progress mb-4">
                                <div class="progress-bar" role="progressbar" 
                                    style="width: {{ ($currentCount / 5) * 100 }}%" 
                                    aria-valuenow="{{ $currentCount }}" aria-valuemin="0" aria-valuemax="5">
                                    {{ $currentCount }}/5
                                </div>
                            </div> --}}

                            <form action="{{ route('user.store-queue') }}" method="POST">
                                @csrf

                                <input type="hidden" name="queue_no" value="{{ $nextQueueNo }}">

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-check-circle"></i> Get Queue {{ $nextQueueNo }}
                                    </button>
                                    <a href="/user/list-queue" class="btn btn-info">All Queue</a>
                                    <a href="/admin/user" class="btn btn-outline-secondary">Back</a>
                                </div>
                            </form>

                            <hr>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>