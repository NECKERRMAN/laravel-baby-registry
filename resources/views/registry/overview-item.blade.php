<tr class="m-4">
    <td><img src="{{ $article[0]->img_src }}" class="w-10 h-10" alt="{{ $article[0]->title }}"></td>
    <td>{{ $article[0]->title }}</td>
    <td>{{ $article[0]->category->title }}</td>
    <td>
        <form method="POST" action="{{ route('registry.deleteArticle', ['id' => $registry_id])}}" >
            @csrf
            <input type="hidden" name="article_id" value="{{ $article[0]->id}}">
            <button class="p-2 bg-red-500 rounded text-white" type="submit">{{ ucfirst(__('delete')) }}</button>
        </form>
    </td>
    <td>
        <p class="text-red-500">
            @if ($article['status'] == 0)
                NO
            @else
                <p class="text-green-400">YES</p>
            @endif
        </p>
    </td>
</tr>