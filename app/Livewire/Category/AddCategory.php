<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddCategory extends Component
{
    #[Validate()]
    public string $name = '';

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255|unique:categories',
        ];
    }

    public function addCategory()
    {
        $validated = $this->validate();

        Category::create($validated);

        $this->reset();

        session()->flash('ok', 'Category created successfully');

        $this->dispatch('category-created');

    }

    public function render()
    {
        return view('livewire.category.add-category');
    }
}
