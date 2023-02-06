<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ url('home') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('admin-assets/assets/img/icons/brands/mapsline.png') }}" style="width: 180px; height: 70px"
          alt="" />
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
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
        <li class="menu-item">
          <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon {{ $menu->icon_menus }}"></i>
            <div data-i18n="{{ $menu->name_menus }}">{{ $menu->name_menus }}</div>
          </a>

          <ul class="menu-sub">
            <li class="menu-item">
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

              <li class="menu-item">
                <a href="/{{ $submenu->link_menus }}" class="menu-link">
                  <div data-i18n="{{ $submenu->name_menus }}">{{ $submenu->name_menus }}</div>
                </a>
              </li>
            @endforeach
          </ul>
        </li>
      @else
        <li class="menu-item">
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
