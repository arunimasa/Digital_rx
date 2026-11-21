@php $u = $user ?? null; @endphp

<div class="space-y-4" x-data="{ role: @js(old('role', optional($u)->role ?? 'assistant')) }">
    <div>
        <x-input-label for="name" value="Name" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', optional($u)->name)" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', optional($u)->email)" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="mobile" value="Mobile" />
        <x-text-input id="mobile" name="mobile" type="text" class="mt-1 block w-full" :value="old('mobile', optional($u)->mobile)" />
        <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password" :value="$u ? 'New password (leave empty to keep the old one)' : 'Password'" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="role" value="Role" />
        <select id="role" name="role" x-model="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @foreach (['admin', 'doctor', 'assistant'] as $r)
                <option value="{{ $r }}">{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="preferred_language" value="Language" />
        <select id="preferred_language" name="preferred_language" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @foreach (['bn' => 'বাংলা', 'en' => 'English'] as $code => $label)
                <option value="{{ $code }}" @selected(old('preferred_language', optional($u)->preferred_language ?? 'bn') === $code)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('preferred_language')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2">
        <input type="hidden" name="is_active" value="0">
        <input id="is_active" type="checkbox" name="is_active" value="1"
               class="rounded border-gray-300" @checked(old('is_active', optional($u)->is_active ?? true))>
        <label for="is_active" class="text-sm text-gray-700">Active (can log in)</label>
    </div>

    <div x-show="role === 'doctor'" style="display: none;" class="pt-4 border-t">
        <p class="text-sm text-gray-500 mb-3">Doctor profile (used on the prescription header)</p>
        @include('doctor-profile._fields', ['profile' => optional($u)->doctorProfile])
    </div>
</div>