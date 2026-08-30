<?php
$this->breadcrumbs = array(
    'Informasi Stok Kantong Darah',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
/**
 * Halaman ini digunakan untuk menampilkan informasi stok kantong darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('#stokkantongdarah-r-search').submit(function(){
        $.fn.yiiGridView.update('stokkantongdarah-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Informasi <b>Stok Kantong Darah</b>
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
                <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stok Kantong Darah</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'stokkantongdarah-r-grid',
                    'dataProvider' => $model->informasi(),
                    'replaceUrl' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'Jenis Komponen Darah',
                            'value' => '$data->singkatan_komp'
                        ),
                        array(
                            'header' => 'Golongan Darah',
                            'value' => function ($data) {
                                echo $data->gol_darah;
                            },
                        ),
                        array(
                            'header' => 'Stok Kantong Darah',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::Link(
                                    $data->getStokKantongDarah($data->singkatan_komp, $data->gol_darah),
                                    Yii::app()->controller->createUrl(
                                        "detailStokKantongDarah",
                                        array('singkatan_komp' => $data->singkatan_komp, 'gol_darah' => $data->gol_darah)
                                    ),
                                    array(
                                        "class" => "hover",
                                        "target" => "frameDetailStokKantongDarah",
                                        "onclick" => "$('#dialogStokKantongDarah').dialog('open');",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat rincian stok kantong darah",
                                    )
                                );
                            },
                        ),
                        array(
                            'header' => 'Stok Darah Siap',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::Link(
                                    $data->getStokDarahSiap($data->singkatan_komp, $data->gol_darah),
                                    Yii::app()->controller->createUrl(
                                        "detailStokDarahSiap",
                                        array('singkatan_komp' => $data->singkatan_komp, 'gol_darah' => $data->gol_darah)
                                    ),
                                    array(
                                        "class" => "hover",
                                        "target" => "frameDetailStokDarahSiap",
                                        "onclick" => "$('#dialogStokDarahSiap').dialog('open');",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat rincian stok darah siap",
                                    )
                                );
                            },
                        ),
                        array(
                            'header' => 'Stok Keluar',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::Link(
                                    $data->getStokDarahKeluar($data->singkatan_komp, $data->gol_darah),
                                    Yii::app()->controller->createUrl(
                                        "detailStokDarahKeluar",
                                        array('singkatan_komp' => $data->singkatan_komp, 'gol_darah' => $data->gol_darah)
                                    ),
                                    array(
                                        "class" => "hover",
                                        "target" => "frameDetailStokDarahKeluar",
                                        "onclick" => "$('#dialogStokDarahKeluar').dialog('open');",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat rincian stok darah keluar",
                                    )
                                );
                            },
                        ),
                        /*array(
                                    'header'=>'Stok Masuk',
                                    'value'=>function($data){
                                        echo $data->jmlkantongdarah;
                                    },
                                ),
                                array(
                                    'header' => 'Stok Keluar', 
                                    'value' => function($data){
                                        echo $data->rilis; 
                                    }, 
                                ), 
                                array(
                                    'header' => 'Stok Akhir', 
                                    'value' => function($data){
                                        echo $data->jmlkantongdarah - $data->rilis; 
                                    }, 
                                ), 
                                array(
                                    'header' => 'Detail',
                                    'type' => 'raw',
                                    'value'=>function($data){
                                            return CHtml::Link("<span style='font-size:17px'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("detail",array('singkatan_komp'=>$data->singkatan_komp, 'gol' => $data->gol_darah)),
                                            array("class"=>"", 
                                                      "target"=>"frameDetail",
                                                      "onclick"=>"$('#dialogStokKantongDarah').dialog('open');",
                                                      "rel"=>"tooltip",
                                                      "title"=>"Klik untuk melihat rincian stok kantong darah",
                                            ));
                                    },
                                ),*/
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Details =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogStokKantongDarah',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Stok Kantong Darah',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false
    ),
));
?>
<iframe src="" name="frameDetailStokKantongDarah" style="width:100%; height: 98%;"></iframe>';
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogStokDarahSiap',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Stok Darah Siap',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false
    ),
));
?>
<iframe src="" name="frameDetailStokDarahSiap" style="width:100%; height: 98%;"></iframe>';
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogStokDarahKeluar',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Stok Darah Keluar',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false
    ),
));
?>
<iframe src="" name="frameDetailStokDarahKeluar" style="width:100%; height: 98%;"></iframe>';
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>