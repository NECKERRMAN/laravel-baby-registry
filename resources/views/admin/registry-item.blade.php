<div class="flex items-center justify-between p-4 rounded border-2 my-2">
    <ul>
        <li class="font-bold">{{ $registry[0]->name }}</li>
        <li>{{ucfirst(__('user'))}}: {{ $registry[0]->user->name}}</li>
        <li>{{ucfirst(__('slug'))}}: /{{ $registry[0]->slug}}</li>
        <li>{{ucfirst(__('total articles'))}}: {{ count($registry[0]->articles)}}</li>
        <li>{{ucfirst(__('total price'))}}: € {{ sprintf("%.2f", $registry['total']) }}</li>
    </ul>
    <div class="flex flex-col">
        <button class="border-2 py-2 px-4 my-2 rounded text-red-500 border-red-500">{{ ucfirst(__('close registry'))}}</button>
        <a href="{{ route('registry.export', ['registry' => $registry[0]->id])}}" class="px-4 py-2 rounded border-2 border-[#9ec4c5] text-[#9ec4c5]">{{__('export')}} <i class="fa-solid fa-download"></i></a>
    </div>
</div>
