<form action="{{ $action }}" method="post" class="user-registries--form">
    @csrf
    <div>
        <label for="registryName">
            {{ucfirst(__('registry name'))}}
        </label>
        <input type="text" name="registryName" id="registryName" value="{{ old('registryName') ?? optional($registry)->name }}" placeholder="e.g. {{ucfirst(__('example_registry_name'))}}">
    </div>
    <div>
        <label for="babyName">
            {{ucfirst(__('baby name'))}}
        </label>
        <input type="text" name="babyName" id="babyName"  value="{{ old('babyName') ?? optional($registry)->baby_name }}">
    </div>
    <div>
        <label for="birthdate">
            {{ucfirst(__('birthdate baby'))}}
        </label>
        <input type="date" name="birthdate" id="birthdate"  value="{{ old('birthdate') ?? optional($registry)->birthdate }}">
    </div>
    <div>
        <label for="password_registry">
            {{ucfirst(__('registry password'))}}
        </label>
        <div class="flex items-center">
            <input type="password" name="password_registry" id="password_registry"  value="{{ old('password_registry') ?? optional($registry)->password }}">
            <i id="showPass" class="fa-solid fa-eye p-1"></i>
        </div>
    </div>
    <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
    @if(!empty($success))
        <div class="text-green-500"> {{ $success }}</div>
    @endif
        <button type="submit">{{ ucfirst(__('save'))}}</button>
</form>