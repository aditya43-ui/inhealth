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
            <i class="entypo-newspaper"></i> Informasi <b>Pasien Rawat Darurat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pasien Rawat Darurat',
        );
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'daftarPasien-form',
                    'type' => 'horizontal',
                    'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                )); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <label for="namaPasien" class="control-label">
                                <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue' => 0, 'rel' => 'tooltip', 'onClick' => 'cekTanggal()', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal')); ?>
                                <label for="AMInfoKunjunganRDV_ceklis">Tanggal Masuk</label>
                            </label>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'nama_bin', array('placeholder' => 'Nama Panggilan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'class' => 'btn btn-default',
                            'title' => 'Ulang',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi_ambulans', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php
                echo CHtml::hiddenField('pendaftaran_id');
                echo CHtml::hiddenField('pasien_id');
                ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Darurat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasien-grid',
                    'dataProvider' => $model->searchRD(),
                    //        'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'name' => 'tgl_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->tgl_pendaftaran'
                        ),
                        //                    array(
                        //                        'header'=>'Instalasi / Poliklinik',
                        //                        'value'=>'$data->insatalasiRuangan'
                        //                    ),
                        array(
                            'name' => 'no_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran',
                        ),
                        array(
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien / Alias',
                            'value' => '$data->NamaPasienNamaBin'
                        ),
                        array(
                            'header' => 'Jenis Penjamin / Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
                        array(
                            'name' => 'Dokter',
                            'type' => 'raw',
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'name' => 'Transportasi',
                            'type' => 'raw',
                            'value' => '(!empty($data->transportasi))? $data->transportasi : "-"',
                        ),
                        array(
                            'name' => 'Cara Masuk',
                            'type' => 'raw',
                            'value' => '(!empty($data->caramasuk_nama))? $data->caramasuk_nama : "-"',
                        ),
                        array(
                            'name' => 'Rujukan',
                            'type' => 'raw',
                            'value' => '(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                        ),
                        //                    array(
                        //                       'name'=>'kelaspelayanan_nama',
                        //                        'type'=>'raw',
                        //                        'value'=>'$data->kelaspelayanan_nama',
                        //                    ),
                        array(
                            'name' => 'jeniskasuspenyakit_nama',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        //                    array(
                        //                       'name'=>'umur',
                        //                        'type'=>'raw',
                        //                        'value'=>'$data->umur',
                        //                    ),
                        array(
                            'name' => 'alamat_pasien',
                            'type' => 'raw',
                            'value' => '$data->alamat_pasien',
                        ),
                        array(
                            'header' => 'Status Periksa',
                            'type' => 'raw',
                            'value' => '$data->getStatus($data->statusperiksa,$data->pendaftaran_id)',
                        ),
                        //                    array(
                        //                        'name'=>'Pemeriksaan Pasien',
                        //                        'type'=>'raw',
                        //                        'value'=>'(!empty($data->pasienpulang_id))? "" : CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/rawatDarurat/anamnesa",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
                        //                    ),
                        //                    array(
                        //                       'header'=>'Tindak Lanjut',
                        //                       'type'=>'raw',
                        //                       'value'=>'(!empty($data->pasienpulang_id))? $data->carakeluar : CHtml::link("<i class=icon-pencil></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Menindak Lanjuti Pasien","onclick"=>"{buatSession($data->pendaftaran_id,$data->pasien_id); addPasienPulang($data->pendaftaran_id,$data->pasien_id); $(\'#dialogPasienPulang\').dialog(\'open\');}"))',    
                        //                       'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                        //                    ),
                        array(
                            'header' => 'Pemakaian Ambulans',
                            'type' => 'raw',
                            'value' => '(empty($data->pemakaianambulans_id)) ? CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
													   Yii::app()->controller->createUrl("pemakaianAmbulanPasienRS/index",array("instalasi_id"=>Params::INSTALASI_ID_RD,"pendaftaran_id"=>$data->pendaftaran_id,
																													 "modul_id"=>Yii::app()->session["modul_id"])),
													   array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk pemakaian Ambulans")) : ""',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
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
<script>
    function addPasienPulang(pendaftaran_id, pasien_id) {
        $('#pendaftaran_id').val(pendaftaran_id);
        $('#pasien_id').val(pasien_id);
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createUrl('ActionAjaxRIRD/addPasienPulang'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogPasienPulang div.divForForm').html(data.div);
                    $('#dialogPasienPulang div.divForForm form').submit(addPasienPulang);
                    jQuery('.dtPicker2-5').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','minDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                }
                else
                {
                    $('#dialogPasienPulang div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogPasienPulang').dialog('close') \",1000);
                }
            } ",
        ))
        ?>;
        return false;
    }
</script>
<?php
$urlSession = Yii::app()->createUrl('ActionAjaxRIRD/buatSessionPendaftaranPasien');
$jscript = <<< JS
function buatSession(pendaftaran_id,pasien_id)
{
    $.post("${urlSession}", { pendaftaran_id: pendaftaran_id,pasien_id: pasien_id },
        function(data){
            'sukses';
    }, "json");
}
JS;
Yii::app()->clientScript->registerScript('jsPendaftaran', $jscript, CClientScript::POS_BEGIN);
?>
<script>
    //document.getElementById('AMInfoKunjunganRDV_tgl_awal_date').setAttribute("style","display:none;");
    //document.getElementById('AMInfoKunjunganRDV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {
        var checklist = $('#AMInfoKunjunganRDV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('AMInfoKunjunganRDV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('AMInfoKunjunganRDV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('AMInfoKunjunganRDV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('AMInfoKunjunganRDV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
</script>