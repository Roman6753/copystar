<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    public function export()
    {
        $categories = Category::all();
        
        $fileName = 'categories_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Created At']);

            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->id,
                    $category->name,
                    $category->created_at,
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
                    
                    Category::create([
                        'name' => $data['Name'] ?? $data['name'] ?? '',
                    ]);
                }
            }
            
            return back()->with('success', 'Categories imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing categories: ' . $e->getMessage());
        }
    }
}