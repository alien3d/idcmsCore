<?php
$a=range("1","8");
foreach ($a as $x) {
 	 $str.="'-',{
 	   xtype:'button',
 	   text:'".$x."',
 	   tooltip:'".$x."',
 	   handler: function (button,e) { 
	   		generalLedgerChartOfAccountStore.reload({
				params : {
					leafId : leafId,
					start : 0,
					limit : perPage,
					character : '".$x."' 
				}
		});
	}	
	},";
}
echo substr($str,0,-1);
?>