<?php
if(count($dataHasilPemeriksaanPAs) > 0){
    foreach($dataHasilPemeriksaanPAs AS $i => $pemeriksaan){
        if ($pemeriksaan['statushasilpemeriksaan'] == Params::STATUS_PEMERIKSAAN_PA_KRITIS) {
            $pemeriksaan->statushasilpemeriksaan = 1;
        } 
//        $trpemeriksaan = false;
//        if($i == 0){
//            echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$dataHasilPemeriksaanPAs[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
//        }else if(($i) < count($dataHasilPemeriksaanPAs)){
//            if($dataHasilPemeriksaanPAs[$i]->pemeriksaanlab_id != $dataHasilPemeriksaanPAs[$i-1]->pemeriksaanlab_id){
//                echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$dataHasilPemeriksaanPAs[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
//            }
//        }
        
    $pemeriksaan->tglperiksapa = $format->formatDateTimeForUser($pemeriksaan->tglperiksapa);
?>   
    <tr>
        <td>
            <?php echo CHtml::textField('no_urut',0,array('class'=>'span1 integer','style'=>'width:24px;')) ?>
            <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']hasilpemeriksaanpa_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']tindakanpelayanan_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']pemeriksaanlab_id',array('readonly'=>true)) ?>
        </td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']nosediaanpa',array('placeholder'=>'Ketik Hasil Pemeriksaan','class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td>
            <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $pemeriksaan,
                        'attribute' => '[' . $i . ']tglperiksapa',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker1 tglperiksapa', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ,'width'=>'100px;'),
                    ));
                    ?>
            <?php //echo CHtml::activeTextField($pemeriksaan,'['.$i.']tglperiksapa',array('readonly'=>true,'class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo $pemeriksaan->pemeriksaanlab->pemeriksaanlab_nama; ?></td>
        <td><?php echo CHtml::activeTextArea($pemeriksaan,'['.$i.']makroskopis',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextArea($pemeriksaan,'['.$i.']mikroskopis',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextArea($pemeriksaan,'['.$i.']kesimpulanpa',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextArea($pemeriksaan,'['.$i.']saranpa',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextArea($pemeriksaan,'['.$i.']catatanpa',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeCheckBox($pemeriksaan,'['.$i.']statushasilpemeriksaan',array('class'=>'span1', 'rel' => 'tooltip', 'title' => 'Pilih untuk mengubah status pemeriksaan menjadi Kritis' ,'onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
    </tr>
<?php        
    }
}
?>

