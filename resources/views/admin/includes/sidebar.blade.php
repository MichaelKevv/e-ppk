<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo_black.PNG') }}" class="navbar-brand-img" width="35" height="42"
                alt="main_logo">
            <span class="ms-1 text-sm text-dark"><span style="color: #ffb703">SI</span>PERU</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: auto;">
        <ul class="navbar-nav">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- Pengaduan --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/pengaduan*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('admin.pengaduan.index') }}">
                    <i class="material-symbols-rounded opacity-5">report</i>
                    <span class="nav-link-text ms-1">Pengaduan</span>
                </a>
            </li>

            {{-- Feedback --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/feedback*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('admin.feedback.index') }}">
                    <i class="material-symbols-rounded opacity-5">forum</i>
                    <span class="nav-link-text ms-1">Feedback</span>
                </a>
            </li>

            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#profileExamples" class="nav-link text-dark collapsed"
                    aria-controls="profileExamples" role="button" aria-expanded="false">
                    <i
                        class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">group</i>
                    <span class="nav-link-text ms-1 ps-1">Metode</span>
                </a>
                <div class="collapse" id="profileExamples" style="">
                    <ul class="nav ">
                        {{-- Decision Tree --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/decision-tree*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                                href="{{ route('admin.decision-tree.index') }}">
                                <i class="material-symbols-rounded opacity-5">article</i>
                                <span class="nav-link-text ms-1">Decision Tree</span>
                            </a>
                        </li>

                        {{-- TAM & Survey Data --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('survey*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                                href="{{ route('admin.survey.index') }}">
                                <i class="material-symbols-rounded opacity-5">assessment</i>
                                <span class="nav-link-text ms-1">Survey Data & TAM</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#projectsExamples" class="nav-link text-dark "
                    aria-controls="projectsExamples" role="button" aria-expanded="false">
                    <i
                        class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">widgets</i>
                    <span class="nav-link-text ms-1 ps-1">Projects</span>
                </a>
                <div class="collapse " id="projectsExamples">
                    <ul class="nav ">
                        <li class="nav-item ">
                            <a class="nav-link text-dark " href="../../pages/projects/general.html">
                                <span class="sidenav-mini-icon"> G </span>
                                <span class="sidenav-normal  ms-1  ps-1"> General </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-dark " href="../../pages/projects/timeline.html">
                                <span class="sidenav-mini-icon"> T </span>
                                <span class="sidenav-normal  ms-1  ps-1"> Timeline </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-dark " href="../../pages/projects/new-project.html">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal  ms-1  ps-1"> New Project </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Siswa --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/siswa*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('admin.siswa.index') }}">
                    <i class="material-symbols-rounded opacity-5">school</i>
                    <span class="nav-link-text ms-1">Siswa</span>
                </a>
            </li>

            {{-- Petugas --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/admin*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('admin.admin.index') }}">
                    <i class="material-symbols-rounded opacity-5">badge</i>
                    <span class="nav-link-text ms-1">Admin</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/dinsos*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('admin.dinsos.index') }}">
                    <i class="material-symbols-rounded opacity-5">badge</i>
                    <span class="nav-link-text ms-1">Dinsos</span>
                </a>
            </li>

            {{-- Pengguna --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/pengguna*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('admin.pengguna.index') }}">
                    <i class="material-symbols-rounded opacity-5">group</i>
                    <span class="nav-link-text ms-1">Pengguna</span>
                </a>
            </li>

            {{-- Artikel --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/artikel*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('admin.artikel.index') }}">
                    <i class="material-symbols-rounded opacity-5">article</i>
                    <span class="nav-link-text ms-1">Artikel</span>
                </a>
            </li>
        </ul>
    </div>
</aside>