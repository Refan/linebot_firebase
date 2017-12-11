<?php
//固定文字回應
//20170116 add by fan
function firebase($linebot,$Token,$Text,$firebase){
	if (strpos($Text, "!add")===false){
		//讀取
		$value = $firebase->get('keywords/'.urlencode($Text));
		if ($value!='null'){
			// sleep(rand(1,5));
			$value = json_decode($value,true);
			$data = $value['value'];
			
			//純文字回覆
			line_reply($linebot,$Token,$data);
		}
	}else{
		//寫入
		$value = explode(';',$Text,3);
		$firebase->set('keywords/'.urlencode($value[1]).'/value', $value[2]);
		
		$data = '好喔~好喔~';
		
		//純文字回覆
		line_reply($linebot,$Token,$data);
	}
}
