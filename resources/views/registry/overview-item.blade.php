<tr class="m-4">
    <td><img src="/storage/{{ $article[0]->img_int }}" class="w-10 h-10" alt="{{ $article[0]->title }}"></td>
    <td>{{ $article[0]->title }}</td>
    <td>€ {{ sprintf("%.2f", $article[0]->price) }}</td>
    <td>
        <p class="text-red-500">
            @if ($article['status'] == 0)
               {{ ucfirst(__('available'))}}
            @else
                <p class="text-green-400">{{ ucfirst(__('bought'))}}</p>
            @endif
        </p>
    </td>
    <td>{{ $article['ordered_by'] }}</td>
    <td>
        {{-- IF item is not bought -> can be deleted --}}
        @if ($article['status'] == 0)
        <form method="POST" action="{{ route('registry.deleteArticle', ['id' => $registry_id])}}" >
            @csrf
            <input type="hidden" name="article_id" value="{{ $article[0]->id}}">
            <button class="p-2 bg-red-500 rounded text-white" type="submit">{{ ucfirst(__('delete')) }}</button>
        </form>
        @else
        <button class="p-2 bg-red-500 opacity-25 rounded text-white cursor-default	" type="button">{{ ucfirst(__('delete')) }}</button>
        @endif
    </td>
</tr>