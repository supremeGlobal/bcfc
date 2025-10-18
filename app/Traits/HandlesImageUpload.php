<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait HandlesImageUpload
{	
	public function uploadFile($file, $fileBaseName)
	{
		$path = "uploads";

		// Ensure directory exists
		if (!File::exists(public_path($path))) {
			File::makeDirectory(public_path($path), 0755, true);
		}

		// Create file name like A-1004_certificate.jpg
		$extension = $file->getClientOriginalExtension();
		$filename = "{$fileBaseName}.{$extension}";

		// If file exists, delete old version (optional but good practice)
		if (File::exists(public_path("$path/$filename"))) {
			File::delete(public_path("$path/$filename"));
		}

		// Move file
		$file->move(public_path($path), $filename);

		return "$path/$filename";
	}
}
