
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
        <td  style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/0.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br/>
            0
            <br/>
            Tidak Nyeri
            
        </td> 
        <td  style="text-align: center;line-height: 1.42857143 !important;">
            &nbsp;
        </td>       
        <td  style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/2.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br/>
            2
            <br/>
            Sedikit Nyeri 
        </td>
          <td  style="text-align: center;line-height: 1.42857143 !important;">
            
        </td> 
        <td  style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/4.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br/>
            4
            <br/>
            Agak Menganggu
        </td>
          <td  style="text-align: center;">
            
        </td> 
        <td  style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/6.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br/>
            6
            <br/>
            Menganggu
			<br>
			Aktifitas
        </td>
          <td  style="text-align: center;">
            
        </td> 
        <td  style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/8.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br/>
            8
            <br/>
            Sangat
			<br>
			Menganggu
        </td>
          <td  style="text-align: center;">
            
        </td> 
        <td  style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/10.png','',array('style'=>'max-width:100%;width:90px;')); ?>
            <br/>
            10
            <br/>
            Tak
			<br>
			Tertahankan
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
						<td width='<?php echo ($i == 10)?'1%':'8%'; ?>'><a style="position:relative; left:-5px;"  class="hover"><span style="padding: 4px; <?php echo (($model->score_skalanyeri==$i)? "border-radius: 5px; border: 1px solid black;":""); ?>" class="nyeri-nomor" id="nyerinomor_<?php echo $i; ?>" ><?php echo $i; ?></span></a></td>
					<?php
						}
					?>
				</tr>				
			</table>			
		</td>
	</tr>	
        <tr>
            <td colspan="12" style="color:black">
                Skala Nyeri
                <?php echo CHtml::activeTextField($model,'score_skalanyeri',array('class'=>'span1','readonly'=>true,'style'=>'text-align:right;')) ?>
                <?php echo CHtml::activeTextField($model,'keteranganskala_nyeri',array('class'=>'span3','readonly'=>true,'style'=>'text-align:left;')) ?>
            </td>
        </tr>
</table>
