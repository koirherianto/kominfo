<header>
    <div class="brand animate"><a href="/"><img style="max-height: 40%;max-width: 40%"  src="{{ asset('landing2/img/logoname.png') }}" alt=""></a></div>
    <nav>
        <ul class="navigation animate">
            @if (Route::has('login'))
            @auth
                    <li><a href="{{ url('/projects') }}">Dashboard</a></li>
                @else
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    
                    @if (Route::has('register'))
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @endif
                @endauth
            @endif
        </ul>
        <!--end navigation-->
    </nav>
</header>
