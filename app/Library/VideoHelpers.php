<?php
namespace App\Library;
class VideoHelpers {
	private $ffmpeg_path;
	private $file_path;
	private $file_name;
	private $data;

	public function __construct($path,$file,$name){
		$this->ffmpeg_path = $path;
		$this->file_path = $file;
		$this->file_name = $name;
		$this->data['split_duration'] = 10;
		$this->data['size'] = '255x215';
	}

	public function getDuration(){

		$cmd = shell_exec("$this->ffmpeg_path -i \"{$this->file_path}\" 2>&1");
        preg_match('/Duration: (.*?),/', $cmd, $matches);
		return $matches[1];
	}

	public function convertImages($video_image_path = ''){
		// echo $video_image_path;exit;

		$cmd = "$this->ffmpeg_path -i \"{$this->file_path}\" -an -ss ".$this->data['split_duration']." -s {$this->data['size']} $video_image_path";
		if(!shell_exec($cmd)){
			return true;
		}else{
			echo 'false';exit;
			return false;
		}
	}

	public function convertVideos($given_type){
		// if($given_type == "video/mp4"){
		// 	$this->webMConversion();
		// 	$this->oggConversion();
		// }else{
			$this->mp4Conversion();
			$this->webMConversion();
			$this->oggConversion();
		// }
	}

	private function oggConversion(){
		$cmd = "$this->ffmpeg_path -i $this->file_path -acodec libvorbis -b:a 128k -vcodec libtheora -b:v 400k -f ogg ./uploads/videos/{$this->file_name}.ogv";
		if(!shell_exec($cmd)){
			return true;
		}else{
			return false;
		}
	}

	private function webMConversion(){
		$cmd = "$this->ffmpeg_path -i $this->file_path -acodec libvorbis -b:a 128k -ac 2 -vcodec libvpx -b:v 400k -f webm ./uploads/videos/{$this->file_name}.webm";
		if(!shell_exec($cmd)){
			return true;
		}else{
			return false;
		}
	}

	private function mp4Conversion(){
		$cmd = "$this->ffmpeg_path -i $this->file_path -acodec aac -strict experimental ./uploads/videos/{$this->file_name}.mp4";
		if(!shell_exec($cmd)){
			return true;
		}else{
			return false;
		}
	}

}
