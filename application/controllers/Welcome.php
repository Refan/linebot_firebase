<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		//firebase設定
		$baseURI = $this->config->config['firebase_url'];
		$token = $this->config->config['firebase_token'];
		$this->firebase = new \Firebase\FirebaseLib($baseURI, $token);
		
		//linebot設定
		$channelAccessToken = $this->config->config['line_token'];
		$channelSecret = $this->config->config['line_secret'];
		$this->linebot = new LINEBotTiny($channelAccessToken, $channelSecret);
		
		//設定功能名稱
		$this->config = array(
			'firebase',			//核心-撈firebase資料庫
			'help',				//help查詢指令
		);
	}
	
	public function index()
	{
		//讀取各功能
		load_func($this->config);

		//讀取line訊息
		foreach ($this->linebot->parseEvents() as $event) {
			log_file('LOG','',json_encode($event));
			$tmp = json_encode($event);
			switch ($event['type']) {
				case 'message':
					$message = $event['message'];
					switch ($message['type']) {
						//文字訊息
						case 'text':
							//讀取載入func裡的function
							foreach ($this->config as $key => $item){
								if(function_exists($item)){
									$item($this->linebot,$event['replyToken'],$message['text'],$this->firebase);
								}
							}
							break;
					}
					break;
			}
		};
		
	}

	//主動推播，須先知道推播對象ID
	public function push()
	{
		$str = $_GET['text'];
		if (!empty($str)){
			line_push($this->linebot,'C0be88ec69c2b4f3883db7d8e564f0f70',$_GET['text']);
		}
	}
}
