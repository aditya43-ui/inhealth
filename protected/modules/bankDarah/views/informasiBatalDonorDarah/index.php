<?php
/**
 * Halaman ini digunakan untuk menampilkan informasi stok kantong darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('#informasibataldonor-r-search').submit(function(){
        $.fn.yiiGridView.update('informasibataldonor-r-grid', {
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
                <div class="panel-title">Informasi <strong> Batal Donor Darah </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong> Batal Donor Darah </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                            'id' => 'informasibataldonor-r-grid',
                            'dataProvider' => $model->searchInformasiBatalDonor(),
                            'mergeHeaders' => array(
                                array(
                                    'name' => '<center>Golongan Darah</center>',
                                    'start' => 8,
                                    'end' => 9,
                                ),
                            ),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header' => '<center> No.</center>'
                                    ,
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type' => 'raw',
                                ),
                                array(

                                    'header' => '<center> Tgl Pendaftaran <br> No. Formulir </center>',
                                    'value' => function($data){
                                        echo MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($data->create_time)))."<br>".$data->no_formulir;
                                    },
                                ),
                                array(
                                    'header' => '<center> No. Registrasi </center>',
                                    'value' => '$data->no_pendonor',
                                ),
                                array(
                                    'header' => '<center> Nama Donor </center>',
                                    'value' => '$data->nama_lengkap',
                                ),
                                array(
                                    'header' => '<center>Tempat / <br> Tanggal Lahir </center>',
                                    'value' => function($data){
                                        echo $data->tempat_lahir." / <br> ".MyFormatter::formatDateTimeForUser($data->tgllahir);
                                    }
                                ),
                                array(
                                    'header' => '<center>Jenis Kelamin </center>',
                                    'value' => '$data->jenis_kelamin',
                                ),
                                array(
                                    'header' => '<center>Umur </center>',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'value' => function($data) {
                                        $hitungUmur = CustomFunction::getUmurTahun($data->tgllahir, $data->create_time);
                                        echo $hitungUmur . " Th";
                                    }
                                ),
                                array(
                                    'header' => '<center>Alamat </center>',
                                    'value' => '$data->alamat_lengkap',
                                ),
                                array(
                                    'header' => '<center>ABO </center>',
                                    'value' => '$data->gol_darah',
                                ),
                                array(
                                    'header' => '<center>Rhesus </center>',
                                    'value' => '$data->rhesus',
                                ),
                                array(
                                    'header' => '<center>Ruangan Rekrutmen </center>',
                                    'value' => '$data->ruangrekrutmen->ruangan_nama',
                                ),
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
                        <div class="panel-title"><i class="entypo-search"></i> <b> Pencarian</b></div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php
                            $this->renderPartial('_search', array(
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