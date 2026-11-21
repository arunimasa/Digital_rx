<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DoctorProfile extends Model
{
    protected $fillable = [
        'user_id', 'name_en', 'name_bn', 'degrees', 'specialty', 'bmdc_no',
        'chamber_name', 'chamber_address', 'chamber_phone', 'visiting_hours',
        'signature_path', 'logo_path', 'default_paper_size',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSignatureUrlAttribute(): ?string
    {
        return $this->signature_path ? asset('storage/' . ltrim($this->signature_path, '/')) : null;
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset('storage/' . ltrim($this->logo_path, '/')) : null;
    }
}