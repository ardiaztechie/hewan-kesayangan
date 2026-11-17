<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/**
 * UA29 Kelola Akun Staf (khusus Owner).
 */
class StaffController extends Controller
{
    public function index(): View
    {
        $staff = User::query()->where('role', UserRole::Staff)->orderBy('name')->get();

        return view('admin.staff.index', compact('staff'));
    }

    public function create(): View
    {
        return view('admin.staff.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::query()->create([
            ...$data,
            'role' => UserRole::Staff,
            'is_active' => true,
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        return redirect()->route('admin.staff.index')
            ->with('status', "Akun staf {$user->name} berhasil dibuat.");
    }

    public function toggle(User $staff): RedirectResponse
    {
        abort_unless($staff->isStaff(), 404);

        $staff->update(['is_active' => ! $staff->is_active]);

        return back()->with('status', $staff->is_active
            ? "Akun {$staff->name} diaktifkan kembali."
            : "Akun {$staff->name} dinonaktifkan.");
    }

    public function resetPassword(Request $request, User $staff): RedirectResponse
    {
        abort_unless($staff->isStaff(), 404);

        $data = $request->validate([
            'password' => ['required', Password::min(8)],
        ]);

        $staff->update(['password' => $data['password']]);

        return back()->with('status', "Password {$staff->name} berhasil diganti.");
    }
}
