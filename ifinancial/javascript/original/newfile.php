<?php
$a=range("A","Z");
foreach ($a as $x) {
 	 $str.="'-',{
 	   xtype:'button',
 	   text:'".$x."',
 	   tooltip:'".$x."',
 	   handler: function (button,e) { 
	   		generalLedgerChartOfAccountSegmentStore.reload({
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