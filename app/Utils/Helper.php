<?php

namespace App\Utils\UploadImage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Helper {
    public function uploadImage($file){
        // $uploadedFileUrl = Cloudinary::upload($file->getRealPath())->getSecurePath();
        // return $uploadedFileUrl; 

        return $file;
    }
}
