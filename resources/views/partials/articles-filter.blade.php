            {{-- GET METHOD so user can see changes --}}
            <form action="{{ route('registry.filterArticles', ['id' => $registry->id])}}" method="GET" class="flex items-end">
                <div class="flex flex-col">
                    <label class="inline-block" for="filter_categories">
                        Categories
                    </label>
                    <select name="filter_categories" id="filter_categories">
                            <option value="all">All</option>
                        @foreach ($categories as $category)
                            <option {{ request()->filter_categories == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col ml-4">
                    <label for="priceRange">Price range</label>
                    <select name="priceRange" id="priceRange">
                        <option {{ request()->priceRange == 'high-low' ? 'selected' : '' }} value="high-low">Highest first</option>
                        <option {{ request()->priceRange == 'low-hig' ? 'selected' : '' }} value="low-hig">Lowest first</option>
                    </select>
                </div>
                <button type="submit" class="link-btn ml-4">Filter</button>
            </form>