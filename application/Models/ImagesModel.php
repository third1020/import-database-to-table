<?php
namespace App\Models;

use CodeIgniter\Model;

class ImagesModel extends Model
{
	public function resize($img, $reSize) {
		$images = $img->getTempName();
		$new_images = "Thumbnails_".$img->getName();
		// 					copy($img->getTempName(),"MyResize/".$img->getName());
		$width=$reSize; //*** Fix Width & Heigh (Autu caculate) ***//
		$size=GetimageSize($images);
		$height=round($width*$size[1]/$size[0]);
		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		
		ob_start ();
		ImageJPEG($images_fin);
		$image_data = ob_get_contents ();
		ob_end_clean ();
		
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);
		
		return $image_data;
	}
}
