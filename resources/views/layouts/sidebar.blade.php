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
                    <a href="{{ url('students') }}" class="nav-link {{ request()->is('students') ? 'active' : '' }}">
                        <i
                            class="nav-icon fa-regular {{ request()->is('students') ? $check : 'fa-circle text-danger' }}"></i>
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
                            <i
                                class="nav-icon fa-regular {{ request()->is('students/' . strtolower($group)) ? $check : 'fa-circle text-info' }}"></i>
                            <p>Group {{ $group }}</p>
                        </a>
                    </li>
                @endforeach

                @php
                    // You can make this dynamic from DB if needed
                    $groups = ['A', 'B', 'C', 'D'];
                @endphp

                <li class="nav-item {{ request()->is('print-copy*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('print-copy*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-users"></i>
                        <p>
                            Print: Group list
                            <i class="nav-arrow fa-solid fa-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @foreach ($groups as $group)
                            <li class="nav-item">
                                <a href="{{ url('print-copy/' . strtolower($group)) }}" target="_blank" class="nav-link {{ request()->is('print-copy/' . strtolower($group)) ? 'active' : '' }}">
                                    <p class="ps-4">
										Group :
										<span class="ps-2">{{ $group }}</span>
									</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
