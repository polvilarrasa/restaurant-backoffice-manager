<div class="mx-auto py-16 px-8" style="color: black !important;">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-green-600 pt-4 px-6 flex {{ $this->record->headerPositionCssClass()  }}">
            @if($this->record->header_type == App\Enums\MenuHeaderType::Logo)
                <img src="{{ asset('filament/' . $this->record->header_content) }}" alt="Logo" style="width: 250px;">
            @elseif($this->record->header_type == App\Enums\MenuHeaderType::Text)
                <h1 class="text-3xl font-bold">{{ $this->record->header_content }}</h1>
            @endif
        </div>
        <div class="pb-6 px-6 grid grid-cols-4 gap-4">
            @foreach($this->record->sections as $section)
                <div>
                    <h2 class="text-xl font-bold uppercase mb-4">{{ $section->name }}</h2>
                    <ul class="mb-8">
                        @foreach($section->products as $product)
                            <li class="flex justify-between mb-2 gap-2" style="align-items: baseline;">
                                <span class="text-gray-600">{{ $product->name }}</span>
                                <span style="flex-grow:1; border-bottom:dotted 2px black;"></span>
                                <span class="text-gray-600">${{ $product->price }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</div>
