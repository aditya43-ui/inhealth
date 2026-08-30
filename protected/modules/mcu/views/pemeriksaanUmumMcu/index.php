<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Umum berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'periksaanfisik-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Umum
        </div>
    </div>
    <div class="panel-body">
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-riwayat',
            'content' => array(
                'content-riwayat' => array(
                    'header' => '<b>Riwayat Pemeriksaan Umum</b>',
                    'isi' => $this->renderPartial($this->path_view . '_formRiwayat', array(
                        'form' => $form,
                        'modpemeriksaanumum' => $modpemeriksaanumum,
                        'modpemeriksaanumumRiwayat' => $modpemeriksaanumumRiwayat,
                        'format' => $format
                    ), true),
                    'active' => false,
                ),
            ),
        )); 
        
        
        ?>
        
        <?= $this->renderPartial($this->path_view.'form/_01_dataPemeriksaan',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_02_dataRiwayatPenyakit',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_03_dataPemeriksaanFisik',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_04_dataTandaVital',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>        
        <?= $this->renderPartial($this->path_view.'form/_05_dataKepala',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>                        
        <?= $this->renderPartial($this->path_view.'form/_06_dataMata',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>                        
        <?= $this->renderPartial($this->path_view.'form/_07_dataHidung',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>                        
        <?= $this->renderPartial($this->path_view.'form/_08_dataTelinga',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_09_dataTenggorokan',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_10_dataLeher',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_11_dataThorax',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_12_dataBunyiParu',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_13_dataJantung',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_14_dataAbdomen',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_15_dataEkstremitas',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_16_dataPemeriksaanLab',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_17_dataPemeriksaanRad',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_18_dataDariHasilLab',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_19_dataFungsiGinjal',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_20_dataFungsiHati',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_21_dataMetabolismeGlukosa',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        <?= $this->renderPartial($this->path_view.'form/_22_dataMetabolismeLemak',['form'=>$form,'model'=>$modpemeriksaanumum], true) ?>    
        
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
                        $modpemeriksaanumum->tgl_pemeriksaan = $format->formatDateTimeForUser($modpemeriksaanumum->tgl_pemeriksaan);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modpemeriksaanumum,
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
                        <?php echo CHtml::textField('nama_pegawai', $modPegawai->namaLengkap, array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->renderPartial($this->path_view . '_formPemeriksaanUmum', array(
            'form' => $form,
            'modpemeriksaanumum' => $modpemeriksaanumum,
            'modpemeriksaanumumRiwayat' => $modpemeriksaanumumRiwayat,
            'format' => $format
        )); ?>
        <?php $this->renderPartial($this->path_view . '_formPemeriksaanLab', array(
            'form' => $form,
            'modpemeriksaanumum' => $modpemeriksaanumum,
            'modpemeriksaanumumRiwayat' => $modpemeriksaanumumRiwayat,
            'format' => $format
        )); ?>
        <?php $this->renderPartial($this->path_view . '_formKesimpulan', array(
            'form' => $form,
            'modpemeriksaanumum' => $modpemeriksaanumum,
            'modKonsul' => $modKonsul,
            'format' => $format,
            'modPendaftaran' => $modPendaftaran
        )); ?>
        <?php $this->renderPartial($this->path_view . '_formKonsul', array(
            'form' => $form,
            'modpemeriksaanumum' => $modpemeriksaanumum,
            'modKonsul' => $modKonsul,
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
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'onclick' => 'print();'));
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsTreadmill', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array(
    'modpemeriksaanumum' => $modpemeriksaanumum,
    'modpemeriksaanumumRiwayat' => $modpemeriksaanumumRiwayat,
    'format' => $format
)); ?>
<script>
    function print(caraprint, id) {
        if (typeof id === 'undefined'){
            id = '<?= $modpemeriksaanumum->mcu_pemeriksaanumum_id ?>';
        }
        
        if (typeof caraprint === 'undefined'){
            caraprint = 'PRINT';
        }
        window.open('<?php echo $this->createUrl('print', array('id' => '')); ?>'+id+'&caraPrint='+caraprint, 'printwin', 'left=100,top=100,width=640,height=480');
    }
</script>