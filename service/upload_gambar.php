<?php

function UploadImage($fupload_name, $posisi) {
	// $posisi = "../$posisi";
	$vfile_upload = $posisi . $fupload_name;
	$imageType = "image/jpg";

	move_uploaded_file($_FILES["file"]["tmp_name"], $vfile_upload);

	switch($imageType) {
		case "image/gif":
			$im_src = imagecreatefromgif($vfile_upload); 
		break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$im_src = imagecreatefromjpeg($vfile_upload); 
		break;
		case "image/png":
		case "image/x-png":
			$im_src = imagecreatefrompng($vfile_upload); 
		break;
	}
	
	$src_width = imageSX($im_src);
	$src_height = imageSY($im_src);

	if ($src_width >= 400 ){
		$dst_width = 400;
	} else {
		$dst_width = $src_width;
	}
	$dst_height = ($dst_width/$src_width)*$src_height;

	$im = imagecreatetruecolor($dst_width,$dst_height);
	imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

	switch($imageType) {
		case "image/gif":
			imagegif($im,$posisi.$fupload_name);
		break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			imagejpeg($im,$posisi.$fupload_name);
		break;
		case "image/png":
		case "image/x-png":
			imagepng($im,$posisi.$fupload_name);
		break;
	}

	$dst_width2 =300;
	$dst_height2 = ($dst_width2/$src_width)*$src_height;

	$im2 = imagecreatetruecolor($dst_width2,$dst_height2);
	imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

	switch($imageType) {
		case "image/gif":
			imagegif($im2,$posisi . "small_" . $fupload_name);
		break;
				
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			imagejpeg($im2,$posisi . "small_" . $fupload_name);
		break;

		case "image/png":
		case "image/x-png":
			imagepng($im2,$posisi . "small_" . $fupload_name);
		break;
	}
	
	imagedestroy($im_src);
	imagedestroy($im);
	imagedestroy($im2);}
?>