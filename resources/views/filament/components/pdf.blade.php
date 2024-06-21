<div class="mx-auto py-16 px-8" style="color: black !important;">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-green-600 py-4 px-6 text-center">
            <h1 class="text-3xl font-bold uppercase">{{ $this->record->name }}</h1>
        </div>
        <div class="py-8 px-6 grid grid-cols-2 gap-4">
            @foreach($this->record->sections as $section)
                <div class="@if(true)@endif">
                    <h2 class="text-xl font-bold uppercase mb-4">{{ $section->name }}</h2>
                    <ul class="mb-8">
                        @foreach($section->products as $product)
                            <li class="flex justify-between mb-2">
                                <span class="text-gray-600">{{ $product->name }}</span>
                                <span class="text-gray-600">${{ $product->price }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</div>
