<header class="p-4 pb-2 bg-green-100">
    <div class="flex flex-row justify-between max-w-screen-xl m-auto items-center">
      <nav>
        <ul class="flex" data-dropdown-menu="tckp8q-dropdown-menu" role="menubar">
          @auth
          <li class="ml-4 {{ (request()->is('/*')) ? 'active' : ''}}" role="menuitem"><a href="/">Home</a></li>
          @endauth
        </ul>
      </nav>
      <div class="flex flex-col items-center mb-4">
        <img src="/images/storksie-logo.png" alt="storksie-logo" class="w-20 h-20">
        <h1>Storksie</h1>
    </div>
      @if (Route::has('login'))
      <div class="">
          @auth
              <a href="{{ route('user.account')}}">{{ ucfirst(__('my account'))}} <i class="fa-solid fa-user"></i></a>
              <a href="{{ route('logout') }}"  class="text-red-500 mr-5" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
          @else
              <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 rounded px-4 py-2 border-2	border-gray-700">{{ strtoupper(__('login'))}}</i></a>
              @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">{{ ucwords( __('register'))}}</a>
              @endif
              @endauth
      </div>
      @endif
    </div>
  </header>
