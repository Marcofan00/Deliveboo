<header class="container">
    <a href="{{ route('homepage')}}">
        <img src="{{asset('storage/img/Logo.png')}}" alt="logo_deeboo">
    </a>
    @auth
    <div>
        <a class="btn btn-danger" href="{{ route('logout') }}">LOGOUT</a>
        <a  href="{{ route('create') }}">
            <i class="fas fa-cart-arrow-down"></i>
        </a>
    </div>
    @endauth

    @guest
        <div id="Action_user">
            <a href="">
                <i class="fas fa-cart-arrow-down"></i>
            </a>
            <div id="accedi_btn">
                <a  href="{{ route('login_page') }}">Accedi</a>
            </div>
        </div>

    @endguest
    
    <div id="header_component">
        <header-component :userid="{{ Auth::check() ? true : 'false' }}">
        
        </header-component>
    </div>
    
</header>