<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); 
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($modRencana, 'no_rencana', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                if (!empty($modRencana->rencanaaskep_id)) {
                    echo CHtml::hiddenField('ASRencanaaskepT[iskeperawatan]', $modRencana->iskeperawatan, array('readonly' => true));
                    echo CHtml::hiddenField('ASRencanaaskepT[rencanaaskep_id]', $modRencana->rencanaaskep_id, array('readonly' => true));
                    echo CHtml::textField('ASRencanaaskepT[no_rencana]', $modRencana->no_rencana, array('readonly' => true));
                } else {
                    echo CHtml::hiddenField('ASRencanaaskepT[iskeperawatan]', $modRencana->iskeperawatan, array('readonly' => true));
                    echo CHtml::hiddenField('ASRencanaaskepT[rencanaaskep_id]', $modRencana->rencanaaskep_id, array('readonly' => true));
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'ASRencanaaskepT[no_rencana]',
                        'value' => $modRencana->no_rencana,
                        'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('AutocompleteRencana') . '",
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
												cekRencanaId(ui.item.rencanaaskep_id);
                                                return false;
                                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogRencanaKep', 'idTombol' => 'tombolRencanaDialog'),
                        'htmlOptions' => array(
                            'class' => 'span3',
                            'placeholder' => 'No. Rencana', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modRencana, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                <?php echo CHtml::textField('ASRencanaaskepT[nama_pegawai]', $modRencana->nama_pegawai, array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modRencana, 'rencanaaskep_tgl', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php echo CHtml::textField('ASRencanaaskepT[rencanaaskep_tgl]', $modRencana->rencanaaskep_tgl, array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php
                echo CHtml::link("<i class=icon-form-detail></i>", 'javascript:void(0)', array(
                    "rel" => "tooltip",
                    "title" => "Klik untuk melihat detail",
                    "target" => "frameDetail",
                    "onclick" => "cekRencana(this);",
                ));
                //					echo CHtml::link(Yii::t('mds',array('{icon}'=>"<i class=\'icon-form-detail\'></i> ")), Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajian", array("pengkajianaskep_id" => $modRencana->pengkajianaskep_id)), array("target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pengkajian Keperawatan", "onclick" => "window.parent.$(\'#dialogDetail\').dialog(\'open\')")); 
                ?>
            </div>
        </div>
    </div>

</div>
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRencanaKep',
    'options' => array(
        'title' => 'Pencarian Rencana Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 420,
        'resizable' => false,
    ),
));
$modRencanaAskep = new ASInforencanaaskepV('searchDialog');
$modRencanaAskep->unsetAttributes();
$modRencanaAskep->rencanaaskep_tgl = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['ASInforencanaaskepV'])) {
    $modRencanaAskep->attributes = $_GET['ASInforencanaaskepV'];
    $modRencanaAskep->no_pengkajian = $_GET['ASInforencanaaskepV']['no_pengkajian'];
    $modRencanaAskep->nama_pegawai = $_GET['ASInforencanaaskepV']['nama_pegawai'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modRencanaAskep->searchDialog(),
    'filter' => $modRencanaAskep,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectRencana",
                                        "onClick" => "
                                            $(\"#dialogRencanaKep\").dialog(\"close\");
											cekRencanaId($data->rencanaaskep_id);
                                        "))',
        ),
        array(
            'name' => 'no_rencana',
            'type' => 'raw',
            'value' => '$data->no_rencana',
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '$data->nama_pasien',
        ),
        array(
            'name' => 'no_pengkajian',
            'type' => 'raw',
            'value' => '$data->no_pengkajian',
        ),
        array(
            'header' => 'Tgl. Rencana Keperawatan',
            'name' => 'rencanaaskep_tgl',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->rencanaaskep_tgl)',
            'filter' =>
            CHtml::activeTextField($modRencanaAskep, 'rencanaaskep_tgl', array('class' => 'span3', 'readonly' => true)),
            /*$this->widget('MyDateTimePicker', array(
				'model' => $modRencanaAskep,
				'attribute' => 'rencanaaskep_tgl',
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'rencanaaskep_tgl', 'placeholder' => '23 Jan 1993'),
					), true
			),*/
        ),
        array(
            'header' => 'Nama Ruangan',
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modRencanaAskep, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif=TRUE'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
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
//                jQuery(\'#rencanaaskep_tgl_date\').on(\'click\', function(){jQuery(\'#rencanaaskep_tgl\').datepicker(\'show\');});
                jQuery("#' . CHtml::activeId($modRencanaAskep, 'rencanaaskep_tgl') . '").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                });
            
            }',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    $(document).ready(function() {
        $('input[name="ASInforencanaaskepV[rencanaaskep_tgl]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>