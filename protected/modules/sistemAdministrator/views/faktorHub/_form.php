<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'bataskarakteristik-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
	'focus' => '#' . CHtml::activeId($model, 'lookup_type'),
		));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo CHtml::hiddenField('norow',0); ?>
<?php echo $form->errorSummary($model); ?>

<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo Chtml::label('Diagnosa Keperawatan', 'diagnosakep_id', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'diagnosakep_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model' => $model,
					'attribute' => 'diagnosakep_nama',
					'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('AutoCompleteDiagnosaKeperawatan') . '",
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
												$(this).val( ui.item.value);
												return false;
											}',
						'select' => 'js:function( event, ui ) { 
												$("#' . CHtml::activeId($model, 'diagnosakep_id') . '").val(ui.item.diagnosakep_id);
												return false;
											}',
					),
					'htmlOptions' => array(
						'placeholder' => 'Kode / Nama Diagnosa',
						'onkeypress' => "return $(this).focusNextInputField(event)",
					),
					'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
				));
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo Chtml::label('Nama Kondisi Klinis Terkait', 'faktorhub_nama', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php /*
				echo $form->dropDownList($model, 'faktorhub_nama', LookupM::getItems('faktorhub_as'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
					'class' => 'inputRequire',
					'onchange' => 'refreshTable();'));
				 * 
				 */
				echo $form->textField($model, 'faktorhub_nama', array('class'=>'inputRequire', 'onblur'=>'refreshTable()'));
				?>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid block-tabel">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">Tabel <b>Kondisi Klinis Terkait</b></div>
        </div>
        <div class="panel-body" style="overflow-y: auto;">

	<table id="table-lookup" class="table table-striped table-bordered table-condensed">
		<thead>
		<th>Indikator<span style="color: red">*</span></th>
		<th>Status</th>
                <thcolspan="2"></th>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>
</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "#", array('class' => 'btn btn-danger',
		'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'));
	?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kondisi Klinis Terkait', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
	<?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view. '_jsFunctions', array('model' => $model, 'modDetail' => $modDetail)); ?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogDiagnosa',
	'options' => array(
		'title' => 'Diagnosa Keperawatan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 800,
		'height' => 500,
		'resizable' => false,
	),
));

$modDiagnosaKep = new SADiagnosakepM('search');
$modDiagnosaKep->unsetAttributes();
if (isset($_GET['SADiagnosakepM'])) {
	$modDiagnosaKep->attributes = $_GET['SADiagnosakepM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'diagnosakep-m-grid',
	'dataProvider' => $modDiagnosaKep->search(),
	'filter' => $modDiagnosaKep,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'diagnosakep_id') . '\").val(\'$data->diagnosakep_id\');
                                    $(\"#' . CHtml::activeId($model, 'diagnosakep_nama') . '\").val(\'$data->diagnosakep_nama\');

                                    $(\'#dialogDiagnosa\').dialog(\'close\');
									refreshTable();
                                    return false;"))'
		),
		array(
			'header' => 'Kode Diagnosa',
			'name' => 'diagnosakep_kode',
			'value' => '$data->diagnosakep_kode',
		),
		array(
			'header' => 'Diagnosa Keperawatan',
			'type' => 'raw',
			'name' => 'diagnosakep_nama',
			'value' => '$data->diagnosakep_nama',
		),
		array(
			'header' => 'Deskripsi',
			'name' => 'diagnosakep_deskripsi',
			'value' => '$data->diagnosakep_deskripsi',
		),
		array(
			'header' => 'Status',
			'value' => '($data->diagnosakep_aktif == TRUE) ? "Aktif" : "Tidak Aktif"',
			'filter' => CHtml::dropDownList(
					'diagnosakep_aktif', $modDiagnosaKep->diagnosakep_aktif, array('1' => 'Aktif',
				'0' => 'Tidak Aktif',), array('empty' => '-- Pilih --'))
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogDaftarTanda',
            'options'=>array(
                'title'=>'Pencarian Daftar  Kondisi Klinis Terkait' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 500,
                'resizable' => true,
            ),
        )
    );
        	            
    $modHasilDaftar = new FaktorhubDaftarM('search');
    $modHasilDaftar->unsetAttributes();
    if (isset($_GET['FaktorhubDaftarM'])) {
        $modHasilDaftar->attributes = $_GET['FaktorhubDaftarM'];        
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'kreiteriahasildaftar-m-grid',
        'dataProvider' => $modHasilDaftar->search(),
        'filter' => $modHasilDaftar,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',                
                'value'=>function($data) {
                        $load = $data->attributes;                            
                        $res = json_encode($load);

                        return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                "onclick" => 'setDaftar('.$res.');'));
                    },
            ),
            array(
                'header' => 'No. ',
                'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:center; width:5px;'),
            ),
            [
                'header'    => 'Nama Kondisi Klinis Terkait',
                'name'      => 'faktorhub_daftar_nama',
                'type' => 'raw',
                'value'     => '$data->faktorhub_daftar_nama',
            ],
            [
                'header'    => 'Nama Lain Kondisi Klinis Terkait',
                'name'      => 'faktorhub_daftar_namalain',
                'type' => 'raw',
                'value'     => '$data->faktorhub_daftar_namalain',
            ],
        ),
        'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
    ));
    $this->endWidget();
?>
