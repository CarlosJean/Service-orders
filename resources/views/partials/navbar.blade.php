

@foreach($roleMenus as $menu)

@if($menu['menu']['name'] == '')

@foreach($menu['submenus'] as $submenu)
<li class="nav-item">
    <a class="nav-link" href="{{url($submenu['url'])}}">
        <i class="{{$submenu['icon']}}"></i>
        {{$submenu['name']}}
    </a>
</li>
@endforeach

@else
<li class="nav-item dropdown with-sub">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        <i class="{{$menu['menu']['icon']}}"></i>
        {{$menu['menu']['name']}}
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        @foreach($menu['submenus'] as $submenu)
        <a class="dropdown-item" href="{{url($submenu['url'])}}">
            {{$submenu['name']}}
        </a>
        @endforeach
    </div>
</li>
@endif
@endforeach