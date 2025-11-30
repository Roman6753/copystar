<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CountryController extends Controller
{
    public function export()
    {
        $countries = Country::all();
        
        $fileName = 'countries_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($countries) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Top']);

            foreach ($countries as $country) {
                fputcsv($file, [
                    $country->id,
                    $country->name,
                    $country->top,
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240'
        ]);

        try {
            $file = $request->file('file');
            $csvData = file_get_contents($file->getRealPath());
            $rows = array_map('str_getcsv', explode("\n", $csvData));
            
            $rows = array_filter($rows);
        
            $header = array_shift($rows);
            
            foreach ($rows as $row) {
                if (!empty($row) && count($row) === count($header)) {
                    $data = array_combine($header, $row);
                    
                    Country::create([
                        'name' => $data['Name'] ?? $data['name'] ?? '',
                        'top' => isset($data['Top']) ? (int)$data['Top'] : (isset($data['top']) ? (int)$data['top'] : 0),
                    ]);
                }
            }
            
            return back()->with('success', 'Countries imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing countries: ' . $e->getMessage());
        }
    }
}