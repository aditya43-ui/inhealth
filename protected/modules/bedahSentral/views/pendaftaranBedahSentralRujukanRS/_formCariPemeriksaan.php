<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanBedah, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanBedah, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanBedah, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3')); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="control-group" style="float:left;">
                <?php echo CHtml::activeLabel($modPemeriksaanBedah, 'kelaspelayanan_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('BSPasienmasukpenunjangT[kelaspelayanan_id]', 'kelaspelayanan_id',CHtml::listData(BSPendaftaranMp::model()->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('onchange' => 'setChecklistPemeriksaanBedah();setTindakanPemeriksaanReset();', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); ?>
                    <?php //echo CHtml::activeTextField($modPemeriksaanBedah, 'kegiatanoperasi_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanBedah();")); 
                    ?>
                </div>
            </div>
            <div class="control-group" style="float:left;">
                <?php echo CHtml::activeLabel($modPemeriksaanBedah, 'kegiatanoperasi_nama', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('BSTarifoperasiruanganV[kegiatanoperasi_nama]', 'kegiatanoperasi_nama', CHtml::listData(KegiatanOperasiM::model()->findAll("kegiatanoperasi_aktif = TRUE ORDER BY kegiatanoperasi_nama ASC"), 'kegiatanoperasi_nama', 'kegiatanoperasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4', "onchange" => "updateChecklistPemeriksaanBedah();")); ?>
                    <?php //echo CHtml::activeTextField($modPemeriksaanBedah, 'kegiatanoperasi_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanBedah();")); 
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group" style="float:left;">
                <?php echo CHtml::activeLabel($modPemeriksaanBedah, 'operasi_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($modPemeriksaanBedah, 'operasi_nama', array('placeholder' => 'Operasi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanBedah();",)); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanBedah();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari operasi')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanBedahReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang operasi')); ?>
                </div>
            </div>
        </div>
    </div>
</div>