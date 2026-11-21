<?php

namespace App\Services;

use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DoctorProfileService
{
    public static function rules(?int $profileId = null): array
    {
        return [
            'name_en'            => ['nullable', 'string', 'max:150'],
            'name_bn'            => ['nullable', 'string', 'max:150'],
            'degrees'            => ['required', 'string', 'max:1000'],
            'specialty'          => ['nullable', 'string', 'max:150'],
            'bmdc_no'            => ['required', 'string', 'max:50', Rule::unique('doctor_profiles', 'bmdc_no')->ignore($profileId)],
            'chamber_name'       => ['nullable', 'string', 'max:191'],
            'chamber_address'    => ['nullable', 'string', 'max:1000'],
            'chamber_phone'      => ['nullable', 'string', 'max:50'],
            'visiting_hours'     => ['nullable', 'string', 'max:255'],
            'default_paper_size' => ['required', Rule::in(['A4', 'A5'])],
            'signature'          => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:1024'],
            'logo'               => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:1024'],
        ];
    }

    public function save(User $doctor, array $data, ?UploadedFile $signature = null, ?UploadedFile $logo = null): DoctorProfile
    {
        $profile = $doctor->doctorProfile ?? new DoctorProfile(['user_id' => $doctor->id]);

        $data = Arr::except($data, ['signature', 'logo']);
        $data['name_en'] = $data['name_en'] ?? $doctor->name;   // default to the account name

        foreach (['signature_path' => $signature, 'logo_path' => $logo] as $column => $file) {
            if ($file) {
                if ($profile->{$column}) {
                    Storage::disk('public')->delete($profile->{$column});
                }
                $data[$column] = $file->store("doctor-profiles/{$doctor->id}", 'public');
            }
        }

        $profile->fill($data)->save();

        return $profile;
    }
}