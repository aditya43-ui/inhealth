<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rujukan',
);
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$modul = $this->module->name;
$control = $this->id;
Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $.fn.yiiGridView.update('pasienpenunjangrujukan-M-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Rujukan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_formSearch', array('model'=>$model)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rujukan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                    $this->renderPartial('_table', ['dataProvider' => $dataProvider])
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
        'zIndex' => 1002,
        'minWidth' => 500,
        'minHeight' => 100,
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php echo $this->renderPartial('_jsFunctions', array()); ?>

<?php
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPilihTglPeriksa',
    'options' => array(
        'title' => 'Pilih Tgl. Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
            data: $('#search-penunjangrujukan-form').serialize()
        }); }",
    ),
));
?>
<iframe name='framePilihTglPeriksa' style="width: 100%; height: 98%;"></iframe>

<?php $this->endWidget(); ?>