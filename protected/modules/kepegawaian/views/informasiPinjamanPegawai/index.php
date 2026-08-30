<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Informasi Pinjaman Pegawai' => array('index'),
);
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('kppenggajianpeg-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pinjaman Pegawai</b>
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
                <?php $this->renderPartial('_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pinjaman Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kppenggajianpeg-t-grid',
                    'dataProvider' => $model->searchTabel(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'NIP',
                            'name' => 'nomorindukpegawai',
                            'value' => '$data->nomorindukpegawai',
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'name' => 'nama_pegawai',
                            'value' => '$data->gelardepan." ".$data->nama_pegawai',
                        ),
                        'nopinjam',
                        array(
                            'name' => 'tglpinjampeg',
                            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglpinjampeg)))',
                        ),
                        array(
                            'name' => 'tgljatuhtempo',
                            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglpinjampeg)))',
                        ),
                        array(
                            'header' => 'Rincian Pinjaman',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i>",Yii::app()->createUrl(\'kepegawaian/informasiPinjamanPegawai/detailPinjaman&pinjamanpeg_id=\'.$data->pinjamanpeg_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Pinjaman","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsPinjaman\").dialog(\"open\");", ))',
                            'htmlOptions' => array('style' => 'text-align: left; width:60px'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Details Penggajian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailsPinjaman',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rincian Pinjaman Pegawai',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false
    ),
));
?>
<iframe src="" name="iframe" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Penggajian================================
?>