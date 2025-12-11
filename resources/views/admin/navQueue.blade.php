<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Queue Navigate</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
	<div class="container py-4">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h2>Queue Navigate</h2>
			<a href="/admin" class="btn btn-outline-secondary">Back</a>
		</div>

		@if(session('success'))
			<div class="alert alert-success text-dark">{{ session('success') }}</div>
		@endif
		@if(session('error'))
			<div class="alert alert-danger text-dark">{{ session('error') }}</div>
		@endif

		<div class="row">
			<div class="col-md-6 mb-3">
				<div class="card text-center">
					<div class="card-body">
						<h5 class="card-title">Queue</h5>
						@if(!empty($lastCalled))
							<div class="display-1 fw-bold">{{ $lastCalled['no'] }}</div>
							<div class="text-muted">{{ $lastCalled['user_name'] ?? '' }}</div>
							<div class="small text-muted">   {{ $lastCalled['called_at'] }}</div>
						@else
							<div class="display-4">-</div>
							<div class="text-muted">-</div>
						@endif

						<form action="{{ route('queue.callNext') }}" method="POST" class="mt-3">
							@csrf
							<button type="submit" class="btn btn-primary btn-lg">Next</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card text-dark">
					<div class="card-body">
						<h5 class="card-title">Next Queue</h5>

						@if(isset($nextQueues) && $nextQueues->count())
							<ul class="list-group">
								@foreach($nextQueues as $q)
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<div>
											<strong>{{ $q->no }}</strong>
											<div class="small text-muted">{{ $q->user->name ?? 'N/A' }} - {{ $q->user->email ?? '' }}</div>
										</div>
										<div class="small text-muted">{{ $q->created_at->format('H:i d-m') }}</div>
									</li>
								@endforeach
							</ul>
						@else
							<div class="alert alert-info mb-0">-</div>
						@endif

					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>