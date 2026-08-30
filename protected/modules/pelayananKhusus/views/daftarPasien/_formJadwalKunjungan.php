<?php  ?>
<fieldset class="box">
    <legend class="rim">Jadwal Kunjungan Rehab Medis</legend>    
    <div class="control-group" style="display: <?php echo (!empty($listJadwalKunjungan)) ? 'none' : 'block' ?>">
        <?php echo CHtml::label('Lama Terapi Kunjungan', 'lamaterapi',array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textfield('lamaterapi', '',array('style'=>'width:100px')) ?> <strong>Kali Kunjungan</strong>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} ',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-success','onClick'=>'generateJadwal()','rel'=>'tooltip','data-title'=>'Klik untuk membuat jadwal kunjungan')); ?>
        </div>
    </div>
    <div class="block-tabel">
        <h6>Detail <b>Jadwal Kunjungan</b></h6>
        <table class="table table-striped table-condensed" id="tblDetailjadwal">
            <tr>
                <th>No. Urut</th>
                <th>Tgl. Jadwal Kunjungan</th>
                <th>Jenis - Tindakan</th>
                <th>Paramedis</th>
                <th>Dokter</th>
                <?php if(!empty($listJadwalKunjungan)){?>
                <th>Status Terapi</th>
                <?php } ?>
            </tr>
            <?php 
                if(!empty($listJadwalKunjungan))
                {
                    foreach ($listJadwalKunjungan as $jadwalKunjungan) {
            ?>
            <tr>
                <td><?php echo $jadwalKunjungan->nourutjadwal ?></td>
                <td><?php echo $jadwalKunjungan->harijadwalrm.' - '.$jadwalKunjungan->tgljadwalrm ?></td>
                <?php $tindakans = HasilpemeriksaanrmT::model()->findAllByAttributes(array('jadwalkunjunganrm_id'=>$jadwalKunjungan->jadwalkunjunganrm_id)) ?>
                <td>
                <?php 
                    foreach ($tindakans as $tindakan) {
                        $t = TindakanrmM::model()->with('jenistindakanrm')->findByPk($tindakan->tindakanrm_id);
                        echo $t->jenistindakanrm->jenistindakanrm_nama.' - ';
                        echo $t->tindakanrm_nama.'</br>';
                    } 
                ?>
                </td>
                <td>
                    <?php echo (!empty($jadwalKunjungan->paramedis1_id)) ?  ParamedisV::model()->findByAttributes(array('pegawai_id'=>$jadwalKunjungan->paramedis1_id))->nama_pegawai.' dan ' : '-' ?>
                    <?php echo (!empty($jadwalKunjungan->paramedis2_id)) ?  ParamedisV::model()->findByAttributes(array('pegawai_id'=>$jadwalKunjungan->paramedis2_id))->nama_pegawai : '-' ?>
                </td>
                <td>
                    <?php echo (!empty($jadwalKunjungan->pegawai_id)) ? DokterV::model()->findByAttributes(array('pegawai_id'=>$jadwalKunjungan->pegawai_id))->nama_pegawai : '-' ?>
                </td>
                <td>
                    <?php echo ($jadwalKunjungan->statusterapi) ? 'Sudah' : 'Belum' ?>
                </td>
            </tr>
            <?php            
                    }
                }
            ?>
        </table>
    </div>        
</fieldset>
        
<div id="tglPatokan" style="display: none">
    <?php  $this->widget('MyDateTimePicker',array(
			'name'=>'tes',
			'value'=>'',
			'mode'=>'datetime',
			'options'=> array(
				'dateFormat'=>Params::DATE_FORMAT,
			),
			'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
    )); ?>
</div>
        
<script>
    
function generateJadwal()
{
    var lamaTerapi = $('#lamaterapi').val();
    var pasienmasukpenunjang_id = <?php echo $id; ?>
    
    if(lamaTerapi == ''){
                myAlert('Anda Belum Memilih Lama Terapi Kunjungan');
                $('#lamaterapi').addClass('error').focus();
	}else{
        jQuery.ajax({'url':'<?php echo $this->createUrl('loadFormJadwalKunjunganAwal')?>',
			'data':{pasienmasukpenunjang_id:pasienmasukpenunjang_id, lamaTerapi:lamaTerapi},
			'type':'post',
			'dataType':'json',
			'success':function(data) {
			   if(data.pesan == ''){
					$('#tblDetailjadwal tr:not(:first)').remove();
					$('#tblDetailjadwal').append(data.form);
				   jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
				   jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','minDate'  : 'd','timeText':'Waktu','hourText':'Jam',
					   'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
			   }else{
				   myAlert(data.pesan);
				   return false;
			   }
			} ,
		'cache':false});
	}  
}
</script>