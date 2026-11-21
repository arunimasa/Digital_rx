<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DoctorProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(private DoctorProfileService $profiles)
    {
    }

    public function index()
    {
        $users = User::with('doctorProfile')->orderBy('name')->paginate(15);

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

        DB::transaction(function () use ($request, $data) {
            $user = User::create(Arr::only($data, $this->userFields()));

            if ($user->role === 'doctor') {
                $this->profiles->save($user, $data, $request->file('signature'), $request->file('logo'));
            }
        });

        return redirect()->route('admin.users.index')->with('status', 'User created.');
    }

    public function edit(User $user)
    {
        $user->load('doctorProfile');

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

        // An admin must not lock themselves out
        if ($user->id === $request->user()->id) {
            $data['role'] = $user->role;
            $data['is_active'] = true;
        }

        DB::transaction(function () use ($request, $user, $data) {
            $user->update(Arr::only($data, $this->userFields()));

            if ($user->role === 'doctor') {
                $this->profiles->save($user, $data, $request->file('signature'), $request->file('logo'));
            }
        });

        return redirect()->route('admin.users.index')->with('status', 'User updated.');
    }

    public function toggleActive(Request $request, User $user)
    {
        abort_if($user->id === $request->user()->id, 403, 'You cannot disable your own account.');

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('status', $user->is_active ? 'User enabled.' : 'User disabled.');
    }

    private function userFields(): array
    {
        return ['name', 'email', 'mobile', 'password', 'role', 'preferred_language', 'is_active'];
    }

    private function rules(Request $request, ?User $user = null): array
    {
        $rules = [
            'name'               => ['required', 'string', 'max:150'],
            'email'              => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user?->id)],
            'mobile'             => ['nullable', 'string', 'max:20'],
            'password'           => [$user ? 'nullable' : 'required', 'string', 'min:8'],
            'role'               => ['required', Rule::in(['admin', 'doctor', 'assistant'])],
            'preferred_language' => ['required', Rule::in(['bn', 'en'])],
            'is_active'          => ['boolean'],
        ];

        // Doctor fields are validated only when the role is Doctor
        if ($request->input('role') === 'doctor') {
            $rules += DoctorProfileService::rules($user?->doctorProfile?->id);
        }

        return $rules;
    }
}