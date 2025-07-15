<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white position-absolute end-0 top-0 d-none d-xl-none"
            id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center m-0" href="#">
            <span class="font-weight-bold text-lg">{{ $kec->nama_lembaga_sort }}</span>
        </a>
    </div>
    <div class="collapse navbar-collapse px-4 w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @foreach ($menus as $menu)
                @php
                    $collapseId = 'collapseMenu' . $menu->id;
                    $active =
                        request()->is(ltrim($menu->link, '/') . '*') ||
                        $menu->child
                            ->where('link', '!=', '#')
                            ->pluck('link')
                            ->contains(fn($link) => request()->is(ltrim($link, '/') . '*'));
                @endphp
                <li class="nav-item">
                    @if ($menu->child->where('aktif', 'Y')->count())
                        <a class="nav-link d-flex justify-content-between align-items-center {{ $active ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse" href="#{{ $collapseId }}"
                            aria-expanded="{{ $active ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                            <div class="d-flex align-items-center">
                                <div
                                    class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center px-0">
                                    <i class="fa-solid {{ $menu->ikon }} fs-5"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ $menu->title }}</span>
                            </div>
                            <i class="fas fa-chevron-down me-2 fs-sm"></i>
                        </a>
                        <div class="collapse {{ $active ? 'show' : '' }}" id="{{ $collapseId }}">
                            <ul class="nav flex-column ms-4 border-start ps-0">
                                @foreach ($menu->child->where('aktif', 'Y') as $submenu)
                                    <li class="nav-item p-1 m-1">
                                        <a class="nav-link px-2 py-1 m-0 {{ request()->is(ltrim($submenu->link, '/') . '*') ? 'active fs-6' : '' }}"
                                            href="{{ url($submenu->link) }}">
                                            <span class="nav-link-text text-white">{{ $submenu->title }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <a class="nav-link {{ $active ? 'active' : '' }}" href="{{ url($menu->link) }}">
                            <div
                                class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center px-0">
                                <i class="fa-solid {{ $menu->ikon }} fs-5"></i>
                            </div>
                            <span class="nav-link-text">{{ $menu->title }}</span>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</aside>
