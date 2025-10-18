<nav class="app-header navbar navbar-expand-lg bg-body shadow-sm">
    <div class="container-fluid">
        <!-- Left: Home -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <h4 class="mb-0">
				<i class="fa-solid fa-house"></i> Home
			</h4>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <div class="d-flex flex-column flex-lg-row w-100 justify-content-between align-items-center gap-3">

                <!-- Center Title -->
                <div class="text-center flex-grow-1 order-1 order-lg-2">
                    <h4 class="mb-0">Bangladesh-China Friendship Center</h4>
                </div>

                <!-- Right Search -->
                <div class="order-2 order-lg-3">
                    <form method="POST" action="{{ route('search.number') }}" enctype="multipart/form-data" class="d-flex flex-column flex-sm-row align-items-center gap-2 w-100">
                        @csrf
                        <input type="number" class="form-control w-100" name="mobile" placeholder="Mobile number" style="max-width: 220px;">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-magnifying-glass pe-2"></i> Search Student
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>