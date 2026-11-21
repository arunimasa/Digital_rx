<?php

namespace App\Http\Controllers;

use App\Services\DoctorProfileService;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    public function __construct(private DoctorProfileService $profiles)
    {
    }

    public function edit(Request $request)
    {
        return view('doctor-profile.edit', ['profile' => $request->user()->doctorProfile]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate(DoctorProfileService::rules($user->doctorProfile?->id));

        $this->profiles->save($user, $data, $request->file('signature'), $request->file('logo'));

        return redirect()->route('doctor-profile.edit')->with('status', 'Doctor profile saved.');
    }
}