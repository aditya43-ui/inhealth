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
    
    .tab2 > tbody > tr > td {
        border: none !important;
        border-left: none !important;
    }
    
    .borderradiusno {
        margin-left: -17px !important;
        padding: 5px;
        border: 1px solid #333;
        border-radius: 30%;
    }
    
    .borderradius {
        padding: 5px;
        border: 1px solid #333;
        border-radius: 30%;
    }
</style>

<table class="table tab2 noborder paddingtext" style="text-align: center;">                    
    <tr>             
		<td width='1px;'>
			&nbsp;
		</td>
        <td style="width: 16.6%; text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/0.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            0
            <br>
            tidak sakit
            
        </td>       
        <td style="width: 16.6%; text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/2.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            2
            <br>
            sedikit sakit 
        </td>
        <td style="width: 16.6%; text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/4.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            4
            <br>
            agak menganggu
        </td>
        <td style="width: 16.6%; text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/6.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            6
            <br>
            menganggu
			<br>
			aktifitas
        </td>
        <td style="width: 16.6%; text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/8.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            8
            <br>
            sangat
			<br>
			menganggu
        </td> 
        <td style="width: 16.6%; text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/10.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            10
            <br>
            tak
			<br>
			tertahankan
        </td>
    </tr>   
     <!--<tr>       
         <?php
           // for ($i=0;$i<=10;$i++){
         ?>
            <td style="text-align: center;line-height: 1.42857143 !important;">
                <?php //echo CHtml::radioButton('gambarNyeri',($modFisik->skala_wongbaker_nrs == $i)?true:false,array('onclick'=>'getScalaNyeri(this);','value'=>$i)); ?>               
                <br>
                <?php //echo $i; ?>
             </td> 
         <?php
           // }
         ?>
                        
    </tr>-->	
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
						<td width='<?php echo ($i == 10)?'1%':'8%'; ?>' style="border: none;"><span class="nyeri-nomor <?php echo ($i == $modFisik->skala_wongbaker_nrs) ? "borderradiusno" : "";?>"><?php echo $i; ?></span></td>
					<?php
						}
					?>
				</tr>				
			</table>
			
			<table>
				<tr>
					<tr>
						<td width="16%">
							<span class="nyeri-nomor">Tidak Ada nyeri</span>
						</td>
						<td width="8%" style="border: none;">&nbsp;</td>						
						<td width="8%" style="border: none;">&nbsp;</td>
						<td width="8%" colspan="" style="border: none;">
							<span class="nyeri-nomor">Nyeri sedang</span>
						</td>
						<td width="8%" style="border: none;">&nbsp;</td>
						<td width="8%" style="border: none;">&nbsp;</td>
						<td width="8%" style="border: none;">&nbsp;</td>						
						<td width="3%" style="border: none;">&nbsp;</td>						
						<td width="16%" style="border: none;"> 
							nyeri sangat besar
						</td>
					</tr>
				</tr>
			</table>
		</td>
	</tr>		
</table>

<?php 

if ($modFisik->skalanyeri_statusumur == Params::SKALA_NYERI_BERDASARKAN_UMUR_2) {

    echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan/rehab/_formNyeriFlaCcsDetail',array(
            'dataFlaCcs'=>$dataFlaCcs,
            //'modAsesTriase'=>$modAsesTriase,
            'modFlaCcs'=>$modFlaCcs,		
            'getFlaCcs'=>$getFlaCcs),true); 

} else { ?>
<table class="table tab2 noborder">
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_0_1" <?php echo in_array($modFisik->skala_wongbaker_nrs, array(0, 1)) ? 'class="borderradius"' : ''; ?>> 0 - 1 &nbsp;  = sangat bahagia karena tidak merasa nyeri sama sekali </span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_2_3" <?php echo in_array($modFisik->skala_wongbaker_nrs, array(2, 3)) ? 'class="borderradius"' : ''; ?>> 2 - 3 &nbsp; = sedikit nyeri		</span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_4_5" <?php echo in_array($modFisik->skala_wongbaker_nrs, array(4, 5)) ? 'class="borderradius"' : ''; ?>> 4 - 5 &nbsp; = cukup nyeri				</span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_6_7" <?php echo in_array($modFisik->skala_wongbaker_nrs, array(6, 7)) ? 'class="borderradius"' : ''; ?>> 6 - 7  &nbsp; = lumayan nyeri			</span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_8_9" <?php echo in_array($modFisik->skala_wongbaker_nrs, array(8, 9)) ? 'class="borderradius"' : ''; ?>> 8 - 9 &nbsp;  = sangat nyeri</span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_10" <?php echo ($modFisik->skala_wongbaker_nrs >= 10) ? 'class="borderradius"' : ''; ?>> 10 &nbsp; &nbsp; &nbsp;   = amat sangat nyeri (tak tertahankan)		</span>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<?php } ?>
