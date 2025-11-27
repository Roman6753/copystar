<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ListCategory extends Component
{
    use WithPagination;

    public int $limit = 10;

    public array $list_paginate = [10,25,50,100];

    public string $search = '';

    public function deleteCategory(Category $category)
    {
        $category->delete();
    }

    public function changeLimit()
    {
        $this->resetPage();
    }

    #[On('category-created')]
    public function render()
    {
        $categories = Category::
            whereLike('name','%' . $this->search . '%')
            ->paginate($this->limit);

        return view('livewire.category.list-category', compact('categories'));
    }
}
