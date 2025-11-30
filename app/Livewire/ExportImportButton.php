<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ExportImportButton extends Component
{
    use WithFileUploads;

    public $model;
    public $exportClass;
    public $importClass;
    public $fileName;
    public $importFile;
    public $showImportModal = false;

    protected $rules = [
        'importFile' => 'required|file|mimes:csv,xlsx,xls|max:10240'
    ];

    public function mount($model, $exportClass, $importClass, $fileName)
    {
        $this->model = $model;
        $this->exportClass = $exportClass;
        $this->importClass = $importClass;
        $this->fileName = $fileName;
    }

    public function export()
    {
        try {
            return Excel::download(
                new $this->exportClass, 
                $this->fileName . '_' . date('Y-m-d_H-i-s') . '.xlsx'
            );
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Export failed: ' . $e->getMessage()
            ]);
        }
    }

    public function import()
    {
        $this->validate();

        try {
            Excel::import(new $this->importClass, $this->importFile);
            
            $this->showImportModal = false;
            $this->importFile = null;
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => ucfirst($this->model) . ' imported successfully!'
            ]);
            
            $this->dispatch('refresh' . ucfirst($this->model) . 'List');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Import failed: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.export-import-button');
    }
}