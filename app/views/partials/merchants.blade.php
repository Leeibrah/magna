<div id='merchantlinks'>
<hr style="margin: 24pt; border-top: 1px solid #999;">
<p style='margin-top: 20pt; color: dimgray'>Click any site below to shop</p>

<?php

	$merchantarray = DB::table('merchants')->get();
	foreach ($merchantarray as $merchant) {
		echo '<a href="'.$merchant->url.'"><img src="'.asset($merchant->logo).'"/></a>';
	}

?>

</div>