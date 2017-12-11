<?php
//查詢現有指令功能
//20170116 add by fan
function help($linebot,$Token,$Text,$firebase){
	if ($Text=='/help'){
		$data = '現有指令：
===============
!add;關鍵字;回應';

		//純文字回覆
		line_reply($linebot,$Token,$data);
	}
	if ($Text=='/help list'){
		$value = $firebase->get('keywords/');
		if ($value!='null'){
			$value = json_decode($value,true);
			$data = '現有關鍵字：';
			foreach($value as $key => $item){
				$data .= '
				
['.$key.'] = '.$item['value'];
			}
			
			//純文字回覆
			line_reply($linebot,$Token,$data);
		}
	}
}
