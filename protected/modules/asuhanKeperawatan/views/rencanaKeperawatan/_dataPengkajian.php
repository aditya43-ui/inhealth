<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="">
	<div class="row">
		<div class="control-group">
			<?php echo CHtml::label('Pengkajian Kebidanan', 'iskeperawatan', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::checkBox('iskeperawatan', false, array('uncheckValue' => 0, 'onclick' => 'cekListKebidanan(this)', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				<?php echo CHtml::activeHiddenField($modPengkajian, 'anamesa_id', array('readonly' => true, 'class' => 'span1')); ?>
				<?php echo CHtml::activeHiddenField($modPengkajian, 'pemeriksaanfisik_id', array('readonly' => true, 'class' => 'span1')); ?>
				<?php echo CHtml::hiddenField('ASPengkajianaskepT[pengkajianaskep_id]', $modPengkajian->pengkajianaskep_id, array('readonly' => true)); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">

			<div class="control-group keperawatan">
				<?php echo CHtml::label('No. Pengkajian Keperawatan', 'no_pengkajian', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (!empty($modPengkajian->pengkajianaskep_id)) {
						echo CHtml::textField('ASPengkajianaskepT[no_pengkajian]', $modPengkajian->no_pengkajian, array('readonly' => true));
					} else {
						$this->widget('MyJuiAutoComplete', array(
							'name' => 'ASPengkajianaskepT[no_pengkajian]',
							'value' => $modPengkajian->no_pengkajian,
							'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('Autocompletepengkajiankep') . '",
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
											
											cekPengkajianId(ui.item.pengkajianaskep_id);
                                            return false;
                                                return false;
                                            }',
							),
							'tombolDialog' => array('idDialog' => 'dialogPengkajianKep', 'idTombol' => 'tombolPengkajianDialog'),
							'htmlOptions' => array('class' => 'span3',
								'placeholder' => 'No. Pengkajian', 'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
					}
					?>
				</div>
			</div>
			<div class="control-group kebidanan">
				<?php echo CHtml::label('No. Pengkajian Kebidanan', 'no_pengkajian', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (!empty($modPengkajian->pengkajianaskep_id)) {
						echo CHtml::textField('ASPengkajianaskepT[no_pengkajian]', $modPengkajian->no_pengkajian, array('readonly' => true));
					} else {
						$this->widget('MyJuiAutoComplete', array(
							'name' => 'ASPengkajianaskepT[no_pengkajian_keb]',
							'value' => $modPengkajian->no_pengkajian,
							'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('Autocompletepengkajiankeb') . '",
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
                                                cekPengkajianId(ui.item.pengkajianaskep_id);
                                                return false;
                                            }',
							),
							'tombolDialog' => array('idDialog' => 'dialogPengkajianKeb', 'idTombol' => 'tombolPengkajianDialog'),
							'htmlOptions' => array('class' => 'span3 hidden',
								'placeholder' => 'No. Pengkajian', 'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
					}
					?>
				</div>
			</div>
                    <div class="control-group">
				<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_tgl', array('class' => 'control-label inline')) ?>
				<div class="controls">
					<?php echo CHtml::textField('ASPengkajianaskepT[pengkajianaskep_tgl]', $modPengkajian->pengkajianaskep_tgl, array('readonly' => true, 'class' => 'span3')); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			
                    <div class="control-group">
				<?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->hiddenField($modPengkajian, 'pegawai_id', array('readonly' => true)) ?>
					<?php echo CHtml::textField('ASPengkajianaskepT[nama_pegawai]', $modPengkajian->nama_pegawai, array('readonly' => true)); ?>
				</div>
			</div>
                    <div class="control-group">
				<div class="controls">
					<?php
					echo CHtml::link("<i class=icon-form-detail></i>", 'javascript:void(0);', array("rel" => "tooltip",
						"title" => "Klik untuk melihat detail",
						"target" => "frameDetail",
						"onclick" => "cekPengkajian(this);",
					));
//					echo CHtml::link(Yii::t('mds',array('{icon}'=>"<i class=\'icon-form-detail\'></i> ")), Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajian", array("pengkajianaskep_id" => $modPengkajian->pengkajianaskep_id)), array("target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pengkajian Keperawatan", "onclick" => "window.parent.$(\'#dialogDetail\').dialog(\'open\')")); 
					?>
				</div>
			</div>
		</div>

	</div>
</div>
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPengkajianKep',
	'options' => array(
		'title' => 'Pencarian Pengkajian Keperawatan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 420,
		'resizable' => false,
	),
));
$modPengkajianAskep = new ASInfopengkajianaskepV('searchDialog');
$modPengkajianAskep->unsetAttributes();
$modPengkajianAskep->pengkajianaskep_tgl = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['ASInfopengkajianaskepV'])) {
	$modPengkajianAskep->attributes = $_GET['ASInfopengkajianaskepV'];
	$modPengkajianAskep->no_pengkajian = $_GET['ASInfopengkajianaskepV']['no_pengkajian'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'keperawatan-t-grid',
	'dataProvider' => $modPengkajianAskep->searchDialog(),
	'filter' => $modPengkajianAskep,
	'template' => "{summaryNonPage}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPengkajian",
                                        "onClick" => "
                                            $(\"#dialogPengkajianKep\").dialog(\"close\");
											cekPengkajianId($data->pengkajianaskep_id);
                                        "))',
		),
		array(
			'name' => 'no_pengkajian',
			'type' => 'raw',
			'value' => '$data->no_pengkajian',
		),
		array(
			'name' => 'nama_pasien',
			'type' => 'raw',
			'value' => '$data->nama_pasien',
		),
		array(
			'name' => 'no_pendaftaran',
			'type' => 'raw',
			'value' => '$data->no_pendaftaran',
		),
		array(
			'header' => 'Tgl. Pengkajian Askep',
			'name' => 'pengkajianaskep_tgl',
			'value' => 'MyFormatter::formatDateTimeForUser($data->pengkajianaskep_tgl)',
			'filter' => 
                                CHtml::activeTextField($modPengkajianAskep, 'pengkajianaskep_tgl', array('class'=>'span3','readonly'=>true)),
                                /*$this->widget('MyDateTimePicker', array(
				'model' => $modPengkajianAskep,
				'attribute' => 'pengkajianaskep_tgl',
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'pengkajianaskep_tgl', 'placeholder' => '23 Jan 1993'),
					), true
                                ),*/
		),
		array(
			'header' => 'Nama Ruangan',
			'name' => 'ruangan_nama',
			'type' => 'raw',
			'filter' => CHtml::activeDropDownList($modPengkajianAskep, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif=TRUE'), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)"))
		),
		array(
			'name' => 'nama_pegawai',
			'type' => 'raw',
			'value' => '$data->nama_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//                 jQuery(\'#pengkajianaskep_tgl\').datepicker(jQuery.extend({
//                        showMonthAfterYear:false}, 
//                        jQuery.datepicker.regional[\'id\'], 
//                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
//                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
//                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
//                jQuery(\'#pengkajianaskep_tgl_date\').on(\'click\', function(){jQuery(\'#pengkajianaskep_tgl\').datepicker(\'show\');});
                jQuery("#'.CHtml::activeId($modPengkajianAskep, 'pengkajianaskep_tgl').'").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                });
            
            }',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPengkajianKeb',
	'options' => array(
		'title' => 'Pencarian Pengkajian Kebidanan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 420,
		'resizable' => false,
	),
));
$modPengkajianAskep = new ASInfopengkajiankebidananV('searchDialog');
$modPengkajianAskep->unsetAttributes();
$modPengkajianAskep->pengkajianaskep_tgl = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['ASInfopengkajiankebidananV'])) {
	$modPengkajianAskep->attributes = $_GET['ASInfopengkajiankebidananV'];
	$modPengkajianAskep->no_pengkajian = $_GET['ASInfopengkajiankebidananV']['no_pengkajian'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'kebidanan-t-grid',
	'dataProvider' => $modPengkajianAskep->searchDialog(),
	'filter' => $modPengkajianAskep,
	'template' => "{summaryNonPage}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPengkajian",
                                        "onClick" => "
                                            $(\"#dialogPengkajianKeb\").dialog(\"close\");
											cekPengkajianId($data->pengkajianaskep_id);
                                        "))',
		),
		array(
			'name' => 'no_pengkajian',
			'type' => 'raw',
			'value' => '$data->no_pengkajian',
		),
		array(
			'name' => 'nama_pasien',
			'type' => 'raw',
			'value' => '$data->nama_pasien',
		),
		array(
			'name' => 'no_pendaftaran',
			'type' => 'raw',
			'value' => '$data->no_pendaftaran',
		),
		array(
			'header' => 'Tgl. Pengkajian Askep',
			'name' => 'pengkajianaskep_tgl',
			'type' => 'raw',
			'value' => 'MyFormatter::formatDateTimeForUser($data->pengkajianaskep_tgl)',
			'filter' => 
                                CHtml::activeTextField($modPengkajianAskep, 'pengkajianaskep_tgl', array('class'=>'span3','readonly'=>true)),
                                /*$this->widget('MyDateTimePicker', array(
				'model' => $modPengkajianAskep,
				'attribute' => 'pengkajianaskep_tgl',
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'pengkajianaskep_tgl_keb', 'placeholder' => '23 Jan 1993'),
					), true
                                ),*/
		),
		array(
			'header' => 'Nama Ruangan',
			'name' => 'ruangan_nama',
			'type' => 'raw',
			'filter' => CHtml::activeDropDownList($modPengkajianAskep, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif=TRUE'), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)"))
		),
		array(
			'name' => 'nama_pegawai',
			'type' => 'raw',
			'value' => '$data->nama_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//                 jQuery(\'#pengkajianaskep_tgl_keb\').datepicker(jQuery.extend({
//                        showMonthAfterYear:false}, 
//                        jQuery.datepicker.regional[\'id\'], 
//                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
//                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
//                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
//                jQuery(\'#pengkajianaskep_tgl_keb_date\').on(\'click\', function(){jQuery(\'#pengkajianaskep_tgl_keb\').datepicker(\'show\');});
                jQuery("#'.CHtml::activeId($modPengkajianAskep, 'pengkajianaskep_tgl').'").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                });
            
            }',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    $(document).ready(function(){
        $('input[name="ASInfopengkajianaskepV[pengkajianaskep_tgl]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
        $('input[name="ASInfopengkajiankebidananV[pengkajianaskep_tgl]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>