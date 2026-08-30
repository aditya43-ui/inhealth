<div class="table-responsive overflow-x" >
    <?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'informasi-spk-grid',
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
                'header' => 'Tanggal & <br>Nomor Transaksi',
                'name' => 'tglsuratperjanjian',
                'value' => function($data) {
                    $tanggal = !empty($data->tglsuratperjanjian) ? MyFormatter::formatDateTimeForUser($data->tglsuratperjanjian) : '';
                    $nomor = !empty($data->nosuratperjanjiankerja) ? $data->nosuratperjanjiankerja : '';
                    echo CHtml::link($tanggal . '<br>' . $nomor, Yii::app()->createUrl('pengadaan/addendumSPK/index&suratperjanjiankerja_id=' . $data->suratperjanjiankerja_id.'&spk=true'), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        'target' => '_blank',
                                                        "title"=>"Klik untuk Melihat Detail Kontrak")); 
                },
            ),
            array(
                'header' => 'Nomor Kontrak',
                'name' => 'nomor_dokumen'
            ),
            array(
                'header' => 'Nama Pekerjaan',
                'name' => 'namapekerjaan'
            ),
            array(
                'header' => 'Penyedia',
                'name' => 'supplier_nama'
            ),
            array(
                'header' => 'Nilai Pekerjaan',
                'name' => 'nilaikontrak',
                'value' => function ($data) {
                    return 'Rp ' . number_format($data->nilaikontrak, 2, ",", ".");
                },
                'htmlOptions' => array('style' => 'text-align:right')
            ),
            array(
                'header' => 'Status',
                'name' => 'suratperjanjiankerja_status'
            ),
            array(
                'header' => 'Riwayat Addendum',
                'type' => 'raw',
                'value' => function($data){
                    $criteria = new CDbCriteria();
                    $criteria->addCondition("persiapanpengadaan_id = ".$data->persiapanpengadaan_id);
                    $criteria->addCondition('suratperjanjiankerjaasal_id is not null');
                    $criteria->order = "nomor_urut asc";
                    $cariSPK = SuratperjanjiankerjaT::model()->findAll($criteria);
                    
                    if (!empty($cariSPK)) {
                        foreach($cariSPK as $model){
                            echo CHtml::link("(".$model->nomor_urut."). ".$model->nomor_dokumen, Yii::app()->createUrl('pengadaan/addendumSPK/index&suratperjanjiankerja_id=' . $model->suratperjanjiankerja_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        'target' => '_blank',
                                                        "title"=>"Klik untuk Melihat Detail Addendum"))."<br>";
                        }
                    } else {
                        return "Belum ada Addendum";
                    }
                }
            ),
            array(
                'header' => 'Ubah',
                'type' => 'raw',
                'value' => function($data) use (&$nota, &$kirim) {
                    $nota = NotadinaspptkT::model()->find(" suratperjanjiankerja_id = ".$data->suratperjanjiankerja_id." ");
                    $kirim = PerintahpengirimanT::model()->find(" suratperjanjiankerja_id = ".$data->suratperjanjiankerja_id." ");
                    
                    $url = Yii::app()->createUrl('pengadaan/SuratPerjanjianKerja/ubah&suratperjanjiankerja_id=' . $data->suratperjanjiankerja_id.'&ubah=true');
                    $dis = '';
                    
                    if (!empty($nota) || !empty($kirim)){                        
                        $url = '';
                        $dis = 'opacity:0.5;';
                    }
                    
                    return CHtml::link('<i class="fa fa-pencil" style="font-size:15px;'.$dis.'">', $url, array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",                                                                                
                                                        "title"=>"Klik untuk mengubah kontrak"));
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => 'Addendum',
                'type' => 'raw',
                'value' => function($data) {
                    return CHtml::link('<i class="fa fa-files-o" style="font-size:15px">', Yii::app()->createUrl('pengadaan/addendumSPK/index&suratperjanjiankerja_id=' . $data->suratperjanjiankerja_id.'&transaksi=true'), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "title"=>"Klik untuk Menambahkan Addendum Kontrak"));
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => 'Batal',
                'type' => 'raw',
                'value' => function($data) use (&$nota, &$kirim) {
                    $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                                            
                    if (empty($data->isbatal)) {
                        
                        $url = Yii::app()->createUrl('pengadaan/addendumSPK/index&suratperjanjiankerja_id=' . $data->suratperjanjiankerja_id.'&transaksi=true');
                        $dis = '';

                        if (!empty($nota) || !empty($kirim)){                        
                            $url = '';
                            $dis = 'opacity:0.5;';
                        }
                        
                        if ($data->pejabatpembuatkomitmen_id == $modPegawai->pegawai_id) {
                            return CHtml::link("<i class='glyphicon glyphicon-remove' style='font-size: 16px; color: #BF0000;".$dis."'></i>", $url, array("title" => "Klik untuk Melakukan Pembatalan", "target" => "iframe4", "onclick" => "$('#dialogBatal').dialog('open');"));
                        } else {
                            return "<i class='glyphicon glyphicon-remove' style='font-size: 16px;'></i>";
                        }
                    } else {
                        if (!empty($data->batal_file)) {
                            $batal_file = CHtml::link("<i class='fa fa-file' style='font-size: 15px;'></i>", Yii::app()->createUrl('pengadaan/informasiSuratPerjanjianKerja/unduhDokumen&id=' . $data->suratperjanjiankerja_id), array("title" => "Klik untuk Mengunduh File"));
                        } else {
                            $batal_file = '';
                        }
                        echo $batal_file . " <br>" . $data->batal_alasan;
                    }
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
    ?> 
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

$js = <<< JSCRIPT
    function cekForm(obj){
            $("#informasi-spk-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#informasi-spk-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

// ===========================Dialog Batal SPK=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatal',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Kontrak',
        'autoOpen' => false,
        'width' => 550,
        'height' => 370,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasi-spk-grid', {
            data: $('#informasi-spk-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe4" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal SPK================================
?>
<script type="text/javascript">

</script>