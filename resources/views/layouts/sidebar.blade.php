<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">


        {{-- role regency --}}
        @if (Auth::user()->role === 'regency')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('province-budget-requests') ? 'active' : 'collapsed' }}"
                    href="/province-budget-requests">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Pengajuan Anggaran</span>
                </a>
            </li>
            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('profile') ? 'active' : 'collapsed' }}" href="/profile">
                    <i class="bi bi-person-check"></i>
                    <span>Profile</span>
                </a>
            </li>
            <br>
            <li class="nav-item">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light ">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        @endif


        {{-- role province --}}

        @if (Auth::user()->role === 'province')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : 'collapsed' }}" href="/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::is('#') ? 'active' : 'collapsed' }}"
                    href="/pengajuan-anggaran-departement/regency">
                    <i class="bi bi-file-earmark-medical"></i>
                    <span>Anggaran Daerah</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('province-budget-requests') ? 'active' : 'collapsed' }}"
                    href="/province-budget-requests">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Pengajuan Anggaran</span>
                </a>
            </li>

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('user') ? 'active' : 'collapsed' }}" href="/user">
                    <i class="bi bi-person-check"></i>
                    <span>Akun Kota/Kab</span>
                </a>
            </li>
            <br>
            <li class="nav-item">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light ">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        @endif


        {{-- role departement --}}
        @if (Auth::user()->role === 'departement' || Auth::user()->role === 'pusat' || Auth::user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : 'collapsed' }}" href="/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/pengajuan-anggaran/*') ? 'active' : 'collapsed' }}"
                    data-bs-target="#tables-nav-1" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-diagram-2"></i><span>Pengajuan Anggaran</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav-1" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/pengajuan-anggaran-departement/regency">
                            <i class="bi bi-circle"></i><span>Anggraran Kota/Kab</span>
                        </a>
                    </li>
                    <li>
                        <a href="/pengajuan-anggaran-departement/province">
                            <i class="bi bi-circle"></i><span>Anggraran Provinsi</span>
                        </a>
                    </li>
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'pusat')
                        <li>
                            <a href="/pengajuan-anggaran-departement/departement">
                                <i class="bi bi-circle"></i><span>Anggraran Departement</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li><!-- End Tables Nav -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/manage-account-*') ? 'active' : 'collapsed' }}"
                    data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-diagram-2"></i><span>Kelola Akun</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/manage-account-regency">
                            <i class="bi bi-circle"></i><span>Akun Kota/Kab</span>
                        </a>
                    </li>
                    <li>
                        <a href="/manage-account-province">
                            <i class="bi bi-circle"></i><span>Akun Provinsi</span>
                        </a>
                    </li>
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'pusat')
                        <li>
                            <a href="/manage-account-departement">
                                <i class="bi bi-circle"></i><span>Akun Departement</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li><!-- End Tables Nav -->
            @if (Auth::user()->role === 'departement')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('province-budget-requests') ? 'active' : 'collapsed' }}"
                        href="/province-budget-requests">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Ajukan Anggaran</span>
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/departement') ? 'active' : 'collapsed' }}" href="/departement">
                    <i class="bi bi-bank"></i>
                    <span>Departement</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::is('/unit') ? 'active' : 'collapsed' }}" href="/unit">
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>Satuan</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::is('/funding') ? 'active' : 'collapsed' }}" href="/funding-source">
                    <i class="bx bx-money"></i>
                    <span>Sumber Dana</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::is('/program') ? 'active' : 'collapsed' }}" href="/program">
                    <i class="bi bi-bookmark-plus"></i>
                    <span>Program</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/activity') ? 'active' : 'collapsed' }}" href="/activity">
                    <i class="bi ri-stack-overflow-line"></i>
                    <span>Kegiatan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/kro') ? 'active' : 'collapsed' }}" href="/kro">
                    <i class="bi bi-door-open"></i>
                    <span>KRO</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/ro') ? 'active' : 'collapsed' }}" href="/ro">
                    <i class="bi bi-grid-1x2"></i>
                    <span>RO</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/component') ? 'active' : 'collapsed' }}" href="/component">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>Komponent</span>
                </a>
            </li>
            <br>
            <li class="nav-item">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light ">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        @endif


    </ul>

</aside>
