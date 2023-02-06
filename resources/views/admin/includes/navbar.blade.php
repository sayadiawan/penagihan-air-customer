<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">


  <div class="app-brand demo">
    <a href="/" class="app-brand-link text-left">
      <span class="app-brand-logo demo">

        <img src="{{ asset('admin-assets/assets/img/icons/brands/save-water.png') }}" width="50" viewBox="0 0 25 42"
          alt="" />

      </span>

      <span class="app-brand-text demo menu-text fw-bolder ms-2">Air <br> Anda</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    {{-- get module menu --}}
    @foreach ($menus as $menu)
      @php
        //role config
        $role_access = isAccess('list', $menu->id_menus, Auth::user()->roles_id);
        
        if (!$role_access) {
            continue;
        }
      @endphp

      @if ($menu->menus->count() > 0)
        <li class="menu-item menu-sub-parent">
          <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon {{ $menu->icon_menus }}"></i>
            <div data-i18n="{{ $menu->name_menus }}">{{ $menu->name_menus }}</div>
          </a>

          <ul class="menu-sub">
            <li class="menu-item {{ activeMenu($menu->link_menus) }}">
              <a href="/{{ $menu->link_menus }}" class="menu-link">
                <div data-i18n="{{ $menu->name_menus }}">Dashboard {{ $menu->name_menus }}</div>
              </a>
            </li>

            @foreach ($menu->menus as $submenu)
              @php
                //role config
                $role_access = isAccess('list', $submenu->id_menus, Auth::user()->roles_id);
                
                if (!$role_access) {
                    continue;
                }
              @endphp

              <li class="menu-item {{ activeMenu($submenu->link_menus) }}">
                <a href="/{{ $submenu->link_menus }}" class="menu-link">
                  <div data-i18n="{{ $submenu->name_menus }}">{{ $submenu->name_menus }}</div>
                </a>
              </li>
            @endforeach
          </ul>
        </li>
      @else
        <li class="menu-item {{ activeMenu($menu->link_menus) }}">
          <a href="/{{ $menu->link_menus }}" class="menu-link">
            <i class="menu-icon {{ $menu->icon_menus }}"></i>
            <div data-i18n="{{ $menu->name_menus }}">{{ $menu->name_menus }}</div>
          </a>
        </li>
      @endif
    @endforeach
    {{-- /get module menu --}}
  </ul>



</aside>
