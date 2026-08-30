<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new BukuregisterpasienV('searchDialog');
    $modDialogKunjungan->unsetAttributes();
    if(isset($_GET['BukuregisterpasienV'])) {
        $modDialogKunjungan->attributes = $_GET['BukuregisterpasienV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'datakunjungan-grid',
		'dataProvider'=>$modDialogKunjungan->searchDialogBD(),
		'filter'=>$modDialogKunjungan,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectKunjungan",
								"onClick" => "
									setKunjungan($data->pendaftaran_id, );
									$(\"#dialogKunjungan\").dialog(\"close\");
								"))',
			),
			'no_pendaftaran',
			array(
				'name'=>'tgl_pendaftaran',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
				'filter'=> false,
			),
			array(
				'header'=>'Tanggal Rujuk',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
				'filter'=>$this->widget('MyDateTimePicker', array(
					'model' => $modDialogKunjungan,
					'attribute' => 'tgl_pendaftaran',
					'mode' => 'date', //date / datetime
					'gridFilter' => true,
					'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
					'maxDate'=>'d',
					),
					'htmlOptions' => array('readonly' => true, 'class' => "span2",
					'onkeypress' => "return $(this).focusNextInputField(event)"),
					),true),
			),
			'no_rekam_medik',
			'nama_pasien',
			array(
				'name'=>'jeniskelamin',
				'type'=>'raw',
				'filter'=>LookupM::model()->getItems('jeniskelamin'),
			),
			'instalasi_nama',
			'ruangan_nama',
			array(
				'name'=>'carabayar_id',
				'type'=>'raw',
				'value'=>'$data->carabayar_nama',
				'filter'=>CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE"),'carabayar_id','carabayar_nama'),
			),
		),
		'afterAjaxUpdate'=>'function(id, data){
			jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			jQuery("#'.CHtml::activeId($modDialogKunjungan, 'tgl_kirimpasien').'").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
			jQuery("#'.CHtml::activeId($modDialogKunjungan, 'tgl_kirimpasien').'_date").on("click", function(){jQuery("#'.CHtml::activeId($modDialogKunjungan, 'tgl_kirimpasien').'").datepicker("show");});
		}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>