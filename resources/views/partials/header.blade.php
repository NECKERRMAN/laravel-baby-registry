<header class="py-4 mb-4 border-b-2 border-slate-300">
    <div class="flex flex-row justify-between page-wrapper items-center">
      <nav>
        <ul class="flex" data-dropdown-menu="tckp8q-dropdown-menu" role="menubar">
          @guest
          <li class="ml-4 {{ (request()->is('/*')) ? 'active' : ''}}" role="menuitem"><a href="/">Home</a></li>
          @endguest
          @auth
          <li class="ml-4 {{ (request()->is('/*')) ? 'active' : ''}}" role="menuitem"><a href="/">Home</a></li>
          @if (Auth::user()->hasRole('user'))
            <li class="ml-4 {{ (request()->is('/dashboard')) ? 'active' : ''}}" role="menuitem"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="ml-4" {{ (request()->is('/registry/all')) ? 'active' : ''}}" role="menuitem"><a href="{{ route('registry.all')}}">{{ ucfirst(__('my_lists'))}}</a></li>    
          @endif

                              
          @if (Auth::user()->hasRole('admin'))
          <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
              {{ __('Admin dashboard') }}
          </x-nav-link>
          @endif

          @endauth
        </ul>
      </nav>
      @include('components.application-logo-sm')

      <div class="flex items-center">
          @auth
              <a href="{{ route('user.account')}}">{{ ucfirst(__('my account'))}} <i class="fa-solid fa-user"></i></a>
              <a href="{{ route('logout') }}"  class="p-2 rounded bg-red-400 text-white mx-5" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
          @endauth
            @guest
              <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 rounded px-4 py-2 border-2	border-gray-700">{{ strtoupper(__('Login'))}}</i></a>
              <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">{{ ucwords( __('Register'))}}</a>
            @endguest
      </div>
    </div>
  </header>
