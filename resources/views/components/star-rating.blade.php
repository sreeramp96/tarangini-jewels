@props(['rating' => 0, 'count' => 0])

<div class="flex items-center space-x-1">
    @php $roundedRating = round($rating); @endphp

    @for ($i = 1; $i <= 5; $i++)
        <x-heroicon-s-star class="w-4 h-4 {{ $i <= $roundedRating ? 'text-yellow-500' : 'text-gray-300' }}" />
    @endfor

    <span class="text-xs text-gray-500">({{ $count }})</span>
</div>
