{{-- @if ($errors)
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger text-center alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong class="text-dark">{{ $error }}</strong>
        </div>
    @endforeach
@endif

@foreach (['success', 'danger', 'warning', 'info'] as $alert)
    @if ($message = Session::get($alert))
        <div class="alert alert-{{ $alert }} text-center alert-block">
            <button type="button" class="close text-dark" data-dismiss="alert">×</button>
            <strong class="text-dark">{{ $message }}</strong>
        </div>
    @endif
@endforeach --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ✅ Success alert
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: @json(session('success')),
                timer: 4000,
                showConfirmButton: false
            });
        @endif

        // ❌ Error alert
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: @json(session('error')),
                confirmButtonText: 'OK'
            });
        @endif

        // ⚠️ Validation errors
        @if ($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>