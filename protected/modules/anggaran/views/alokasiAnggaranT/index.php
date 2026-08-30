<div class="white-container">
	<legend class="rim2">Transaksi <b>Alokasi Anggaran<b/></legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'alokasianggaran-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event); '),//dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
	'focus'=>'#'.CHtml::activeId($model,'konfiganggaran_id'),
)); ?>
<?php 
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success', "Data alokasi anggaran berhasil disimpan!");
}
?>	
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
    <fieldset id="form-alokasianggaran" class="box">
        <legend class="rim">Data Alokasi Anggaran</legend>
        <div>
            <?php $this->renderPartial('_formAlokasiAnggaran', array('form'=>$form,'format'=>$format,'model'=>$model)); ?>
        </div>
    </fieldset>
	<fieldset id="form-alokasianggarankerjaunit" class="box">
        <legend class="rim">Data Alokasi Anggaran Program Kerja Unit</legend>
        <div id="detailRencAnggPen">
            <?php $this->renderPartial('_formAlokasiAnggaranKerjaUnit', array('form'=>$form,'format'=>$format,'model'=>$model)); ?>
        </div>
    </fieldset>
	<div class="block-tabel">
        <h6>Tabel <b>Alokasi Anggaran Program Kerja Unit</b></h6>
        <table class="items table table-striped table-condensed" id="table-alokasianggaran">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Program</th>
                    <th>Kode Sub Program</th>
                    <th>Kode Kegiatan</th>
                    <th>Kode Sub Kegiatan</th>
                    <th>Program Kerja</th>
                    <th>Bulan</th>
                    <th>Nilai <span id="digitlabel"></span></th>
					<th>Sumber Anggaran</th>
					<th>Nilai Alokasi <span id="digitlabel"></span></th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
				<?php
					if(count((array)$modDetails) > 0){
						foreach($modDetails as $i=>$data){
							$modProgramKerja = AGInformasialokasianggaranV::model()->findByAttributes(array('apprrencanggaran_id'=>$data->apprrencanggaran_id));
							$data->sumberanggarannama = $data->sumberanggaran->sumberanggarannama;
							echo $this->renderPartial('_rowAlokasiAnggaran',array('modAlokasiAnggaran'=> $data,'modProgramKerja'=>$modProgramKerja,'format'=>$format));
						}
					}
				?>
                <tfoot>
                    <tr>
                        <td colspan="7" style="text-align:right;">TOTAL</td>
                        <td><?php echo $form->textField($model,'total_nilairencana',array('class'=>'span2 integer2','style'=>'width:90px;','readonly'=>true))?></td>
						<td></td>
						<td><?php echo $form->textField($model,'total_nilaialokasi',array('class'=>'span2 integer2','style'=>'width:90px;','readonly'=>true))?></td>
						<td></td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>  
<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'mengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'mengetahui_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'pegawaimengetahui_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimengetahui_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
				));
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
        <?php echo $form->labelEx($model, 'menyetujui_id', array('class' => 'control-label')); ?>
			<div class="controls">
            <?php echo $form->hiddenField($model, 'menyetujui_id',array('readonly'=>true)); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model'=>$model,
                'attribute' => 'pegawaimenyetujui_nama',
                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
                        $(this).val( ui.item.label);
                        return false;
                    }',
                    'select' => 'js:function( event, ui ) {
                        $("#'.Chtml::activeId($model, 'menyetujui_id') . '").val(ui.item.pegawai_id); 
                        return false;
                    }',
                ),
                'htmlOptions' => array(
                    'class'=>'pegawaimenyetujui_nama',
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'menyetujui_id') . '").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
            ));
            ?>
			</div>
		</div>
	</div>
</div>
    <div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['alokasianggaran_id'])) ? true : (($sukses > 0) ? true : false); 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'verifikasi();', 'onkeypress'=>'verifikasi();','disabled'=>$disableSave,)); ?>
		<?php 
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-default',
					  'onclick'=>'return refreshForm(this);'));
		?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')')); ?>
		<?php	$content = $this->renderPartial('../tips/transaksi1',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model'=>$model)); ?>

<div style='display:none;'>
<?php
    $this->widget('MyDateTimePicker', array(
		'model'=>$model,
		'attribute'=>'tglalokasianggaran',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array('readonly' => true,
		'onkeypress' => "return $(this).focusNextInputField(event)"),
    ));
?>	
</div>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new AGPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['AGPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['AGPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchPegawaiMengetahui(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'mengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
		'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new AGPegawairuanganV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['AGPegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['AGPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->searchPegawaiMenyetujui(),
	'filter'=>$modPegawaiMenyetujui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'menyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>