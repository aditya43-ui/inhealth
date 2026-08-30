<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienruangpulih-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->label($model, 'keluarruanganpulih_tanggal', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'keluarruanganpulih_tanggal',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'span3',
                    'onclick' => "return $(this).focusNextInputField(event)",
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'keluarruanganpulih_jam', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'keluarruanganpulih_jam',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'span3',
                    'onclick' => "return $(this).focusNextInputField(event)",
                    'disabled' => !empty($model->masukkamar_id),
                ),
            ));
            ?>
        </div>
    </div>
    <?php echo $form->dropDownListRow($model, 'petugas_saatkeluarruangpulih_id', CHtml::listData($penunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</div>
<div class="col-sm-6"></div>
<div class="clear"></div>
<div class="col-sm-12">

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Skrinning Skala Nyeri</div>
        </div>
        <div class="panel-body">
            <?php
            echo $this->renderPartial('keluar/_formNyeri', array(
                'form' => $form,
                'model' => $modelNyeri
            ), true);
            ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Skor Aldrette</div>
        </div>
        <div class="panel-body">
            <?php echo $this->renderPartial("keluar/_skor", array(
                'form' => $form,
                'model' => $model,
            )); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Catatan Khusus Ruang Pulih
            </div>
        </div>
        <div class="panel-body">
            <?php echo $this->renderPartial("keluar/_catatan", array(
                'form' => $form,
                'model' => $model,
                'penunjang' => $penunjang,
            )); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Instruksi Dokter Pasca Anestesi
            </div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <?php echo $form->textAreaRow($model, 'instruksi_bilanyeri', array('class' => 'span3')); ?>
                <?php echo $form->textAreaRow($model, 'intruksi_mualmuntah', array('class' => 'span3')); ?>
                <?php echo $form->textAreaRow($model, 'instruksi_infus', array('class' => 'span3')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textAreaRow($model, 'instruksi_makanminum', array('class' => 'span3')); ?>
                <?php echo $form->textAreaRow($model, 'instruksi_obat', array('class' => 'span3')); ?>

            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-6">
    <br>
    <div class="panel panel-dark">
        <span class="group-title">
            Tindak Lanjut Pasien
        </span>
        <div class="panel-body">
            <?php
            echo $this->renderPartial("keluar/_tindaklanjut", array(
                'form' => $form, 'model' => $model, 'pindahkamar' => $pindahkamar,
            ), true);
            ?>

        </div>
    </div>
</div>
<div class="col-sm-6">
    <br>
    <div class="panel panel-dark">
        <span class="group-title">
            Hal yang akan diserahterima Pasien dengan Perawat Ruangan
        </span>
        <div class="panel-body">
            <?php
            echo $this->renderPartial("keluar/_serahterima", array(
                'form' => $form, 'model' => $model
            ), true);
            ?>

        </div>
    </div>
</div>
<div class="clear"></div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create', array('pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan PasienruangpulihT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>