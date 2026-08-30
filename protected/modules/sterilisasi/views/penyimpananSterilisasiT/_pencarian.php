<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarian-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modSterilisasiDetail, 'sterilisasi_no'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Penerimaan ', '', array('class' => 'control-label inline')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modSterilisasiDetail->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modSterilisasiDetail->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($modSterilisasiDetail->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modSterilisasiDetail->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($modSterilisasiDetail, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($modSterilisasiDetail, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('No. Sterilisasi', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modSterilisasiDetail, 'sterilisasi_no', array('placeholder' => 'No. Sterilisasi', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => false)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modSterilisasiDetail,
                        'instalasi_id',
                        $instalasiTujuans,
                        array(
                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modSterilisasiDetail))),
                                'update' => "#" . CHtml::activeId($modSterilisasiDetail, 'ruangan_id'),
                            )
                        )
                    ); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modSterilisasiDetail, 'ruangan_id', $ruanganTujuans, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onkeypress' => 'searchPenerimaan();', 'onclick' => 'searchPenerimaan()')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>