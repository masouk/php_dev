<?php
	/*
	 * chinese char substring
	 * 中文字與英文字夾雜時，需取之簡稱
	 * 
	 */
	 
	$content = "要截取的文字內容，中文字為2-3byte，英數字1byte";
	echo "原始內容:".$content."<br>";
	echo "--------------------------------<br>";
	$words = 20; //要截取之byte
	
	$select_words = 0; //截取之byte
	$brief = ""; //截取結果
	$pos = 0; //中文字關係所以透過mb_substr 逐字截取
	
	//如預取之字串byte沒那麼多時
	if(strlen($content) < $words){
		$words = strlen($content);
	}
	
	while($select_words < $words){
		$char = mb_substr($content,$pos,1,"UTF-8"); //中文字在 BIG5 編碼是 2 byte，在 UTF-8 要 3 byte
		
		$select_words += strlen($char); 
		if($select_words > $words){
			$select_words -= strlen($char);
			break;
		}
		echo "內容:".$char." byte:".strlen($char)."<br>";
		$brief .= $char;
		$pos++;
	}
	echo "--------------------------------<br>";
	echo "截取數:".$select_words."<br>";
	echo "結果:".$brief;

?>
