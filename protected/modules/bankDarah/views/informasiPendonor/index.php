<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#informasipendonor-r-search').submit(function(){
            $.fn.yiiGridView.update('informasipendonor-r-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong> Pencarian Donor Darah </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong> Pencarian Donor Darah </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'informasipendonor-r-grid',
                            'dataProvider' => $model->searchInformasiPendonor(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'replaceUrl' => true,
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

                                    'header' => 'Tanggal Pendaftaran',
                                    'value' => function($data){
                                        return MyFormatter::formatDateTimeForUser($data->create_time);
                                    },
                                ),
                                array(
                                    'header' => 'No. Registrasi Donor Darah',
                                    'value' => '$data->no_pendonor',
                                ),
                                array(
                                    'header' => 'Nama Donor',


                                    'value' => '$data->nama_lengkap',
                                ),
                                array(
                                    'header' => 'Jenis Kelamin',
                                    'value' => '$data->jenis_kelamin',
                                ),
                                array(
                                    'header' => 'Umur',
                                    'value' => function($data) {
                                        $hitungUmur = CustomFunction::getUmurTahun($data->tgllahir, $data->create_time);
                                        echo $hitungUmur . " Th";
                                    }
                                ),
                                array(
                                    'header' => 'Alamat',
                                    'value' => '$data->alamat_lengkap',
                                ),
                                array(
                                    'header' => 'Golongan Darah',
                                    'value' => '$data->gol_darah',
                                ),
                                array(
                                    'header' => 'Rhesus',
                                    'value' => '$data->rhesus',
                                ),
                                array(
                                    'header' => 'Riwayat Donasi',
                                    'value' => function($data) {
                                        echo CHtml::link("<i class='entypo-doc-text' style='color: black'></i>", Yii::app()->createUrl('bankDarah/InformasiPendonor/riwayat&id=' . $data->pendonor_id), array("rel" => "tooltip", "title" => "Klik untuk Melihat Riwayat Donasi", "target" => "frame3", "onclick" => "window.parent.$(\"#dialogRiwayat\").dialog(\"open\");"));
                                    }
                                ),
                                array(
                                    'header' => 'Ubah',
                                    'value' => function($data) {
                                        echo CHtml::link("<i class='glyphicon glyphicon-pencil' style='color: black'></i>", Yii::app()->createUrl('bankDarah/InformasiPendonor/update&id=' . $data->pendonor_id), array("rel" => "tooltip", "frame" => 1, "title" => "Klik untuk Mengubah Data Pendonor"));
                                    }
                                ),
                                array(
                                    'header' => 'Cetak Kartu Donor',
                                    'value' => function($data) {
                                        echo CHtml::link("<i class='glyphicon glyphicon-print' style='color: black'></i>", Yii::app()->createUrl('bankDarah/pendaftaranDonorDarah/print&id=' . $data->pendonor_id), array("rel" => "tooltip", "title" => "Klik untuk Mencetak Kartu Pendonor", "target" => "frame2", "onclick" => "window.parent.$(\"#dialogCetak\").dialog(\"open\");"));
                                    }
                                )
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
    function cekForm(obj){
        $("#informasiae-r-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
        window.open("${urlPrint}/"+$('#informasiae-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                        ?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php
                            $this->renderPartial($this->path_view . '/_search', array(
                                'model' => $model,
                            ));
                            ?>
                        </fieldset>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUpdate',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Ubah Data Pendonor',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 800,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogCetak',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cetak Kartu Pendonor',
        'autoOpen' => false,
        'width' => 640,
        'height' => 480,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame2" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<?php
// ===========================Dialog Riwayat=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Riwayat Donasi',
        'autoOpen' => false,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame3" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Riwayat================================
?>