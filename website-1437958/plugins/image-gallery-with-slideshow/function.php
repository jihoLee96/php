<?php
function cropImage($nw,$nh,$source,$w,$h,$dest,$type)
{
	switch($type)
	{
		case 1:    //gif->jpg
		$simg = imagecreatefromgif($source);
		break;
		case 2:    //jpeg->jpg
		$simg = imagecreatefromjpeg($source);
		break;
		case 3:    //png->jpg
		$simg = imagecreatefrompng($source);
		break;
	}
	if($w > $h) $biggestSide = $w; //find biggest length
		   else $biggestSide = $h;
		   
//The crop size will be half that of the largest side
	$option_data = get_option('combo_front_end_data');
	$img_zooming_level_show = $option_data['img_zooming_level'];
 
   $cropPercent = $img_zooming_level_show; // This will zoom in to 50% zoom (crop)
   $cropWidth   = $biggestSide*$cropPercent; 
   $cropHeight  = $biggestSide*$cropPercent;
   
 //getting the top left coordinate
   $x = ($w-$cropWidth)/2;
   $y = ($h-$cropHeight)/2;
   
   
   $thumbWidth = $nw; // will create a thumb
   $thumbHeight = $nw; // will create a  thumb	  
   if($w < $thumbWidth)
	 $thumbWidth = $w;
   if($h < $thumbHeight)
	 $thumbHeight = $h;	
	$dimg = @imagecreatetruecolor($nw,$nh);	
//restore transparency blending	
	@imagecopyresampled($dimg,$simg,0,0,$x,$y,$thumbWidth,$thumbHeight,$cropWidth,$cropHeight);	
	switch($type)
	{
		case 1:    //gif
		imagegif($dimg, $dest);
		break;
		case 2:    //jpeg
		imagejpeg($dimg,$dest,100);
		break;
		case 3:    //png->jpg
		imagepng($dimg, $dest, 0);
		break;
	}
	
}
function exact_size_cropper($tp,$ptp,$fn,$nw,$nh)
{
	@list($owidth,$oheight,$type,$attr) = getimagesize($tp.$fn); 
	
	$nheight = $nh;
	$nwidth = $nw;
	
	cropImage($nwidth,$nheight,$tp.$fn,$owidth,$oheight,$ptp.$fn,$type);
}

function fixed_size_cropper($tp,$ptp,$fn,$nw,$nh)
{
	@list($owidth,$oheight,$type,$attr) = getimagesize($tp.$fn);
	
	if($owidth < $nw || $oheight < $nh)
	{
		if($owidth < $nw && $oheight < $nh)
		{
			$nheight = $oheight;
			$nwidth = $owidth;
		}
		else if($owidth < $nw)
		{
			$nheight = $nh;
			$nwidth = $owidth;
		}
		else if($oheight < $nh)
		{
			$nheight = $oheight;
			$nwidth = $nw;
		}
	}
		else
		{
			$nheight = $nh;
			$nwidth = $nw;
			
		}

		
	cropImage($nwidth,$nheight,$tp.$fn,$owidth,$oheight,$ptp.$fn,$type);
}
function relative_size_cropper($tp,$ptp,$fn,$nw,$nh)
{
	@list($owidth,$oheight,$type,$attr) = getimagesize($tp.$fn);
	if($owidth < $nw || $oheight < $nh)
	{
		$nheight = $oheight;
		$nwidth = $owidth;
	}
	else if($owidth < $nw)
	{
		$nheight = $nh;
		$nwidth = $owidth;
	}
	else if($oheight < $nh)
	{
		$nheight = $oheight;
		$nwidth = $nw;
	}
	else
	{
		$nheight = $nh;
		$nwidth = $nw;
		
	}
	/* maintain ratio */
	$ratio1 = $owidth/$nwidth;
	$ratio2 = $oheight/$nheight;
	if($ratio1 > $ratio2)
	{
		$nwidth = $nwidth;
		$nheight = $oheight/$ratio1;
	}
	cropImage($nwidth,$nheight,$tp.$fn,$owidth,$oheight,$ptp.$fn,$type);
}

function getExtension($str)
	{
		$value = strrpos($str,".");
		if(!$value)
		{
			return "";
		}
		$length = strlen($str) - $value;
		$ext = substr($str,$value+1,$length);
		return $ext;
	}
	

function get_combo_path_value()
{
	$page_value = get_option('combo_front_end_data');
	if($page_value['root_path_image_upload'])
	{ 
		$path_value = "/".$page_value['root_path_image_upload'];
	}
	else
	{
		$path_value = "";
	}
	return $path_value;
}

function get_combo_root_path_value()
{
	$page_value = get_option('combo_front_end_data');
	if($page_value['root_path_image_upload'])
	{
		$root_path_value = $_SERVER['DOCUMENT_ROOT']."/".$page_value['root_path_image_upload'];
	}
	else
	{
		$root_path_value = $_SERVER['DOCUMENT_ROOT'];
	}
		return $root_path_value;
}
?>