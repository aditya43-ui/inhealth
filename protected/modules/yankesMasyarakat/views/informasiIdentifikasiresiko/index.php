<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#informasiae-r-search').submit(function(){
            $.fn.yiiGridView.update('informasiae-r-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong> Identifikasi Resiko </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong> Identifikasi Resiko </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'informasiae-r-grid',
                            'dataProvider' => $model->searchInformasi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                ),
                                array(
                                    'header' => 'Periode',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data) {
                                        echo MyFormatter::formatDateTimeForUser(date('d-m-Y', strtotime($data->periode_awal))) . " - " . MyFormatter::formatDateTimeForUser(date('d-m-Y', strtotime($data->periode_akhir)));
                                    }
                                ),
                                array(
                                    'header' => 'Jenis Risk Management',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data){
                                        echo !empty($data->jenisriskmanajemen) ? $data->jenisriskmanajemen : "";
                                    }
                                ),
                                array(
                                    'header' => 'Ruangan / Unit Kerja',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data) {
                                        echo $data->ruangan_nama ." / ".$data->namaunitkerja;
                                    }
                                ),
                                array(
                                    'header' => 'Sumber Resiko',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data) {
                                        if (isset($data->sumber_resiko)) {
                                            $criteria = new CDbCriteria;
                                            $criteria->compare('lookup_type', "sumber_riskregister", true);
                                            $criteria->compare('lookup_value', $data->sumber_resiko, true);
                                            $modlookup = LookupM::model()->find($criteria);
                                            echo $modlookup->lookup_name;
                                        } else {
                                            echo "-";
                                        }
                                    }
                                ),
                                array(
                                    'header' => 'Tipe Resiko',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data){
                                        echo !empty($data->tiperesiko_id) ? $data->tiperesiko->tiperesiko_nama : "-";
                                    }
                                ),
                                array(
                                    'header' => 'Sub Tipe Resiko',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data){
                                        echo !empty($data->subtiperesiko_id) ? $data->subtiperesiko->subtiperesiko_nama : "-";
                                    }
                                ),
                                array(
                                    'header' => 'Identifikasi <br> dan Evaluasi Managemen Risiko',
                                    'type' => 'raw',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data) {
                                        if (!empty($data->identifikasiresiko_id)) {
                                            echo CHtml::Link("<button class ='btn btn-sm btn-success'> <i class='glyphicon glyphicon-list'> </i> </button>", Yii::app()->controller->createUrl("EvaluasiIdentifikasiresikoT/index", array("identifikasiresiko_id" => $data->identifikasiresiko_id)), array(
                                                    "class" => "",
                                                    "target" => "iframe3",
                                                    "onclick" => "$(\"#dialogEvaluasi\").dialog(\"open\");",
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk Melihat Evaluasi Manajemen",
                                                        )
                                                );
                                        } else {
                                            echo "";
                                        }
                                    }
                                ),
                                array(
                                    'header' => 'Monev Resiko',
                                    'type' => 'raw',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data) {
                                        $modEvaluasi = YKMEvaluasiidentifikasirisikoT::model()->findByAttributes(array('identifikasirisiko_id' => $data->identifikasiresiko_id));

                                        if (!empty($modEvaluasi->evaluasiidentifikasirisiko_id)) {
                                            echo CHtml::Link("<button class ='btn btn-sm btn-blue'> <i class='glyphicon glyphicon-pencil'> </i> </button>", Yii::app()->controller->createUrl("ProgressmonevindentifikasirisikoT/index", array("identifikasiresiko_id" => $data->identifikasiresiko_id)), array(
                                                "class" => "",
                                                "target" => "iframe4",
                                                "onclick" => "$(\"#dialogProgres\").dialog(\"open\");",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk Melihat Progress Monev",
                                                    )
                                            );
                                        } else {
                                            echo CHtml::Link("<button disabled='true' class ='btn btn-sm btn-primary'> <i class='glyphicon glyphicon-pencil'> </i> </button>", "", array(
                                                "title" => "Anda Belum Menginputkan Evaluasi Manajemen Resiko",
                                                    )
                                            );
                                        }
                                    }
                                ),
                                array(
                                    'header' => 'Batal',
                                    'type' => 'raw',
                                    'headerHtmlOptions' => array('style' => 'text-align:center;'),
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data) {
                                        if (!empty($data->identifikasiresiko_id)) {
                                            echo CHtml::Link("<i class='glyphicon glyphicon-remove' style='font-size: 14px'> </i>", Yii::app()->controller->createUrl("batal", array("identifikasiresiko_id" => $data->identifikasiresiko_id)), array(
                                                    "class" => "",
                                                    "target" => "iframeBatal",
                                                    "onclick" => "$(\"#dialogBatal\").dialog(\"open\");",
//                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk Membatalkan Risk Register",
                                                        )
                                                );
                                        } else {
                                            echo "";
                                        }
                                    }
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
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php
                            $this->renderPartial($this->path_view . '_search', array(
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
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Lihat Identifikasi Resiko',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasiae-r-grid'); }",
    ),
));
?>
<iframe src="" name="iframe2" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog detail================================
?>

<?php
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogEvaluasi',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Evaluasi Identifikasi Resiko',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasiae-r-grid'); }",
    ),
));
?>
<iframe src="" name="iframe3" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog detail================================
?>

<?php
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogProgres',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Progress Laporan Monev',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasiae-r-grid'); }",
    ),
));
?>
<iframe src="" name="iframe4" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog detail================================
?>

<?php
/* ============================== start Grading =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogGrading',
    'options' => array(
        'title' => 'Petunjuk',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 150,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeGrading" width="100%" height="320">
</iframe>

<?php
$this->endWidget();
/* =============================== end Grading ================================ */

// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatal',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Pembatalan Risk Register',
        'autoOpen' => false,
        'width' => 500,
        'height' => 300,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasiae-r-grid'); }",
    ),
));
?>
<iframe src="" name="iframeBatal" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog detail================================
?>
