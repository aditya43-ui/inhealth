
<style>
	#status-nyeri{
		margin-top: -5px;
	}

	#status-nyeri > label{
		font-size:13px !important;
	}

	.ruler-nyeri-tengah{
		border-left:1px solid #333 !important;
		border-top:1px solid #333 !important;
		border-right:1px solid #333 !important;
	}

	.ruler-nyeri-left{
		border-left:1px solid #333 !important;
	}
	.ruler-nyeri-right{
		border-right:1px solid #333 !important;
	}

	.nyeri-nomor{
		margin-left: -11px;
	}

	.borderradiusno {
    margin-left: -17px !important;
    padding: 5px;
    border: 1px solid #333;
    border-radius: 30%;
}

</style>

<table class="" style="text-align: center;width:100%;">
	<tr>
	<td width='1px;'>
		&nbsp;
	</td>
			<td  style="text-align: center;line-height: 1.42857143 !important;color:#333 !important;">
					<?php echo CHtml::image('images/icon_nyeri/0.png','',array('style'=>'max-width:100%;width:90px;')); ?>
					<br/>
					0
					<br/>
					tidak sakit

			</td>
			<td  style="text-align: center;line-height: 1.42857143 !important;color:#333 !important;color:#333 !important;">
					&nbsp;
			</td>
			<td  style="text-align: center;line-height: 1.42857143 !important;color:#333 !important;">
					<?php echo CHtml::image('images/icon_nyeri/2.png','',array('style'=>'max-width:100%;width:90px;')); ?>
					<br/>
					2
					<br/>
					sedikit sakit
			</td>
				<td  style="text-align: center;line-height: 1.42857143 !important;color:#333 !important;">

			</td>
			<td  style="text-align: center;line-height: 1.42857143 !important;color:#333 !important;">
					<?php echo CHtml::image('images/icon_nyeri/4.png','',array('style'=>'max-width:100%;width:90px;')); ?>
					<br/>
					4
					<br/>
					agak menganggu
			</td>
				<td  style="text-align: center;">

			</td>
			<td  style="text-align: center;line-height: 1.42857143 !important;color:#333 !important;">
					<?php echo CHtml::image('images/icon_nyeri/6.png','',array('style'=>'max-width:100%;width:90px;')); ?>
					<br/>
					6
					<br/>
					menganggu
		<br>
		aktifitas
			</td>
				<td  style="text-align: center;">

			</td>
			<td  style="text-align: center;line-height: 1.42857143 !important;color:#333 !important;">
					<?php echo CHtml::image('images/icon_nyeri/8.png','',array('style'=>'max-width:100%;width:90px;')); ?>
					<br/>
					8
					<br/>
					sangat
		<br>
		menganggu
			</td>
				<td  style="text-align: center;">

			</td>
			<td  style="text-align: center;line-height: 1.42857143 !important;color:#333 !important;">
					<?php echo CHtml::image('images/icon_nyeri/10.png','',array('style'=>'max-width:100%;width:90px;')); ?>
					<br/>
					10
					<br/>
					tak
		<br>
		tertahankan
			</td>
	</tr>

	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12" style="margin-left:10px;">
			<table width='100%'>
				<tr>
					<td class='ruler-nyeri-left'></td>
					<td class=''></td>
					<td class=''></td>
					<td class=''></td>
					<td class=''></td>
					<td class=''></td>
					<td class=''></td>
					<td class=''></td>
					<td class=''></td>
					<td class='ruler-nyeri-right'></td>
				</tr>
				<tr>
					<td class='ruler-nyeri-tengah'></td>
					<td class='ruler-nyeri-tengah'></td>
					<td class='ruler-nyeri-tengah'></td>
					<td class='ruler-nyeri-tengah'></td>
					<td class='ruler-nyeri-tengah'></td>
					<td class='ruler-nyeri-tengah'></td>
					<td class='ruler-nyeri-tengah'></td>
					<td class='ruler-nyeri-tengah'></td>
					<td class='ruler-nyeri-tengah'></td>
					<td class='ruler-nyeri-tengah'></td>
				</tr>
				<tr>

					<?php

						for($i=0;$i<=10;$i++){
					?>
						<td width='<?php echo ($i == 10)?'1%':'8%'; ?>'><a class=""><span class="nyeri-nomor <?php echo (($model->skala_wongbaker_nrs==$i)? 'borderradiusno':''); ?>" id="nyerinomor_<?php echo $i; ?>" ><?php echo $i; ?></span></a></td>
					<?php
						}
					?>
				</tr>
			</table>

			<table>
				<tr>
					<tr>
						<td width="16%">
                <label><span class="nyeri-nomor">Tidak Ada nyeri</span></label>
						</td>
						<td width="8%">&nbsp;</td>
						<td width="8%">&nbsp;</td>
						<td width="8%" colspan="">
              <label><span class="nyeri-nomor">Nyeri sedang</span></label>
						</td>
						<td width="8%">&nbsp;</td>
						<td width="8%">&nbsp;</td>
						<td width="8%">&nbsp;</td>
						<td width="3%">&nbsp;</td>
						<td width="16%">
              <label>nyeri sangat besar</label>
						</td>
					</tr>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table  style="width:100%;">
	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
				<label><a class="umurlebih" class=""><?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_1 ?></a></label>
		</td>
	</tr>
	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<label><span id="nyerilebih_0_1" min="0" max="1"> 0 - 1 &nbsp;  = sangat bahagia karena tidak merasa nyeri sama sekali </span></label>
		</td>
	</tr>
	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<label><span id="nyerilebih_2_3" min="2" max="3"> 2 - 3 &nbsp; = sedikit nyeri		</span></label>
		</td>
	</tr>
	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<label><span id="nyerilebih_4_5"  min="4" max="5"> 4 - 5 &nbsp; = cukup nyeri				</span></label>
		</td>
	</tr>
	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<label><span id="nyerilebih_6_7"  min="6" max="7"> 6 - 7  &nbsp; = lumayan nyeri			</span></label>
		</td>
	</tr>
	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<label><span id="nyerilebih_8_9"  min="8" max="9"> 8 - 9 &nbsp;  = sangat nyeri</span></label>
		</td>
	</tr>
	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<label><span id="nyerilebih_10"  min="10" max="10"> 10 &nbsp; &nbsp; &nbsp;   = amat sangat nyeri (tak tertahankan)		</span></label>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
