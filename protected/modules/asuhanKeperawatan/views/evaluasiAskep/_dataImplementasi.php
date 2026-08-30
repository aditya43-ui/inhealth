<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($modImpl, 'no_implementasi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::hiddenField("rencanaaskep_id",(!empty($model->implementasiaskep_id)?$model->implementasiaskep->rencanaaskep_id:''),[]);
                if (!empty($modImpl->rencanaaskep_id)) {
                    echo CHtml::hiddenField('ASImplementasiaskepT[implementasiaskep_id]', $modImpl->implementasiaskep_id, array('readonly' => true));
                    echo CHtml::textField('ASImplementasiaskepT[no_implementasi]', $modImpl->no_implementasi, array('readonly' => true));
                } else {
                    echo CHtml::hiddenField('ASImplementasiaskepT[implementasiaskep_id]', $modImpl->implementasiaskep_id, array('readonly' => true));
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'ASImplementasiaskepT[no_implementasi]',
                        'value' => $modImpl->no_implementasi,
                        'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('AutocompleteImplementasi') . '",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           instalasiId: $("#ASPengkajianaskepT_instalasi_id").val(),
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
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                            'select' => 'js:function( event, ui ) {
												cekImplementasiId(ui.item.implementasiaskep_id);
                                                return false;
                                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogImplKep', 'idTombol' => 'tombolImplDialog'),
                        'htmlOptions' => array('class' => 'span3',
                            'placeholder' => 'No. Implementasi', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Perawat', 'nama_pegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modImpl, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                <?php echo CHtml::textField('ASImplementasiaskepT[nama_pegawai]', $modImpl->nama_pegawai, array('readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modImpl, 'implementasiaskep_tgl', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php echo CHtml::textField('ASImplementasiaskepT[implementasiaskep_tgl]', $modImpl->implementasiaskep_tgl, array('readonly' => true, 'class' => 'span2')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Detail Implementasi Keperawatan</label>
            <div class="controls">
                <?php
                echo CHtml::link("<i class=icon-form-detail></i>", 'javasacript:void(0)', array("rel" => "tooltip",
                    "title" => "Klik untuk melihat detail",
                    "target" => "frameDetail",
                    "onclick" => "cekImplementasi(this);",
                ));
//					echo CHtml::link(Yii::t('mds',array('{icon}'=>"<i class=\'icon-form-detail\'></i> ")), Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajian", array("pengkajianaskep_id" => $modImpl->pengkajianaskep_id)), array("target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pengkajian Keperawatan", "onclick" => "window.parent.$(\'#dialogDetail\').dialog(\'open\')")); 
                ?>
            </div>
        </div>
    </div>

</div>
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogImplKep',
    'options' => array(
        'title' => 'Pencarian Implementasi Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 420,
        'resizable' => false,
    ),
));
$modImplAskep = new ASInfoimplementasiaskepV('searchDialog');
$modImplAskep->unsetAttributes();
$modImplAskep->rencanaaskep_tgl = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['ASInfoimplementasiaskepV'])) {
    $modImplAskep->attributes = $_GET['ASInfoimplementasiaskepV'];
    $modImplAskep->no_rencana = $_GET['ASInfoimplementasiaskepV']['no_rencana'];
    $modImplAskep->nama_pegawai = $_GET['ASInfoimplementasiaskepV']['nama_pegawai'];
    $modImplAskep->rencanaaskep_tgl = $_GET['ASInfoimplementasiaskepV']['rencanaaskep_tgl'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modImplAskep->searchDialog(),
    'filter' => $modImplAskep,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectImpl",
                                        "onClick" => "
                                            $(\"#dialogImplKep\").dialog(\"close\");
											cekImplementasiId($data->implementasiaskep_id);
                                        "))',
        ),
//        array(
//            'name' => 'no_implementasi',
//            'type' => 'raw',
//            'value' => '$data->no_implementasi',
//        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '$data->nama_pasien',
        ),
        array(
            'name' => 'no_rencana',
            'type' => 'raw',
            'value' => '$data->no_rencana',
        ),
        array(
            'name' => 'rencanaaskep_tgl',
            'value' => 'MyFormatter::formatDateTimeForUser($data->rencanaaskep_tgl)',
            'filter' =>
            CHtml::activeTextField($modImplAskep, 'rencanaaskep_tgl', array('class' => 'span3', 'readonly' => true)),
        /* $this->widget('MyDateTimePicker', array(
          'model' => $modImplAskep,
          'attribute' => 'implementasiaskep_tgl',
          'mode' => 'date',
          'options' => array(
          'dateFormat' => Params::DATE_FORMAT,
          ),
          'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'implementasiaskep_tgl', 'placeholder' => '23 Jan 1993'),
          ), true
          ), */
        ),
        array(
            'header' => 'Nama Ruangan',
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modImplAskep, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif=TRUE'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
        array(
            'name' => 'nama_pegawai',
            'type' => 'raw',
            'value' => '$data->nama_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//                 jQuery(\'#rencanaaskep_tgl\').datepicker(jQuery.extend({
//                        showMonthAfterYear:false}, 
//                        jQuery.datepicker.regional[\'id\'], 
//                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
//                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
//                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
//                jQuery(\'#rencanaaskep_tgl_date\').on(\'click\', function(){jQuery(\'#implementasiaskep_tgl\').datepicker(\'show\');});
                jQuery("#' . CHtml::activeId($modImplAskep, 'rencanaaskep_tgl') . '").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                });
            
            }',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    $(document).ready(function () {
        $('input[name="ASInfoimplementasiaskepV[rencanaaskep_tgl]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>