<div class="flex items-center justify-between p-4 rounded border-2 my-2">
    <ul>
        <li class="font-bold">{{ $registry->name }}</li>
        <li>User: {{ $registry->user->name}}</li>
        <li>Slug: /{{ $registry->slug}}</li>
        <li>Total articles: {{ count($registry->articles)}}</li>
        <li>Total price: ???</li>
    </ul>
    <div class="flex flex-col">
        <button class="border-2 py-2 px-4 my-2 rounded text-red-500 border-red-500">Close registry</button>
        <button class="border-2 py-2 px-4 my-2 rounded text-green-500 border-green-500">Export registry</button>
    </div>
</div>
