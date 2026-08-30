<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pembatalan", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); 
                ?>
                <?php // echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'No. Pendaftaran','style'=>'width:204px;', 'maxlength'=>20)); 
                ?>
                <div class="control-group">
                    <?php echo Chtml::label("No. Pendaftaran", 'no_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $ini = ModulK::model()->findByPk(Yii::app()->session['modul_id']);
                        $pr = Params::getPrefixNoPendaftaran();
                        if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) {
                            $prefix = array(
                                0 => Params::PREFIX_RAWAT_DARURAT,
                                1 => Params::PREFIX_RAWAT_INAP,
                                2 => Params::PREFIX_RAWAT_JALAN
                            );
                        } elseif (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_VERLOS_KAMER) {
                            $prefix = array(
                                0 => Params::PREFIX_RAWAT_DARURAT,
                            );
                        } else {
                            if (isset($pr[$ini->modul_key])) {
                                if (!empty($pr[$ini->modul_key])) {
                                    $prefix = array(
                                        0 => $pr[$ini->modul_key]
                                    );
                                } else {
                                    $prefix = '';
                                }
                            } else {
                                $prefix = '';
                            }
                        }
                        echo $form->dropDownList($model, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                        ?>
                        <?php echo $form->textField($model, 'no_pendaftaran', array('empty' => '-- Pilih --', 'class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'maxlength' => 6)); ?>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'maxlength' => 50)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow(
                    $model,
                    'nama_pegawai',
                    CHtml::listData(DokterV::model()->findAllByAttributes(array(
                        'instalasi_id' => Params::INSTALASI_ID_RJ,
                        'pegawai_aktif' => true,
                    ), array(
                        'order' => 'nama_pegawai asc'
                    )), 'nama_pegawai', 'namaLengkap'),
                    array('empty' => '-- Pilih --', 'class' => 'span4')
                );
                ?>
                <?php
                $carabayar = CarabayarM::model()->findAll(array(
                    'condition' => 'carabayar_aktif = true',
                    'order' => 'carabayar_nama ASC',
                ));
                foreach ($carabayar as $idx => $item) {
                    $penjamins = PenjaminpasienM::model()->findByAttributes(
                        array(
                            'carabayar_id' => $item->carabayar_id,
                            'penjamin_aktif' => true,
                        ),
                        array('order' => 'penjamin_nama ASC')
                    );
                    if (empty($penjamins)) unset($carabayar[$idx]);
                }
                $penjamin = PenjaminpasienM::model()->findAll(array(
                    'condition' => 'penjamin_aktif = true',
                    'order' => 'penjamin_nama',
                ));
                echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span4',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                    ),
                ));
                echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                ?>
                <?php echo $form->textFieldRow($model, 'nama_pemakai', array('placeholder' => 'Nama Pembatal', 'class' => 'span4 hurufs-only', 'maxlength' => 20)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views.informasi.batalPeriksaPasien.tips.informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>