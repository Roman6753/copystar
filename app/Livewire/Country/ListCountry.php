<?php

namespace App\Livewire\Country;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;

class ListCountry extends Component
{
        use WithPagination;

    public int $limit = 10;

    public string $search = '';

    public string $orderByField = 'ID';

    public string $orderByDirection = 'desc';

    public array $fields = ['ID','Top','Name'];

    public function addTop(Country $country)
    {
        $country->update(['top' => $country->top + 1]);

    }

    public function minusTop(Country $country)
    {
        $country->update(['top' => $country->top - 1]);
    }

    public function changeField($field)
    {
        if($this->orderByField == $field)
        {
            $this->orderByDirection = $this->orderByDirection == 'desc' ? 'asc' : 'desc';
        }

        $this->orderByField = $field;
    }

    public function deleteCategory(Country $country)
    {
        $country->delete();
    }

    public function changeLimit()
    {
        $this->resetPage();
    }

    public function render()
    {
        $countries = Country:: whereLike('name','%' . strtolower($this->search) . '%')
            ->orderBy($this->orderByField, $this->orderByDirection)
            ->paginate($this->limit);
        return view('livewire.country.list-country',compact('countries'));
    }
}
