@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <h1 class="my-4">{{ucfirst(__('welcome'))}} {{ auth()->user()->name}}</h1>
        <div class="user-registries">
            <h2>{{ ucfirst(__('new_registry'))}}</h2>
            <a class="link-btn inline-block mb-4" href="{{route('registry.new')}}">{{ucfirst(__('new_registry_btn'))}}</a>
            <h2>{{ ucfirst(__('my_lists'))}}</h2>
            @if (count($registries) < 1)
            <p class="mb-4">Oops, looks like you have no registries yet...</p>
            @else
                <div class="mb-4">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left">
                                <th width="200" class="p-3">name</th>
                                <th width="400" class="p-3">link</th>
                                <th width="200" class="p-3">actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registries as $registry)
                            <tr class="m-4">
                                <td>{{ $registry->name }}</td>
                                <td>http://www.storksie.be/{{ $registry->slug }}</td>
                                <td>
                                    <a class="link-btn inline-block" href="{{ route('registry.edit', $registry->id )}}">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection