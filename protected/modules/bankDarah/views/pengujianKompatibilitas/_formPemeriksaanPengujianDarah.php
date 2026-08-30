<?php
 $tgl_pengujian='';
 $nama_penguji ='';
 $anti_a ='';
 $anti_b ='';
 $anti_d ='';
 $kesimpulan ='';
  if(isset($modUjiDarah)) {
      $tgl_pengujian = isset($modUjiDarah->tglujidarahpasien) ? $format->formatDateTimeForUser($modUjiDarah->tglujidarahpasien) : ' ';
      $modPegawai = isset($modUjiDarah->peg_pemeriksa_id) ? PegawaiM::model()->findByPk($modUjiDarah->peg_pemeriksa_id) : ' ';
      $nama_penguji = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : ' ';
      $anti_a = isset($modUjiDarah->anti_a) ? $modUjiDarah->anti_a : ' ';
      $anti_b = isset($modUjiDarah->anti_b) ? $modUjiDarah->anti_b : ' ';
      $anti_d = isset($modUjiDarah->anti_d) ? $modUjiDarah->anti_d : ' ';
      $kesimpulan = isset($modUjiDarah->kesimpulan_uji) ? $modUjiDarah->kesimpulan_uji : ' ';
  }

?>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Waktu Pengujian','',array('class'=>'control-label')); ?>
             <div class="controls">
           <?php echo CHtml::textField('tgl_pengujian',$tgl_pengujian,array('readonly'=>true))?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Anti A','',array('class'=>'control-label')); ?>
             <div class="controls">
           <?php echo CHtml::textField('anti_a',$anti_a,array('readonly'=>true))?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Anti B','',array('class'=>'control-label')); ?>
             <div class="controls">
           <?php echo CHtml::textField('anti_b',$anti_b,array('readonly'=>true))?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Anti D','',array('class'=>'control-label')); ?>
             <div class="controls">
           <?php echo CHtml::textField('anti_d',$anti_d,array('readonly'=>true))?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Kesimpulan','',array('class'=>'control-label')); ?>
             <div class="controls">
           <?php echo CHtml::textArea('kesimpulan',$kesimpulan,array('readonly'=>true))?>
        </div>
    </div>
</div>