<nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner" style="transform: scale(2); transform-origin: left;">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    @php $segments = request()->segments(); @endphp
                    <div class="page-title ms-xl-0 ms-5">
                        @foreach ($segments as $i => $s)
                            @php $text = ucwords(str_replace(['-', '_'], ' ', $s)); @endphp
                            @if ($i === 0)
                                <h5 class="fw-bold d-inline">{{ $text }}</h5>
                            @elseif ($i === 1)
                                <span class="text-muted mx-1">/</span>
                                <span class="h6 d-inline">{{ $text }}</span>
                            @else
                                <span class="text-muted mx-1">/</span>
                                <small class="text-muted">{{ $text }}</small>
                            @endif
                        @endforeach
                    </div>
                </li>
            </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
            <div class="mb-0 font-weight-bold breadcrumb-text text-white">
                <form id="logout-form" method="POST" action="/logout">
                    @csrf
                    <button type="button" id="btn-logout" class="btn btn-sm btn-danger mb-0 me-1">Log out</button>
                </form>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="#" class="nav-link text-body p-0">
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                            class="fixed-plugin-button-nav cursor-pointer" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <svg height="16" width="16" viewBox="0 0 24 24" fill="currentColor"
                            class="cursor-pointer">
                            <path fill-rule="evenodd"
                                d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-1">
                            <a class="dropdown-item d-flex align-items-center text-sm text-nowrap" href="#">
                                <span class="fw-bold">My Profile</span>
                            </a>
                        </li>
                        <li class="mb-1">
                            <a class="dropdown-item d-flex align-items-center text-sm text-nowrap"
                                href="/pengaturan/sop">
                                <span class="fw-bold">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-sm text-nowrap" href="#"
                                data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <span class="fw-bold">TS / Invoice</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ps-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <img src="{{ asset('storage/logo/' . $kec->logo) }}" class="PreviewLogo avatar avatar-sm"
                            alt="Logo Navbar" />
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ts dan Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                        <img src="../../assets/img/user.png" alt="Preview" class="img-fluid rounded">
                    </div>
                    <div class="col-md-8">
                        <h3 class="fw-bold text-center mb-2" style="font-size: 28px;">TECHNICAL SUPPORT</h3>
                        <h4 class="fw-bold text-center mb-4" style="font-size: 22px;">0882-0066-44656</h4>
                        <ul class="text-muted" style="font-size: 14px;">
                            <li>Jika terdapat kendala teknis, silahkan menghubungi Technical Support kami melalui
                                WhatsApps ke nomor diatas. Dimohon menggunakan bahasa yang mudah dipahami dan tidak
                                menyulitkan.</li>
                            <li>Regristasikan terlebih dahulu Nomor Bapak/Ibu dengan cara ketik Lokasi Beserta Nama
                                Aplikasinya</li>
                            <li>Jika permasalahan berkaitan dengan transaksi, sertakan Loan ID Transaksi yang
                                dimaksud.</li>
                        </ul>
                        <p class="text-end fw-bold mt-4">Team Technical Support</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btn-logout').addEventListener('click', function() {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: "Sesi Anda akan diakhiri.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>
