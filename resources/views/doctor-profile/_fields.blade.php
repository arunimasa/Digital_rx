@php
    $p = $profile ?? null;
    $input = 'mt-1 block w-full border-gray-300 rounded-md shadow-sm';
    $textFields = [
        ['name_en',        'Name (English) - empty = account name'],
        ['name_bn',        'Name (বাংলা)'],
        ['specialty',      'Specialty'],
        ['bmdc_no',        'BMDC no *'],
        ['chamber_name',   'Chamber name'],
        ['chamber_phone',  'Chamber phone'],
        ['visiting_hours', 'Visiting hours'],
    ];
@endphp

<div class="space-y-4">
    @foreach ($textFields as [$name, $label])
        <div>
            <x-input-label :for="$name" :value="$label" />
            <x-text-input :id="$name" :name="$name" type="text" class="mt-1 block w-full" :value="old($name, $p?->{$name})" />
            <x-input-error :messages="$errors->get($name)" class="mt-2" />
        </div>
    @endforeach

    <div>
        <x-input-label for="degrees" value="Degrees *" />
        <textarea id="degrees" name="degrees" rows="2" class="{{ $input }}">{{ old('degrees', optional($p)->degrees) }}</textarea>
        <x-input-error :messages="$errors->get('degrees')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="chamber_address" value="Chamber address" />
        <textarea id="chamber_address" name="chamber_address" rows="2" class="{{ $input }}">{{ old('chamber_address', optional($p)->chamber_address) }}</textarea>
        <x-input-error :messages="$errors->get('chamber_address')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="default_paper_size" value="Default paper size" />
        <select id="default_paper_size" name="default_paper_size" class="{{ $input }}">
            @foreach (['A4', 'A5'] as $size)
                <option value="{{ $size }}" @selected(old('default_paper_size', optional($p)->default_paper_size ?? 'A4') === $size)>{{ $size }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('default_paper_size')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="signature" value="Signature image (PNG or JPG, max 1 MB)" />
        @if (optional($p)->signature_url)
            <img src="{{  optional($p)->signature_url }}" alt="Signature" class="h-16 my-2 border rounded p-1">
        @endif
        <input id="signature" name="signature" type="file" accept=".png,.jpg,.jpeg" class="mt-1 block w-full text-sm">
        <x-input-error :messages="$errors->get('signature')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="logo" value="Logo (optional, PNG or JPG, max 1 MB)" />
        @if (optional($p)->logo_url)
            <img src="{{ optional($p)->logo_url }}" alt="Logo" class="h-16 my-2 border rounded p-1">
        @endif
        <input id="logo" name="logo" type="file" accept=".png,.jpg,.jpeg" class="mt-1 block w-full text-sm">
        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
    </div>
</div>