<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ url('result') }}" class="brand-link">
            {{-- <img src="{{ asset('images/supreme.png') }}" alt="Company logo" class="brand-image opacity-75 shadow text-bg-light"> --}}
            <span class="brand-text fw-light">BCFC</span>
        </a>
    </div>
	@php
		$check = 'fa-check-circle';
	@endphp
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">                
                <li class="nav-item">
                    <a href="{{ url('students') }}"
                        class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular {{ request()->is('admin/users') ? $check : 'fa-circle text-danger' }}"></i>
                        <p>Total student</p>
                    </a>
                </li>
				<li class="nav-item">
                    <a href="{{ url('admin/gallery') }}"
                        class="nav-link {{ request()->is('admin/gallery') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular {{ request()->is('admin/gallery') ? $check : 'fa-circle text-primary' }}"></i>
                        <p>Photo Gallery</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>