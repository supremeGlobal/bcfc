@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
            <div class="card">
                <h4 class="card-header py-2 text-center">{{ __('Register form') }}</h4>
                <div class="card-body">
                    <form method="POST" action="{{ route('register.save') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Student name*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" autofocus>
                            </div>
                        </div>

						<div class="row mb-3">
                            <label for="father" class="col-md-4 col-form-label text-md-end">Father's name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="father" autofocus>
                            </div>
                        </div>

						<div class="row mb-3">
                            <label for="mother" class="col-md-4 col-form-label text-md-end">Mother's name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="mother" autofocus>
                            </div>
                        </div>

						<div class="row mb-3">
                            <label for="dob" class="col-md-4 col-form-label text-md-end">Date of birth*</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control datepicker" name="dob" autofocus>
                            </div>
                        </div>

						<div class="row mb-3">
                            <label for="school" class="col-md-4 col-form-label text-md-end">School / Institute</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="school" autofocus>
                            </div>
                        </div>

						<div class="row mb-3">
                            <label for="mobile" class="col-md-4 col-form-label text-md-end">Mobile number*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="mobile" autofocus>
                            </div>
                        </div>

						<div class="row mb-3">
							<label for="image" class="col-md-4 col-form-label text-md-end">Student's photo*</label>
							<div class="col-md-8">
								<input type="file" class="form-control" name="image" autofocus>
							</div>
						</div>

						<div class="row mb-3">
                            <label for="certificate" class="col-md-4 col-form-label text-md-end">Birth certificate</label>
                            <div class="col-md-8">
                                <input type="file" class="form-control" name="certificate" autofocus>
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
        </div>
    </div>
</div>
@endsection
