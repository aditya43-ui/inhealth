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
<style>
.red {
background-color: #FF0000
}
.yellow {
   background-color: #FFFF00;
}
.green {
   background-color: #00FF00;
}
</style>

<?php

$modul_login = Yii::app()->user->getState('modul_id');
$modul_hide = [6, 7, 72];

$hide_edit = in_array($modul_login, $modul_hide) ? "hidden" : "";

?>
<?php $visible = isset($_GET['lihat']) ? false : true; ?>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>Pencarian</strong></div>
    </div>
    <div class="panel-body">

        <form class="form-horizontal" id="searchriwayatcppt">
        <div class="row">
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Profesional Pemberi Asuhan (PPA)",'', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($modelRiwayat,'ppa_jenis', LookupM::getItems('cppt_pemberiasuhan') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Ruangan",'', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($modelRiwayat,'ruangan_id', CHtml::listData(RuangantransferpasienV::model()->findAll(array(
                            'order'=>'instalasi_id, ruangan_nama'
                        )), 'ruangan_id', 'ruangan_nama') ,array(
                            'onkeypress'=>"return $(this).focusNextInputField(event)", 
                            'class'=>'span3 riwayat_ruangan_id',
                            'multiple'=>'multiple',
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary btn-cari', 'type'=>'submit')); ?>
        </div>
        </form>
    </div>
</div>
<div style="padding: 15px; width: 70%; color: black; border: 1px solid black">
    Kode Profesional Asuhan (PPA): (1) Dokter Spesialis/DPJP, (2) Dokter Umum, (3) Perawat/ Bidan, (4) Apoteker, (5) Ahli Gizi, (6) Fisiotherapis, (7) Lainnya
</div>
<br />
<div style="overflow: auto;">

<?php
    $column = array(
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
            'value' => function($data){
                $values = "";

                if($data->ppa_jenis!=5){
                    $values .= "<p><b>S</b> : ".preg_replace('#</?p.*?>#is', '', $data->soap_subjective).'</p>';
                    $values .= "<p><b>O</b> : ".preg_replace('#</?p.*?>#is', '', $data->soap_objective).'</p>';
                    $values .= "<p><b>A</b> : ".preg_replace('#</?p.*?>#is', '', $data->soap_asesmen).'</p>';
                    $values .= "<p><b>P</b> : ".preg_replace('#</?p.*?>#is', '', $data->soap_planning).'</p>';
                }else{
                    $values .= "<p><b>A</b> : ".preg_replace('#</?p.*?>#is', '', $data->soapgizi_asesmen).'</p>';
                    $values .= "<p><b>D</b> : ".preg_replace('#</?p.*?>#is', '', $data->soapgizi_diagnosagizi).'</p>';
                    $values .= "<p><b>I</b> : ".preg_replace('#</?p.*?>#is', '', $data->soapgizi_intervensi).'</p>';
                    $values .= "<p><b>M</b> : ".preg_replace('#</?p.*?>#is', '', $data->soapgizi_monitoring).'</p>';
                    $values .= "<p><b>E</b> : ".preg_replace('#</?p.*?>#is', '', $data->soapgizi_evaluasi).'</p>';
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
                    $peg_validasi[] = $data->dpjp_id;
                    $peg_validasi[] = $data->dpjp->namaLengkap;
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
                    echo "<div class='yellow'><b>Sudah diverifikasi oleh : <br />".(isset($data->dpjp_id)? $data->dpjp->namaLengkap : "-").'<br /> Tgl : <br />'.MyFormatter::formatDateTimeForUser($data->verifikasidpjp_tanggal).'<br />'.CHtml::link("<icon class='icon-form-detailtagihan'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/reviewVerifikasiDpjp', array("cpptpasien_id"=>$data->cpptpasien_id,'type'=>'review',"frame"=>true)), array("target"=>"frameHasilReview","rel"=>"tooltip", "title"=>"Klik untuk Lihat Hasil Review", "onclick"=>"$('#dialogHasilReview').dialog('open');"))."</b></div>";
                }else{
                    echo "". CHtml::link("<div style='background-color:red'><icon class='icon-form-verifikasi'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/reviewVerifikasiDpjp', array("cpptpasien_id"=>$data->cpptpasien_id,'type'=>'verifikasi',"frame"=>true)), array("target"=>"frameVerifikasi","rel"=>"tooltip", "title"=>"Klik untuk Review & Verifikasi DPJP", "onclick"=>$dataDialog))."</div>";
                }

            },
            'htmlOptions'=>array('style'=>'text-align: center;'),
        ),
    );

    if(!$hide_edit && $visible) {
        array_push($column, 
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'value'=>function($data) {
                if($data->pegawaippa_id==Yii::app()->user->getState('pegawai_id')){
                    return CHtml::link('<i class="entypo-pencil" style="font-size:14pt"></i>', Yii::app()->controller->createUrl('index', array(
                        'pendaftaran_id'=>$data->pendaftaran_id,
                        'cpptpasien_id'=>$data->cpptpasien_id,
                    )));
                }else{
                    return "";                      
                }

            },
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
        )
        );
    }

    if($visible) {
        array_push($column,
            array(
                'header' => 'Hapus',
                'type' => 'raw',
                'value'=>function($data, $row) {
                    if($data->pegawaippa_id==Yii::app()->user->getState('pegawai_id')){
                        $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('pegawai_id'), $data->create_ruangan_id, $data->create_petugaspengisi_id);
    
                        $onclick = 'window.parent.myAlert("Data tidak dapat dihapus karena sudah valid")';
                        if($row == 0) {
                            $onclick = 'hapusRiwayatCPPT('.$data->cpptpasien_id.', ' . $bisa_hapus . '); return false';
                        }
                         return CHtml::link('<i class="entypo-trash" style="font-size:14pt"></i>', '#', array(
                            'onclick'=>$onclick
                        ));
                    }else{
                        return "";
                    }
                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ),
        );
    }

?>
    <?php
    $modelRiwayat->pasien_id = $modPendaftaran->pasien_id;
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'riwayatcppt-t-grid',
        'dataProvider'=>$modelRiwayat->searchRiwayat(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'dropdownItemKelipatan'=>5,
        'columns'=> $column,
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>
<br />
<div>
    <?php $this->renderPartial($this->path_view.'_tombolPrinout',array('modPendaftaran'=>$modPendaftaran)); ?>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogVerifikasi',
        'options' => array(
            'title' => 'Review & Verifikasi DPJP',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 400,
            'resizable' => false,
            'close'=>"js:function(){ $.fn.yiiGridView.update('riwayatcppt-t-grid', {
                            data: $(this).serialize()
                    }); }",
        ),
));
?>
<iframe name='frameVerifikasi' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
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

</script>
