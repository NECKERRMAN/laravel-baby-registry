<tr class="m-4">
    <td><img src="{{ $article->img_src }}" class="w-10 h-10" alt="{{ $article->title }}"></td>
    <td>{{ $article->title }}</td>
    <td>{{ $article->category->title }}</td>
    <td>
        <a class="link-btn" href="#">Delete</a>
    </td>
    <td>
        <p class="text-red-500">Not ordered</p>
    </td>
</tr>