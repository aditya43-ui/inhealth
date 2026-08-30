<?php
Yii::app()->clientScript->registerScript('search', "
    $('#searchriwayatcppt').submit(function(){
        $.fn.yiiGridView.update('riwayatcppt-t-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");


?>
<!--  -->
<div style="overflow: auto;">

    <?php
    $modelRiwayat->pasien_id = $modPendaftaran->pasien_id;
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'riwayatcppt-t-grid',
        'dataProvider' => $modelRiwayat->searchRiwayat(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
        'dropdownItemKelipatan' => 5,
        'columns' => array(
            array(
                'header' => 'Tanggal Pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)'
            ),
            array(
                'header' => 'Ruangan',
                'type' => 'raw',
                'value' => '$data->ruangan->ruangan_nama'
            ),
            array(
                'header' => 'Tanggal/ Jam Input CPPT',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_cppt)'
            ),
            array(
                'header' => 'Kode PPA',
                'type' => 'raw',
                'value' => '$data->ppa_jenis'
            ),
            array(
                'header' => 'Nama Profesional Pemberi Asuhan (PPA)',
                'type' => 'raw',
                'value' => '$data->pegawaippa->namaLengkap'
            ),
            array(
                'header' => 'Hasil Pemeriksaan, Analisa dan Tindak Lanjut <br /> Subjective, Objective, Assesment, Planning (SOAP)/ ADIME',
                'type' => 'raw',
                'value' => function ($data) {
                    $values = "";

                    if ($data->ppa_jenis != 5) {
                        $values .= "<p><b>S</b> : " . preg_replace('#</?p.*?>#is', '', $data->soap_subjective) . '</p>';
                        $values .= "<p><b>O</b> : " . preg_replace('#</?p.*?>#is', '', $data->soap_objective) . '</p>';
                        $values .= "<p><b>A</b> : " . preg_replace('#</?p.*?>#is', '', $data->soap_asesmen) . '</p>';
                        $values .= "<p><b>P</b> : " . preg_replace('#</?p.*?>#is', '', $data->soap_planning) . '</p>';
                    } else {
                        $values .= "<p><b>A</b> : " . preg_replace('#</?p.*?>#is', '', $data->soapgizi_asesmen) . '</p>';
                        $values .= "<p><b>D</b> : " . preg_replace('#</?p.*?>#is', '', $data->soapgizi_diagnosagizi) . '</p>';
                        $values .= "<p><b>I</b> : " . preg_replace('#</?p.*?>#is', '', $data->soapgizi_intervensi) . '</p>';
                        $values .= "<p><b>M</b> : " . preg_replace('#</?p.*?>#is', '', $data->soapgizi_monitoring) . '</p>';
                        $values .= "<p><b>E</b> : " . preg_replace('#</?p.*?>#is', '', $data->soapgizi_evaluasi) . '</p>';
                    }

                    return $values;
                }
            ),
            array(
                'header' => 'Intruksi Tenaga Kesehatan Pasca Bedah/ Prosedur',
                'type' => 'raw',
                'value' => '$data->instruksi'
            ),
            array(
                'header' => 'Status Review dan Verifikasi DPJP',
                'type' => 'raw',
                'value' => function($data){

                    $peg_validasi = array();
                    $peg_validasi_nama = array();

                    if (!empty($data->dpjp)) {
                        $peg_validasi[] = $data->pegawaippa_id;
                        $peg_validasi[] = $data->pegawaippa->namaLengkap;
                    }
                    if (!empty($data->pegawaippa)) {
                        $peg_validasi_nama[] = $data->pegawaippa_id;
                        $peg_validasi_nama[] = $data->pegawaippa->namaLengkap;
                    }

                    $dataDialog = 'myAlert("Hanya '.implode(", ", $peg_validasi_nama).' yang bisa mengakses");';


                    if(in_array(Yii::app()->user->getState('pegawai_id'), $peg_validasi)){
                        $dataDialog = "$('#dialogVerifikasi').dialog('open');";
                    }
                    if($data->isverifikasidpjp==true){
                        $html = "Sudah diverifikasi oleh : <br />".(isset($data->dpjp_id)? $data->dpjp->namaLengkap : "-").'<br /> Tgl : <br />'.MyFormatter::formatDateTimeForUser($data->verifikasidpjp_tanggal).'<br />'.CHtml::link("<icon class='icon-form-detailtagihan'></icon> ", Yii::app()->createUrl('/rekamMedis/cPPTRK/reviewVerifikasiDpjp', array("cpptpasien_id"=>$data->cpptpasien_id,'type'=>'review',"frame"=>true)), array("target"=>"frameHasilReview","rel"=>"tooltip", "title"=>"Klik untuk Lihat Hasil Review", "onclick"=>"$('#dialogHasilReview').dialog('open');"));
                    }else{
                        $html = CHtml::link("<icon class='icon-form-verifikasi'></icon> ", Yii::app()->createUrl('/rekamMedis/cPPTRK/reviewVerifikasiDpjp', array("cpptpasien_id"=>$data->cpptpasien_id,'type'=>'verifikasi',"frame"=>true)), array("target"=>"frameVerifikasi","rel"=>"tooltip", "title"=>"Klik untuk Review & Verifikasi DPJP", "onclick"=>$dataDialog));
                    }

                    return $html;
                },
                'htmlOptions'=>array('style'=>'text-align: center;'),
            ),
            array(
                'header' => 'Ubah',
                'type' => 'raw',
                'value'=>function($data) {
                    if($data->pegawaippa_id==Yii::app()->user->getState('pegawai_id')){
                        return CHtml::link('<i class="entypo-pencil" style="font-size:14pt"></i>', Yii::app()->controller->createUrl('/rekamMedis/cPPTRK/index', array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                            'cpptpasien_id'=>$data->cpptpasien_id,
                        )));
                    }else{
                        return "";                      
                    }

                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
            array(
                'header' => 'Hapus',
                'type' => 'raw',
                'value'=>function($data) {
                    if($data->pegawaippa_id==Yii::app()->user->getState('pegawai_id')){
                            return CHtml::link('<i class="entypo-trash" style="font-size:14pt"></i>', '#', array(
                            'onclick'=>'hapusRiwayatCPPT('.$data->cpptpasien_id.'); return false'
                        ));
                    }else{
                        return "";
                    }
                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
    <?php //$this->renderPartial('rawatDarurat.views.cppt._tombolPrinout',array('modPendaftaran'=>$modPendaftaran)); 
    ?>

    <div style="float:right;">
        <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'buttons' => array(
                array('label' => 'Cetak CPPT Pasien', 'icon' => MyIcon::getIcons('cetak'), 'url' => 'javascript:void(0)', 'htmlOptions' => array('onclick' => 'printRiwayat(' . $modPendaftaran->pendaftaran_id . ',"PRINT")')),
                array('label' => '', 'items' => array(
                    array('label' => 'PDF', 'icon' => MyIcon::getIcons('pdf'), 'url' => '', 'itemOptions' => array('onclick' => 'printRiwayat(' . $modPendaftaran->pendaftaran_id . ',"PDF")')),
                )),
            ),
        )); ?>
    </div>
</div>

<div>

</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogVerifikasi',
    'options' => array(
        'title' => 'Review & Verifikasi DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 400,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('riwayatcppt-t-grid', {
                            data: $(this).serialize()
                    }); }",
    ),
));
?>
<iframe name='frameVerifikasi' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogHasilReview',
    'options' => array(
        'title' => 'Hasil Review DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<iframe name='frameHasilReview' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function() {
        jQuery(".riwayat_ruangan_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });

    function printRiwayat(pendaftaran_id, caraPrint) {
        window.open('<?php echo $this->createUrl('/rekamMedis/CPPTRK/print'); ?>&pendaftaran_id=' + pendaftaran_id + '&caraPrint=' + caraPrint + '&' + $("#searchriwayatcppt :input").serialize(), 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
    function hapusRiwayatCPPT(id) {
    myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('/rekamMedis/CPPTRK/hapusRiwayatCPPT'); ?>', {id: id}, function(data) {
                if (data.sukses === 1) {
                    myAlert(data.msg);
                    $.fn.yiiGridView.update('riwayatcppt-t-grid', {
                        data: $('#searchriwayatcppt').serialize()
                    });
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}
</script>