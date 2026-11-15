<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules($request));
        $data['password'] = Hash::make($data['password']);
        $data = $this->withSignature($request, $data);

        User::create($data);

        return redirect()->route('admin.users.index')->with('status', 'User created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate($this->rules($request, $user));

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $data = $this->withSignature($request, $data, $user);
        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'User updated.');
    }

    private function rules(Request $request, ?User $user = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'doctor', 'assistant'])],
            'degrees' => ['nullable', 'string', 'max:500'],
            'bmdc_no' => [Rule::requiredIf($request->role === 'doctor'), 'nullable', 'string', 'max:50'],
            'chamber' => ['nullable', 'string', 'max:500'],
            'signature' => ['nullable', 'image', 'max:1024'],
        ];
    }

    private function withSignature(Request $request, array $data, ?User $user = null): array
    {
        unset($data['signature']);

        if ($request->hasFile('signature')) {
            if ($user?->signature_path) {
                Storage::disk('public')->delete($user->signature_path);
            }
            $data['signature_path'] = $request->file('signature')->store('signatures', 'public');
        }

        return $data;
    }
}