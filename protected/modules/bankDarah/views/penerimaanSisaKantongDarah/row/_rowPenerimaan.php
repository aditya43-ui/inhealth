<tr>
    <!--<td>
        <label><?php //echo $det['no_identitas']; ?></label>
    </td>        
    <td>
        <label><?php //echo $det['no_pendonor']; ?></label>
    </td>-->
    <td>
        <label><?php echo $det['gol_darah']; ?></label>
    </td>
    <td>
        <label><?php echo $det['rhesus']; ?></label>
    </td>
    <td>
        <label><?php echo $det['jenisterima_nama']; ?></label>
    </td>
    <!--<td><label>
        <?php
//            echo "<ul>";
//            foreach($det['det'] as $d){
//                echo "<li>".$d['no_kantongdarah']."</li>";
//            }
//            echo "</ul>";
        ?>
        </label>
    </td>-->
    <td>
        <label><?php echo $det['no_kirimkantong']; ?></label>
    </td>
    <td>
        <label class="nomorbarcode"><?php echo $det['nomorbarcode']; ?></label>
        <?php            
            echo CHtml::activeHiddenField($model, '[0]nomorbarcode_sample',array('class'=>'nomorbarcode_sample')); 
            echo "<div class='banyak-komponen'>";
            foreach($det['det'] as $d){
                $model->terimakantongdet_id = $d['terimakantongdet_id'];
                echo CHtml::activeHiddenField($model, '[0][detail][0]terimakantongdet_id');
            }
            echo "</div>";                                                           
        ?>
    </td>
    <td>
        <?php         
            if ($model->sampel_utama==true){
                echo CHtml::checkBox('sampel_utama',true,array('disabled'=>true));  
            }else{
                echo CHtml::activeCheckBox($model, '[0]sampel_utama',array());  
            }
        ?>
    </td>
    <td>
        <?php 
            if ($model->sampel_konfirmasi==true){
                echo CHtml::checkBox('sampel_konfirmasi',true,array('disabled'=>true));  
            }else{
                echo CHtml::activeCheckBox($model, '[0]sampel_konfirmasi',array()); 
            }
        ?>    
    </td>
    <td>
        <?php 
            if ($model->sampel_imltd==true){
                echo CHtml::checkBox('sampel_imltd',true,array('disabled'=>true));  
            }else{
                echo CHtml::activeCheckBox($model, '[0]sampel_imltd',array()); 
            }
        ?>                
    </td>
</tr>