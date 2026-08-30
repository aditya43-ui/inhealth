<?php
Yii::app()->clientScript->registerScript('search', "
    $('#dokumenpengadaan-m-search').submit(function(){
        $.fn.yiiGridView.update('dokumenpengadaan-m-grid', {
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
                <div class="panel-title">Informasi <strong>Dokumen Pengadaan</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Informasi <strong>Dokumen Pengadaan</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'dokumenpengadaan-m-grid',
                            'dataProvider' => $model->searchDokumenPengadaan(),
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
                                    'headerHtmlOptions' => array(
                                    'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Nama Pekerjaan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->nama_pekerjaan)) {
                                            return $data->nama_pekerjaan;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Kode Kegiatan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->kode_kegiatan)) {
                                            return $data->kode_kegiatan;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Unit Kerja',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->namaunitkerja)) {
                                            return $data->namaunitkerja;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Pejabat Pembuat Komitmen',
                                    'type' => 'raw',
                                    'value' => function ($data) {
                                        $modPegawai = PegawaiM::model()->findByPk($data->pegawaippk_id);
                                        if (!empty($modPegawai->pegawai_id)) {
                                            return $modPegawai->namaLengkap;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Kuasa Pengguna Anggaran',
                                    'type' => 'raw',
                                    'value' => function ($data) {
                                        $modPegawai = PegawaiM::model()->findByPk($data->pegawaikpa_id);
                                        if (!empty($modPegawai->pegawai_id)) {
                                            return $modPegawai->namaLengkap;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Total Pengadaan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->total_pagu)) {
                                            return 'Rp ' . number_format($data->total_pagu, 2, ',', '.');
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: right',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Metode Pengadaan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->metodepengadaan_final)) {
                                            return $data->metodepengadaan_final;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'RUP',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            return CHtml::link($data->rencanaumumpengadaan_nomor, Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/detail&id=' . $data->rencanaumumpengadaan_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        'target' => '_blank',
                                                        "title" => "Klik untuk Melihat Detail RUP"));
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Kode SIRUP',
                                    'type' => 'raw',
                                    'value' => function($data){
                                        if (!empty($data->koderup_awal) && !empty($data->koderup_final)){
                                            return $data->koderup_final;
                                        }else if (!empty($data->koderup_awal) && empty($data->koderup_final)){
                                            return $data->koderup_awal;
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Persiapan Pengadaan',
                                    'type' => 'raw',
                                    'value'=>function($data) {
                                        if(!empty($data)){
                                            return CHtml::link($data->persiapanpengadaan_nomor,
                                                    Yii::app()->createUrl('pengadaan/InformasiPersiapanPengadaan/detail&id='.$data->persiapanpengadaan_id),
                                                    array(
                                                        'class'=>'hover',
                                                        "rel"=>"tooltip",
                                                        'target' => '_blank',
                                                        "title"=>"Klik untuk Melihat Detail Persiapan Pengadaan"));
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Kontrak',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            return CHtml::link($data->nosuratperjanjiankerja ." - ". $data->nomor_dokumen, Yii::app()->createUrl('pengadaan/addendumSPK/index&suratperjanjiankerja_id=' . $data->suratperjanjiankerja_id.'&spk=true'), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        'target' => '_blank',
                                                        "title"=>"Klik untuk Melihat Detail Kontrak")); 
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Nota Dinas',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            return CHtml::link($data->notadinaspptk_nomor ." - ". $data->nomor_notadinas, Yii::app()->createUrl('pengadaan/InformasiNotadinaspptk/detail&notadinaspptk_id=' . $data->notadinaspptk_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        'target' => '_blank',
                                                        "title"=>"Klik untuk Melihat Detail Nota Dinas PPTK"));
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Status',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->status)) {
                                            return $data->status;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: left',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Kelengkapan Kontrak',
                                    'value' => function($data) {
                                                echo CHtml::link("<span style='font-size:16px;'><i class='fa fa-file-text'></i></span>",Yii::app()->createUrl('pengadaan/InformasiDokumenPengadaan/KelengkapanKonrak&id=' . $data->rencanaumumpengadaan_id),
                                                array("class" => "hover",
                                                        "rel" => "tooltip",
                                                        "target" => "_blank",
                                                        "title" => "Klik untuk Melihat Kelengkapan Kontrak"));
                                           },
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center; vertical-align: middle;'),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Berita Acara',
                                    'value' => function($data) {
                                                echo CHtml::link("<span style='font-size:16px;'><i class='fa fa-file-text'></i></span>",Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/detail&id=' . $data->rencanaumumpengadaan_id),
                                                array("rel"=>"tooltip","title"=>"Klik untuk Melihat Berita Acara",
                                                    "data-placement"=>"left",
                                                    "target"=>"frameBeritAcara", 
//                                                    "onclick"=>"$('#dialogBeritaAcara').dialog('open');",
                                                    "onclick" => "myAlert('Coming Soon')",
                                                    ));
                                           },
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center; vertical-align: middle'),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Keuangan',
                                    'value' => function($data) {
                                                echo CHtml::link("<span style='font-size:16px;'><i class='fa fa-file-text'></i></span>",Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/detail&id=' . $data->rencanaumumpengadaan_id),
                                                array("rel"=>"tooltip","title"=>"Klik untuk Melihat Keuangan",
                                                    "data-placement"=>"left",
                                                    "target"=>"frameKeuangan", 
                                                    "onclick"=>"$('#dialogKeuangan').dialog('open');",
                                                    "onclick" => "myAlert('Coming Soon')",
                                                    ));
                                           },
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center; vertical-align: middle'),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
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
                        <fieldset class="">
                        <?php
                        $this->renderPartial($this->path_view.'_search', array(
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
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Print');

$js = <<< JSCRIPT
    function cekForm(obj){
        $("#dokumenpengadaan-m-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
        window.open("${urlPrint}/"+$('#dokumenpengadaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('Print', $js, CClientScript::POS_HEAD);
?>

<?php
// ===========================Dialog Kelengkapan SPK=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogKelengkapanSPK',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Laporan Kelengkapan SPK',
    'autoOpen'=>false,
    'width'=>1200,
    'height'=>500,
    'resizable'=>false,    
     ),
));
?>
<iframe src="" name="frameKelengkapanSPK" width="100%" height="100%"></iframe>
<?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Kelengkapan SPK================================
?>
<?php
// ===========================Dialog Berita Acara=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogBeritaAcara',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Laporan Berita Acara',
    'autoOpen'=>false,
    'width'=>1200,
    'height'=>500,
    'resizable'=>false,    
     ),
));
?>
<iframe src="" name="frameBeritAcara" width="100%" height="100%"></iframe>
<?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Berita Acara================================
?>
<?php
//===============================Akhir Dialog Keuangan================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'frameKeuangan',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Laporan Keuangan',
    'autoOpen'=>false,
    'width'=>1200,
    'height'=>500,
    'resizable'=>false,    
     ),
));
?>
<iframe src="" name="frameKeuangan" width="100%" height="100%"></iframe>
<?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Keuangan================================
?>
