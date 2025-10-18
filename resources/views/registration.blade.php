@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-3 p-0">
				<div id="registration-form" class="card">
                    <h4 class="card-header py-2 text-center fw-bold" style="background-color: whitesmoke; color: #333;">Registration form</h4>
                    <div class="card-body">
                        <form method="POST" action="{{ route('registration.save') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">Student name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        autofocus required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="father" class="col-md-4 col-form-label text-md-end fw-bold">Father's name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="father" value="{{ old('father') }}"
                                        autofocus required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="mother" class="col-md-4 col-form-label text-md-end fw-bold">Mother's name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="mother" value="{{ old('mother') }}"
                                        autofocus required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="dob" class="col-md-4 col-form-label text-md-end fw-bold">Date of birth</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control datepicker" name="dob"
                                        value="{{ old('dob') }}" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="school" class="col-md-4 col-form-label text-md-end fw-bold">School / Institute</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="school" value="{{ old('school') }}"
                                        autofocus required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="mobile" class="col-md-4 col-form-label text-md-end fw-bold">Mobile number</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="mobile" value="{{ old('mobile') }}"
                                        autofocus required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end fw-bold">Student's photo</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control" name="image" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="certificate" class="col-md-4 col-form-label text-md-end fw-bold">Birth certificate</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control" name="certificate" autofocus required>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Save now') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

				<!-- Countdown Timer -->
                <div id="countdown" class="text-center my-3 fs-5 fw-bold border border-danger rounded-1"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
		// Set target datetime in Bangladesh timezone (GMT+6)
		const targetDate = new Date('2025-10-24T16:00:00+06:00').getTime();

		const countdownEl = document.getElementById('countdown');
		const formEl = document.getElementById('registration-form');

		const interval = setInterval(function() {
			const now = new Date().getTime();
			const distance = targetDate - now;

			if (distance <= 0) {
				clearInterval(interval);
				countdownEl.innerHTML = "Registration closed";
				formEl.style.display = "none"; // hide the form
				return;
			}

			const days = Math.floor(distance / (1000 * 60 * 60 * 24));
			const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance % (1000 * 60)) / 1000);

			countdownEl.innerHTML = `Time left: ${days}d ${hours}h ${minutes}m ${seconds}s`;
		}, 1000);
	</script>
@endsection
