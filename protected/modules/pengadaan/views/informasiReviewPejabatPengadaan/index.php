<?php
Yii::app()->clientScript->registerScript('search', "
    $('#informasireview-v-search').submit(function(){
        $.fn.yiiGridView.update('informasireview-v-grid', {
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
                <div class="panel-title">Informasi <strong>Review Pejabat Pengadaan</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Informasi <strong>Review Pejabat Pengadaan</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'informasireview-v-grid',
                            'dataProvider' => $model->searchInformasi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'replaceUrl' => true,
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Nomor dan Tanggal',
                                    'type' => 'raw',
                                    'value' => function ($data) {
                                        return CHtml::link($data->persiapanpengadaan_nomor . " <br> " . MyFormatter::formatDateTimeForUser($data->create_time), Yii::app()->createUrl('pengadaan/informasiReviewPejabatPengadaan/detail&id=' . $data->persiapanpengadaan_id), array(
                                                    'class' => 'hover',
                                                    "rel" => "tooltip",
                                                    "data-placement" => "left",
                                                    "title" => "Klik untuk menampilkan detil Persiapan Pengadaan"));
                                    }
                                ),
                                array(
                                    'header' => 'Nama Pekerjaan',
                                    'value' => function ($data) {
                                        echo $data->nama_pekerjaan;
                                    }
                                ),
                                array(
                                    'header' => 'Nilai HPS',
                                    'value' => function ($data) {
                                        echo MyFormatter::formatUang($data->total_hps, "Rp.", 2);
                                    }
                                ),
                                array(
                                    'header' => 'Tahun Anggaran',
                                    'value' => function ($data) {
                                        echo $data->rencanaumumpengadaan_tahun;
                                    }
                                ),
                                array(
                                    'header' => 'Pejabat Pembuat Komitmen',
                                    'value' => function ($data) {
                                        $modPegawai = PegawaiM::model()->findByPk($data->pegppk_id);
                                        echo $modPegawai->namaLengkap;
                                    }
                                ),
                                array(
                                    'header' => 'Pejabat Pengadaan',
                                    'value' => function ($data) {
                                        if (!empty($data->pegpengadaan_id)) {
                                            $modPegawai = PegawaiM::model()->findByPk($data->pegpengadaan_id);
                                            echo $modPegawai->namaLengkap;
                                        } else {
                                            echo "-";
                                        }
                                            
                                    }
                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => function ($data) {
                                        echo $data->infoumumpengadaan_status;
                                    }
                                ),
                                array(
                                    'header' => 'Review',
                                    'htmlOptions' => array('style' => 'text-align: center',),
                                    'type' => 'raw',
                                    'value' => function ($data) {
                                        if (($data->create_loginpemakai_id == Yii::app()->user->getState('loginpemakai_id') ||
                                                $data->pegpa_id == Yii::app()->user->getState('pegawai_id') ||
                                                $data->pegppk_id == Yii::app()->user->getState('pegawai_id') ||
                                                $data->pegpengadaan_id == Yii::app()->user->getState('pegawai_id') ||
                                                $data->pegkpa_id == Yii::app()->user->getState('pegawai_id')) && $data->infoumumpengadaan_status !== "Dilanjutkan") {
                                            return CHtml::link("<span style='font-size:15px; color: red'><i class='entypo-docs'></i></span>", Yii::app()->createUrl('pengadaan/informasiReviewPejabatPengadaan/review&id=' . $data->persiapanpengadaan_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "data-placement" => "left",
                                                        "title" => "Klik untuk Menambahkan Review Pejabat Pengadaan"));
                                        } else {
                                            return "<span style='font-size:15px;'><i class='entypo-docs'></i></span>";
                                        }
                                    }
                                ),
                                array(
                                    'header' => 'Revisi Dokumen',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center',),
                                    'value' => function ($data) {
                                        if (($data->create_loginpemakai_id == Yii::app()->user->getState('loginpemakai_id') ||
                                                $data->pegpa_id == Yii::app()->user->getState('pegawai_id') ||
                                                $data->pegppk_id == Yii::app()->user->getState('pegawai_id') ||
                                                $data->pegpengadaan_id == Yii::app()->user->getState('pegawai_id') ||
                                                $data->pegkpa_id == Yii::app()->user->getState('pegawai_id')) && $data->infoumumpengadaan_status !== "Dilanjutkan") {
                                            return CHtml::link("<span style='font-size:15px; color: green'><i class='fa fa-pencil'></i></span>", Yii::app()->createUrl('pengadaan/informasiReviewPejabatPengadaan/updateDokumen&id=' . $data->persiapanpengadaan_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "data-placement" => "left",
                                                        "title" => "Klik untuk Menambahkan Revisi Dokumen"));
                                        } else {
                                            echo "<span style='font-size:15px;'><i class='fa fa-pencil'></i></span>";
                                        }
                                    }
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>                            
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>        
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

$js = <<< JSCRIPT
    function cekForm(obj){
        $("#informasireview-v-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
        window.open("${urlPrint}/"+$('#informasireview-v-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=800px, height=800');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>