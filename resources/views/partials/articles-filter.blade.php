            {{-- GET METHOD so user can see changes --}}
            <form action="{{ route('registry.addArticles', ['id' => $registry->id])}}" method="GET" class="flex items-end">
                <div class="flex flex-col">
                    <label class="inline-block" for="category">
                        Categories
                    </label>
                    <select name="category" id="category">
                            <option value="0">All</option>
                        @foreach ($categories as $category)
                            <option {{ request()->category == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col ml-4">
                    <label for="price">Price range</label>
                    <select name="price" id="price">
                        <option {{ request()->price == 'high-low' ? 'selected' : '' }} value="high-low">Highest first</option>
                        <option {{ request()->price == 'low-high' ? 'selected' : '' }} value="low-high">Lowest first</option>
                    </select>
                </div>
                <button type="submit" class="link-btn ml-4">Filter</button>
            </form>