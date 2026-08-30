<style>
    #checkBoxList{
        width:100%;
    }
    #checkBoxList label.checkbox{
        width: 150px;
        display:inline-block;
    }

</style>
<fieldset class="box" id="formCari">
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
	<div class="row">
		<div class="col-sm-4">
			<div class="control-group">
				<span class="control-label">Pilih Jasa Dokter</span>
				<div class="controls">
					<?php echo $form->dropDownList($model,'pilihDokter', array('rujukan'=>'Jasa Dokter Luar', 'rs'=>'Jasa Dokter RS'), array('onchange'=>'pilihDokter();', 'class'=>'span3')); ?>
				</div>
			</div>
			<div class="control-group" id="formTglPenunjangAwal">
				<?php echo CHtml::label('Tgl. Pasien Masuk Penunjang','tgl_awalPenunjang',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_awalPenunjang',
							'mode' => 'date',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
							),
						));
					?>
				</div>
			</div>
			<div class="control-group" id="formTglPendaftaranAwal">
				<?php echo CHtml::label('Tgl. Pendaftaran Pasien','tgl_awalPendaftaran',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_awalPendaftaran',
							'mode' => 'date',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
							),
						));
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="control-group" id="formRujukan">
				<?php echo $form->labelEx($model,'rujukandari_id', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->hiddenField($model,'rujukandari_id',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					<?php $this->widget('MyJuiAutoComplete', array(
							   'model'=>$model,
							   'attribute'=>'rujukandariNama',
							   'source'=>'js: function(request, response) {
											  $.ajax({
												  url: "'.$this->createUrl('RujukanDari').'",
												  dataType: "json",
												  data: {
													  term: request.term,
												  },
												  success: function (data) {
														  response(data);
												  }
											  })
										   }',
								'options'=>array(
									  'showAnim'=>'fold',
									  'minLength' => 2,
									  'focus'=> 'js:function( event, ui ) {
										   $(this).val("");
										   return false;
									   }',
									  'select'=>'js:function( event, ui ) {
										   $(this).val(ui.item.value);
										   $("#KUPembayaranjasaT_rujukandari_id").val(ui.item.rujukandari_id);
										   return false;
									   }',
							   ),
							   'tombolDialog'=>array('idDialog'=>'dialogPerujuk','idTombol'=>'tombolPerujukDialog'),
							   'htmlOptions'=>array('placeholder'=>'Nama Perujuk', 'onkeypress'=>"return $(this).focusNextInputField(event);"),
						   )); 
					?>
				</div>
			</div>
			<div class="control-group"  id="formDokter">
				<?php echo $form->labelEx($model,'pegawai_id', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->hiddenField($model,'pegawai_id',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					<?php $this->widget('MyJuiAutoComplete', array(
							   'model'=>$model,
							   'attribute'=>'pegawaiNama',
							   'source'=>'js: function(request, response) {
											  $.ajax({
												  url: "'.$this->createUrl('GetDokter').'",
												  dataType: "json",
												  data: {
													  term: request.term,
												  },
												  success: function (data) {
														  response(data);
												  }
											  })
										   }',
								'options'=>array(
									  'showAnim'=>'fold',
									  'minLength' => 2,
									  'focus'=> 'js:function( event, ui ) {
										   $(this).val("");
										   return false;
									   }',
									  'select'=>'js:function( event, ui ) {
										   $(this).val(ui.item.NamaLengkap);
										   $("#KUPembayaranjasaT_pegawai_id").val(ui.item.pegawai_id);
										   $("#KUPembayaranjasaT_pegawaiNama").val(ui.item.nama_pegawai);
										   return false;
									   }',
							   ),
							   'tombolDialog'=>array('idDialog'=>'dialogDokter','idTombol'=>'tombolDokterDialog'),
							   'htmlOptions'=>array('placeholder'=>'Nama Dokter RS', 'onkeypress'=>"return $(this).focusNextInputField(event);"),
						   )); 
					?>
				</div>
			</div>
			<div class="control-group" id="formTglPenunjangAkhir">
				<?php echo CHtml::label('Sampai dengan ','tgl_akhirPenunjang',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_akhirPenunjang',
							'mode' => 'date',

							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
							),
						));
					?>
				</div>
			</div>
			<div class="control-group" id="formTglPendaftaranAkhir">
				<?php echo CHtml::label('Sampai dengan ','tgl_akhirPendaftaran',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_akhirPendaftaran',
							'mode' => 'date',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
							),
						));
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
		</div>
	</div>
    <fieldset class="box2">
        <legend class="rim">Komponen Tarif</legend>
        <?php echo CHtml::checkBox('pilihSemua', false, array('onclick'=>'checkAllKomponen();')) ?> <label><b>Pilih Semua</b></label><br><br>
        <div id="checkBoxList">
            <?php echo $form->checkBoxList($model, 'komponentarifId', CHtml::listData(KomponentarifM::model()->Items, 'komponentarif_id', 'komponentarif_nama'), array('class'=>'komponenTarif')); ?><br>
        </div>
    </fieldset>
<div class="form-actions">
    <?php 
    if(!isset($_GET['id'])){
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick'=>'addDetail();'));
    }
    ?>
</div>
</fieldset>
<script>
    function checkAllKomponen(){
        if($('#pilihSemua').is(':checked')){
            $('#checkBoxList').each(function(){
                $(this).find('input').attr('checked',true);
            });
        }else{
            $('#checkBoxList').each(function(){
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    checkAllKomponen();
</script>

<?php 
//========= Dialog buat cari data dokter =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Data Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>540,
        'resizable'=>false,
    ),
));
    $pegawai = new DokterpegawaiV('searchByDokter');
    if (isset($_GET['DokterpegawaiV'])){
        $pegawai->attributes = $_GET['DokterpegawaiV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dokter-t-grid',
            'dataProvider'=>$pegawai->searchByDokter(),
            'filter'=>$pegawai,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogDokter\").dialog(\"close\");
											$(\"#KUPembayaranjasaT_rujukandari_id\").val(\"$data->pegawai_id\");
                                            $(\"#KUPembayaranjasaT_rujukandariNama\").val(\"$data->gelardepan"." "."$data->nama_pegawai".", "."$data->gelarbelakang_nama\");
											
                                            $(\"#KUPembayaranjasaT_pegawai_id\").val(\"$data->pegawai_id\");
                                            $(\"#KUPembayaranjasaT_pegawaiNama\").val(\"$data->gelardepan"." "."$data->nama_pegawai".", "."$data->gelarbelakang_nama\");

                                        "))',
                    ),
                    'gelardepan',
                    array(
                        'name'=>'nama_pegawai',
                        'header'=>'Nama Dokter',
                    ),
                    'gelarbelakang_nama',
                    'jeniskelamin',
                    'agama',
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>

<?php 
//========= Dialog buat cari data dokter =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPerujuk',
    'options'=>array(
        'title'=>'Pencarian Data Perujuk',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>540,
        'resizable'=>false,
    ),
));
    $perujuk = new RujukandariM('search');
    if (isset($_GET['RujukandariM'])){
        $perujuk->attributes = $_GET['RujukandariM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'perujuk-t-grid',
            'dataProvider'=>$perujuk->search(),
            'filter'=>$perujuk,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogPerujuk\").dialog(\"close\");
                                            $(\"#KUPembayaranjasaT_rujukandari_id\").val(\"$data->rujukandari_id\");
                                            $(\"#KUPembayaranjasaT_rujukandariNama\").val(\"$data->namaperujuk\");

                                        "))',
                    ),
                    'namaperujuk',
                    'spesialis',
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
