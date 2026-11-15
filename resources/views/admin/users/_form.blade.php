@php $u = $user ?? null; @endphp

<div class="space-y-4">
    <div>
        <x-input-label for="name" value="Name" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $u?->name)" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $u?->email)" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password" :value="$u ? 'New password (leave empty to keep the old one)' : 'Password'" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="role" value="Role" />
        <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @foreach (['admin', 'doctor', 'assistant'] as $r)
                <option value="{{ $r }}" @selected(old('role', $u?->role ?? 'assistant') === $r)>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

    <div class="pt-4 border-t">
        <p class="text-sm text-gray-500 mb-3">Doctor details (needed only for the Doctor role)</p>

        <div class="space-y-4">
            <div>
                <x-input-label for="degrees" value="Degrees" />
                <x-text-input id="degrees" name="degrees" type="text" class="mt-1 block w-full" :value="old('degrees', $u?->degrees)" />
                <x-input-error :messages="$errors->get('degrees')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="bmdc_no" value="BMDC no" />
                <x-text-input id="bmdc_no" name="bmdc_no" type="text" class="mt-1 block w-full" :value="old('bmdc_no', $u?->bmdc_no)" />
                <x-input-error :messages="$errors->get('bmdc_no')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="chamber" value="Chamber (name, address, phone)" />
                <textarea id="chamber" name="chamber" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('chamber', $u?->chamber) }}</textarea>
                <x-input-error :messages="$errors->get('chamber')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="signature" value="Signature image (PNG or JPG, max 1 MB)" />
                @if ($u?->signature_path)
                    <img src="{{ asset('storage/' . $u->signature_path) }}" alt="Signature" class="h-16 my-2">
                @endif
                <input id="signature" name="signature" type="file" accept="image/*" class="mt-1 block w-full text-sm">
                <x-input-error :messages="$errors->get('signature')" class="mt-2" />
            </div>
        </div>
    </div>
</div>