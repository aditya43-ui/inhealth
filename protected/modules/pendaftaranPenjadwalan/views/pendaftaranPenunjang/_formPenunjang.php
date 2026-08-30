<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>

<?php 
$kp = $model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id);
$peg = $model->getDokterItems($modPasienMasukPenunjang->ruangan_id);
$modPasienMasukPenunjang->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;

if (count((array)$kp) == 1) $modPasienMasukPenunjang->jeniskasuspenyakit_id = $kp[0]->jeniskasuspenyakit_id;
if (count((array)$peg) == 1) $modPasienMasukPenunjang->pegawai_id = $peg[0]->pegawai_id;

echo $form->dropDownListRow($modPasienMasukPenunjang,'['.$i.']jeniskasuspenyakit_id', CHtml::listData($kp, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'['.$i.']kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcisPenunjang(".$i.");", 'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang,'['.$i.']kelaspelayanan_id'); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'['.$i.']pegawai_id',array('class'=>'control-label','label'=>'Dokter <span class="required">*</span>')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']pegawai_id', CHtml::listData($peg, 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    </div>
</div>
<?php
    if($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_RAD){
        echo CHtml::htmlButton(Yii::t('mds','{icon} Pilih Pemeriksaan',array('{icon}'=>'<i class="icon-edit icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', "onclick"=>"setChecklistPemeriksaan($('#form-masukpenunjang-".$i."'),".$i."); "));
    }else{
      echo CHtml::htmlButton(Yii::t('mds','{icon} Pilih Pemeriksaan',array('{icon}'=>'<i class="icon-edit icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanLab($('#form-masukpenunjang-".$i."'),".$i."); "));  
    }
?> 
<div id="form-tindakanpemeriksaan-<?php echo $i;?>" style="overflow-x: scroll;">
    <table class="table table-condensed table-bordered">
        <thead>
            <th>No.</th>
            <th>Nama Pemeriksaan</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Tarif</th>
            <th>Total Tarif</th>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

