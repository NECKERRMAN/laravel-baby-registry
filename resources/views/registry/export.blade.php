<table>
    <thead>
        <tr>
            <th>{{ ucfirst(__('name'))}}</th>
            <th>{{ ucfirst(__('article code'))}}</th>
            <th>{{ ucfirst(__('store'))}}</th>
            <th>{{ ucfirst(__('price'))}}</th>
            <th>{{ ucfirst(__('ordered_by')) }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articles as $article)
        <tr>
            <td>{{ $article[0]->title }}</td>
            <td>{{ $article[0]->product_code }}</td>
            <td>{{ $article[0]->store->name }}</td>
            <td>{{ sprintf("%.2f", $article[0]->price) }} EUR</td>
            <td>{{ $article['ordered_by'] }}</td>
        </tr>
        @endforeach
        <tr>
            <td>{{ ucfirst(__('total ordered'))}}:</td>
            <td></td>
            <td></td>
            <td>{{ sprintf("%.2f", $total) }} EUR</td>
        </tr>
    </tbody>
</table>

