<div class="row-fluid">
	<div class="col-md-6">
		<?php echo $form->dropDownListRow($model,'profilrs_id',CHtml::listData(ProfilrumahsakitM::model()->findAll(),'profilrs_id','nama_rumahsakit'),array('empty' => 'Pilih', 'onclick'=>'setKlinik(this);setBank(this)')) ?>
		<?php //echo $form->dropDownListRow($model,'jenistransaksi',LookupM::getItems('advancepayment'),array('empty' => 'Pilih','onchange'=>'setJenisTransaksi(this)')) ?>
		<?php echo $form->hiddenField($model,'jenistransaksi') ?>
		<input type="hidden" name="nopengajuan" id="nopengajuan" >
		<div class="control-group ">
			<?php $model->tglpengajuan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tglpengajuan, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
			<?php echo $form->labelEx($model,'tglpengajuan', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
					$this->widget('MyDateTimePicker',
						array(
								'model'=>$model,
								'attribute'=>'tglpengajuan',
								'mode'=>'datetime',
								'options'=>array(
									'dateFormat'=>Params::DATE_FORMAT,
									// 'maxDate' => 'd',
								),
								'htmlOptions'=>array(
									'class'=>'dtPicker2-5',
									'onkeypress'=>"return $(this).focusNextInputField(event)",
									'onchange' => '$(this).removeClass("realtime")'
								),
						)
					);
				?>

			</div>
		</div>
		<?php echo $form->textFieldRow($model,'nopengajuan',array('readonly'=>true)) ?>
		<?php echo $form->textFieldRow($model,'nodokumen') ?>
		<?php echo $form->textFieldRow($model,'noanggaran') ?>
		<?php echo $form->textAreaRow($model,'keterangan') ?>
	</div>
	<div class="col-md-6">
		<div class="control-group ">
			<?php echo Chtml::label("Pegawai <span class='required'>*</span>", 'pegawai_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'pegawai_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'pegawai_nama',
					'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('AutocompletePegawai') . '",
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
							$("#'.Chtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);

                                                        return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder' => 'Ketik Nama Pegawai',
						'class'=>'span3 pegawai_nama  hurufs-only',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($model, 'pegawai_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawai'),
				));
				?>
			</div>
		</div>

		<?php echo $form->textFieldRow($model,'nip',array('readonly'=>true)) ?>
		<?php echo $form->hiddenField($model,'jabatan_id') ?>
		<div class="control-group">
			<?php echo Chtml::label("Jabatan <span class='required'>*</span>", 'jabatan_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'jabatan_nama',array('readonly'=>true)) ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo Chtml::label("Pegawai Pemeriksa <span class='required'>*</span>", 'jabatan_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'pegawaipemeriksa_nama',array('readonly'=>true)) ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo Chtml::label("Pegawai Menyetujui <span class='required'>*</span>", 'jabatan_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'pegawaimenyetujui_nama',array('readonly'=>true)) ?>
			</div>
		</div>
		<?php echo $form->hiddenField($model,'pegawaipemeriksa_id') ?>
		<?php echo $form->hiddenField($model,'pegawaimenyetujui_id') ?>
		<?php //echo $form->dropDownListRow($model,'jabatan_id') ?>
	</div>
</div>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Pencarian Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM('search');

$modPegawai->unsetAttributes();
//$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modPegawai->search(),
	'filter'=>$modPegawai,
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
                                                  $(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawai_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#'.CHtml::activeId($modTandaBuktiKeluar,'namapenerima').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#'.CHtml::activeId($model,'nip').'\").val(\"$data->nomorindukpegawai\");
                                                  $(\"#'.CHtml::activeId($model,'jabatan_id').'\").val(\"$data->jabatan_id\");
                                                  $(\"#'.CHtml::activeId($model,'jabatan_nama').'\").val(\"". (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "") ."\");
                                                  $(\"#dialogPegawai\").dialog(\"close\");
                                                //   ambilDataGaji();
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                    'filter' => Chtml::activeTextField($modPegawai,'nomorindukpegawai',array('class'=>'numbers-only'))
                ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
                array(
                    'header'=>'Nama Pegawai',
                    'name' => 'nama_pegawai',
                    'value'=>'$data->namaLengkap',
                    'filter' => Chtml::activeTextField($modPegawai,'nama_pegawai',array('class'=>'hurufs-only'))
                ),
                array(
                    'header' => 'Jabatan',
                    'name' => 'jabatan_id',
                    'value' => function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);

                        if (!empty($j)){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    },
                    'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
            . '$(".numbers-only").keyup(function(){setNumbersOnly(this);});'
            . '$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
