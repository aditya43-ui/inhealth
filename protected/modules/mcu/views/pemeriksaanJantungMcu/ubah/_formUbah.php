<?php
$this->breadcrumbs = array(
    'Mcu',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Jantung berhasil diubah");
}

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'periksaanjantung-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Pemeriksaan Jantung</b>
        </div>
        <div style="float:right; margin-bottom:5px">
            <?php echo CHtml::link('<i class="entypo-back" style="color: black;"></i> Kembali', '#', array('class' => '', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: black;')) ?>
        </div>
    </div>

    <div class="panel-body">
        <?= $this->renderPartial($this->path_view.'form/_1_dataSubjektif',['form'=>$form,'model'=>$modPemeriksaanjantung], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_2_dataObjektif',['form'=>$form,'model'=>$modPemeriksaanjantung], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_3_dataPemeriksaanPenunjang',['form'=>$form,'model'=>$modPemeriksaanjantung], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_4_dataLainLain',['form'=>$form,'model'=>$modPemeriksaanjantung], true) ?>        
        
        <?php
        
        /*
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Pemeriksaan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($modPemeriksaanjantung, 'checkup_jantung_id', array('readonly' => true));
                        $modPemeriksaanjantung->tgl_pemeriksaan = $format->formatDateTimeForUser($modPemeriksaanjantung->tgl_pemeriksaan);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPemeriksaanjantung,
                            'attribute' => 'tgl_pemeriksaan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,

                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Dokter', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPemeriksaanjantung, 'dokterpemeriksa_id',  CHtml::listData(DokterV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'  "), 'pegawai_id', 'namaLengkap'), array(
                            'class' => 'span3'
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->renderPartial($this->path_view . '_form1', array(
            'form' => $form,
            'modPemeriksaanjantung' => $modPemeriksaanjantung,
            'format' => $format,
        )); ?>
        <?php $this->renderPartial($this->path_view . '_form2', array(
            'form' => $form,
            'modPemeriksaanjantung' => $modPemeriksaanjantung,
            'format' => $format,
        )); ?>
        <?php $this->renderPartial($this->path_view . '_form3', array(
            'form' => $form,
            'modPemeriksaanjantung' => $modPemeriksaanjantung,
            'format' => $format,
        )); */ ?>
    </div>
</div>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? true : false;
    $disableSave = false;
    $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
    ?>
    <?php $disablePrint = ($disableSave) ? false : true; ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $sukses)); //formSubmit(this,event)        
    ?>
    <?php if (!isset($_GET['frame'])) {
        echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/update&id=' . $modPemeriksaanjantung->checkup_jantung_id),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        );
    } ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsTreadmill', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>

</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array(
    'modPemeriksaanjantung' => $modPemeriksaanjantung,
    'format' => $format,
)); ?>
<script>
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $modPemeriksaanjantung->checkup_jantung_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
</script>