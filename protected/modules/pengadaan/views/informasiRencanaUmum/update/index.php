<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>
<style>
    .form-horizontal .control-label{
        text-align: right;
        width: 180px
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><strong>Ubah Rencana Umum Pengadaan</strong></div>
            </div>
            <div class="panel-body">
                <?php                
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'rup-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype'=>'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                }
                $this->widget('bootstrap.widgets.BootAlert');
                ?>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Detil Pekerjaan </b> </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view_ubah.'_formRUP', array('model' => $model, 'modLokasi' => $modLokasi, 'arrLokasi' => $arrLokasi, 'lokasi' => $lokasi, 'form' => $form), true); ?>
                    </div>
                    <?php echo CHtml::hiddenField("noRow",0,array('readonly'=>true)); ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"> <b> RAB/HPS </b></div>
                        </div>
                        <div class="panel-body overflow-x">
                                <?php echo $this->renderPartial($this->path_view_ubah.'_formRAB',array('modRAB'=>$modRAB,'form'=>$form, 'model'=>$model),true); ?>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"> <b> Dana </b> </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial($this->path_view_ubah.'_formDana', array('model' => $model,'jenis' => $jenis, 'modSumberDana' => $modSumberDana, 'modDana' => $modDana ,'modJenis' => $modJenis, 'arrSumberDana' => $arrSumberDana, 'arrJenis' => $arrJenis, 'form' => $form), true); ?>
                            <?php echo CHtml::hiddenField('jenis_trans','paket',array('readonly'=>true, 'class'=>'')); ?>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"><b> Jadwal </b></div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial($this->path_view_ubah.'_formJadwal', array('model' => $model, 'form' => $form), true); ?>
                        </div>
                    </div>
                   
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"> <b> Dokumen Pendukung </b> </div>
                        </div>
                        <div class="panel-body">
                            <div class="panel-body overflow-x">
                                <?php echo $this->renderPartial($this->path_view_ubah.'_formDokDukung',array('model'=>$model,'form'=>$form, 'modDokumen' => $modDokumen),true); ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"> <b> Pejabat Pengadaan </b> </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial($this->path_view_ubah.'_formPejabat',array('model'=>$model,'form'=>$form),true); ?>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"> <b> Catatan </b></div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial($this->path_view_ubah.'_formCatatan',array('model'=>$model,'form'=>$form, 'modRiwayatPengadaan' => $modRiwayatPengadaan),true); ?>
                        </div>
                    </div>
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'form-riwayat',
                        'content' => array(
                            'content-riwayat' => array(
                                'header' => CHtml::htmlButton("<i class='icon-accordion icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat pengadaan')) . '<b> Riwayat</b>',
                                'isi' => $this->renderPartial($this->path_view_ubah.'_riwayat', array('form' => $form, 'model' => $modRiwayat), true),
                                'active' => false,
                            ),
                        ),
                    ));
                    ?>
                    <div class="row-fluid">
                        <div class="form-actions">
                            <?php echo $form->hiddenField($model, 'statusnya', array('class' => 'span4')); ?>
                            <?php if(strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DRAFT) || 
                                     strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI_TPP_RUP) ||
                                     strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK)) : ?>
                                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => false, 'onclick' => "cekSimpanRUP('ubah');return false;")); ?>
                                    <?php                                         
                                        if ($model->pegawaippk_id == Yii::app()->user->getState('pegawai_id') || $model->pegawaipembuat_id == Yii::app()->user->getState('pegawai_id') ){
                                            
                                            if(strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI_TPP_RUP) || strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DRAFT)    ){
                                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Ajukan RUP', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => false, 'onclick' => "cekSimpanRUP('ajukan');return false;")); 
                                            }else if(strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI_PPK)){ 
                                                if ($model->pegawaippk_id == Yii::app()->user->getState('pegawai_id')){
                                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Ajukan RUP', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => false, 'onclick' => "cekSimpanRUP('revisi_ppk');return false;")); 
                                                }else {
                                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Ajukan RUP', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)); 
                                                }
                                            }else{
                                                if (strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI) || strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK)){
                                                    if ($model->pegawaippk_id == Yii::app()->user->getState('pegawai_id')){
                                                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ajukan RUP', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => false, 'onclick' => "cekSimpanRUP('ajukan');return false;")); 
                                                    }else{
                                                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ajukan RUP', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)); 
                                                    }
                                                }else{
                                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Ajukan RUP', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)); 
                                                }
                                            }
                                        }else{
                                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Ajukan RUP', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)); 
                                        }
                                    ?>
                                    <?php 
                                        if((strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI) || strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI_PPK) || strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK)) && 
                                            $model->pegawaippk_id == Yii::app()->user->getState('pegawai_id') 
                                            ){
                                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Revisi Drafter', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => false, 'onclick' => "cekSimpanRUP('revisi');return false;")); 
                                        }else{
                                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Revisi Drafter', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)); 
                                        }
                                    ?>
                            
                            <?php else :                                 
                                ?>
                            
                                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)); ?>
                                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ajukan RUP', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)); ?>
                                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Revisi Drafter', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)); ?>
                            <?php endif; ?>
                            <?php
                            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('ubah&id='.$_GET['id']), array('class' => 'btn btn-danger',
                                'onclick' => 'return refreshForm(this);'));
                            ?>
                            
                            <?php 
                                echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class'=>'btn btn-success','onclick'=>'window.history.back(); return false;', 'style'=>'color: white;'));
 
                            ?>
                        </div>
                    </div>
                </div>
            <?php echo $this->renderPartial($this->path_view_ubah.'_jsFunction', 
                    array(
                            'model' => $model, 
                            'lokasi' => $lokasi, 
                            'jenis' => $jenis,
                            'modLokasi' => $modLokasi, 
                            'modSumberDana' => $modSumberDana, 
                            'modDana' => $modDana, 
                            'modJenis' => $modJenis, 
                            'form' => $form), true); 
                    echo $this->renderPartial($this->path_view_ubah.'_dialog',array());
            ?>
            <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script>    
    /**
     * Digunakan untuk menghitung di tabel RAB
     * @returns {undefined}
     */
    function hitung() {
        var total_harga = 0;
        var total_pajak = 0;
        var grandtotal = 0;
        var total_hargas = 0;
        var total_pajaks = 0;
        var grandtotals = 0;
        var grandtotalss = 0;
        var aa = 0;
        var bb = 0;
        var cc = 0;
        
        unformatNumberSemua();
//        $("#tabelRAB > tbody > tr").each(function () {
//            var volumes = $(this).find(".volume").val();
//            var hargas = $(this).find(".estimasi").val();
//            var pajaks = $(this).find(".persenpajak").val();
//            var totals = 0;
//            var hit_pajaks = 0;
//            var harga_vols = 0;
//
//            if (volumes != '' && hargas != '' && pajaks != '') {
//                volumes = parseInt(volumes);
//                hargas = parseInt(hargas);
//                pajaks = parseFloat(pajaks);
//
//                hit_pajaks = ((volumes * hargas * pajaks) / 100);
//                harga_vols = (volumes * hargas);
//
//                totals = (harga_vols) + (hit_pajaks);
//                total_hargas += harga_vols;
//                total_pajaks += hit_pajaks;
//                grandtotals += totals;
//            }
//        });
        var totals = 0;
        var hit_pajaks = 0;
        var harga_vols = 0;
        $("#tabelRAB > tbody > tr").each(function () {
            var volume = $(this).find(".volume").val();
            var harga = $(this).find(".estimasi").val();
            var pajak = $(this).find(".persenpajak").val();
//            var a = $(this).find(".volumeawal").val();
//            var b = $(this).find(".estimasiawal").val();
//            var c = $(this).find(".persenpajakawal").val();
//            var d = $(this).find(".total").val();            

            if (volume != '' && harga != '' && pajak != '') {
                volume = volume;
                harga = harga;
                pajak = pajak;

                var hit_pajak = ((volume * harga * pajak) / 100);
                var harga_vol = (volume * harga);
                console.log(hit_pajak);
                var total = (harga_vol) + (hit_pajak);
                total_harga += harga_vol;
                total_pajak += hit_pajak;
                grandtotal += parseFloat(total.toFixed(2)); 
                //----------------
//                aa = parseInt(a);
//                bb = parseInt(b);
//                cc = parseInt(c);
//                
//                hit_pajaks = ((aa * bb * cc) / 100);
//                harga_vols = (aa * bb);
//                
//                totals = (harga_vols) + (hit_pajaks);
//                total_hargas += harga_vols;
//                total_pajaks += hit_pajaks;
//                grandtotalss += totals;
                
//                if (grandtotals > d) {
//                    $(this).find('.pajak').val(hit_pajak);
//                    $(this).find('.harga').val(total);
//                    $(this).find('.volume').val(aa);
//                    $(this).find('.estimasi').val(bb);
//                    $(this).find('.persenpajak').val(cc);
                //}else{
                    //$(this).find('.pajak').val(hit_pajak);
                    $(this).find('.pajak').val(hit_pajak.toFixed(2));
                    $(this).find('.harga').val(total.toFixed(2));
//                    $(this).find('.volume').val(volume);
//                    $(this).find('.estimasi').val(harga);
//                    $(this).find('.persenpajak').val(pajak);
                //}
            }
        });

        var dpa = $("#ADRencanaumumpengadaanT_dpa_pagu").val();        
        var totItemRBA = $("#tabelRAB > tbody > tr").length;
        var totTempTempRBA = $("#totItemRAB").val();
        $("#<?php echo CHtml::activeId($model, 'total_harga') ?>").val(total_harga.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_pajak') ?>").val(total_pajak.toFixed(2));
        
        //if (grandtotal > dpa) {
            //myAlert('Total harga melebihi Pagu pada DPA');
            //$("#total_hargaseluruhnya").val(grandtotal.toFixed(2));
            //$("#total_awal").val(grandtotalss);            
            //$("#ADRencanaumumpengadaanT_dpa_pagu").val(grandtotal);
            //$("#ADRencanaumumpengadaanT_dpa_pagu_temp").val(grandtotal.toFixed(2));
        //} else {
            $("#total_hargaseluruhnya").val(grandtotal.toFixed(2));
            //$("#total_awal").val(grandtotalss);
            
            if (totItemRBA != totTempTempRBA){
                //$("#ADRencanaumumpengadaanT_dpa_pagu").val(grandtotal.toFixed(2));
                //$("#ADRencanaumumpengadaanT_dpa_pagu_temp").val(grandtotal.toFixed(2));
            }
       // }


        formatNumberSemua();
        setPaguDPA();
    }
</script>
<?php
/* ========= Dialog untuk mencari data PPDS ========================= */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogMAK',
    'options'=>array(
            'title'=>'Daftar MAK',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'height'=>500,
            'resizable'=>false,
    ),
));
$modPengadaan = new ADDokumenpelaksanaananggarandetT('search');
$modPengadaan->default = 'ada';
if(isset($_GET['ADDokumenpelaksanaananggarandetT'])){
    $modPengadaan->attributes = $_GET['ADDokumenpelaksanaananggarandetT'];
    $modPengadaan->default = isset($_GET['ADDokumenpelaksanaananggarandetT']['default'])?$_GET['ADDokumenpelaksanaananggarandetT']['default']:null;    
    $modPengadaan->kodeanggaran = isset($_GET['ADDokumenpelaksanaananggarandetT']['kodeanggaran'])?$_GET['ADDokumenpelaksanaananggarandetT']['kodeanggaran']:null;    
    $modPengadaan->subprogramkerja_nama = isset($_GET['ADDokumenpelaksanaananggarandetT']['subprogramkerja_nama'])?$_GET['ADDokumenpelaksanaananggarandetT']['subprogramkerja_nama']:null;    
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'mak-m-grid',
    'dataProvider'=>$modPengadaan->searchDialogRekMAK(),
    'filter'=>$modPengadaan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) {
                            $dt = $data->attributes;
                                                        
                            $dt['namarekening'] = $data->kodeanggaran.' - '.$data->nama_rekeninganggaran5;
                            $dt['rekeninganggaran5_id'] = $data->rekeninganggaran5_id;
                            $dt['mappingrekeninganggaran_id'] = $data->mappingrekeninganggaran_id;                            
                            $dt['subprogramkerja_nama'] = $data->subprogramkerja_nama;                            
                            
                            $res = json_encode($dt);
    
                            return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                                    "onclick" => " setPengadaan(".$res."); return false; "));
                        },
                ),                
                array(
                    'header'=>'Kegiatan',
                    'name'=>'subprogramkerja_nama',
                    'filter'=> 
                    CHtml::activeHiddenField($modPengadaan, 'default',array('class'=>'default')). 
                    CHtml::activeHiddenField($modPengadaan, 'paketpekerjaan_id',array('class'=>'paketpekerjaan_id')). 
                    CHtml::activeTextField($modPengadaan, 'subprogramkerja_nama').
                    CHtml::activeHiddenField($modPengadaan, 'subkegiatanprogram_id',array('class'=>'subkegiatanprogram_id'))
                ),                
                array(
                    'header'=>'Nama Rekening',
                    'name'=>'kodeanggaran',
                    'value'=>'$data->kodeanggaran." - ".$data->nama_rekeninganggaran5'
                ),
        ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
