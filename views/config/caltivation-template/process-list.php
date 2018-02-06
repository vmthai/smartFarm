<?php
if(!empty($dataProcess)){
	$inum=1;
	$maxall_period = (is_numeric($data->culti_period))?$data->culti_period:0;
	$persen_max = 100;
	$period_daytotal_old = 0;//จำนวนวัน process รวม ของ processที่แล้ว
	$persen_space_old = 0;//persen process ที่แล้ว
	$before_process_id = 0;//process id ก่อนหน้า
	$sum_process_budget = 0;
	$sum_process_period = 0;
	foreach($dataProcess as $item){
		$period_start = $item->period_start;
		$period_process = (is_numeric($item->period))?$item->period:0;
		$sum_process_budget += $item->budget;
		$sum_process_period += $period_process;

		//calculate persen
		$persen_process_full = 0;
		$persen_space_full = 0;
		$persen_process = 0;
		$persen_space = 0;
		if(is_numeric($period_start)){
			if($maxall_period != 0){
				if($period_start != 0){
					$persen_space = ($period_start / $maxall_period) * 100;
					$persen_space_full = $persen_space;
					$persen_space = round($persen_space, 2);
				}
				if($period_process != 0){
					$persen_process = ($period_process / $maxall_period) * 100;
					$persen_process_full = $persen_process;
					$persen_process = round($persen_process, 2);
				}
			} else {
				$persen_process_full = 0;
				$persen_space_full = 0;
				$persen_process = 0;
				$persen_space = 0;
			}
			//จำนวนวัน process รวมตั้งแต่เริ่ม
			$period_daytotal = ($period_start + $period_process);
		} else {
			$persen_space = $persen_space_old;
			$persen_space_full = $persen_space;
			$persen_space = round($persen_space, 2);
			if($maxall_period != 0){
				$persen_process = ($period_process / $maxall_period) * 100;
				$persen_process_full = $persen_process;
				$persen_process = round($persen_process, 2);
			} else {
				$persen_process_full = 0;
				$persen_space_full = 0;
				$persen_process = 0;
				$persen_space = 0;
			}
			//จำนวนวัน process รวมตั้งแต่เริ่ม
			$period_daytotal = ($period_daytotal_old + $period_process);
		}
		//check ว่าเกิน 100%
		if(($persen_process + $persen_space) > $persen_max){
			$persen_process = $persen_max - $persen_space;
		}
		
?>
<tr>
    <td class="text-truncate text-center">
    	<?=$inum;?>
    	<input type="hidden" id="before_process_id_<?=$item->id;?>" value="<?=$before_process_id;?>">
    	<input type="hidden" id="process_name_<?=$item->id;?>" value="<?=$item->name;?>">
    	<input type="hidden" id="period_daytotal_<?=$item->id;?>" value="<?=$period_daytotal;?>">
    </td>
    <td class="text-truncate"><?=$item->name;?></td>
    <td class="text-truncate text-right"><?=number_format($item->budget,2);?></td>
    <td class="text-truncate text-right"><?=number_format($period_process);?></td>
    <td class="text-truncate" style="vertical-align: middle;">
    	<progress class="progress progress-sm progress-success mt-0 mb-0" value="100" max="100" style="width: <?=$persen_process;?>%;margin-left: <?=$persen_space;?>%;"></progress>
    </td>
    <td class="text-truncate text-center">
    	<a class="btn btn-sm btn-outline-primary" href="javascript:fncEditProcess('<?=$item->id;?>');"><span class="icon-pencil2"></span></a>
    	<a class="btn btn-sm btn-outline-danger" href="javascript:fncClickDeltete('<?=$item->id;?>','<?=$inum;?>');"><span class="icon-bin2"></span></a>
    </td>
</tr>
<?php
		$persen_space_old = $persen_process_full + $persen_space_full;
		$period_daytotal_old = $period_daytotal;
		$before_process_id = $item->id;
		$inum++;
	}
}
?>
<tr>
	<th class="text-truncate text-center" colspan="2">รวมทั้งหมด</th>
	<th class="text-truncate text-right">
		<input type="hidden" id="total_processbudget" value="<?=$sum_process_budget;?>">
		<?=number_format($sum_process_budget,2);?>
	</th>
	<th class="text-truncate text-right"><?=number_format($sum_process_period);?></th>
	<th class="text-truncate text-center" colspan="2">&nbsp;</th>
</tr>