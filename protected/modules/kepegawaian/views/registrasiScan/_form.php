<fieldset>
    <?php
    Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sapegawai-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial('_search', array(
            'model' => $model,
        )); ?>
    </div>
    <!--search-form-->
    <hr>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'kppengangkatanpns-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#',
    )); ?>

    <?php
    if (isset($modDetails)) {
        echo $form->errorSummary($modDetails);
    }
    ?>
    <?php echo $form->errorSummary($model); ?>
    <br>
    <?php
    $konfigFinger = AlatfingerM::model()->findAll('alat_aktif = true and is_facerecognition = true');
    if (is_array($konfigFinger)) {

        echo '<div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">Perangkat Face Recognition <span class="required">*</span></label>
            <div class="controls">';
        echo CHtml::dropDownList('finger', '', CHtml::listData($konfigFinger, 'alatfinger_id', 'namaalat'), array('empty' => '-- Pilih --'));
        echo CHtml::button("connect", array("id" => "connect", "class" => 'btn btn-primary', 'style' => 'height:20px;line-height:4px;padding:0px 5px 0px 5px ;', 'onclick' => 'aktifkanFinger(this, false);'));
        echo CHtml::button("info", array("class" => 'btn btn-info', 'style' => 'height:20px;line-height:4px;padding:0px 5px 0px 5px ;', 'onclick' => '$("#infokoneksi").slideToggle();'));
        echo '</div>';
        echo '</div>';
    }
    ?>
    <style>
        #infokoneksi {
            margin-left: 80px;
            display: none;
            width: 400px;
            border: 1px solid #cccccc;
            padding: 5px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            margin-bottom: 10px;
        }

        #infokoneksi .control-label {
            width: 50px;
        }

        #infokoneksi .controls {
            margin-left: 70px;
        }
    </style>
    <div id="infokoneksi">
        <div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">Status</label>
            <div class="controls" id="status-connection">

            </div>
        </div>
        <div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">IP</label>
            <div class="controls" id="ip-connection">

            </div>
        </div>
        <div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">Lokasi</label>
            <div class="controls" id="lokasi-connection">

            </div>
        </div>
        <input type="hidden" id="alatfinger_id" name="alatfinger_id">
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Registrasi Face Recognition</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <div style='max-height:300px;overflow-y: auto;'>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sapegawai-m-grid',
                    'dataProvider' => $model->searchPegawaiAktif(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        ////'pegawai_id',
                        array(
                            'header' => 'No.',
                            'value' => '$row+1',
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $belum_ada = empty($data->alatfinger_id) ? 1 : 0;
                                $str = $belum_ada == 1 ? "Belum" : "Sudah";
                                $str .= CHtml::hiddenField('KPRegistrasifingerprint[register_foto][' . $data->pegawai_id . '][ceklis]', $belum_ada);

                                return $str;
                            }
                        ),
                        'nomorindukpegawai',
                        'nama_pegawai',
                        'jeniskelamin',
                        'kelompokpegawai.kelompokpegawai_nama',
                        'jabatan.jabatan_nama',
                        array(
                            'header' => 'Foto Pegawai',
                            'value' => function ($data) {
                                return Yii::app()->controller->renderPartial('_rowAmbilFoto', array(
                                    'model' => $data,
                                ), true);
                            },
                            'type' => 'raw',
                        ),
                    ),
                    'afterAjaxUpdate' => '
                            function(id, data){
                                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                                $("#sapegawai-m-grid .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                        }',
                )); ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            '#',
            array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
        <?php
        $content = $this->renderPartial('../tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'create', 'content' => $content)); ?>
    </div>

    <?php $this->endWidget(); ?>
</fieldset>

<?php
$getFingerUser =  Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getFingerUser');
Yii::app()->clientScript->registerScript('onheadfunction', '
    function getInformasiUser(params)
    {
        $(\'#tbl_info_user_finger\').find(\'tbody\').empty();
        $.ajax({
            dataType:"json",
            data: {idAlat:params},
            url: "' . $getFingerUser . '",
            success:function(data)
            {
                $(\'#dlgInfoUser\').dialog(\'open\');
                if(data.status == 1)
                {
                    $(\'#tbl_info_user_finger\').find(\'tbody\').append(data.form);
                }
            }
        });
    }
    
    function slide(data){
        $("."+data).slideToggle();
    }

   function openDialogini(){
        $("#dialogDetails").dialog("open");
    }
    
    function setVolume(){
        var value = $("#fisiks").val();
        $("#sapegawai-m-grid").find(".nofinger").each(function(){
            $(this).val(value);
            value++;
        });
    }
    
function aktifkanFinger(obj,disconnect){
    var idAlat = $("#finger").val();
    var data = {idAlat:idAlat};

    if (disconnect){
        data = {idAlat:idAlat,disconnect:true};
    }
    
    if (jQuery.isNumeric(idAlat)){
        $(obj).parents(".controls").find("select, input#connect").attr("disabled","disabled");
        $.ajax({
            dataType:"json",
            data: data,
            success:function(data){
                if (disconnect){
                   $("#KPRegistrasifingerprint_alatfinger_id").val("");
                   $("#finger").val("");
                   if (data.success == true){
                        if ($("#infokoneksi").not(":hidden")){
                            $("#infokoneksi").slideUp();
                        }
                        $("#status-connection").html("");
                        $("#ip-connection").html("");
                        $("#lokasi-connection").html("");
                        $("#alatfinger_id").val("");
                        $("select#finger, input#connect").removeAttr("disabled");
                    }
                }else{
                    if ($("#infokoneksi").is(":hidden")){
                        $("#infokoneksi").slideDown();
                    }
                    var statusKoneksi;
                    var is_conn = "<div class=\'control-label\' style=\'width: 0;\'>"+data.data.ipfinger+"</div>";
                    if(data.success == 1 && data.connection == true){
                        statusKoneksi = "Connect ("+data.time+") <input type=\"hidden\" value=\""+idAlat+"\" name=\"id_alat_finger\"><a onclick=\"aktifkanFinger(this, true);\" style=\"line-height:8px;\" class=\"btn btn-danger\">disconnect</a>";
                        $("#KPRegistrasifingerprint_alatfinger_id").val(idAlat);
                        is_conn = "<a href=\"#\" data-original-title=\"Click untuk mengetahui data User\" rel=\"tooltip\" onclick=\"getInformasiUser("+ idAlat +");return false;\">"+data.data.ipfinger+"</a>";
                    }
                    else{
                        $(obj).parents(".controls").find("select, input#connect").removeAttr("disabled");
                        statusKoneksi = "<div class=\'error\'>Failed";
                    }
                    $("#status-connection").html(statusKoneksi);
                    $("#ip-connection").html(is_conn);
                    $("#lokasi-connection").html("<div class=\'control-labe\' style=\'width: 0;\'>"+data.data.lokasifinger+"</div>");
                    $("#alatfinger_id").val(data.data.alatfinger_id);
                }
                
                $.fn.yiiGridView.update(\'sapegawai-m-grid\', {
                    data: $(\'#sapegawai-m-search\').serialize()
                });                
            }
        });
    }
    
    return false;
}
', CClientScript::POS_HEAD); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetails',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'No. Finger Print',
        'autoOpen' => false,
        'width' => 170,
        'height' => 140,
        'resizable' => false,
        'scroll' => false,
        'modal' => true
    ),
));
?>
<div class="awawa" width="100%" height="100%">
    <?php echo CHtml::textField('fisiks', 0, array('class' => 'numbersOnly span2')); ?>
    <?php echo CHtml::button('submit', array('class' => 'btn btn-danger', 'onclick' => 'setVolume();', 'id' => 'submitJumlahVolume')); ?>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dlgInfoUser',
        'options' =>
        array(
            'title' => 'Informasi User Finger',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 450,
            'resizable' => false,
        ),
    )
);
?>
<div style='max-height:400px;overflow-y: scroll;'>
    <table id="tbl_info_user_finger" class="table table-striped table-bordered table-condensed">
        <thead>
            <th width="10">No. </th>
            <th width="50">PIN</th>
            <th>Nama Pegawai</th>
        </thead>
        <tbody></tbody>
    </table>
</div>
<?php $this->endWidget(); ?>

<script>



</script>