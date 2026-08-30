<?php
Yii::app()->clientScript->registerScript('search', "
$('#remunerasikedisiplinan-t-search').submit(function(){
	$('#remunerasikedisiplinan-t-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('remunerasikedisiplinan-t-grid', {
            data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <b>Pemberian Obat</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Pemberian Obat</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'_table', array('model' => $model)) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="<?php echo MyIcon::getIcons('cari'); ?>"></i>Pencarian </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'_search', array('model' => $model)) ?>
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk menampilkan riwayat reseptur=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReseptur',
    'options' => array(
        'title' => 'Resep Dokter',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 1100,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('remunerasikedisiplinan-t-grid', {
                        data: $('#remunerasikedisiplinan-t-search').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeReseptur" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end dialog reseptur riwayat =============================
?>