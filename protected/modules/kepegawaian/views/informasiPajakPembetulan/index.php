<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Informasi Pajak dan Perbaikan' => array('index')
);

$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Data Pelamar ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) : '';
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PelamarT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PelamarT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

$this->menu = $arrMenu;

Yii::app()->clientScript->registerScript('search', "
    $('#pegmutasi-r-search').submit(function(){
            $.fn.yiiGridView.update('pegmutasi-r-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

$this->widget('bootstrap.widgets.BootAlert');

$prov = $model->searchInfo();
$prov->pagination = false;

$total_bruto = 0;
$total_pph = 0;

foreach ($prov->data as $item) {
    $total_bruto += $item->totalterima;
    $total_pph += $item->pph21perbulan;
}

?>

<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn'));  
?>
<!--<div class="cari-lanjut search-form">-->

<!--</div> search-form-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pajak dan Perbaikan</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pajak dan Perbaikan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pegmutasi-r-grid',
                    'dataProvider' => $model->searchInfo(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Nama Pegawai',
                            'type' => 'raw',
                            'name' => 'pegawai.namaLengkap',
                        ),
                        array(
                            'header' => 'NPWP',
                            'type' => 'raw',
                            'name' => 'pegawai.npwp',
                        ),
                        array(
                            'header' => 'NIP',
                            'type' => 'raw',
                            'name' => 'pegawai.nomorindukpegawai',
                            'value' => '$data->pegawai->nomorindukpegawai',
                        ),
                        array(
                            'header' => 'Jabatan',
                            'type' => 'raw',
                            'value' => '$data->pegawai->jabatanNama',
                        ),
                        array(
                            'header' => 'Kode PTKP',
                            'type' => 'raw',
                            'value' => '$data->kodeptkp',
                        ),
                        array(
                            'header' => 'Tanggal Penggajian',
                            'type' => 'raw',
                            'value' => 'date("d M Y", strtotime($data->tglpenggajian));',
                            'footer' => "Total",
                            'footerHtmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Bruto',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totalterima)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                            'footer' => MyFormatter::formatNumberForPrint($total_bruto),
                            'footerHtmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'PPh 21/Bulan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->pph21perbulan)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                            'footer' => MyFormatter::formatNumberForPrint($total_pph),
                            'footerHtmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Perbaikan PPh 21',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<u><i class="icon-form-input"></i></u>', Yii::app()->controller->createUrl('pembetulanPph', array('penggajianpeg_id' => $data->penggajianpeg_id)), array(
                                    'target' => 'framePembetulanPph',
                                    'onclick' => '$("#dialogPembetulanPph").dialog("open");',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Klik untuk Perbaikan PPh 21',
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Rincian Perbaikan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<u><i class="icon-form-detailtagihan"></i></u>', Yii::app()->controller->createUrl('rincian', array('penggajianpeg_id' => $data->penggajianpeg_id)), array(
                                    'target' => 'frameRincian',
                                    'onclick' => '$("#dialogRincian").dialog("open");',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Klik untuk Rincian Perbaikan',
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Formulir 1721-A1',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<u><i class="icon-form-detail"></i></u>', Yii::app()->controller->createUrl('formulir', array('penggajianpeg_id' => $data->penggajianpeg_id)), array(
                                    'target' => 'frameFormulir',
                                    'onclick' => '$("#dialogFormulir").dialog("open");',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Klik untuk Melihat Formulir 1721-A1',
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<!--/div-->

<?php
// ===========================Dialog=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPembetulanPph',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Perbaikan PPh 21',
        'autoOpen' => false,
        'width' => 900,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="framePembetulanPph" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog================================
?>

<?php
// ===========================Dialog=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincian',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rincian Perbaikan PPh 21',
        'autoOpen' => false,
        'width' => 900,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameRincian" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog================================
?>

<?php
// ===========================Dialog=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogFormulir',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Formulir 1721 - A1',
        'autoOpen' => false,
        'width' => 1200,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="frameFormulir" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog================================
?>

<script type="text/javascript">
    function exportRincianCSV() {
        window.open("<?php echo $this->createUrl("exportInformasiCSV", array()); ?>/" + $('#pegmutasi-r-search').serialize(), "", "location=_new,width=900px");
    }

    function exportRincianCSVPPh() {
        window.open("<?php echo $this->createUrl("exportInformasiCSV", array('pph' => true)); ?>/" + $('#pegmutasi-r-search').serialize(), "", "location=_new,width=900px");
    }
</script>