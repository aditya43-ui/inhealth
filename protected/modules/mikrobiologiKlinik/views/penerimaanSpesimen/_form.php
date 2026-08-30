<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penerimaanspesimen-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
?>

<?php if (count($modKirimSpesimendetail) <= 0) { ?>
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Cari Data Pengiriman Spesimen</div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label('Data Kirim Spesimen', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::hiddenField('pengirimanspesimen_id'); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'no_kirimspesimen',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompletePengirimanSpesimen') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                cekSudahAda(ui.item.no_spesimen,this);
                                setSpesimen();
                                return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'Ketik No. Kirim Spesimen',
                            'class' => 'span3 custom-only',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogKirimspesimen', 'jsFunction' => 'setCeklisSpesimen(); $("#dialogKirimspesimen").dialog("open");'),
                    ));
                    ?>
                </div>   
            </div>
        </div>
    </div>
<?php } ?>

<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Penerimaan Spesimen</div>
    </div>
    <div class="panel-body">
        <div class="panel-body table-responsive">
            <?php
            $this->renderPartial($this->path_view . '_tableDetail', array(
                'modTerimaSpesimen' => $modTerimaSpesimen,
                'modTerimaSpesimenDet' => $modTerimaSpesimenDet,
                'modKirimSpesimendetail' => $modKirimSpesimendetail,
                'modKirimSpesimen' => $modKirimSpesimen,
                'format' => $format,
                'form' => $form,
            ));
            ?>
        </div>
        <hr>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tanggal Penerimaan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php $modTerimaSpesimen->tglterimaspesimen = $format->formatDateTimeForUser($modTerimaSpesimen->tglterimaspesimen); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modTerimaSpesimen,
                        'attribute' => 'tglterimaspesimen',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('No. Penerimaan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTerimaSpesimen, 'no_terimaspesimen', array('class' => 'span3', 'readonly' => true)); ?>

                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan Penerimaan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTerimaSpesimen, 'ruanganterima_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($modTerimaSpesimen, 'ruangan_id', array('class' => 'span3', 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($modTerimaSpesimen, 'pengirimanspesimen_id', array('class' => 'span3 numbers-only', 'readonly' => false)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Nama Petugas <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($modTerimaSpesimen, 'petugasterima_id', array('class' => 'petugasterima_id required'));

                    $petugasterima_nama = "";
                    if (!empty($modTerimaSpesimen->petugasterima_id)) {
                        $peg = PegawaiM::model()->findByPk($modTerimaSpesimen->petugasterima_id);
                        $petugasterima_nama = $peg->nama_pegawai;
                    }

                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'petugasterima_nama',
                        'value' => $petugasterima_nama,
                        'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('autocompletePetugasTerima') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                        },
                                        success: function (data) {
                                            response(data);
                                        }
                                    })
                                }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                        $(this).val("");
                                        return false;
                                    }',
                            'select' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.label);
                                        $(this).parents(".controls").find(".petugasterima_id").val(ui.item.value);
                                        return false;
                                    }',
                        ),
                        'htmlOptions' => array(
                            'disabled' => false,
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 petugasterima_nama required',
                            'placeholder' => 'Ketik Nama Petugas'
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPetugasTerima'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modTerimaSpesimen, 'keterangan_penerimaan', array('rows' => 3, 'class' => 'span3', 'placeholder' => 'Keterangan Penerimaan')); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="form-actions">
            <?php $kirimkantong_id = isset($pengirimanspesimen_id) ? $pengirimanspesimen_id : null; ?>
            <?php
            echo CHtml::htmlButton($modTerimaSpesimen->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false));
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Index', array('pengirimanspesimen_id' => $kirimkantong_id)), array('class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'));
            ?>
            <?php
            if (!empty($_GET['pengirimanspesimen_id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('InformasiPengirimanSpesimen/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-green'));
            }
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPetugasTerima',
    'options' => array(
        'title' => 'Petugas Penerima',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));


$modPetugasTerima = new PegawairuanganV('search');
$modPetugasTerima->unsetAttributes();
$modPetugasTerima->ruangan_id = Yii::app()->user->getState('ruangan_id');
// $modPetugasTerima->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
$modPetugasTerima->pegawai_aktif = true;

if (isset($_GET['PegawairuanganV'])) {
    $modPetugasTerima->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'drafter-grid',
    'dataProvider' => $modPetugasTerima->search(),
    'filter' => $modPetugasTerima,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".petugasterima_id\").val(".$data->pegawai_id.");
                    $(\".petugasterima_nama\").val(\"".$data->nama_pegawai."\");
                    $(\"#dialogPetugasTerima\").dialog(\"close\");
                    return false;"))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modPetugasTerima, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array(
                'empty' => '-- Pilih --',
            )),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>



<!--end-->
<?php
$this->renderPartial($this->path_view . '_jsFunctions', array(
    'modTerimaSpesimen' => $modTerimaSpesimen,
    'modTerimaSpesimenDet' => $modTerimaSpesimenDet,
    'modKirimSpesimendetail' => $modKirimSpesimendetail,
    'modKirimSpesimen' => $modKirimSpesimen,
    'format' => $format,
    'form' => $form,
));


/* ========= Dialog buat cari Spesimen ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKirimspesimen',
    'options' => array(
        'title' => 'Daftar Pengiriman Spesimen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPengiriman = new InfopengirimanspesimenV('searchDialog');
if (isset($_GET['InfopengirimanspesimenV'])) {
    $modPengiriman->attributes = $_GET['InfopengirimanspesimenV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'spesimen-t-grid',
    'dataProvider' => $modPengiriman->searchDialog(),
    'filter' => $modPengiriman,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array(
                'class' => 'check_all_produk', 'onchange' => 'setSemuaSpesimen(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'no_spesimen' => $data["spesimen_id"],
                            'onchange' => 'setSpesimen(this);',
                            'class' => 'pilih',
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-green', 'onclick' => 'inputSpesimen();'))
        ),
        array(
            'header' => 'Spesimen ID',
            'name' => 'no_spesimen',
            'value' => '$data["no_spesimen"]',
        ),
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'value' => function($data){
                echo $data->nama_pasien;
            }
        ),
        array(
            'header' => 'No. Rekam Medik',
            'name' => 'no_rekam_medik',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Ruangan Asal',
            'name' => 'ruangan_nama',
            'value' => '$data->ruangan_nama',
        ),
        array(
            'header' => 'Jenis Spesimen',
            'name' => 'samplelab_nama',
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'daftartindakan_nama',
            'value' => '$data->daftartindakan_nama',
        ),
        array(
            'header' => 'Nomor Pengiriman',
            'name' => 'no_kirimspesimen',
            'value' => '$data->no_kirimspesimen',
        ),
        array(
                'header' => 'Waktu Pengiriman',
                'name' => 'tglkirimspesimen',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglkirimspesimen)',
                'filter' => CHtml::activeTextField($modPengiriman, 'tglkirimspesimen', array('class'=>'span3','readonly'=>true)),
        ),
        array(
            'header' => 'Petugas Pengirim',
            'name' => 'petugaskirim_id',
            'value'=>function ($data) {
                $cekPegawai = PegawaiM::model()->findByPk($data->petugaskirim_id);
                if(!empty($cekPegawai)){
                    echo $cekPegawai->namaLengkap;
                }else{
                    echo '-';
                }
            }
        ),
    ),
        'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                jQuery("#'.CHtml::activeId($modPengiriman, 'tglkirimspesimen').'").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                });
            
            }',));
$this->endWidget();

?>
