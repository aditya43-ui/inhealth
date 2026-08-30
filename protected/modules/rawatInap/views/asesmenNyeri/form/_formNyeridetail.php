<?php
/**
* - digunakan untuk menginput data asesmen nyeri
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*/
?>
<style>
	
	
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
</style>

<table class="table noborder paddingtext" style="text-align: center;">                    	
    <tr>             
		<td width='1px;'>
			&nbsp;
		</td>
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/0.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            0
            <br>
            Tidak Nyeri
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            &nbsp;
        </td>       
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/2.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            2
            <br>
            Sedikit Nyeri
        </td>
          <td style="text-align: center;line-height: 1.42857143 !important;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/4.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            4
            <br>
            Agak Menganggu
        </td>
          <td style="text-align: center;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/6.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            6
            <br>
            Menganggu
			<br>
			Aktifitas
        </td>
          <td style="text-align: center;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/8.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            8
            <br>
            Sangat
			<br>
			Menganggu
        </td>
          <td style="text-align: center;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/10.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br>
            10
            <br>
            Tak
			<br>
			Tertahankan
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
            <td colspan="12">
                <div class="control-group">
                        <label class="control-label">Skala Nyeri</label>
                        <div class="controls">                                    
                            <?php echo $form->textField($model,'score_skalanyeri',array('class'=>'span1','readonly'=>true,'style'=>'text-align:right;')) ?>
                        </div>
                        <div class="controls">                                    
                            <?php echo $form->textField($model,'keteranganskala_nyeri',array('class'=>'span3','readonly'=>true,'style'=>'text-align:left;')) ?>
                        </div>
                    </div>
            </td>
        </tr>
</table>
