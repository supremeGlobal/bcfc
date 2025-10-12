<?php
namespace App\Traits;

use Illuminate\Support\Facades\File;

trait HandlesImageUpload
{    
	public function uploadFile($file, $folder = 'general', $subFolder = null)
    {
        $subFolder = $subFolder ? "/$subFolder" : '';
        $path = "uploads/$folder$subFolder";

        // Ensure directory exists
        if (!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0755, true);
        }

        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($path), $filename);

        return "$path/$filename";
    }
}