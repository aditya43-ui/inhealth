<style>
    .button-status {
        margin-right: 8px;
    }

    .badge-status {
        position: relative;
        top: 12px;
        left: 8px;
    }

    .btn-status {
        min-width: 190px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Informasi <b>Pasien Rawat Inap</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pasien Rawat Inap',
        );
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        Yii::app()->clientScript->registerScript('cari wew', "
       $('#daftarPasiesn-form').submit(function(){
               $.fn.yiiGridView.update('daftarPasien-grid', {
                       data: $(this).serialize()
               });
               return false;
       });
       ");
        //echo Yii::app()->user->getState('ruangan_id');
        ?>
        <?php echo $this->renderPartial('_searchPasienRI', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Inap</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasien-grid',
                    'dataProvider' => $model->searchRILagi(),
                    //                'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Admisi / Masuk Kamar',
                            'type' => 'raw',
                            'value' => '$data->tglAdmisiMasukKamar'
                        ),
                        //                    'ruangan_nama',
                        array(
                            'name' => 'caramasuk_nama',
                            'type' => 'raw',
                            'value' => '$data->caramasuk_nama',
                        ),
                        array(
                            'header' => 'No. RM / No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->noRmNoPend',
                        ),
                        array(
                            'header' => 'Nama Pasien / Panggilan',
                            'value' => '$data->namaPasienNamaBin'
                        ),
                        array(
                            'name' => 'jeniskelamin',
                            'value' => '$data->jeniskelamin',
                        ),
                        array(
                            'name' => 'umur',
                            'value' => '$data->umur',
                        ),
                        array(
                            'name' => 'Dokter',
                            'type' => 'raw',
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'header' => 'Jenis Penjamin / Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
                        array(
                            'name' => 'kelaspelayanan_nama',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan_nama',
                        ),
                        array(
                            'name' => 'jeniskasuspenyakit_nama',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'name' => 'kamarruangan_nokamar',
                            'type' => 'raw',
                            'value' => '(!empty($data->kamarruangan_nokamar))? $data->kamarruangan_nokamar : "-"',
                            //                        'value'=>'(!empty($data->kamarruangan_nokamar))? $data->kamarruangan_nokamar : CHtml::link("<i class=icon-home></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Memasukan Pasien Ke kamar","onclick"=>"{buatSessionMasukKamar($data->masukkamar_id,$data->kelaspelayanan_id,$data->pendaftaran_id); addMasukKamar(); $(\'#dialogMasukKamar\').dialog(\'open\');}"))',    
                        ),
                        array(
                            'header' => 'Status Periksa',
                            'type' => 'raw',
                            'value' => '$data->getStatus($data->statusperiksa,$data->pendaftaran_id)',
                        ),
                        //                    array(
                        //                       'header'=>'Pindah Kamar',
                        //                       'type'=>'raw',
                        //                       'value'=>'(!empty($data->pasienpulang_id) ? $data->carakeluar : CHtml::link("<i class=\'icon-share\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/PindahKamarPasienRI",array("pendaftaran_id"=>$data->pendaftaran_id)) ,array("title"=>"Klik untuk Pindah Kamar","target"=>"iframe", "onclick"=>"$(\"#dialogPindahKamar\").dialog(\"open\");", "rel"=>"tooltip"))) ',
                        //                    ),
                        //                    array(
                        //                        'name'=>'Pemeriksaan Pasien',
                        //                        'type'=>'raw',
                        //                        'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/rawatInap/anamnesa",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
                        //                        'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                        //                    ),
                        array(
                            'header' => 'Pemakaian Ambulans',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => '(empty($data->pemakaianambulans_id)) ? CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
													   Yii::app()->controller->createUrl("pemakaianAmbulanPasienRS/index",array("instalasi_id"=>Params::INSTALASI_ID_RI,"pendaftaran_id"=>$data->pendaftaran_id,
																													 "modul_id"=>Yii::app()->session["modul_id"])),
													   array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk pemakaian Ambulans")) : ""',
                        )
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk pasienpulang_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPasienPulang',
    'options' => array(
        'title' => 'Pasien Pulang',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 600,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>
<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogMasukKamar',
    'options' => array(
        'title' => 'Masuk Kamar Rawat Inap',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 200,
        'resizable' => false,
    ),
));
$this->endWidget();
//========= end masukkamar_t dialog =============================
?>
<?php
// Dialog untuk pindahkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPindahKamar',
    'options' => array(
        'title' => 'Pindah Kamar Rawat Inap',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 200,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframe" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>
<?php
// Dialog untuk pindahkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogTindakLanjut',
    'options' => array(
        'title' => 'Pindah Kamar Rawat Inap',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 700,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeTindakLanjut" width="100%" height="900"></iframe>
<?php
$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>
<script>
    //document.getElementById('AMPasienrawatinapV_tgl_awal_date').setAttribute("style","display:none;");
    //document.getElementById('AMPasienrawatinapV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {
        var checklist = $('#AMPasienrawatinapV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('AMPasienrawatinapV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('AMPasienrawatinapV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('AMPasienrawatinapV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('AMPasienrawatinapV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
</script>