<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php
            $carabayar = CarabayarM::model()->findAll(array(
                'condition' => 'carabayar_aktif = true',
                'order' => 'carabayar_nourut',
            ));
            $penjamin = PenjaminpasienM::model()->findAll(array(
                'condition' => 'penjamin_aktif = true',
                'order' => 'penjamin_nama',
            ));
            $pegawai = DokterV::model()->findAllByAttributes(array(
                //'instalasi_id' => Params::INSTALASI_ID_RJ,
                'pegawai_aktif' => true,
            ), array(
                'order' => 'nama_pegawai',
            ));
            foreach ($carabayar as $idx => $item) {
                $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                    'carabayar_id' => $item->carabayar_id,
                    'penjamin_aktif' => true,
                ));
                if (empty($penjamins)) unset($carabayar[$idx]);
            }
            //$kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true order by kelaspelayanan_nama');
            /*$kamar = KamarruanganM::model()->findAll(array(
                'join' => 'join ruangan_m r on r.ruangan_id = t.ruangan_id',
                'condition' => 't.kamarruangan_aktif = true and r.instalasi_id = ' . Params::INSTALASI_ID_RI,
                'order' => 't.kamarruangan_nokamar, t.kamarruangan_nobed',
            ));*/
            echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                'empty' => '-- Pilih --',
                'class' => 'span4',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                    'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                ),
            ));
            echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
            
            ?>
            <?php
            // $instalasi = InstalasiM::model()->findAllByAttributes(array(
            //     'instalasi_id' => array(2, 3, 4, 8),
            // ));
            $instalasi = InstalasiM::model()->findAll(['condition'=>'instalasi_aktif = true', 'order'=>'instalasi_nama']);

            $ruangan = RuanganM::model()->findAll(['condition'=>'ruangan_aktif = true', 'order'=>'ruangan_nama']);
            echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                'empty' => '-- Pilih --',
                'class' => 'span4',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/actionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                    'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_id") . '").html(data); }',
                ),
            ));
            echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
            echo $form->textFieldRow($model, 'pegawaibatal_nama', array(
                'class'=>'span4'
            ));
            
            ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>