<?php 
    namespace App;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use Intervention\Image\Facades\Image;

    class Utility{
        public static function addCreatedBy(array $insert){
            if(Auth::guard('admin')->user() != null){
                $id = Auth::guard('admin')->user()->id;
            }
            $insert['created_by'] = $id;
            $insert['updated_by'] = $id;
            return $insert;
        }
        public static function addUpdatedBy(array $data){
            if(Auth::guard('admin')->user() != null){
                $id = Auth::guard('admin')->user()->id;
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $id;
            return $data;
        }
        public static function addDeletedBy(array $data){
            if(Auth::guard('admin')->user() != null){
                $id = Auth::guard('admin')->user()->id;
            }
            $data['deleted_by'] = $id;
            $data['deleted_at'] = date('Y-m-d H:i:s');
            return $data;
        }
        public static function saveDebugLog(string $screen,array $query_log){
            $formatted_querries = '';
            foreach($query_log as $query){
                $sql_query = $query['query'];
                foreach($query['bindings'] as $binding){
                    $sql_query = preg_replace('/\?/', "'". $binding . "'" . $sql_query , 1);
                }
                $formatted_querries .= $sql_query . PHP_EOL;
            }
            Log::debug($screen . $formatted_querries);
        }
        public static function saveErrorLog(string $screen,string $query){
            Log::error($screen . $query);
        }
        public static function saveFile($sourceImagePath, $targetImagePath, $targetWidth, $targetHeight){
        $imageType = exif_imagetype($sourceImagePath);

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($sourceImagePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($sourceImagePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($sourceImagePath);
                break;
            default:
                $sourceImage = imagecreatefromstring(file_get_contents($sourceImagePath));
                break;
        }

        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        $cropWidth = round($sourceWidth);
        $cropHeight = round($sourceHeight);

        if ($sourceWidth > $sourceHeight) {
            $cropWidth = round($sourceHeight * ($targetWidth / $targetHeight));
        } else {
            $cropHeight = round($sourceWidth * ($targetHeight / $targetWidth));
        }

        $cropX = round(($sourceWidth - $cropWidth) / 2);
        $cropY = round(($sourceHeight - $cropHeight) / 2);

        $croppedImage = imagecreatetruecolor($cropWidth, $cropHeight);
        imagecopyresampled($croppedImage, $sourceImage, 0, 0, $cropX, $cropY, $cropWidth, $cropHeight, $cropWidth, $cropHeight);

        $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($targetImage, $croppedImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $cropWidth, $cropHeight);

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($targetImage, $targetImagePath);
                break;
            case IMAGETYPE_PNG:
                imagepng($targetImage, $targetImagePath);
                break;
            case IMAGETYPE_GIF:
                imagegif($targetImage, $targetImagePath);
                break;
            default:
                imagejpeg($targetImage, $targetImagePath);
                break;
        }

        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        return true;
        }
        public static function saveThumb($sourceFile, $destination, $thumb_name, $targetWidth, $targetHeight){
            $desiredRatio = $targetWidth / $targetHeight;

            $img = Image::make($sourceFile);

            $width = $img->width();
            $height = $img->height();

            $originalRatio = $width / $height;

            if ($originalRatio > $desiredRatio) {
                $newWidth = (int) ($height * $desiredRatio);
                $newHeight = $height;
            } else {
                $newWidth = $width;
                $newHeight = (int) ($width / $desiredRatio);
            }

            $cropX = max(0, (int) (($width - $newWidth) / 2));
            $cropY = max(0, (int) (($height - $newHeight) / 2));

            $img->crop($newWidth, $newHeight, $cropX, $cropY);

            $img->resize($targetWidth, $targetHeight);

            $img->save($destination . '/' . $thumb_name);
            // if($width/$height > $desiredRatio){
            //     $newWidth = (int)($height * $desiredRatio);
            //     $newHeight = $height;
            // } else {
            //     $newWidth = $width;
            //     $newHeight = (int)($width * $desiredRatio);
            // }

            // $cropX = (int)(($width - $newWidth)/2);
            // $cropY = (int)(($height - $newHeight)/2);

            // $modifiedImage = $img->crop($newWidth, $newHeight, $cropX, $cropY);

            // $modifiedImage->resize($targetWidth, $targetHeight);

            // $modifiedImage->save($destination . '/' . $thumb_name);
        }
    }
?>