<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    //'method' => 'get',
    'id' => 'pencarian-form',
    'type' => 'horizontal',
    //'focus' => '#' . CHtml::activeId($modPenerimaansterilisasiV, 'penerimaansterilisasi_no'),
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>Tanggal Pengajuan</label>
            <!--<div class="controls">
                <?php
                /*$this->widget('MyDateTimePicker', array(
                    'model' => $modCari,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                ));*/
                ?>
            </div>-->
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modCari->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modCari->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($modCari->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modCari->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modCari, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modCari, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <!--<div class="control-group">
            <label class='control-label'>Sampai Dengan</label>
            <div class="controls">
                <?php
                /*$this->widget('MyDateTimePicker', array(
                    'model' => $modCari,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                ));*/
                ?>    
            </div>
        </div>-->
        <div class="control-group">
            <label class='control-label'>No. Pengajuan</label>
            <div class="controls">
                <?php echo $form->textField($modCari, 'pengajuansterlilisasi_no', array('placeholder' => 'No. Pengajuan', 'class' => 'span4', 'maxlength' => 20)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'Instalasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $modCari,
                    'instalasi_id',
                    CHtml::listData(InstalasiM::model()->findAll(), 'instalasi_id', 'instalasi_nama'),
                    array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modCari))),
                            'update' => "#" . CHtml::activeId($modCari, 'ruangan_id'),
                        )
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', 'Ruangan', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modCari, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    //echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button','id'=>'pencarian','onclick'=>'cekNoPengajuan()','onkeypress'=>'cekNoPengajuan()'));
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'searchPenerimaan()', 'onkeypress' => 'searchPenerimaan()')
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('index'),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
    ); ?>
</div>
<?php $this->endWidget(); ?>