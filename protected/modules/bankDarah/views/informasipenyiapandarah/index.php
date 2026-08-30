<?php 
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
});
$('#permintaandarah-r-search').submit(function(){
        $.fn.yiiGridView.update('permintaandarah-r-grid', {
                data: $(this).serialize()
        });
        return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penyiapan Darah Pasien </b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', ['model' => $model]); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-bar"></i> Table Penyiapan Darah
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_table', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions', ['model' => $model]); ?>

<?php
/* ====================================== Widget Dialog Transfusi ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogReaksiTransfusi',
    'options' => array(
        'title' => 'Reaksi Transfusi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('grid-statusterima'); }",
    ),
));
?>
<iframe id="iframeReaksiTransfusi" width="98%" height="98%"></iframe>
<?php  
$this->endWidget();
?>
