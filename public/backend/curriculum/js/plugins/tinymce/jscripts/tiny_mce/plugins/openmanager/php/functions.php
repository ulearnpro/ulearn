<?php
	//display specific page of gallery - takes a list of filenames & page number to display
	function display_gallery_page($files_array, $pageno = 1, $prepath = "", $resultspp = 15, $display = true)
	{
		$pagination['resultspp'] = $resultspp; //results per page
		$pagination['startres'] = 1 + (($pageno-1) * $pagination['resultspp']); //start result
		$pagination['endres'] = $pagination['startres'] + $pagination['resultspp'] - 1; //end result
		$pagination['counter'] = 1; //file iterator
		$pagination['totalres'] = count($files_array); //total number of files/results
		$pagination['totalpages'] = ceil($pagination['totalres']/$pagination['resultspp']); //total number of pages based on number of results and results per page
		
		$thumbimagepath = $_GET['d']."images/thumbs/";
		$imagepath = $_GET['d']."images/";
		
		$relthumbimagepath = $prepath.$_GET['d']."images/thumbs/";
		$relimagepath = $prepath.$_GET['d']."images/";
		
		if((is_dir($thumbimagepath))&&(is_dir($imagepath)))
		{
			$files = scandir($thumbimagepath);
		}
		$array_count = 0;
		
		$output = "";
		
		foreach($files_array as $file_name)
		{	
			$file_path = $imagepath . $file_name;
			$rel_file_path = $relimagepath . $file_name;
			$thumb_file_path = $thumbimagepath . $file_name;
			
			if(($pagination['counter']>=$pagination['startres'])&&($pagination['counter']<=$pagination['endres']))
			{
				$addcbr = "";
				
				//figure out if we are on the last row so we can add the class "br" which removes and extra padding/margin from the bottom
				if(($pagination['counter']>($pagination['endres']-5))&&($pagination['counter']>($pagination['totalres']-5)))
				{
					$addcbr = " class=\"br\"";
				}
				$file['name'] = $file_name;
				$file['size'] = filesize($rel_file_path);
				//$file->url = $this->getPath_img_upload_folder() . rawurlencode($file->name);
				//$file->thumbnail_url = $this->getPath_url_img_thumb_upload_folder() . rawurlencode($file->name);
				//File name in the url to delete 
				
				$files_array[$array_count] = array($file);
				$array_count++;
				
				$output .= "<a href=\"$file_path\" data-gallery=\"gallery\"><img src=\"$thumb_file_path\"$addcbr></a>";
			}
			$pagination['counter']++;
		}
		
		if($display==true)
		{
			echo $output;
		}
		else
		{
			return $output;
		}
	}
	
	function display_gallery_pagination($url = "", $totalresults = 0, $pageno = 1, $resultspp = 15, $display = true)
	{
		//lookup total number of rows for query
		$configp['results_per_page']= $resultspp;
		$configp['total_no_results'] = $totalresults;
		$configp['page_url'] = $url;
		$configp['current_page_segment'] = 4;
		$configp['url'] = $url;
		$configp['pageno'] = $pageno;
		
		$output = get_html($configp);
		
		if($display==true)
		{
			echo $output;
		}
		else
		{
			return $output;
		}
	}
		
	function get_limits($which_limit)
	{
		if($which_limit==='start_result')
		{
			return $this->start_result;
		}
		else if($which_limit==='results_per_page')
		{
			return $this->results_per_page;
		}
		else
		{
			return 0;
		}
	}
	function get_html($pconfig, $ext = "")
	{
		$links_html = "";
		
		$pageAddress = $pconfig['url'];
		$resultspp = $pconfig['results_per_page'];
		$currentPage = $pconfig['pageno'];
		$startRes = $currentPage*$resultspp;
		$endRes = $startRes+$resultspp;

		$totPages=$pconfig['total_no_results']/$resultspp;
		
		$roundPages=ceil($totPages);
		
		//displaying previous page arrow
		$links_html .= "<ul>";

		if($currentPage > 1)
		{
			if($totPages>1)
			{
				$links_html .= "<li id=\"gliFirst\"><a data-target-page=\"1\" href=\"#\">&lt; First</a></li>";
			}
			$links_html .= "<li id=\"gliPrev\"><a data-target-page=\"prev\" href=\"#\">Prev</a></li>";
		}
		else
		{
			if($totPages>1)
			{
				$links_html .= "<li class=\"disabled\" id=\"gliFirst\"><a data-target-page=\"1\" href=\"#\">&lt; First</a></li>";
			}
			$links_html .= "<li class=\"disabled\" id=\"gliPrev\"><a data-target-page=\"prev\" href=\"#\">Prev</a></li>";
		}

		//displaying numbers inbetween page arrows.
		$pageLimit=9;

		//startpage / endpage calculations
		if(($currentPage-3)>0)
		{
			$startPage = $currentPage-3;
			$endAdd=0;
		}
		else
		{
			// if start is forced to be set at 1 then we are missing some page numbers, so we need to add these to end page result.
			$startPage=1;
			$endAdd = 1 - ($currentPage-3);
		}
			
		/*if(($currentPage+5+$endAdd)<$roundPages)
		{
			$endPage=$currentPage+5+$endAdd;
			$startAdd=0;
		}
		else
		{*/
			$endPage = $roundPages;
			$startAdd = 0;
		/*}*/

		if(($startPage+$startAdd)>0)
		{
			$startPage = $startPage - $startAdd;
		}
		else
		{
			$startPage=1;
		}
		if($startPage<=0)
		{
			$startPage=1;
		}

		for($i=$startPage;$i<=$endPage;$i++)
		{
			if($i==$currentPage)
			{
				$links_html .= "<li class=\"disabled\" id=\"gli$i\"><a href=\"#\" data-target-page=\"$i\">$i</a></span></li>";
			}
			else
			{
				$links_html .= "<li id=\"gli$i\"><a href=\"#\" data-target-page=\"$i\">$i</a></li>";
			}
			/*if($i!=$endPage)
			{
				$links_html .= " | ";
			}*/
		}

		//displaying previous page arrow
		if($currentPage < $roundPages)
		{
			$nextPage= $currentPage+1;
			$links_html .= "<li id=\"gliNext\"><a href=\"#\" data-target-page=\"next\">Next</a></li>";
			
			if($totPages>1)
			{
				$links_html .= "<li id=\"gliLast\"><a href=\"#\" data-target-page=\"$roundPages\">Last &gt;</a></li>";
			}
		}
		else
		{
			$links_html .= "<li id=\"gliNext\" class=\"disabled\"><a href=\"#\" data-target-page=\"next\">Next</a></li>";
			
			if($totPages>1)
			{
				$links_html .= "<li id=\"gliLast\" class=\"disabled\"><a href=\"#\" data-target-page=\"$roundPages\">Last &gt;</a><li>";
			}
		}
		if($roundPages>9)
		{
			//$links_html .= "<br /><em><span style=\"font-size:10px;\">(of $roundPages pages)</span></em>";
		}
		$links_html .= "</ul>";
		return $links_html;
	}
	

?>