<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .sidebar-custom {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;
        background: #0f172a;
        color: white;
        overflow-y: auto;
        z-index: 1000;
        display: flex;
        flex-direction: column;
    }

    .sidebar-header {
        padding: 1.5rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-brand {
        font-size: 1.125rem;
        font-weight: 700;
        color: white;
        text-decoration: none;
    }

    .sidebar-menu {
        flex: 1;
        padding: 1rem 0.75rem;
        list-style: none;
    }

    .menu-item {
        margin-bottom: 0.25rem;
    }

    .menu-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 0.5rem;
        transition: all 0.3s;
        cursor: pointer;
    }

    .menu-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .menu-link.active {
        background: #129990;
        color: white;
    }

    .menu-link-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .menu-icon {
        width: 20px;
        text-align: center;
        font-size: 1.125rem;
    }

    .menu-text {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .menu-arrow {
        font-size: 0.75rem;
        transition: transform 0.3s;
    }

    .menu-arrow.rotate {
        transform: rotate(180deg);
    }

    .submenu {
        list-style: none;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .submenu.show {
        max-height: 500px;
    }

    .submenu-item {
        margin-left: 0.5rem;
        margin-top: 0.25rem;
    }

    .submenu-link {
        display: block;
        padding: 0.5rem 1rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.3s;
    }

    .submenu-link:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white;
    }

    .submenu-link.active {
        background: #129990;
        color: white;
        font-weight: 600;
    }

    .close-btn {
        display: none;
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: transparent;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }

    @media (max-width: 1199px) {
        .close-btn {
            display: block;
        }
    }
</style>

<aside class="sidebar-custom" id="sidenav-main">
    <button class="close-btn" id="iconSidenav">
        <i class="fas fa-times"></i>
    </button>

    <div class="sidebar-header">
        <a class="sidebar-brand" href="#">
            {{ $kec->nama_lembaga_sort }}
        </a>
    </div>

    <ul class="sidebar-menu">
        @foreach ($menus as $menu)
            @php
                $collapseId = 'collapseMenu' . $menu->id;
                $hasChildren = $menu->child->where('aktif', 'Y')->count() > 0;
                $active = request()->is(ltrim($menu->link, '/') . '*') ||
                    $menu->child
                        ->where('link', '!=', '#')
                        ->pluck('link')
                        ->contains(fn($link) => request()->is(ltrim($link, '/') . '*'));
            @endphp

            <li class="menu-item">
                @if ($hasChildren)
                    <a class="menu-link {{ $active ? 'active' : '' }}" 
                       onclick="toggleSubmenu('{{ $collapseId }}')" 
                       role="button">
                        <div class="menu-link-content">
                            <i class="menu-icon fa-solid {{ $menu->ikon }}"></i>
                            <span class="menu-text">{{ $menu->title }}</span>
                        </div>
                        <i class="menu-arrow fas fa-chevron-down" id="arrow-{{ $collapseId }}"></i>
                    </a>

                    <ul class="submenu" id="{{ $collapseId }}">
                        @foreach ($menu->child->where('aktif', 'Y') as $submenu)
                            <li class="submenu-item">
                                <a class="submenu-link {{ request()->is(ltrim($submenu->link, '/') . '*') ? 'active' : '' }}" 
                                   href="{{ url($submenu->link) }}">
                                    {{ $submenu->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <a class="menu-link {{ $active ? 'active' : '' }}" href="{{ url($menu->link) }}">
                        <div class="menu-link-content">
                            <i class="menu-icon fa-solid {{ $menu->ikon }}"></i>
                            <span class="menu-text">{{ $menu->title }}</span>
                        </div>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</aside>

<script>
    // Auto push content untuk tidak tertutup sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar-custom');
        const sidebarWidth = sidebar ? sidebar.offsetWidth : 260;
        
        // Cari elemen konten utama dan beri margin
        const bodyEl = document.body;
        const mainContent = document.querySelector('main') || 
                          document.querySelector('.main-content') || 
                          document.querySelector('#main-content') ||
                          document.querySelector('.content-wrapper');
        
        if (mainContent) {
            mainContent.style.marginLeft = sidebarWidth + 'px';
            mainContent.style.transition = 'margin-left 0.3s ease';
        } else {
            // Jika tidak ada wrapper, beri padding ke body
            bodyEl.style.paddingLeft = sidebarWidth + 'px';
            bodyEl.style.transition = 'padding-left 0.3s ease';
        }
    });

    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        const arrow = document.getElementById('arrow-' + id);
        
        submenu.classList.toggle('show');
        arrow.classList.toggle('rotate');
    }

    // Close sidebar on mobile
    document.getElementById('iconSidenav')?.addEventListener('click', function() {
        const sidebar = document.getElementById('sidenav-main');
        sidebar.style.display = 'none';
        
        // Reset margin/padding saat sidebar ditutup
        const mainContent = document.querySelector('main') || 
                          document.querySelector('.main-content') || 
                          document.querySelector('#main-content') ||
                          document.querySelector('.content-wrapper');
        
        if (mainContent) {
            mainContent.style.marginLeft = '0';
        } else {
            document.body.style.paddingLeft = '0';
        }
    });
</script>
