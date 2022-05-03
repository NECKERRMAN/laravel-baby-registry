<header class="bg-white border-b-2 border-gray-100">
    <div class="flex flex-row justify-between max-w-screen-xl m-auto mt-5 mb-5 items-center">
      <nav>
        <ul class="flex" data-dropdown-menu="tckp8q-dropdown-menu" role="menubar">
          @guest
          <li class="{{ (request()->is('/')) ? 'active' : ''}}" role="menuitem"><a href="/">Home</a></li>
          <li class="ml-4 {{ (request()->is('contact')) ? 'active' : ''}}" role="menuitem"><a href="/contact">Contact</a></li>
          @endguest
          @auth
          <li class="ml-4 {{ (request()->is('/*')) ? 'active' : ''}}" role="menuitem"><a href="/">Home</a></li>
          <li class="ml-4 {{ (request()->is('contact')) ? 'active' : ''}}" role="menuitem"><a href="/contact">Contact</a></li>
          <li class="ml-4 {{ (request()->is('klanten/*')) || (request()->is('klanten')) ? 'active' : ''}}" role="menuitem"><a href="/klanten">Klanten</a></li>
          <li class="ml-4 {{ (request()->is('reservaties')) || (request()->is('reservatie/*')) ? 'active' : ''}}" role="menuitem"><a href="/reservaties">Reservaties</a></li>
          @endauth
        </ul>
      </nav>
      <h1>Storksie</h1>
      @if (Route::has('login'))
      <div class="">
          @auth
              <a href="{{ route('logout') }}"  class="text-red-500 mr-5" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          @else
              <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

              @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">{{ ucwords( __('register'))}}</a>
              @endif
          @endauth
      </div>
      @endif
    </div>
  </header>
