<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>

<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'['.$i.']jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'['.$i.']kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis(".$i.");", 'class'=>'span3')); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'['.$i.']pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']pegawai_id', CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Analis','perawat_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']perawat_id', CHtml::listData(BDPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    </div>
</div>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Pilih Pemeriksaan',array('{icon}'=>'<i class="icon-edit icon-white"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanLab($('#form-pemeriksaan-".$i."'),".$i."); ")); ?>
<div id="form-tindakanpemeriksaan-<?php echo $i;?>">
    <table class="table table-condensed table-striped">
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


