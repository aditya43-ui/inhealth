<div class="table-responsive overflow-x" >
    <?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'riskregister-m-grid',
        'dataProvider' => $model->searchInformasi(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'No',
                'filter' => false,
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                'headerHtmlOptions' => array('style' => 'text-align:center')
            ),
            array(
                'header' => 'Sumber',
                'name' => 'sumber_riskregister',
                'value' => function($data) {
                    $cekSumber = LookupM::model()->findByAttributes(array('lookup_type' => 'sumber_riskregister', 'lookup_aktif' => true, 'lookup_value' => $data->sumber_riskregister));
                    if (!empty($cekSumber)) {
                        echo $cekSumber->lookup_name;
                    } else {
                        echo $data->sumber_riskregister;
                    }
                },
            ),
            array(
                'header' => 'Deskripsi Resiko',
                'name' => 'riskregister_deskripsiresiko',
                'value' => function($data) {
                    echo $data->riskregister_deskripsiresiko;
                },
            ),
            array(
                'header' => 'Penyebab / Akar Masalah',
                'name' => 'riskregister_penyebab',
                'value' => function($data) {
                    echo $data->riskregister_penyebab;
                },
            ),
            array(
                'header' => 'Tipe / Area Risiko',
                'name' => 'tiperesiko_id',
                'value' => function($data) {
                    $cekTipe = TiperesikoM::model()->findByAttributes(array('tiperesiko_aktif' => true, 'tiperesiko_id' => $data->tiperesiko_id));
                    if (!empty($cekTipe)) {
                        echo $cekTipe->tiperesiko_nama;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'C',
                'name' => 'konsekuensi_skor',
                'type' => 'raw',
                'value' => '$data->konsekuensi_skor',
            ),
            array(
                'header' => 'L',
                'name' => 'peluang_skor',
                'type' => 'raw',
                'value' => '$data->peluang_skor',
            ),
            array(
                'header' => 'D',
                'name' => 'detectability_skor',
                'type' => 'raw',
                'value' => '$data->detectability_skor',
            ),
            array(
                'header' => 'RPN',
                'name' => 'riskregister_rpn',
                'type' => 'raw',
                'value' => '$data->riskregister_rpn',
            ),
            array(
                'header' => 'Target RPN',
                'name' => 'riskregister_targetrpn',
                'type' => 'raw',
                'value' => '$data->riskregister_targetrpn',
            ),
            array(
                'header' => 'Evaluasi Risiko',
                'name' => 'evaluasi_risiko',
                'type' => 'raw',
                'value' => function($data) {
                    $cekSumber = LookupM::model()->findByAttributes(array('lookup_type' => 'evaluasi_risiko', 'lookup_aktif' => true, 'lookup_value' => $data->evaluasi_risiko));
                    if (!empty($cekSumber)) {
                        echo $cekSumber->lookup_name;
                    } else {
                        echo $data->evaluasi_risiko;
                    }
                },
            ),
            array(
                'header' => 'Respon Risiko dan Rencana',
                'name' => 'riskregister_riskresponse',
                'type' => 'raw',
                'value' => '$data->riskregister_riskresponse',
            ),
            array(
                'header' => 'Tanggal Mulai',
                'name' => 'riskregister_tanggalmulai',
                'value' => function($data) {
                    return MyFormatter::formatDateTimeForUser($data->riskregister_tanggalmulai);
                },
            ),
            array(
                'header' => 'Batas Waktu',
                'name' => 'riskregister_tanggaltinjauan',
                'value' => function($data) {
                    return MyFormatter::formatDateTimeForUser($data->riskregister_tanggaltinjauan);
                },
            ),
            array(
                'header' => 'Penanggung Jawab Risiko',
                'name' => 'penanggungjawab',
                'type' => 'raw',
                'value' => '$data->penanggungjawab',
            ),
            array(
                'header' => 'C',
                'name' => 'konsekuensi_skor_rpnsisa',
                'type' => 'raw',
                'value' => '$data->konsekuensi_skor_rpnsisa',
            ),
            array(
                'header' => 'L',
                'name' => 'peluang_skor_rpnsisa',
                'type' => 'raw',
                'value' => '$data->peluang_skor_rpnsisa',
            ),
            array(
                'header' => 'D',
                'name' => 'detectability_skor_rpnsisa',
                'type' => 'raw',
                'value' => '$data->detectability_skor_rpnsisa',
            ),
            array(
                'header' => 'RPN Sisa',
                'name' => 'riskregister_rpnsisa',
                'type' => 'raw',
                'value' => '$data->riskregister_rpnsisa',
            ),
            array(
                'header' => 'Laporan Singkat',
                'name' => 'laporansingkat',
                'type' => 'raw',
                'value' => '$data->laporansingkat',
            ),
            array(
                'header' => 'Status',
                'name' => 'status_riskregister',
                'type' => 'raw',
                'value' => function($data) {
                    $cekSumber = LookupM::model()->findByAttributes(array('lookup_type' => 'status_riskregister', 'lookup_aktif' => true, 'lookup_value' => $data->status_riskregister));
                    if (!empty($cekSumber)) {
                        echo $cekSumber->lookup_name;
                    } else {
                        echo $data->status_riskregister;
                    }
                },
            ),
            array(
                'header' => 'Detail',
                'type' => 'raw',
                'value' => function($data) {
                    return CHtml::Link('<i class="entypo-doc-text">', Yii::app()->controller->createUrl("riskregisterT/detail", array('riskregister_id' => $data->riskregister_id, "frame" => 3, "popup" => "true")), array("class" => "",
                                "target" => "iframeDetail",
                                "onclick" => "$(\"#dialogDetail\").dialog(\"open\");",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Melihat Detail Data",
                    ));
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => 'Ubah',
                'type' => 'raw',
                'value' => function($data) {
                    $value = '';
                    if ($data->status_riskregister == 4) {
                        $value .= "<i class='entypo-pencil' disabled='disabled'>";
                    } else {
                        $value .= CHtml::link("<i class='entypo-pencil'>", Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/riskregisterT/Index", array("riskregister_id" => $data->riskregister_id)), array('rel' => 'tooltip', 'title' => 'Klik untuk Mengubah Data'));
                    }
                    return $value;
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => 'Hapus',
                'type' => 'raw',
                'value' => function($data) {
                    $value = '';
                    if ($data->status_riskregister == 4) {
                        $value .= "<i class='glyphicon glyphicon-trash'disabled='disabled'>";
                    } else {
                        $value .= '<a onclick="hapusData(' . $data->riskregister_id . ')"><i class="glyphicon glyphicon-trash"></i></a>';
//                            CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-trash"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/deleteRecord',array("id"=>$data->riskregister_id)), array(
//			'onclick' => 'hapusData(this);return false;'));
                    }
                    return $value;
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
    ));

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT
    function cekForm(obj){
            $("#riskregister-m-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#riskregister-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>        
</div>
<script type="text/javascript">
    function hapusData(id) {
        var id = id;
        var url = '<?php echo $url . "/deleteRecord"; ?>';
        myConfirm('Apakah Anda yakin untuk menghapus data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                function (data) {
                    if (data.status == 'proses_form') {
                        $.fn.yiiGridView.update('riskregister-m-grid');
                    } else {
                        myAlert('Data Gagal di Hapus');
                    }
                }, "json");
            }
        });
    }
</script>


<?php
/* ============================== start Detail =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Risk Register',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 950,
        'minHeight' => 150,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
/* =============================== end Detail ================================ */
?>