@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'helpText' => null,
])

<div class="space-y-1">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-primary">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes->merge(
            ['class' => 
                'bg-card block w-full px-4 py-2 border rounded-lg shadow-sm transition-colors duration-200 focus:ring-2 focus:ring-accent focus:border-accent ' 
                . ($error ? 'border-danger focus:ring-danger focus:border-danger' : 'border-default') 
                . ' text-primary placeholder-muted/50'
            ]) 
        }}
    >
    
    @if($helpText)
        <p class="text-sm text-muted">{{ $helpText }}</p>
    @endif
    
    @if($error)
        <p class="text-sm text-danger">{{ $error }}</p>
    @endif
    
    @error($name)
        <p class="text-sm text-danger">{{ $message }}</p>
    @enderror
</div>

