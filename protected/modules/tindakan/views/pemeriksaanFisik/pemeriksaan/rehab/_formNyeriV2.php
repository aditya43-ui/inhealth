<?php
/**
* - digunakan untuk menginput data asesmen nyeri
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
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
    }
</style>

<table class="table tab2 noborder paddingtext" style="text-align: center;">                    
	<tr>		
        <td colspan="3">
			<div class="control-group">
				Apakah Ada Nyeri :
			</div>
        </td>
        <td colspan="2">                
			<div class="control-group" id="status-nyeri">
			<?php echo $form->radioButton($modFisik,'keluhan_nyeri',array('id'=>'nyeriNo','value'=>0,'onkeypress'=>"return $(this).focusNextInputField(event);", 'onchange'=>'resetNyeri(this);')); ?> <label>tidak</label>       				                      
			</div>
        </td>
		<td colspan="7">                       			        
			<div class="control-group" id="status-nyeri">
			<?php echo $form->radioButton($modFisik,'keluhan_nyeri',array('id'=>'nyeriYes','value'=>1,'onkeypress'=>"return $(this).focusNextInputField(event);", 'onchange'=>'resetSkala(this);')); ?>  <label>ya, skor nyeri</label>       	<?php echo $form->textField($modFisik,'skala_wongbaker_nrs', array('onblur'=>'getSkala(this)','class'=>'span1 integer', 'style'=>'text-align:right;')); ?>			                      
			</div>
        </td>
    </tr>
    <tr>             
		<td width='1px;'>
			&nbsp;
		</td>
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/0.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            0
            <br>
            tidak sakit
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            &nbsp;
        </td>       
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/2.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            2
            <br>
            sedikit sakit 
        </td>
          <td style="text-align: center;line-height: 1.42857143 !important;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/4.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            4
            <br>
            agak menganggu
        </td>
          <td style="text-align: center;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/6.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            6
            <br>
            menganggu
			<br>
			aktifitas
        </td>
          <td style="text-align: center;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/8.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            8
            <br>
            sangat
			<br>
			menganggu
        </td>
          <td style="text-align: center;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
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
						<td width='<?php echo ($i == 10)?'1%':'8%'; ?>'><a onclick="getNomor(<?php echo $i; ?>)" class="hover"><span class="nyeri-nomor" id="nyerinomor_<?php echo $i; ?>"><?php echo $i; ?></span></a></td>
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
						<td width="8%">&nbsp;</td>						
						<td width="8%">&nbsp;</td>
						<td width="8%" colspan="">
							<span class="nyeri-nomor">Nyeri sedang</span>
						</td>
						<td width="8%">&nbsp;</td>
						<td width="8%">&nbsp;</td>
						<td width="8%">&nbsp;</td>						
						<td width="3%">&nbsp;</td>						
						<td width="16%"> 
							nyeri sangat besar
						</td>
					</tr>
				</tr>
			</table>
		</td>
	</tr>		
</table>

<table class="table tab2 noborder">
	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<a class="umurlebih hover" onclick="cekUmur('<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_1 ?>','lebih');" class="hover"><?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_1 ?></a>						
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_0_1" min="0" max="1"> 0 - 1 &nbsp;  = sangat bahagia karena tidak merasa nyeri sama sekali </span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_2_3" min="2" max="3"> 2 - 3 &nbsp; = sedikit nyeri		</span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_4_5"  min="4" max="5"> 4 - 5 &nbsp; = cukup nyeri				</span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_6_7"  min="6" max="7"> 6 - 7  &nbsp; = lumayan nyeri			</span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_8_9"  min="8" max="9"> 8 - 9 &nbsp;  = sangat nyeri</span>
		</td>
	</tr>
	<tr>		
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">
			<span id="nyerilebih_10"  min="10" max="10"> 10 &nbsp; &nbsp; &nbsp;   = amat sangat nyeri (tak tertahankan)		</span>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width='1px;'>
			&nbsp;
		</td>
		<td colspan="12">			
			<a class="umurkurang hover" onclick="cekUmur('<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_2 ?>','kurang');" class="hover"><?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_2 ?></a>						
		</td>
	</tr>	
</table>

<?php echo $form->hiddenField($modFisik,'skalanyeri_statusumur', array('readonly'=>true)); ?>

<?php echo $this->renderPartial($this->path_view.'pemeriksaan/rehab/_formNyeriFlaCcs',array(
		'dataFlaCcs'=>$dataFlaCcs,
		'form'=>$form,
		//'modAsesTriase'=>$modAsesTriase,
		'modFlaCcs'=>$modFlaCcs,		
		'getFlaCcs'=>$getFlaCcs),true); ?>

<?php /*
<table class="table noborder">
    
    <tr>
        <td colspan="3">
            Skala Wong Baker / NSR
        </td>
        <td>
            <?php echo $form->textField($modFisik,'skala_wongbaker_nrs',array('readonly'=>true,'class'=>'col-sm-2','style'=>'text-align:right;')) ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Apakah Terdapat Nyeri Berpindah - pindah
        </td>
        <td>
             
            <?php
                echo $form->radioButtonList($modFisik, 'rasanyeri_berpindah', array(1=>'Ya',0=>'Tidak'));
                ?>
             
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Berapa Lama Nyeri
        </td>
        <td >
            <?php //echo $form->dropDownList($modFisik,'lama_nyeri', LookupM::getItems('lama_nyeri'),array('empty' => '-- Pilih --')); ?>
            <?php echo $form->textField($modFisik,'lama_nyeri',array()); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Seberapa Sering Mengalami Nyeri ? Berapa Lama
        </td>
        <td >
            <?php //echo $form->dropDownList($modFisik,'seringmengalami_nyeri', LookupM::getItems('seringmengalami_nyeri'),array('empty' => '-- Pilih --')); ?>
            <?php echo $form->textField($modFisik,'seringmengalami_nyeri',array()); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Apa yang Membuat Nyeri Berkurang atau Bertambah Parah ?
        </td>
        <td>
            <?php //echo $form->dropDownList($modFisik,'penyebabberkurang_nyeri', LookupM::getItems('penyebabberkurang_nyeri'),array('empty' => '-- Pilih --')); ?>
            <?php echo $form->textField($modFisik,'penyebabberkurang_nyeri',array()); ?>
        </td>
    </tr>
    <tr>
        <td>
            Rasa Nyeri
        </td>
        <td>
            <label class="checkbox inline">
                <span>Tajam</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_tajam') ?>                
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Ditusuk</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_ditusuk') ?>
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Berdenyut</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_berdenyut') ?>
          </label>
        </td>
        <td>
            <label class="checkbox inline">
                <span>Nyeri Tumpul</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_tumpul') ?>                
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Dibakar</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_dibakar') ?>
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Ditikam</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_ditikam') ?>
          </label>
        </td>
        <td>
            <label class="checkbox inline">
                <span>Seperti Ditarik</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_ditarik') ?>                
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Dipukul</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_dipukul') ?>
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Kram</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_kram') ?>
          </label>
        </td>
    </tr>
</table>
*/
