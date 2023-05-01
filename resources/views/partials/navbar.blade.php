@foreach($roleMenus as $menu)
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        <i class="{{$menu['menu']['icon']}}"></i>
        {{$menu['menu']['name']}}
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        @foreach($menu['submenus'] as $submenu)
            <a class="dropdown-item" href="{{ route('logout') }}">
                {{$submenu['name']}}
            </a>
        @endforeach
    </div>
</li>
@endforeach