<?php

    namespace App\Helper;

    use Intervention\Image\Facades\Image;

    trait UploadFile {

        public function uploadPhoto($file, $path, $width, $height) {
            $image = Image::make($file);
            $image->resize($width, $height, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $srcPath = 'storage/' . $path . '/' . $fileName;
            $image->save(public_path($srcPath));
            return $fileName;
        }

    }
