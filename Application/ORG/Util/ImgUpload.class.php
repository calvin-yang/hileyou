<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace ORG\Util;

/**
 * 图片上传插件类
 * @author yangweijie <yangweijiester@gmail.com>
 */
 
class ImgUpload { 
	public $annexFolder = "./Public/default";//附件存放点，默认为：annex 
	public $smallFolder = "./Public/default/smallimg";//缩略图存放路径，注：必须是放在 $annexFolder下的子目录，默认为：smallimg 
	public $markFolder =  "./Public/default/mark";//水印图片存放处 
	public $upFileType = "jpg gif png";//上传的类型，默认为：jpg gif png rar zip 
	public $upFileMax = 1024;//上传大小限制，单位是“KB”，默认为：1024KB 
	public $fontType =  "./Public/zi/04B_08__.TTF";//字体 
	public $maxWidth = 500; //图片最大宽度 
	public $maxHeight = 600; //图片最大高度 

 
	function upLoad($inputName) { 
	$imageName = time();//设定当前时间为图片名称

	if(@empty($_FILES[$inputName]["name"])){
		$data['status'] = '0';
		$data['info'] = "没有上传图片信息，请确认"; 
		return $data;
		exit;
	}
		

	$name = explode(".",$_FILES[$inputName]["name"]);//将上传前的文件以“.”分开取得文件类型 
	$imgCount = count($name);//获得截取的数量 
	$imgType = $name[$imgCount-1];//取得文件的类型 
	if(strpos($this->upFileType,$imgType) === false){
		$data['status'] = '0';
		$data['info'] = "上传文件类型仅支持 ".$this->upFileType." 不支持 ".$imgType;
		return $data;
		exit;

	}
	if(!is_dir($this->annexFolder)) {
		mkdir($this->annexFolder, 0777, true);
	}
	$photo = $this->annexFolder."/".$imageName.".".$imgType;//写入数据库的文件名
	$uploadFile = $photo;//上传后的文件名称
	
	$upFileok = move_uploaded_file($_FILES[$inputName]["tmp_name"],$uploadFile); 
	if($upFileok) { 
		$this->upFileMax;
		$kSize = $imgSize = $_FILES[$inputName]["size"]; 
		//$kSize = round($imgSize/1024);
		if($kSize > ($this->upFileMax)) { 
			@unlink($uploadFile);
			$data['status'] = '0';
			$data['info'] = "上传文件超过".($this->upFileMax/1024/1024)."&nbsp;M"; 
			return $data;
			exit;
		} 
	} else {
		$data['status'] = '0';
		$data['info'] = "上传图片失败，请确认你的上传文件不超过 ".($this->upFileMax/1024/1024)." M 或上传时间超时"; 
		return $data;
		exit;
	} 	
		$data['info'] = $photo;
		$data['status'] = '1';
		return $data; 
	} 
	function getInfo($photo) { 
		//$photo = $this->annexFolder."/".$photo; 
		$imageInfo = getimagesize($photo); 
		$imgInfo["width"] = $imageInfo[0]; 
		$imgInfo["height"] = $imageInfo[1]; 
		$imgInfo["type"] = $imageInfo[2]; 
		$imgInfo["name"] = basename($photo); 
		return $imgInfo; 
	}
	//缩略图生成
	function smallImg($photo,$width=128,$height=128) {
		if(!is_dir($this->smallFolder)) {
			mkdir($this->smallFolder, 0777, true);
		}

		$imgInfo = $this->getInfo($photo);
		//$photo = $this->annexFolder."/".$photo;//获得图片源 
		$newName = substr($imgInfo["name"],0,strrpos($imgInfo["name"], "."))."_thumb.jpg";//新图片名称 
		if($imgInfo["type"] == 1) { 
			$img = imagecreatefromgif($photo); 
		} elseif($imgInfo["type"] == 2) { 
			$img = imagecreatefromjpeg($photo); 
		} elseif($imgInfo["type"] == 3) { 
			$img = imagecreatefrompng($photo); 
		} else {

		$img = ""; 
	}
	if(empty($img)) return False;

	$width = ($width > $imgInfo["width"]) ? $imgInfo["width"] : $width; 
	$height = ($height > $imgInfo["height"]) ? $imgInfo["height"] : $height; 
	$srcW = $imgInfo["width"]; 
	$srcH = $imgInfo["height"]; 
	if ($srcW * $width > $srcH * $height) { 
		$height = round($srcH * $width / $srcW); 
	} else { 
		$width = round($srcW * $height / $srcH); 
	}
	if (function_exists("imagecreatetruecolor")) { 
		$newImg = imagecreatetruecolor($width, $height);

		ImageCopyResampled($newImg, $img, 0, 0, 0, 0, $width, $height, $imgInfo["width"], $imgInfo["height"]); 
	} else { 
		$newImg = imagecreate($width, $height); 
		ImageCopyResized($newImg, $img, 0, 0, 0, 0, $width, $height, $imgInfo["width"], $imgInfo["height"]); 
	}

	if ($this->toFile) { 
		if (file_exists($this->smallFolder."/".$newName)) @unlink($this->smallFolder."/".$newName); 
			ImageJPEG($newImg,$this->smallFolder."/".$newName); 
			return $this->smallFolder."/".$newName; 
		} else {
			ImageJPEG($newImg,$this->smallFolder."/".$newName); 
			return $this->smallFolder."/".$newName;  
		}
		
		ImageDestroy($newImg); 
		ImageDestroy($img); 
		return $newName; 
	} 
function waterMark($photo,$text) {
	if(!is_dir($this->markFolder)) {
		mkdir($this->markFolder, 0777, true);
	} 
	$imgInfo = $this->getInfo($photo); 
	//$photo = $this->annexFolder."/".$photo; 
	$newName = substr($imgInfo["name"], 0, strrpos($imgInfo["name"], ".")) . "_mark.jpg"; 
	switch ($imgInfo["type"]) { 
		case 1: 
		$img = imagecreatefromgif($photo); 
		break; 
		case 2: 
		$img = imagecreatefromjpeg($photo); 
		break; 
		case 3: 
		$img = imagecreatefrompng($photo); 
		break; 
		default: 
		return False; 
	} 
	if (empty($img)) return False; 
	$width = ($this->maxWidth > $imgInfo["width"]) ? $imgInfo["width"] : $this->maxWidth; 
	$height = ($this->maxHeight > $imgInfo["height"]) ? $imgInfo["height"] : $this->maxHeight; 
	$srcW = $imgInfo["width"]; 
	$srcH = $imgInfo["height"]; 
	if ($srcW * $width > $srcH * $height) { 
	$height = round($srcH * $width / $srcW); 
	} else { 
	$width = round($srcW * $height / $srcH); 
	} 
	if (function_exists("imagecreatetruecolor")) { 
	$newImg = imagecreatetruecolor($width, $height); 
	ImageCopyResampled($newImg, $img, 0, 0, 0, 0, $width, $height, $imgInfo["width"], $imgInfo["height"]); 
	} else { 
	$newImg = imagecreate($width, $height); 
	ImageCopyResized($newImg, $img, 0, 0, 0, 0, $width, $height, $imgInfo["width"], $imgInfo["height"]); 
	} 
	$white = imageColorAllocate($newImg, 255, 255, 255); 
	$black = imageColorAllocate($newImg, 0, 0, 0); 
	$alpha = imageColorAllocateAlpha($newImg, 230, 230, 230, 40); 
	ImageFilledRectangle($newImg, 0, $height-26, $width, $height, $alpha); 
	ImageFilledRectangle($newImg, 13, $height-20, 15, $height-7, $black); 
	ImageTTFText($newImg, 4.9, 0, 20, $height-14, $black, $this->fontType, $text[0]); 
	ImageTTFText($newImg, 4.9, 0, 20, $height-6, $black, $this->fontType, $text[1]); 
	if($this->toFile) { 
	if (file_exists($this->markFolder."/".$newName)) @unlink($this->markFolder."/".$newName); 
	ImageJPEG($newImg,$this->markFolder."/".$newName); 
	return $this->annexFolder."/".$this->markFolder."/".$newName; 
	} else { 
	ImageJPEG($newImg,$this->markFolder."/".$newName); 
	return $this->markFolder."/".$newName;
	} 
	ImageDestroy($newImg); 
	ImageDestroy($img); 
	return $newName; 
	} 
} 