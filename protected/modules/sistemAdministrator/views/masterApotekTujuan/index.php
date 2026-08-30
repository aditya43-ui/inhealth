<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Ruangan Apotek Tujuan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Tabel <b>Ruangan Apotek Tujuan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php 
                    $this->renderPartial('_table', [
                        'model' => $model
                    ]);
                ?>
            </div>
        </div>
        <div class="form-action">
            <?php 
                // echo CHtml::link(
                //     Yii::t('mds', '{icon} Tambah Ruangan Apotek Tujuan', array('{icon}' => '<i class="entypo-plus"></i>')),
                //     $this->createUrl('create'),
                //     array(
                //         'title' => 'Tambah',
                //         'class' => 'btn btn-danger',
                //     )
                // );
            ?>
        </div>
    </div>
</div>
<style>
    .ui-dialog {
        top: 190px !important;
    }
</style>
<?php 
$this->renderPartial('_jsFunctions', [
    'model' => $model
]);
?>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRuangPelayanan',
    'options' => array(
        'title' => 'Tambah Ruangan Pelayanan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'height' => 400,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('ruanganapotek-grid'); }",
    ),
));
echo '<iframe id="iframeRuanganPelayanan"  name="iframeRuanganPelayanan" width="100%" height="100%">
</iframe>';
$this->endWidget();
?>