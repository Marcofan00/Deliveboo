<header class="container container_xxl_">
    {{-- logo  --}}
    <a href="{{ route('homepage')}}">
        <img src="{{asset('storage/img/Logo.png')}}" alt="logo_deeboo">
    </a>

    @auth
    <div>
        <a class="accedi_logout_btn" href="{{ route('logout') }}">LOGOUT</a>
        <a  href="{{ route('cart_page') }}">
            <i class="fas fa-cart-arrow-down"></i>
        </a>
    </div>
    @endauth

    @guest
        <div id="Action_user">
            <a href="{{ route('cart_page') }}">
                <i class="fas fa-cart-arrow-down"></i>
            </a>

            <div class="accedi_logout_btn">
                <a  href="{{ route('login_page') }}">Accedi</a>
                
            </div>
        </div>

    @endguest
    
    <div id="header_component">
        <header-component  :userid="{{Auth::User() ? Auth::User() -> id : 0}}" >
            
        </header-component>
    </div>
    
</header>