<ul class="flex items-center border-[#9EC4C5] rounded border-2 my-2 p-2">
    <li class="mr-4 flex-1">
        @if (Auth::user()->id === $user->id)
        <div class="flex items-center">
            <i class="fa-solid fa-crown mr-4"></i>
            <p class="font-bold text-[#9EC4C5]">{{ $user->name }}</p>
        </div>
        @else
        {{ $user->name }}
        @endif
    </li>
    <li>
        @if (Auth::user()->id !== $user->id)
        {{-- TO DO --}}
       <form action="#" method="post">
           @csrf
           <input type="hidden" name="user_id" value="{{ $user->id }}">
           <button class="py-2 px-4 border-red-500 border-2 rounded text-red-500" type="submit">{{ __('delete')}}</button>
       </form>
        @endif
    </li>
</ul>
