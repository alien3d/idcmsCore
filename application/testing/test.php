<?php
// read from the text file 

$field = array(
				"dl_pm_no"=>14,
				"dl_ent_code"=>2,
				"dl_div_code"=>2,
				"dl_dept_code"=>4,
				"dl_trx_date"=>10,
				"dl_mdoc_no"=>10,
				"dl_mdoc_dt"=>10,
				"dl_ref_no"=>5,
				"dl_mtrxmode"=>1,
				"dl_trx_typ"=>2,
				"dl_type"=>1,
				"dl_status"=>1,
				"dl_kod_hasil"=>8,
				"dl_bank_acct"=>8,
				"dl_mdesc1"=>60,
				"dl_name"=>60,
				"dl_noic"=>14,
				"dl_mail_addr1"=>60,
				"dl_mail_addr2"=>60,
				"dl_mail_addr3"=>60,
				"dl_nofail"=>35,
				"dl_mdoc_amt"=>15,
				"start_date"=>10,
				"end_date"=>10
		);

		$lines = file('test1.txt');


foreach ($lines as $line_num => $line) {
	//echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
	
	foreach($field as $lengthChar) {
		//echo "ddd:[".$lengthChar."]<br>\n";
		
		$test[]=substr($line,$start,$lengthChar);
		$start =  $lengthChar + $start;
	//	print"----Start ".$start."--<br>";
	}
	echo "<br>-------------------baris baru -----------------<br>";
	echo "testing ".substr($line,15,2);
}
				
echo "<pre>";
echo print_r($test);
echo "</pre>";				
?>