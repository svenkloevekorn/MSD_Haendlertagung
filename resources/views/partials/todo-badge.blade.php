@if(isset($todoItems) && count($todoItems) > 0)
<div class="relative group">
    <a href="{{ route('formular') }}" class="relative text-gray-400 hover:text-gray-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ count($todoItems) }}</span>
    </a>
    <div class="absolute right-0 top-full mt-2 w-72 bg-white rounded-xl shadow-lg border border-gray-200 p-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Open Registration Items</p>
        <div class="space-y-2">
            @foreach($todoItems as $item)
                <a href="{{ route($item['route'] ?? 'formular') }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">{{ $item['label'] }}</span>
                    <span class="text-xs text-red-500 font-medium">{{ $item['deadline'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
