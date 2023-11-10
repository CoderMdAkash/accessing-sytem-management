<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @foreach ($menus as $menu)
                    <li @if($menu->base_url == 'dashboard') class="active" @else class="submenu" @endif>
                        <a href="{{ $menu->base_url }}" @if($menu->base_url) class="anchor" @else href="javascript:void(0);" @endif><img src="{{ asset('admin/assets/img/icons/'.$menu->icon) }}" alt="img"><span>{{ $menu->menu_name }}</span> @if(count($menu->sub_menus) > 0) <span class="menu-arrow"> @endif</a>
                        @if(count($menu->sub_menus))
                            <ul>
                                @foreach ($menu->sub_menus as $sub_menu)
                                    <li><a href="{{ $sub_menu->base_url }}" class="anchor">{{ $sub_menu->menu_name}}</a></li> 
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>