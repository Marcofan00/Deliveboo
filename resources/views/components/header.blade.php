<header class="container">
    <img src="{{asset('storage/img/Logo.png')}}" alt="">
    @auth
    <div>
        <a class="btn btn-danger" href="{{ route('logout') }}">LOGOUT</a>
        <a class="btn btn-primary" href="{{ route('create') }}">Carrello</a>
    </div>
    @endauth

    @guest
        <div>
            <a href="">
                <i class="fas fa-cart-arrow-down"></i>
            </a>

            <div id="accedi_btn">
                <a  href="{{ route('login_page') }}">Accedi</a>
            </div>
        </div>
     

    @endguest
</header>