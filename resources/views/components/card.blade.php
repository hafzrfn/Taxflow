<div {{ $attributes->merge(['class'=>'card']) }}>
  @if(isset($title))
    <div class="mb-4">
      <h3 class="text-lg font-semibold">{{ $title }}</h3>
    </div>
  @endif
  {{ $slot }}
</div>
