<?php
$this->breadcrumbs = array(
    'Informasi Pasien Operasi',
);
?>
 <?php
$this->widget('bootstrap.widgets.BootAlert');
Yii::app()->clientScript->registerScript('cariPasien', "
$('#formPencarian').submit(function(){
    $.fn.yiiGridView.update('tabelPasienOperasi', {
        data: $(this).serialize()
    });
    return false;
});
"); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Operasi</b>
        </div>
    </div>
    <div class="panel-body">
        <!-- panel pencarian -->
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-info-circled"></i> Pencarian <b>Pasien Operasi</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', ['modPasienMasukPenunjang' => $modPasienMasukPenunjang]) ?>
            </div>
        </div>

        <!-- panel tabel -->
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-info-circled"></i> Tabel <b>Pasien Operasi</b>
                    <?= CHtml::link('Informasi Daftar Pasien Operasi', $this->createUrl('informasiPasienOperasi'),['class' => 'btn btn-default', 'style' => 'float:right']) ?>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_table', ['modPasienMasukPenunjang' => $modPasienMasukPenunjang]) ?>
            </div>
        </div>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincianTagihanSementara',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Rincian Tagihan Sementara</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));

$r_login = Yii::app()->user->getState('ruangan_id');

// var_dump($r_login); die;
?>
<iframe name='iframeRincianTagihanSementara' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>