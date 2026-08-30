
<?php
if (count((array)$modPengpegdets) > 0 && empty($id)) :
foreach($modPengpegdets as $i=>$modPengpegdet) {
//    $id_occupation = $modPengpegdet->occupation_id;
//    $occopation = OccupationM::model()->findByPk($id_occupation);
//    $modPengpegdet->occupation = $occopation->occupation_nama;
?>

<tr>
        <td><?php echo CHtml::activeTextField($modPengpegdet,'[$i]nourut',array('class'=>'span1', 'readonly'=>true, 'style'=>'text-align:right')); //echo $modPengpegdet->nourut;?></td>
<!--<td><?php //echo $occopation->occupation_nama;?>
            <?php // echo CHtml::activeHiddenField($modPengpegdet,'[$i]occupation_id');?>
                <div style="float:left;">
                    <?php
//                        $this->widget('MyJuiAutoComplete',array(
//                            'model'=>$modPengpegdet,
//                            'attribute'=>'[$i]occupation',
//                            'sourceUrl'=>  Yii::app()->createUrl('ActionAutoComplete/OccupationKP'),
//                            'options'=>array(
//                                'showAnim'=>'fold',
//                                'minLength'=>2,
//                                'select'=>'js:function( event, ui ) {
//                                        $("#DetailpengkaryawanT_occupation_id").val(ui.item.occupation_id);
//                                            }',
//                            ),
//                            'tombolDialog'=>array('idDialog'=>'dialogOccupation'),
//                            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','style'=>'float:left;')
//                        ));
                    ?>
                </div>
        </td>-->
        <td><?php echo CHtml::activeTextField($modPengpegdet,'[$i]jmlorang',array('class'=>'numbers-only span1  required', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>3, 'style'=>'text-align:right')); //echo $modPengpegdet->jmlorang;  ?></td>
        <td><?php echo CHtml::activeTextArea($modPengpegdet,'[$i]untukkeperluan', array('style'=>'resize:none;','rows'=>2, 'cols'=>20, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);")); //echo $modPengpegdet->untukkeperluan;?></td>
        <td><?php echo CHtml::activeTextArea($modPengpegdet,'[$i]keterangan', array('style'=>'resize:none;','rows'=>2, 'cols'=>20, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);")); //$modPengpegdet->keterangan; ?></td>
        <td><?php echo CHtml::activeCheckBox($modPengpegdet,'[$i]disetujui', array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);"));?></td>
        <td>
            <?php             
//            if($removeButton){
//                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan')); 
//                echo "<br><br>";
//                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
//            } 
//            else {
//                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan'));
//            }
        ?>
        </td>
    </tr>
            
            
<?php } 
endif;
if(count((array)$modPengpegdets) > 0 && !empty($id)){
    ?>
    <thead>
        <tr>
            <th>No. Urut</th>
            <th>Jabatan/ Pekerjaan</th>
            <th>Jumlah Orang</th>
            <th>Untuk Keperluan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <?php
    foreach($modPengpegdets as $i=>$modPengpegdet) {
//    $id_occupation = $modPengpegdet->occupation_id;
//    $occopation = OccupationM::model()->findByPk($id_occupation);
?>

<tr>
        <td><?php echo $modPengpegdet->nourut;?></td>
        <td><?php // echo $occopation->occupation_nama;?>
            
        </td>
        <td><?php echo $modPengpegdet->jmlorang;  ?></td>
        <td><?php echo $modPengpegdet->untukkeperluan;?></td>
        <td><?php echo $modPengpegdet->keterangan; ?></td>
        <td><?php echo $modPengpegdet->disetujui; ?></td>
        
    </tr>
            
            
<?php } 
}
?>