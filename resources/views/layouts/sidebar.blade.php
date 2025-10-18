<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ url('result') }}" class="brand-link">
            <span class="brand-text fw-light">BCFC: Dashboard</span>
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
                        class="nav-link {{ request()->is('students') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular {{ request()->is('students') ? $check : 'fa-circle text-danger' }}"></i>
                        <p>Total student</p>
                    </a>
                </li>

				@php
					$groups = ['A', 'B', 'C', 'D'];
				@endphp
				
				@foreach ($groups as $group)
					<li class="nav-item">
						<a href="{{ url('students/' . strtolower($group)) }}"
							class="nav-link {{ request()->is('students/' . strtolower($group)) ? 'active' : '' }}">
							<i class="nav-icon fa-regular {{ request()->is('students/' . strtolower($group)) ? $check : 'fa-circle text-info' }}"></i>
							<p>Group {{ $group }}</p>
						</a>
					</li>
				@endforeach
            </ul>
        </nav>
    </div>
</aside>