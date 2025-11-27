<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ListUsers extends Component
{

    public function deleteUser(User $user)
    {
        Storage::disk('public')->delete($user->avatar);
        $user->delete();
        session()->flash('ok', 'User deleted successfully');
    }

    public function render()
    {
        $users = User::query()->orderBy('id','desc')->get();

        return view('livewire.admin.list-users', compact('users'));
    }
}
