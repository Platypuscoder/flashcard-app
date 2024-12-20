<head>
    <!-- Other head elements -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="container mx-auto p-4 bg-gray-100">
    <div class="font-extrabold text-3xl text-center mb-6 text-blue-600">Frequently Asked Questions</div>


    <div class="flex justify-center items-center">
        <x-mary-accordion wire:model="group">
            @foreach($faqs as $faq)
            <x-mary-collapse class="mb-4 bg-white shadow-md rounded-lg">
                <x-slot:heading><span class="font-bold text-blue-700">{{ $faq['title'] }}</span></x-slot:heading>
                <x-slot:content class="text-gray-700">{{ $faq['info'] }}</x-slot:content>
            </x-mary-collapse>
            @endforeach
        </x-mary-accordion>
    </div>
</div>
