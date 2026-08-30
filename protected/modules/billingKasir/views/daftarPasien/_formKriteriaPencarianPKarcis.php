<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'autofocus' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
                    <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                    </div>
                </div>
        <?php
        $sp = LookupM::getItems('statusperiksa');
        unset($sp['BATAL PERIKSA']);
        echo $form->dropDownListRow($model, 'statusperiksa', $sp, array('empty' => '-- Pilih --', 'class' => 'span4'));
        ?>
    </div>
    <div class="col-sm-6">
        <?php
        $instalasi = InstalasiM::model()->findAll(array(
            'condition' => 'instalasi_aktif = true and (instalasi_id in (2,3,4) or (revenuecenter = true and instalasirujukaninternal = true and instalasi_id not in (7)))',
            'order' => 'instalasi_nama',
        ));
        $ruangan = array();
        /*
            $pegawai = DokterV::model()->findAllByAttributes(array(
                'instalasi_id'=>Params::INSTALASI_ID_RJ,
                'pegawai_aktif'=>true,
            ), array(
                'order'=>'nama_pegawai',
            )); */
        foreach ($instalasi as $idx => $item) {
            $ruangans = RuanganM::model()->findByAttributes(array(
                'instalasi_id' => $item->instalasi_id,
                'ruangan_aktif' => true,
            ));
            if (empty($ruangans)) unset($instalasi[$idx]);
        }
        // echo $form->dropDownListRow($model,'nama_pegawai', CHtml::listData($pegawai, 'nama_pegawai', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
        echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span3',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
        ?>
        <?php
        $carabayar = CarabayarM::model()->findAll(array(
            'condition' => 'carabayar_aktif = true',
            'order' => 'carabayar_nourut',
        ));
        $penjamin = PenjaminpasienM::model()->findAll(array(
            'condition' => 'penjamin_aktif = true',
            'order' => 'penjamin_nama',
        ));
        /*
            $pegawai = DokterV::model()->findAllByAttributes(array(
                'instalasi_id'=>Params::INSTALASI_ID_RJ,
                'pegawai_aktif'=>true,
            ), array(
                'order'=>'nama_pegawai',
            )); */
        foreach ($carabayar as $idx => $item) {
            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                'carabayar_id' => $item->carabayar_id,
                'penjamin_aktif' => true,
            ));
            if (empty($penjamins)) unset($carabayar[$idx]);
        }
        // echo $form->dropDownListRow($model,'nama_pegawai', CHtml::listData($pegawai, 'nama_pegawai', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
        echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span3',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
        ?>
    </div>
</div>
<?php //$model->statusperiksa = (!empty($model->statusperiksa)) ? $model->statusperiksa : 'SEDANG PERIKSA';
?>
<?php // echo $form->dropDownListRow($model,'statusperiksa', LookupM::getItems('statusperiksa'),array('empty'=>'-- Pilih --')); 
?>
<?php // echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); 
?>