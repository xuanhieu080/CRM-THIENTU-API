<?php

namespace App\Supports;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HasImage
{
    public static final function getImage($path)
    {
       if (empty($path)) {
           return null;
       }

        if (Storage::exists($path)) {
            return Storage::url($path);
        }

        return env('APP_URL') ."/storage/$path";
    }
    public static final function addImage(UploadedFile $file, $subdir = 'uploads')
    {
        return self::store($file, $subdir);
    }

    public static final function updateImage(UploadedFile $file, $path, $subdir = 'uploads')
    {
        if (!empty($path)) {
            $fileCurrent = Storage::disk(self::disk());
            if ($fileCurrent->exists($path)) {
                $fileCurrent->delete($path);
            }
        }
        return self::store($file, $subdir);
    }

    /**
     * Deletes a file
     * @param   $path
     * @return bool
     */
    public static final function deleteImage($path)
    {
        if (!empty($path)) {
            $file = Storage::disk(self::disk());
            if ($file->exists($path)) {
                $file->delete($path);
            }
        }
        return null;
    }

    public static final function deleteImages($paths)
    {
        foreach ($paths as $path) {
            if (!empty($path)) {
                $file = Storage::disk(self::disk());
                if ($file->exists($path)) {
                    $file->delete($path);
                }
            }
        }
        return null;
    }

    public static final function store(UploadedFile $file, $subdir, $disk = null)
    {
        $name = $file->hashName();
        $dir = "{$subdir}";
        if (empty($disk)) {
            $disk = self::disk();
        };
        return $file->storeAs($dir, $name, ['disk' => $disk]);
    }

    public static final function disk()
    {
        return Config::get('filesystems.default');
    }

}
