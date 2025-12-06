<div class="mb-3">
  @if(isset($label))
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
  @endif
  <input {{ $attributes->merge(['class'=>'input']) }} />
  @error($attributes->get('name'))
    <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
  @enderror
</div>
