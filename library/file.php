<?php 
	
	class file
	{
	    public static function save_image($filename, $folder, $prefix)
	    {
	      	$path = $_FILES[$filename]['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
	      	$new_name = $prefix."_".strtoupper(md5(uniqid(rand(), true))).'.'.$ext;
	    	move_uploaded_file( $_FILES[$filename]["tmp_name"], $folder. '/' . $new_name );
	    	
	      return $new_name;
	    }
        public static function save_file($filename, $folder,$name)
        {
            $path = $_FILES[$filename]['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $new_name = $name.'.'.$ext;
            move_uploaded_file( $_FILES[$filename]["tmp_name"], $folder. '/' . $new_name );
            return $new_name;
        }
        public static function create_dir($dir)
        {
            global $var;
            if(!file_exists($dir))
            {
                $oldmask = umask(0);
                mkdir($dir, 0777);
                umask($oldmask);
            }
	    }

        public static function create_file($file)
        {
            global $var;
            if(!file_exist($file))
            {
                fopen($file,'w') or die('Cannot open file: '.$file);
            }
	    }

	    public static function createJson($file,$data)
        {
            global $var;
            $fh 	= fopen($file, 'w') or die("can't open file");
            fwrite($fh, $data);
            fclose($fh);
        }

        public static function getJson($jsonFile)
        {
            $source = file_get_contents($jsonFile);
            $source = html_entity_decode($source);
            $data   = json_decode($source, true);
            return $data;
        }

        function recursive_file($src,$dst) {
            $dir = opendir($src);
            @mkdir($dst);
            while(false !== ( $file = readdir($dir)) ) {
                if (( $file != '.' ) && ( $file != '..' )) {
                    if ( is_dir($src . '/' . $file) ) {
                        recursive_file($src . '/' . $file,$dst . '/' . $file);
                    }
                    else {
                        copy($src . '/' . $file,$dst . '/' . $file);
                    }
                }
            }
            closedir($dir);
        }

        public static function compressImage($source, $destination, $quality, $prefix)
        {
            $filename       = $_FILES[$source]['name'];
            $sources        = $_FILES[$source]['tmp_name'];
            $type           = $_FILES[$source]['type'];
            echo $filename;exit;
            // $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $info = getimagesize($sources);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $new_name = $prefix."_".strtoupper(md5(uniqid(rand(), true))).'.'.$ext;
            $destination = $destination.$new_name;
            $imgInfo = getimagesize($sources); 
            $mime = $imgInfo['mime'];
            $exif = exif_read_data($sources);
            $info = getimagesize($sources);
            // echo round($_FILES[$source]['size']/1048576,2);
            switch ($info['mime']) {
                case 'image/jpeg': 
                    $image = imagecreatefromjpeg($sources); 
                    if(isset($exif['Orientation'])){
                        switch ($exif['Orientation']) {
                            case 3:
                                $image = imagerotate($image, 180, 0);
                                break;
                            case 6:
                                $image = imagerotate($image, -90, 0);
                                break;
                            case 8:
                                $image = imagerotate($image, 90, 0);
                                break;
                            default:
                                $image = $image;
                        }
                    }
                    imagejpeg($image , $destination , $quality); 
                    break;
                case 'image/gif': $image = imagecreatefromgif($sources); imagejpeg($image , $destination , $quality); break;
                case 'image/png':
                    $image = imagecreatefrompng($sources);
                    if(file::check_transparent($image)){
                        imagealphablending($image, false);
                        imagesavealpha($image, true);
                        $qf = ($quality==100) ? 99 : $quality;
                        $qf = $qf / 10;
                        $qf = 10 - $qf;
                        imagepng($image , $destination , $qf);
                    }else{
                        imagejpeg($image , $destination , $quality);
                    }
                break;
                default: return false; break;
            }
            // $new_name = $prefix."_".strtoupper(md5(uniqid(rand(), true))).'.'.$ext;
            return $new_name;
        }

        public static function compressImageArray($source, $destination, $quality, $prefix,$array)
        {
            $filename       = $_FILES[$source]['name'][$array];
            $sources        = $_FILES[$source]['tmp_name'][$array];
            $type           = $_FILES[$source]['type'][$array];
            // $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $info = getimagesize($sources);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $new_name = $prefix."_".strtoupper(md5(uniqid(rand(), true))).'.'.$ext;
            $destination = $destination.$new_name;
            $imgInfo = getimagesize($sources); 
            $mime = $imgInfo['mime'];
            $exif = exif_read_data($sources);
            $info = getimagesize($sources);
            // echo round($_FILES[$source]['size']/1048576,2);
            switch ($info['mime']) {
                case 'image/jpeg': 
                    $image = imagecreatefromjpeg($sources); 
                    if(isset($exif['Orientation'])){
                        switch ($exif['Orientation']) {
                            case 3:
                                $image = imagerotate($image, 180, 0);
                                break;
                            case 6:
                                $image = imagerotate($image, -90, 0);
                                break;
                            case 8:
                                $image = imagerotate($image, 90, 0);
                                break;
                            default:
                                $image = $image;
                        }
                    }
                    imagejpeg($image , $destination , $quality); 
                    break;
                case 'image/gif': $image = imagecreatefromgif($sources); imagejpeg($image , $destination , $quality); break;
                case 'image/png':
                    $image = imagecreatefrompng($sources);
                    if(file::check_transparent($image)){
                        imagealphablending($image, false);
                        imagesavealpha($image, true);
                        $qf = ($quality==100) ? 99 : $quality;
                        $qf = $qf / 10;
                        $qf = 10 - $qf;
                        imagepng($image , $destination , $qf);
                    }else{
                        imagejpeg($image , $destination , $quality);
                    }
                break;
                default: return false; break;
            }
            // $new_name = $prefix."_".strtoupper(md5(uniqid(rand(), true))).'.'.$ext;
            return $new_name;
        }

        public static function check_transparent($im) {

        $width = imagesx($im); // Get the width of the image
        $height = imagesy($im); // Get the height of the image

        // We run the image pixel by pixel and as soon as we find a transparent pixel we stop and return true.
        for($i = 0; $i < $width; $i++) {
            for($j = 0; $j < $height; $j++) {
                $rgba = imagecolorat($im, $i, $j);
                if(($rgba & 0x7F000000) >> 24) {
                    return true;
                }
            }
        }

        // If we dont find any pixel the function will return false.
        return false;
    }  
    }
    