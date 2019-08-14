<?php
	include "functions.php";
	
	//get files in folder
	$thumbimagepath = "../".$_GET['d']."images/thumbs/";
	$imagepath = "../".$_GET['d']."images/";
	
	//handle a delete before
	if(isset($_GET['del']))
	{
		if($_GET['del']!="")
		{
			
			//then delete the files....
			$delthumbpath = $thumbimagepath.urldecode($_GET['del']);
			$delimagepath = $imagepath.urldecode($_GET['del']);
			
			if(file_exists($delthumbpath))
			{
				unlink($delthumbpath);
			}
			if(file_exists($delimagepath))
			{
				unlink($delimagepath);
			}
		}
	}
	
	if((is_dir($thumbimagepath))&&(is_dir($imagepath)))
	{
		$files = scandir($thumbimagepath);
	}
	$array_count = 0;
	$files_array = array();

	
	foreach($files as $file_name)
	{	
		$file_path = $imagepath . $file_name;
		$thumb_file_path = $thumbimagepath . $file_name;
		//if (is_file($file_path) && $file_name[0] !== '.')
		if (is_file($file_path) && $file_name[0] !== '.')
		{
			array_push($files_array, $file_name);
		}
	}
	
	$nofiles = count($files_array);
	$resultspp = 15;
	$nopages = ceil($nofiles/$resultspp);
	
	$pageno = $_GET['p'];
	
	$error = array('thumbhtml' => display_gallery_page($files_array,$pageno,"../",$resultspp, false),'paginationhtml' => display_gallery_pagination("",count($files_array), $pageno, $resultspp, false), 'noofpages' => $nopages);

	echo json_encode(array($error));
?>