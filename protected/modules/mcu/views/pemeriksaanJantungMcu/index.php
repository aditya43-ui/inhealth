<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Jantung berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>
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
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Jantung
        </div>
    </div>
    <div class="panel-body">
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-riwayat-jantung',
            'content' => array(
                'content-riwayat-jantung' => array(
                    'header' => '<b>Riwayat Pemeriksaan Jantung</b>',
                    'isi' => $this->renderPartial($this->path_view . '_formRiwayat', array(
                        'form' => $form,
                        'modPemeriksaanjantung' => $modPemeriksaanjantung,
                        'modPemeriksaanjantungRiwayat' => $modPemeriksaanjantungRiwayat,
                        'format' => $format,
                        'modPendaftaran' => $modPendaftaran
                    ), true),
                    'active' => false,
                ),
            ),
        )); 
    ?>
        
        <?= $this->renderPartial($this->path_view.'form/_1_dataSubjektif',['form'=>$form,'model'=>$modPemeriksaanjantung], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_2_dataObjektif',['form'=>$form,'model'=>$modPemeriksaanjantung], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_3_dataPemeriksaanPenunjang',['form'=>$form,'model'=>$modPemeriksaanjantung], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_4_dataLainLain',['form'=>$form,'model'=>$modPemeriksaanjantung], true) ?>        
        
      <?php /*
        <div class="panel-body">
            <div style="float:right;margin-bottom:0px">
                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                    $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&baru="baru"'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return tambahbaru(this);',
                        "rel" => "tooltip",
                        "title" => "Klik untuk tambah data baru"
                    )
                ); ?>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Pemeriksaan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
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
                        <?php echo CHtml::activeHiddenField($modPemeriksaanjantung, 'dokterpemeriksa_id'); ?>
                        <?php echo CHtml::textField('nama_pegawai', empty($modPemeriksaanjantung->dokterpemeriksa) ? null : $modPemeriksaanjantung->dokterpemeriksa->namaLengkap, array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->renderPartial($this->path_view . '_form1', array(
            'form' => $form,
            'modPemeriksaanjantung' => $modPemeriksaanjantung,
            'modPemeriksaanjantungRiwayat' => $modPemeriksaanjantungRiwayat,
            'format' => $format,
            'modPendaftaran' => $modPendaftaran
        )); ?>
        <?php $this->renderPartial($this->path_view . '_form2', array(
            'form' => $form,
            'modPemeriksaanjantung' => $modPemeriksaanjantung,
            'modPemeriksaanjantungRiwayat' => $modPemeriksaanjantungRiwayat,
            'format' => $format,
            'modPendaftaran' => $modPendaftaran
        )); ?>
        <?php $this->renderPartial($this->path_view . '_form3', array(
            'form' => $form,
            'modPemeriksaanjantung' => $modPemeriksaanjantung,
            'modPemeriksaanjantungRiwayat' => $modPemeriksaanjantungRiwayat,
            'format' => $format,
            'modPendaftaran' => $modPendaftaran
        )); 
         * 
         */ ?>  
    </div>
</div>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disableSave = false;
    $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
    ?>
    <?php $disablePrint = ($disableSave) ? false : true; ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $disableSave)); //formSubmit(this,event)        
    ?>
    <?php if (!isset($_GET['frame'])) {
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']),
            array(
                'title' => 'Ulang',
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
    'modPemeriksaanjantungRiwayat' => $modPemeriksaanjantungRiwayat,
    'format' => $format,
    'modPendaftaran' => $modPendaftaran
)); ?>
<script>
    function print(caraprint, id) {
        if (typeof id === 'undefined'){
            id = '<?= $modPemeriksaanjantung->checkup_jantung_id ?>';
        }
        
        if (typeof caraprint === 'undefined'){
            caraprint = 'PRINT';
        }
        window.open('<?php echo $this->createUrl('print', array('id' => '')); ?>'+id+'&caraPrint='+caraprint, 'printwin', 'left=100,top=100,width=640,height=480');
    }
</script>