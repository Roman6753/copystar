<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function export()
    {
        $users = User::all();
        
        $fileName = 'users_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Email', 'Avatar', 'Created At']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->avatar ?? '',
                    $user->created_at,
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
                    
                    User::create([
                        'name' => $data['Name'] ?? $data['name'] ?? '',
                        'email' => $data['Email'] ?? $data['email'] ?? '',
                        'avatar' => $data['Avatar'] ?? $data['avatar'] ?? null,
                        'password' => bcrypt('password123'),
                    ]);
                }
            }
            
            return back()->with('success', 'Users imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing users: ' . $e->getMessage());
        }
    }
}