<?php

namespace App\Livewire\Country;

use App\Models\Country;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddCountry extends Component
{
    #[Validate()]
    public string $name = '';

    public bool $is_active = false;

    public function toggleActive()
    {
        $this->is_active = !$this->is_active;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255|unique:categories',
        ];
    }

    public function addCountry()
    {
        $validated = $this->validate();

        Country::create($validated);

        $this->reset();

        session()->flash('ok', 'Country created successfully');

        $this->dispatch('country-created');

    }

    public function render()
    {
        return view('livewire.country.add-country');
    }
}
