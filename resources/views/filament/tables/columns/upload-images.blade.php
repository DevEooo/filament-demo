<div class="flex space-x-2">
    @if($getState()['uploaded'])
        <div class="flex flex-col items-center">
            <a href="{{ $getState()['uploaded'] }}" download>
                <img src="{{ $getState()['uploaded'] }}" alt="Uploaded Image" class="w-20 h-20 object-cover rounded cursor-pointer">
            </a>
            <span class="text-xs text-gray-500 mt-1">Uploaded</span>
        </div>
    @endif
    @if($getState()['captured'])
        <div class="flex flex-col items-center">
            <a href="{{ $getState()['captured'] }}" download>
                <img src="{{ $getState()['captured'] }}" alt="Captured Image" class="w-20 h-20 object-cover rounded cursor-pointer">
            </a>
            <span class="text-xs text-gray-500 mt-1">Captured</span>
        </div>
    @endif
</div>
