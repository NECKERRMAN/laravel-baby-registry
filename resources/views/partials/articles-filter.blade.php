            {{-- GET METHOD so user can see changes --}}
            <form action="{{ route('registry.addArticles', ['id' => $registry->id])}}" method="GET" class="overview__form">
                <div class="overview__cat">
                    <label class="inline-block" for="category">
                        {{ ucfirst(__('categories'))}}
                    </label>
                    <select name="category" id="category">
                            <option value="0">{{ ucfirst(__('all'))}}</option>
                        @foreach ($categories as $category)
                            <option {{ request()->category == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="overview__price">
                    <label for="price">{{ ucfirst(__('price range'))}}</label>
                    <select name="price" id="price">
                        <option {{ request()->price == 'high-low' ? 'selected' : '' }} value="high-low">{{ucfirst(__('highest first'))}}</option>
                        <option {{ request()->price == 'low-high' ? 'selected' : '' }} value="low-high">{{ucfirst(__('lowest first'))}}</option>
                    </select>
                </div>
                <button type="submit" class="link-btn ml-4">Filter</button>
            </form>