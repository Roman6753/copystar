<?php

namespace App\Livewire\Register;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;

    #[Title('Register')]
    #[Validate()]

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public $avatar;

    public function store()
    {
        $validated = $this->validate();

        if (!$this->avatar) {
            $validated['avatar'] = null;
        }else{
            $validated['avatar'] = $this->avatar->store('avatars','public');
        }

        $user = User::create($validated);

        $this->reset();

        session()->flash('ok', 'User created successfully');

        return redirect()->route('home', ['navigate' => true]);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'avatar' => ['nullable','image','max:1024','extensions:jpg,jpeg,png,svg'],
        ];
    }

    public function render()
    {
        return view('livewire.register.register');
    }
}
