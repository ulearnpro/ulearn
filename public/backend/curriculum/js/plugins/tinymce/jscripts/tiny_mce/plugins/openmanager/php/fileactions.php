<?php
	
	if(isset($_GET['s']))
	{
		//simple switch to see if we want to upload a file or grab the content of a folder
		$s = $_GET['s'];
		
		if($s=="uploadfile")
		{
			upload_file();
		}
		else if($s=="getfiles")
		{
			get_scan_files();
		}
	}
	
	function upload_file()
	{
		//get upload folder
		$uploadfolder = "";
		if(isset($_POST['uploadfolder']))
		{
			$uploadfolder = "../".$_POST['uploadfolder'];
			$reluploadfolder = $_POST['uploadfolder'];
		}
				
		if((file_exists($uploadfolder))&&($uploadfolder!=""))
		{
			//check the that a file has been uploaded by checking for name
			if(isset($_FILES['userfile']['name']))
			{//ensure it is set - this means a file was passed
				
				//grab the media type - this can be "media", "images", or "" (a blank media type also means images in this plugin - this is when the media manager is loaded by the custom icon)
				$mediatype = $_POST['mediatype'];
				
				//grab the name
				$tname = $_FILES['userfile']['name'];
				
				//do some crude cleaning/sanitizing of the name (needs to be improved)
				$name = strtr($tname, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
				$name = preg_replace('/\s+/', '-', $name); //remove spaces
				
				
				$fileext = strtolower(pathinfo($name, PATHINFO_EXTENSION));// get file extension and force lower case
				$filename = strtolower(pathinfo($name, PATHINFO_FILENAME));// get file name and force lower case
				
				//$filepath = $_POST['uploadpath'];
				
				
				$mediafolder = "media/";
				$imagesfolder = "images/";
				
				//check if uploads exists, then check if subfolders exist, if uploads exists, then create subfolders if they don't#
				
				if($mediatype=="media")
				{
					//check for existance of media subfolder
					if(!file_exists($uploadfolder.$mediafolder))
					{
						//if it doesn't exists try to create it
						if(!mkdir($uploadfolder.$mediafolder, 0777))
						{
							//if it can't be created return error about permissions
							$error = array('error' => 'Please check the correct permissions are set on the upload folder');
							echo json_encode(array($error));
							exit;
						}
					}
					//set the desired destination filename
					$destination = $uploadfolder.$mediafolder.$name;
					$reldestination = $reluploadfolder.$mediafolder.$name;
				}
				else
				{//then we are uploading an image
				
					//check for existance of image subfolder
					if(!file_exists($uploadfolder.$imagesfolder))
					{
						//if it doesn't exists try to create it
						if(!mkdir($uploadfolder.$imagesfolder, 0777))
						{
							//if it can't be created return error about permissions
							$error = array('error' => 'Please check the correct permissions are set on the upload folder');
							echo json_encode(array($error));
							exit;
						}
						
						//try to create subfolder for thumbnails
						if(!mkdir($uploadfolder.$imagesfolder."thumbs/", 0777))
						{
							//if it can't be created return error about permissions
							$error = array('error' => 'Please check the correct permissions are set on the upload folder');
							echo json_encode(array($error));
							exit;
						}
					}
					
					//set the desired destination filename
					$destination = $uploadfolder.$imagesfolder.$name;
					
					//now check for the existence of a file at the destination, if it exists we need to change the filename
					if(file_exists($destination))
					{
						$uniqid = uniqid();
						$filename = $filename."_".$uniqid;
						$destination = $uploadfolder.$imagesfolder.$filename.".".$fileext;
					}
					
				}
				
				if(move_uploaded_file($_FILES['userfile']['tmp_name'], $destination))
				{//move temp uploaded file
					
					$uploadinfo = new stdClass(); //object to hold return data
					
					if($mediatype=="media")
					{//if media then simply move file and return upload info as JSON object
					
						$uploadinfo->name = $tname;
						$uploadinfo->destination = $reldestination;
						$uploadinfo->mediatype = $mediatype;
					}
					else
					{//else image, create thumbnail and return upload info as JSON object
					
						//create thumbnail
						$maxaspect = 120/80;
						
						error_reporting(E_ALL);
						$thumbext = ImageCR($destination, $maxaspect.'/1', '120*80', $uploadfolder.$imagesfolder."thumbs/".$filename, $fileext);
						
						if($thumbext)
						{//grab the file extension for the newly generated thumb (gifs are converted to jpg)
							
							$uploadinfo->thumb_name = $reluploadfolder.$imagesfolder."thumbs/".$filename.".".$thumbext;
						}
						else
						{
							
						}

						$uploadinfo->name = $filename.".".$fileext;
						$uploadinfo->destination = $reluploadfolder.$imagesfolder.$filename.".".$fileext;
						$uploadinfo->mediatype = $mediatype;
					}
					echo json_encode(array($uploadinfo));
				}
				else
				{
					$error = array('error' => 'There was a problem uploading the file, please try again');
					echo json_encode(array($error));
				}
			}
			else
			{
				$error = array('error' => 'No file sent');
				echo json_encode(array($error));
			}
		}
		else
		{
			$error = array('error' => 'Upload folder not correctly configured');
			echo json_encode(array($error));
		}
	}
	
	//Get info and Scan the directory
	function get_scan_files()
	{
		$files = scandir(getPath_img_upload_folder());
		$array_count = 0;
		$files_array = array();
		
		//print_r($files);
		foreach($files as $file_name)
		{
			$file_path = getPath_img_upload_folder() . $file_name;
			if (is_file($file_path) && $file_name[0] !== '.') {

				
				$file['name'] = $file_name;
				$file['size'] = filesize($file_path);
				//$file->url = $this->getPath_img_upload_folder() . rawurlencode($file->name);
				//$file->thumbnail_url = $this->getPath_url_img_thumb_upload_folder() . rawurlencode($file->name);
				//File name in the url to delete 
				
				$files_array[$array_count] = array($file);
				$array_count++;
			}
		
		}
		header('Content-type: application/json');
		echo json_encode(array($files_array));
	}
	
	function get_file_objects() {
        return array_values(array_filter(array_map(
             array($this, 'get_file_object'), scandir($this->getPath_img_upload_folder())
                   )));
    }
	
	
	function ImageCR($source, $crop = null, $scale = null, $destination = null, $extension = null)
	{
		$source = @ImageCreateFromString(@file_get_contents($source));
		
		if (is_resource($source) === true)
		{			
			$size = array(ImageSX($source), ImageSY($source));
			
			//check to see if the source image is the same size as required destination
			if (isset($scale) === true)
			{
				$scale = array_filter(explode('*', $scale), 'is_numeric');
				//echo var_dump($size);
				if((($scale[0]==$size[0])&&($scale[1]==$size[1]))&&($extension!="gif"))//we don't want gifs all convert to jpeg
				{
					//then simply return we don't need to modify the file..
					
					/*$content = PHP_EOL.'============================================'.PHP_EOL;
					$content .= strftime('%c').PHP_EOL;
					$content .= print_r($tscale, true).PHP_EOL.PHP_EOL;
					$content .= print_r($size, true).PHP_EOL;
					$content .= '============================================'.PHP_EOL.PHP_EOL;
					$fp = fopen('file.txt', 'a');
					fwrite($fp, $content);
					fclose($fp);*/
					
					return true;
				}
			}
			
			if (isset($crop) === true)
			{
					$crop = array_filter(explode('/', $crop), 'is_numeric');

					if (count($crop) == 2)
					{
							$crop = array($size[0] / $size[1], $crop[0] / $crop[1]);

							if ($crop[0] > $crop[1])
							{
									$size[0] = $size[1] * $crop[1];
							}

							else if ($crop[0] < $crop[1])
							{
									$size[1] = $size[0] / $crop[1];
							}

							$crop = array(ImageSX($source) - $size[0], ImageSY($source) - $size[1]);
					}

					else
					{
							$crop = array(0, 0);
					}
			}

			else
			{
					$crop = array(0, 0);
			}

			if (isset($scale) === true)
			{
					//$scale = array_filter(explode('*', $scale), 'is_numeric');

					if (count($scale) >= 1)
					{
							if (empty($scale[0]) === true)
							{
									$scale[0] = $scale[1] * $size[0] / $size[1];
							}

							else if (empty($scale[1]) === true)
							{
									$scale[1] = $scale[0] * $size[1] / $size[0];
							}
					}

					else
					{
							$scale = array($size[0], $size[1]);
					}
			}

			else
			{
					$scale = array($size[0], $size[1]);
			}

			$result = ImageCreateTrueColor($scale[0], $scale[1]);

			if (is_resource($result) === true)
			{
				ImageFill($result, 0, 0, IMG_COLOR_TRANSPARENT);
				ImageSaveAlpha($result, true);
				ImageAlphaBlending($result, true);

				if (ImageCopyResampled($result, $source, 0, 0, $crop[0] / 2, $crop[1] / 2, $scale[0], $scale[1], $size[0], $size[1]) === true)
				{
					//origpath
					$origpath = $destination.".".$extension;
				
					if (preg_match('~gif$~i', $origpath) >= 1)
					{
							//return ImageGIF($result, $destination.".".$extension);
							//imagecreatetruecolor
							/*if(file_exists($origpath))
							{
								unlink($origpath);
							}
							if(ImageJPEG($result, $destination.".jpg", 90))
							{
								return "jpg";
							}
							else
							{
								return false;
							}
							*/
							if(ImageGIF($result, $origpath, 9))
							{
								return "gif";
							}
							else
							{
								return false;
							}
							//return ImageJPEG($result, $destination.".".$extension, 90);
					}
					else if (preg_match('~png$~i', $origpath) >= 1)
					{
							if(ImagePNG($result, $origpath, 9))
							{
								return "png";
							}
							else
							{
								return false;
							}
					}

					else if (preg_match('~jpe?g$~i', $origpath) >= 1)
					{
							if(ImageJPEG($result, $origpath, 90))
							{
								return "jpg";
							}
							else
							{
								return false;
							}
					}
				}
			}
		}

		return false;
	}
	
	
	function getPath_img_upload_folder()
	{
		return "uploads/";
	}

    function get_file_object($file_name) {
        $file_path = $this->getPath_img_upload_folder() . $file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {

            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->getPath_img_upload_folder() . rawurlencode($file->name);
            $file->thumbnail_url = $this->getPath_url_img_thumb_upload_folder() . rawurlencode($file->name);
            //File name in the url to delete 
			
            return $file;
        }
        return null;
    }

