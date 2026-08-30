<?php

$criteria=new CDbCriteria;
$criteria->compare('LOWER(jadwaldokter_hari)', strtolower($hariCari));
if(!empty($idPegawai)){
	$criteria->addCondition("pegawai_id = ".$idPegawai);				
}
$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RJ);


$modJadwalDokter=  PPJadwaldokterM::model()->findAll($criteria);
if(count((array)$modJadwalDokter)>0){
    foreach ($modJadwalDokter as $i=>$data){ ?>
            <div id="jadwaljam_<?php echo $data->jadwaldokter_id; ?>">
                Jam Buka : <br>
                <?php echo CHtml::link($data->jadwaldokter_buka.' <i class="icon-form-ubah"></i>', 'javascript:void(0)', array('onclick'=>'ubahWaktu('.$data->jadwaldokter_id.',\''.$data->jadwaldokter_mulai.'\',\''.$data->jadwaldokter_tutup.'\')','rel'=>"tooltip", 'data-original-title'=>"Klik untuk Merubah Jam Buka"))?>
                
            </div>
            <div id="ubahjadwaljam_<?php echo $data->jadwaldokter_id; ?>" class="hide">
                Jam Buka : 
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'name'=>'jammulai_'.$data->jadwaldokter_id,
                                            'value'=>$data->jadwaldokter_mulai,
                                            'mode'=>'time',
                                            'options'=> array(
                                                'onSelect'=>'js:function(){}',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'jam dtPicker1', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?> s/d
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'name'=>'jamtutup_'.$data->jadwaldokter_id,
                                            'value'=>$data->jadwaldokter_tutup,
                                            'mode'=>'time',
                                            'options'=> array(
                                                'onSelect'=>'js:function(){}',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'jam dtPicker1', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                <?php echo CHtml::link('OK', 'javascript:void(0)', array('onclick'=>'prosesUbahWaktu('.$data->jadwaldokter_id.')','class'=>'btn'));?>
                <?php echo CHtml::link('Batal', 'javascript:void(0)', array('onclick'=>'batalUbahWaktu('.$data->jadwaldokter_id.',\''.$data->jadwaldokter_mulai.'\',\''.$data->jadwaldokter_tutup.'\')','class'=>'btn'));?>
            </div>
       <?php
       echo "Ruangan : ".$data->ruangan['ruangan_nama']."<br>";
       echo "Max Antrian : ".$data['maximumantrian']."<br><br>";
    }
}else{
    echo "-";
}

?>

<script type="text/javascript">
function ubahWaktu(idJadwal)
{
    $('#jadwaljam_'+idJadwal).addClass('hide');
    $('#ubahjadwaljam_'+idJadwal).removeClass('hide');
}

function batalUbahWaktu(idJadwal, jamMulai, jamTutup)
{
    $('#ubahjadwaljam_'+idJadwal).addClass('hide');
    $('#jadwaljam_'+idJadwal).removeClass('hide');
}

function prosesUbahWaktu(idJadwal)
{
    var jamMulai = $('#jammulai_'+idJadwal).val();
    var jamTutup = $('#jamtutup_'+idJadwal).val();
    $.post('<?php echo $this->createUrl('ubahJamBukaDokter') ?>', {idJadwal:idJadwal, jamMulai:jamMulai, jamTutup:jamTutup}, function(data){
        if(data.status=='OK')
            $.fn.yiiGridView.update('pencarianjadwal-grid');
        else
            myAlert('Gagal merubah Jadwal');
    }, 'json');
}
</script>