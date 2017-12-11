<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Public_function
{
    public function __construct()
    {
        $this->CI =& get_instance();

    }
}

//讀取各功能
function load_func($func){
	foreach ($func as $key => $item){
		$func_file = $item.'.php';
		if (file_exists('functions/'.$func_file)){
			include('functions/'.$func_file);
		}
	}
}

//LINE回覆訊息
function line_reply($linebot,$replyToken,$str){
	if (is_array($str)){
		$linebot->replyMessage(array(
			'replyToken' => $replyToken,
			'messages' => $str
		));
	}else{
		$linebot->replyMessage(array(
			'replyToken' => $replyToken,
			'messages' => array(
				array(
					'type' => 'text',
					'text' => $str
				)
			)
		));
	}
}

//LINE推送訊息
function line_push($linebot,$to,$str){
	if (is_array($str)){
		$linebot->pushMessage(array(
			'to' => $to,
			'messages' => $str
		));
	}else{
		$linebot->pushMessage(array(
			'to' => $to,
			'messages' => array(
				array(
					'type' => 'text',
					'text' => $str
				)
			)
		));
	}
}

//DEBUG
function debug($str){
    print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
    print '<div style="border:1px solid #F00;padding:5px;margin:5px;">';
    print '<p style="font-weight:bold;margin-bottom:10px;">Debug專區 :: </p>';
    print '<pre>'.print_r($str, true).'</pre>';
    print '</div>';
}
//紀錄LOG
function log_file($filename="", $level="INFO", $data=null){
	$path = "logs/";
	if(empty($filename))
		$filename = date("Y-m-d").".txt";
	else
		$filename = $filename."-".date("Y-m-d").".txt";
	if(!is_dir($path))
	{
		mkdir($path, 0775);
		chmod($path, 0775);
	}
	$file = $path.$filename;
	file_put_contents($file, date('Y-m-d H:i:s')."\t".$level."\t".$data."\r\n", FILE_APPEND);
}

