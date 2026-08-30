<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<style>
    label.checkbox,
    label.radio {
        width: 150px;
        display: inline-block;
    }
</style>
<!--fieldset class="box"-->
<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('type', ''); ?>
        <?php //echo CHtml::hiddenField('filter_tab', 'penjamin'); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("Periode Laporan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'bln_awal',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                        'yearRange' => "-100y:+0y",
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => "span2",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Sampai Dengan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'bln_akhir',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                        'yearRange' => "-100y:+0y",
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => "span2",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group" id="formDokter">
            <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label', 'label' => 'Nama Dokter')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawaiNama',
                    'source' => 'js: function(request, response) {
                                                $.ajax({
                                                        url: "' . $this->createUrl('GetDokterSpesialis') . '",
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
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                        $(this).val("");
                                                        return false;
                                                 }',
                        'select' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.NamaLengkap);
                                                        $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                                        $("#' . CHtml::activeId($model, 'pegawaiNama') . '").val(ui.item.nama_pegawai);
                                                        return false;
                                                }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDokter', 'idTombol' => 'tombolDokterDialog'),
                    'htmlOptions' => array('placeholder' => 'Nama Tenaga Medis RS', 'onkeypress' => "return $(this).focusNextInputField(event);"),
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions" style="margin: 0 !important;">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'
        )
    );
    ?>
</div>
<?php //$this->widget('UserTips', array('type' => 'create')); 
?>
<!--</fieldset>-->
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php
Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<?php
//========= Dialog buat cari data dokter =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Data Pegawai Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$pegawai = new DokterspesialisV();
if (isset($_GET['PegawaiV'])) {
    $pegawai->attributes = $_GET['PegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokter-t-grid',
    'dataProvider' => $pegawai->searchDokterSpesialis(),
    'filter' => $pegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogDokter\").dialog(\"close\");
											
                                            $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                            $(\"#' . CHtml::activeId($model, 'pegawaiNama') . '\").val(\"$data->gelardepan"." "."$data->nama_pegawai".", "."$data->gelarbelakang_nama\");
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai'
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    //         $(document).ready(function(){
    //            ubahJnsPeriode();
    //            var pegawai_dokter  = jQuery('#<?php // echo CHtml::activeId($model, 'pegawai_id') 
                                                    ?>');		
    //            jQuery(pegawai_dokter).multiselect({
    //                includeSelectAllOption: true,
    //                buttonClass: "form-control",
    //                maxHeight: 300,
    //                buttonWidth: '182px',
    //                enableCaseInsensitiveFiltering: true
    //            }).hide();
    //         })
    //         
    //        function ubahJnsPeriode(){
    //        var obj = $("#<?php // echo CHtml::activeId($model, 'jns_periode')
                            ?>");
    //        if(obj.val() == 'hari'){
    //            $('.hari').show();
    //            $('.bulan').hide();
    //            $('.tahun').hide();
    //        }else if(obj.val() == 'bulan'){
    //            $('.hari').hide();
    //            $('.bulan').show();
    //            $('.tahun').hide();
    //        }else if(obj.val() == 'tahun'){
    //            $('.hari').hide();
    //            $('.bulan').hide();
    //            $('.tahun').show();
    //        }
    //    }
</script>