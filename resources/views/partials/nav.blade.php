<nav class="nav">
  <ul class="nav__list">
    <li>{{ config('app.name', 'Laravel') }}</li>
  </ul>
  <!-- Authentication Links -->
  <ul class="nav__list nav__list--right">
    @guest
      <li class="nav__list-item">
        <a href="{{ route('login') }}">{{ __('Login') }}</a>
      </li>
      <li class="nav__list-item">
        <a href="{{ route('register') }}">{{ __('Register') }}</a>
      </li>
    @else
      <li class="nav__list-item">
        <a href="{{ route('logout') }}"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>
      
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    @endguest
  </ul>
</nav>