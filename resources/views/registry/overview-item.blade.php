<tr class="m-4">
    <td><img src="{{ $article->img_src }}" class="w-10 h-10" alt="{{ $article->title }}"></td>
    <td>{{ $article->title }}</td>
    <td>{{ $article->category->title }}</td>
    <td>
        <form method="POST" action="{{ route('registry.deleteArticle', ['id' => $registry_id])}}" >
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id}}">
            <button type="submit">delete</button>
        </form>
    </td>
    <td>
        <p class="text-red-500"></p>
    </td>
</tr>