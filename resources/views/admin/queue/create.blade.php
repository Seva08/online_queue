<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($queue) ? 'Edit Antrian' : 'Tambah Antrian' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container-lg mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ isset($queue) ? 'Edit Antrian' : 'Tambah Antrian' }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('queue.store') }}" method="POST">
                            @csrf

                            <div class="text-center mb-4">
                                <small class="text-muted d-block mb-2">Next queue:</small>
                                <div class="display-3 fw-bold text-primary">{{ $nextQueueNo }}</div>
                                {{-- <small class="text-muted d-block mt-2">Antrian saat ini: {{ $currentCount }}/5</small> --}}
                            </div>

                            {{-- <div class="progress mb-4">
                                <div class="progress-bar" role="progressbar" 
                                    style="width: {{ ($currentCount / 5) * 100 }}%" 
                                    aria-valuenow="{{ $currentCount }}" aria-valuemin="0" aria-valuemax="5">
                                    {{ $currentCount }}/5
                                </div>
                            </div> --}}

                            <div class="mb-3">
                                <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">-- Choose --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" 
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    Add Queue {{ $nextQueueNo }}
                                </button>
                                <a href="{{ route('queue.index') }}" class="btn btn-outline-secondary">Close</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>
</html>
