<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<style type="text/css">
	.integer-decimal{
		text-align: right;
	}
</style>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'satarif-tindakan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#kategoritindakan',
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>

<div id="form">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Data Tarif</div>
				</div>
				<div class="panel-body">
					<?php if (isset($_GET['kelaspelayanan_id'])){ ?>
						<div class="control-group">
							<?php echo CHtml::label("SK Tarif",'',array('class' => 'control-label')); ?>
							<div class="controls">
								<?php echo $form->hiddenField($model,'perdatarif_id', array('class' => 'perdatarif_id')); ?>
								<?php echo $form->textField($model,'perdanama_sk',array('class'=>'span3 perdanama_sk', 'readonly'=>true)); ?>
							</div>
						</div>
					<?php }else{ 	?>
						<?php echo $form->dropDownListRow($model,'perdatarif_id',  CHtml::listData($model->PerdaTarifItems, 'perdatarif_id', 'perdanama_sk'),array('class'=>'span3 perdatarif_id', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'onchange'=>'setTarifDet()')); ?>
					<?php	} ?>
					<div class="control-group">
							<label class="control-label" >Jenis Tarif</label>
							<div class="controls">
									<?php
										if (isset($_GET['kelaspelayanan_id'])){
											echo $form->hiddenField($model,'jenistarif_id',array('class' => 'jenistarif_id'));
											echo $form->textField($model,'jenistarif_nama',array('class'=>'span3 jenistarif_nama', 'readonly'=>true));
										}else{
											echo $form->dropDownList($model,'jenistarif_id',  CHtml::listData($model->JenisTarifItems, 'jenistarif_id', 'jenistarif_nama'),array('class'=>'span3 jenistarif_id', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'onchange'=>'setTarifDet()'));
										}
										?>
							</div>
					</div>
					<div class="control-group">
							<label class="control-label" >Kelas Pelayanan</label>
							<div class="controls">
									<?php
										if (isset($_GET['kelaspelayanan_id'])){
											echo $form->hiddenField($model,'kelaspelayanan_id',array('class'=>'kelaspelayanan_id'));
											echo $form->textField($model,'kelaspelayanan_nama',array('class'=>'span3 kelaspelayanan_nama', 'readonly'=>true));
										}else{
											echo $form->dropDownList($model,'kelaspelayanan_id', CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3 kelaspelayanan_id','onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'onchange'=>'setTarifDet()'));
										}
									?>
							</div>
					</div>
					<div class="control-group">
							<label class="control-label" >Uraian Tindakan</label>
							<div class="controls">
									<?php
										if (isset($_GET['kelaspelayanan_id'])){
											echo $form->textField($model,'daftartindakan_nama',array('id'=>'daftartindakan','class'=>'span3', 'readonly'=>true));
										}else{
						$this->widget('MyJuiAutoComplete', array(
														'name'=>'daftartindakan',
														'value'=>isset($model->daftartindakan->daftartindakan_nama)?$model->daftartindakan->daftartindakan_nama:'',
														'source'=>'js: function(request, response) {
																					 $.ajax({
																							 url: "'.$this->createUrl('AutocompleteDaftarTindakan').'",
																							 dataType: "json",
																							 data: {
																									 daftartindakan: request.term,
																							 },
																							 success: function (data) {
																											 response(data);
																											 setTarifDet();
																							 }
																					 })
																				}',
														 'options'=>array(
																	 'minLength' => 4,
																		'focus'=> 'js:function( event, ui ) {
																				 $(this).val("");
																				 return false;
																		 }',
																	 'select'=>'js:function( event, ui ) {
																				$(this).val( ui.item.value);
																				$(".daftartindakan_id").val(ui.item.daftartindakan_id);
																				return false;
																		}',
														),
														'tombolDialog'=>array('idDialog'=>'dialogdaftartindakan'),
														'htmlOptions'=>array('placeholder'=>'Ketik Uraian Tindakan','rel'=>'tooltip','title'=>'Ketik Uraian Tindakan Untuk Mencari Daftar Tindakan',
														'onkeyup'=>"return $(this).focusNextInputField(event)",
														),
												));
										}
									?>
									<?php echo $form->error($model,'daftartindakan_id'); ?>
									<?php echo $form->hiddenField($model,'daftartindakan_id',array('class'=>'daftartindakan_id')); ?>
								</div>
							</div>
							<?php
										if (isset($_GET['jeniswaktukerja'])){
											echo $form->textFieldRow($model,'jeniswaktukerja',array('class'=>'span3 jeniswaktukerja', 'readonly'=>true));
										}else{
											echo $form->dropDownListRow($model,'jeniswaktukerja',  LookupM::getItems('jeniswaktukerja'),array('class'=>'span3 jeniswaktukerja', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'onchange'=>'setTarifDet()'));
										}
									?>
					<?php echo $form->dropDownListRow($model,'komponentarif_id',  CHtml::listData($model->getKomponenTarif(false), 'komponentarif_id', 'komponentarif_nama'),array('class'=>'span3 komponentarif_id', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
					<div class="control-group">
							<label class="control-label" >Harga Tindakan</label>
							<div class="controls">
									<?php echo CHtml::textfield('harga_tariftindakan','',array('value'=>0,'class'=>'span2 integer-decimal harga_tariftindakan', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
									<button class="btn btn-primary" type="button" onkeypress = "tambahTarifTindakan()" onclick = "tambahTarifTindakan()" id='row1-plus'><i class="icon-plus icon-white"></i></button>
							</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Data Total Tarif - Keringanan - Cyto</div>
				</div>
				<div class="panel-body">
					<div class="control-group">
							<label class="control-label" >Total Tarif</label>
							<div class="controls">
									<?php echo CHtml::textfield('totaltariftindakan',0,array('class'=>'span2 integer-decimal harga_tariftindakan', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)) ?>
							</div>
					</div>
					<div class="control-group">
							<?php echo $form->labelex($model,'Diskon',array('class'=>"control-label",'label'=>'Keringanan (%)')) ?>
							<div class="controls">
									<?php echo $form->textField($model,'persendiskon_tind',array('class'=>'span1 float2','onblur'=>'setDiskonPersen();', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;')); ?>
							</div>
					</div>
					<div class="control-group">
							<?php echo $form->labelex($model,'Diskon',array('class'=>"control-label",'label'=>'Keringanan (Rp)')) ?>
							<div class="controls">
									<?php echo $form->textField($model,'hargadiskon_tind',array('value'=>0,'class'=>'span2 integer-decimal','onblur'=>'setDiskonRupiah();','onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;')); ?>
							</div>
					</div>

					<div class="control-group">
						<?php echo $form->labelex($model,'Cyto',array('class'=>"control-label required",'label'=>'Cyto (%)')) ?>
						<div class="controls">
								<?php echo $form->textField($model,'persencyto_tind',array('class'=>'span1 float2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;','onblur'=>'setPersenCyto()')); ?>
								
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelex($model,'hargacyto_tind',array('class'=>"control-label",'label'=>'Cyto (Rp)')) ?>
						<div class="controls">
								<?php echo $form->textField($model,'hargacyto_tind',array('value'=>0,'class'=>'span2 integer-decimal','onblur'=>'setCytoRupiah();','onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;')); ?>
						</div>
					</div>
					<div class="control-group">
							<?php echo $form->labelex($model,'total_tarifakhir',array('class'=>"control-label",'label'=>'Total Tarif Akhir')) ?>
							<div class="controls">
									<?php echo $form->textField($model,'total_tarifakhir',array('value'=>0,'class'=>'span2 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;','readonly'=>true)); ?>
									<i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Total Tarif - Keringanan (Rp)" data-html="true"></i>
							</div>
					</div>
					<div class="control-group">
							<?php echo $form->labelex($model,'totaltarifakhir_cyto',array('class'=>"control-label",'label'=>'Total Tarif Akhir Cyto')) ?>
							<div class="controls">
									<?php echo $form->textField($model,'totaltarifakhir_cyto',array('value'=>0,'class'=>'span2 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;','readonly'=>true)); ?>
									<i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Total Tarif Akhir + Cyto (Rp)" data-html="true"></i>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<br/>
<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">Tabel <b>Nominal Tarif</b></div>
	</div>
	<div class="panel-body">
		<div class="block-tabel" id="divDaftartindakan">
			<div style="overflow: auto;">
			<table class="items table table-striped table-bordered table-condensed" id="table-tariftindakan">
				<thead>
						<th>No.Urut</th>
						<th>SK Tarif <span class="required">*</span></th>
						<th>Jenis Tarif <span class="required">*</span></th>
						<th>Kelas Pelayanan <span class="required">*</span></th>
						<th>Uraian Tindakan <span class="required">*</span></th>
						<th>Komponen Tarif <span class="required">*</span></th>
						<th>Jenis Waktu Kerja <span class="required">*</span></th>
						<th>Harga Tindakan <span class="required">*</span></th>
						<th>Keringanan (Rp)</th>
						<th>Harga Akhir (Rp)</th>
						<th>Cyto (Rp)</th>
						<th>Harga Akhir Cyto (Rp)</th>
						<th>Batal</th>
				</thead>
				<tbody>
						<?php
								if(count((array)$lists)>0){
										foreach ($lists as $i => $detail) {
												if ($detail->komponentarif_id == Params::KOMPONENTARIF_ID_TOTAL) continue;
												echo $this->renderPartial($this->path_view.'_rowDetail',array('model'=>$detail));
										}
								}
						?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="6" ></th>
						<th>Total</th>
						<th style = "text-align: right;"><?php echo CHtml::textField('totalTarif','',array('class'=>'integer-decimal span2', 'style'=>'text-align:right;','readonly'=>true));  ?></th>
						<th style = "text-align: right;"><?php echo CHtml::textField('totalDiskon','',array('class'=>'integer-decimal span2', 'style'=>'text-align:right;','readonly'=>true));  ?></th>
						<th style = "text-align: right;"><?php echo CHtml::textField('totalAkhir','',array('class'=>'integer-decimal span2', 'style'=>'text-align:right;','readonly'=>true));  ?></th>
						<th style = "text-align: right;"><?php echo CHtml::textField('totalCyto','',array('class'=>'integer-decimal span2', 'style'=>'text-align:right;','readonly'=>true));  ?></th>
						<th style = "text-align: right;"><?php echo CHtml::textField('totalAkhirCyto','',array('class'=>'integer-decimal span2', 'style'=>'text-align:right;','readonly'=>true));  ?></th>
						<th colspan="2"></th>
					</tr>
				</tfoot>
			</table>
			</div>
		</div>
	</div>
</div>

<div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) :
                Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'tombolSimpan();', 'onkeypress'=>'tombolSimpan();')); ?>
       <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                '',
                array('class'=>'btn btn-danger',
                      'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')).'&nbsp;'; ?>
		<?php
			echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Nominal Tarif', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
			$content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit2g',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
</div>

<?php $this->endWidget(); ?>

<?php
/* ====================================== Widget Dialog Daftar Tindakan ====================================== */

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogdaftartindakan',
        'options'=>array(
            'title'=>'Pencarian Daftar Tindakan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>400,
            'resizable'=>false,
            ),
    ));

$modDaftarTindakan = new DaftartindakanM('search');
$modDaftarTindakan->unsetAttributes();
if(isset($_GET['DaftartindakanM'])) {
    $modDaftarTindakan->attributes = $_GET['DaftartindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftartindakan-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider'=>$modDaftarTindakan->search(),
    'filter'=>$modDaftarTindakan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",
                                    array(
                                            "class"=>"btn-small",
                                            "id" => "selectbarang",
                                            "onClick" => "\$(\"#form .daftartindakan_id\").val($data->daftartindakan_id);
                                                                  \$(\"#form #daftartindakan\").val(\"$data->daftartindakan_nama\");
                                                                  setTarifDet();
                                                                  \$(\"#dialogdaftartindakan\").dialog(\"close\");"

                                     )
                     )',
                ),
                'daftartindakan_nama',
                array(
                    'header'=>'Kelompok Tindakan',
                    'name'=>'kelompoktindakan_nama',
                    'value'=>'isset($data->kelompoktindakan->kelompoktindakan_nama)?$data->kelompoktindakan->kelompoktindakan_nama:" - "',
                    'filter' => CHtml::dropDownList('DaftartindakanM[kelompoktindakan_nama]',$modDaftarTindakan->kelompoktindakan_nama, CHtml::listData($modDaftarTindakan->getKelompokTindakanItems(), 'kelompoktindakan_nama', 'kelompoktindakan_nama'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header'=>'Kategori Tindakan',
                    'name'=>'kategoritindakan_nama',
                    'value'=>'isset($data->kategoritindakan->kategoritindakan_nama)?$data->kategoritindakan->kategoritindakan_nama:" - "',
                    'filter' => CHtml::dropDownList('DaftartindakanM[kategoritindakan_nama]',$modDaftarTindakan->kategoritindakan_nama, CHtml::listData($modDaftarTindakan->getKategoriTindakanItems(), 'kategoritindakan_nama', 'kategoritindakan_nama'), array('empty'=>'-- Pilih --'))
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Daftar Tindakan ====================================== */
?>

<script type="text/javascript">
    tr = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowDetail', array('model'=>$modDetails), true)); ?>);
    function tambahTarifTindakan(){
        daftartindakan = $('#form #daftartindakan').val();;
        daftartindakan_id = $('#form .daftartindakan_id').val();
        komponentarif_id = $('#form .komponentarif_id').val();
        kelaspelayanan_id = $('#form .kelaspelayanan_id').val();
        perdatarif_id = $('#form .perdatarif_id').val();
        jenistarif_id = $('#form .jenistarif_id').val();
		jeniswaktukerja = $('#form .jeniswaktukerja').val();
        harga_tariftindakan = $('#form').find('#harga_tariftindakan').val();
        persendiskon_tind = $('#form').find('#<?php echo CHtml::activeId($model,'persendiskon_tind'); ?>').val();
        hargadiskon_tind = $('#form').find('#<?php echo CHtml::activeId($model,'hargadiskon_tind'); ?>').val();
        persencyto_tind = $('#form').find('#<?php echo CHtml::activeId($model,'persencyto_tind'); ?>').val();
		hargacyto_tind = $('#form').find('#<?php echo CHtml::activeId($model,'hargacyto_tind'); ?>').val();

        if(komponentarif_id==''){
            komponentarif_nama =  '';
        }else{
            komponentarif_nama =  $('#form .komponentarif_id option:selected').html();
        }
        if(kelaspelayanan_id==''){
            kelaspelayanan_nama =  '';
        }else{
			if (typeof $("#form .kelaspelayanan_nama").val() !== 'undefined' ){
				kelaspelayanan_nama =  $("#form .kelaspelayanan_nama").val();
			}else{
				kelaspelayanan_nama =  $('#form .kelaspelayanan_id option:selected').html();
			}
        }
        if(jenistarif_id==''){
            jenistarif_nama =  '';
        }else{
			if (typeof $("#form .jenistarif_nama").val() !== 'undefined' ){
				jenistarif_nama =  $('#form .jenistarif_nama').val();
			}else{
				jenistarif_nama =  $('#form .jenistarif_id option:selected').html();
			}
        }
        if(perdatarif_id==''){
            perdanama_sk =  '';
        }else{
			if (typeof $("#form .perdanama_sk").val() !== 'undefined' ){
				perdanama_sk =  $('#form .perdanama_sk').val();
			}else{
				perdanama_sk =  $('#form .perdatarif_id option:selected').html();
			}

        }

        //validasi
        i=0;
        $('#table-tariftindakan tr').each(function(){
            current_id = $(this).find('.komponentarif_id').val();
            if(current_id==komponentarif_id){
                i++;
            }
        });

        if(i>0){
            myAlert('Tarif sudah ada di tabel!');
            return false;
        }

        $('#table-tariftindakan').children('tbody').append(tr.replace());
        renameInputRow($('#table-tariftindakan'));

        $('#table-tariftindakan tbody tr:last').find('.daftartindakan_id').val(daftartindakan_id);
        $('#table-tariftindakan tbody tr:last').find('.komponentarif_id').val(komponentarif_id);
        $('#table-tariftindakan tbody tr:last').find('.perdatarif_id').val(perdatarif_id);
        $('#table-tariftindakan tbody tr:last').find('.kelaspelayanan_id').val(kelaspelayanan_id);
        $('#table-tariftindakan tbody tr:last').find('.jenistarif_id').val(jenistarif_id);
        $('#table-tariftindakan tbody tr:last').find('.jeniswaktukerja').val(jeniswaktukerja);

        $('#table-tariftindakan tbody tr:last').find('input[name$="[harga_tariftindakan]"]').val(harga_tariftindakan);
        $('#table-tariftindakan tbody tr:last').find('input[name$="[hargadiskon_tind]"]').val(hargadiskon_tind);
        $('#table-tariftindakan tbody tr:last').find('input[name$="[persendiskon_tind]"]').val(persendiskon_tind);
        $('#table-tariftindakan tbody tr:last').find('input[name$="[persencyto_tind]"]').val(persencyto_tind);
		$('#table-tariftindakan tbody tr:last').find('input[name$="[hargacyto_tind]"]').val(hargacyto_tind);

        $('#table-tariftindakan tbody tr:last #daftartindakan_nama').html(daftartindakan);
        $('#table-tariftindakan tbody tr:last #komponentarif_nama').html(komponentarif_nama);
        $('#table-tariftindakan tbody tr:last #kelaspelayanan_nama').html(kelaspelayanan_nama);
        $('#table-tariftindakan tbody tr:last #jenistarif_nama').html(jenistarif_nama);
        $('#table-tariftindakan tbody tr:last #perdanama_sk').html(perdanama_sk);
        $('#table-tariftindakan tbody tr:last #jeniswaktukerja').html(jeniswaktukerja);
		$('#form').find('#harga_tariftindakan').val(0);
				hitungTotal()
    }

		function hitungTotal(){
		    unformatNumberSemua();
		    var total = 0;
			var totAkhirCyto = 0;
				var totalTarif = 0;
				var totalDiskon = 0;
				var totalCyto = 0;
		    $('#table-tariftindakan tbody tr').each(function(){
		        var harga_tariftindakan  = parseFloat($(this).find('input[name$="[harga_tariftindakan]"]').val());
		        var diskoPersen = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'persendiskon_tind'); ?>').val());
				var cytoPersen = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'persencyto_tind'); ?>').val());
				
				var jmldiskon = (harga_tariftindakan * (diskoPersen/100));
				if (jmldiskon > 0){
					jmldiskon = parseFloat(jmldiskon.toFixed(2));
				}
				
				var jmlcyto = ((harga_tariftindakan - jmldiskon) * (cytoPersen/100));
				if (jmlcyto > 0){
					jmlcyto = parseFloat(jmlcyto.toFixed(2));
				}
				
		        var subtotal = harga_tariftindakan - jmldiskon;
		         if (subtotal > 0){
		            subtotal = parseFloat(subtotal.toFixed(2));
		        }

				var totalAkhirCyto = (subtotal + jmlcyto);
		         if (totalAkhirCyto > 0){
		            totalAkhirCyto = parseFloat(totalAkhirCyto.toFixed(2));
		        }

				totAkhirCyto += totalAkhirCyto;
		        total += subtotal;
				totalDiskon += jmldiskon;
				totalCyto += jmlcyto;
				totalTarif += harga_tariftindakan;

		        $(this).find('input[name$="[hargadiskon_tind]"]').val(jmldiskon);
				$(this).find('input[name$="[hargacyto_tind]"]').val(jmlcyto);
				$(this).find('input[name$="[total_tarifakhir]"]').val(subtotal);
				$(this).find('input[name$="[totaltarifakhir_cyto]"]').val(totalAkhirCyto);
		    });
		    $('#totalTarif').val(totalTarif);
			$('#totalDiskon').val(totalDiskon);
			$('#totalCyto').val(totalCyto);
			$('#totalAkhir').val(total);
			$('#totalAkhirCyto').val(totAkhirCyto);
			$('#totaltariftindakan').val(totalTarif);
			
			$('#form').find('#<?php echo CHtml::activeId($model,'hargadiskon_tind'); ?>').val(totalDiskon);
			$('#form').find('#<?php echo CHtml::activeId($model,'total_tarifakhir'); ?>').val(total);
			$('#form').find('#<?php echo CHtml::activeId($model,'hargacyto_tind'); ?>').val(totalCyto);
			$('#form').find('#<?php echo CHtml::activeId($model,'totaltarifakhir_cyto'); ?>').val(totAkhirCyto);



		    formatNumberSemua();
		}

		function setDiskonRupiah(){
			unformatNumberSemua();
			var jmldiskon = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'hargadiskon_tind'); ?>').val());
			var tarif = parseFloat($('#form').find('#totaltariftindakan').val());
			var diskoPersen = 0;

			diskoPersen =((jmldiskon/tarif)*100);
			if (diskoPersen > 0){
				 diskoPersen = parseFloat(diskoPersen.toFixed(2));
		 }

			if(Math.ceil(diskoPersen) > 100){
				myAlert('Keringanan (%) Lebih dari 100%');
				diskoPersen = 0;
			}

			$('#form').find('#<?php echo CHtml::activeId($model,'persendiskon_tind'); ?>').val(diskoPersen);
			formatNumberSemua();
			diskonPlorateSemua();
		}

		function setDiskonPersen(){
			unformatNumberSemua();
			var diskoPersen = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'persendiskon_tind'); ?>').val());
			var tarif = parseFloat($('#form').find('#totaltariftindakan').val());
			var jmldiskon = 0;

			if(Math.ceil(diskoPersen) > 100){
				myAlert('Keringanan (%) Lebih dari 100%');
				diskoPersen = 0;
				$('#form').find('#<?php echo CHtml::activeId($model,'persendiskon_tind'); ?>').val(0);
			}

			var jmldiskon = (tarif * (diskoPersen/100));
			if (jmldiskon > 0){
				 jmldiskon = parseFloat(jmldiskon.toFixed(2));
		 }

			$('#form').find('#<?php echo CHtml::activeId($model,'hargadiskon_tind'); ?>').val(jmldiskon);
			formatNumberSemua();
			diskonPlorateSemua();
		}

		function diskonPlorateSemua(){
		    unformatNumberSemua();
		    var TotalDiskon = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'hargadiskon_tind'); ?>').val());
		    var totaltariftindakan = parseFloat($('#form').find('#totaltariftindakan').val());
		    var totalAll = 0;

		    $('#table-tariftindakan tbody tr').each(function(){
					var tarif  = parseFloat($(this).find('input[name$="[harga_tariftindakan]"]').val());

					var jumlah = ((tarif / totaltariftindakan) * TotalDiskon);

					if (jumlah > 0){
						 jumlah = parseFloat(jumlah.toFixed(2));
				 }

				 $(this).find('input[name$="[hargadiskon_tind]"]').val(jumlah);
				 totalAll += jumlah;

		    });

		    var selisih = totalAll - TotalDiskon;

		    if (selisih !== 0) {
		        var obj_hargadisk = $("#table-tariftindakan tbody tr input[name$='[hargadiskon_tind]']");

		        if (obj_hargadisk.length > 0) {
		            obj_hargadisk = obj_hargadisk.eq(0);

		            var nilai_diskon = parseFloat($(obj_hargadisk).val());

		            nilai_diskon -= selisih;
		            $(obj_hargadisk).val(nilai_diskon);
		        }
		    }
		    formatNumberSemua();
		   hitungTotal();

		}

		function setPersenCyto(){
			unformatNumberSemua();
			var cytoPersen = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'persencyto_tind'); ?>').val());
			var diskonrp = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'hargadiskon_tind'); ?>').val());
			var tarif = parseFloat($('#form').find('#totaltariftindakan').val());
			var jmlcyto = 0;

			if(Math.ceil(cytoPersen) > 100){
				myAlert('Cyto (%) Lebih dari 100%');
				cytoPersen = 0;
				$('#form').find('#<?php echo CHtml::activeId($model,'persencyto_tind'); ?>').val(0);
			}

			var jmlcyto = ((tarif - diskonrp) * (cytoPersen/100));
			if (jmlcyto > 0){
				jmlcyto = parseFloat(jmlcyto.toFixed(2));
		 	}

			$('#form').find('#<?php echo CHtml::activeId($model,'hargacyto_tind'); ?>').val(jmlcyto);
			formatNumberSemua();
			cytoPlorateSemua();
		}

		function setCytoRupiah(){
			unformatNumberSemua();
			var jmlcyto = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'hargacyto_tind'); ?>').val());
			var tarif = parseFloat($('#form').find('#totaltariftindakan').val());
			var jmldiskon = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'hargadiskon_tind'); ?>').val());
			var tarifDiskon = (tarif - jmldiskon);
			var cytoPersen = 0;

			cytoPersen =((jmlcyto/tarifDiskon)*100);
			if (cytoPersen > 0){
				cytoPersen = parseFloat(cytoPersen.toFixed(2));
		 	}

			if(Math.ceil(cytoPersen) > 100){
				myAlert('Cyto (%) Lebih dari 100%');
				cytoPersen = 0;
			}

			$('#form').find('#<?php echo CHtml::activeId($model,'persencyto_tind'); ?>').val(cytoPersen);
			formatNumberSemua();
			cytoPlorateSemua();
		}

		function cytoPlorateSemua(){
		    unformatNumberSemua();
		    var TotalCyto = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'hargacyto_tind'); ?>').val());
			var TotalDiskon = parseFloat($('#form').find('#<?php echo CHtml::activeId($model,'hargadiskon_tind'); ?>').val());
		    var totaltariftindakan = parseFloat($('#form').find('#totaltariftindakan').val());
		    var totalTarifDiskon = (totaltariftindakan - TotalDiskon);
			var totalAll = 0;

		    $('#table-tariftindakan tbody tr').each(function(){
					var tarif  = parseFloat($(this).find('input[name$="[harga_tariftindakan]"]').val());
					var diskon  = parseFloat($(this).find('input[name$="[hargadiskon_tind]"]').val());

					var jumlah = (((tarif - diskon) / totalTarifDiskon) * TotalCyto);
					
					if (jumlah > 0){
						 jumlah = parseFloat(jumlah.toFixed(2));
				    }

				 $(this).find('input[name$="[hargacyto_tind]"]').val(jumlah);
				 totalAll += jumlah;

		    });

		    var selisih = totalAll - TotalCyto;

		    if (selisih !== 0) {
		        var obj_hargadisk = $("#table-tariftindakan tbody tr input[name$='[hargacyto_tind]']");

		        if (obj_hargadisk.length > 0) {
		            obj_hargadisk = obj_hargadisk.eq(0);

		            var nilai_diskon = parseFloat($(obj_hargadisk).val());

		            nilai_diskon -= selisih;
		            $(obj_hargadisk).val(nilai_diskon);
		        }
		    }
		    formatNumberSemua();
		    hitungTotal();
		}

    function hapus(obj){
        tariftindakan_id = $(obj).parents('tr').find('.tariftindakan_id').val();

        if(tariftindakan_id==''){
            $(obj).parents('tr').detach();
            renameInputRow($('#table-tariftindakan'));
						hitungTotal();
        }else{
            myConfirm("Apakah Anda ingin menghapus data ini?","Perhatian!",function(r){
                if(r){
                    $.ajax({
                        type:'POST',
                        url:'<?php echo $this->createUrl("hapusDetailTarif") ?>',
                        data: {tariftindakan_id : tariftindakan_id},//
                        dataType: "json",
                        success:function(data){
                            if(data.status=1){
                                $(obj).parents('tr').detach();
                                renameInputRow($('#table-tariftindakan'));
																	hitungTotal();
                            }else{
                                myAlert('Tidak dapat dihapus!');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                    });
                }
            });

        }
    }

    function renameInputRow(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(row+1);
            $(this).find('span').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            });
            row++;
        });


    }

    function setTarifDet(){
        isCreate = <?php echo $isCreate?"true":"false"; ?>;
        daftartindakan_id = $('#form .daftartindakan_id').val();
        kelaspelayanan_id = $('#form .kelaspelayanan_id').val();
        perdatarif_id = $('#form .perdatarif_id').val();
        jenistarif_id = $('#form').find('.jenistarif_id').val();
        jeniswaktukerja = $('#form').find('.jeniswaktukerja').val();


        if(daftartindakan_id!=''&&kelaspelayanan_id!=''&&perdatarif_id!=''&&jenistarif_id!=''&&jeniswaktukerja!=''){
            $("#table-tariftindakan").addClass("animation-loading");
            $('#table-tariftindakan > tbody').html("");
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl("setTarifDet") ?>',
                data: {perdatarif_id : perdatarif_id, jenistarif_id : jenistarif_id, kelaspelayanan_id : kelaspelayanan_id, daftartindakan_id : daftartindakan_id, isCreate: isCreate, jeniswaktukerja: jeniswaktukerja},//
                dataType: "json",
                success:function(data){
                    if (data.error == 1) {
                        myAlert("Tindakan sudah memiliki tarif");
                        $(".daftartindakan_id, #daftartindakan").val("");
                    } else {
                        $('#table-tariftindakan > tbody').append(data.form);
                        jQuery('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip({"placement":"bottom"});
                        renameInputRow($("#table-tariftindakan"));
                    }
                    $("#table-tariftindakan").removeClass("animation-loading");
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }
    }

		function tombolSimpan(){
			$('.integer-decimal, .float2, .integer2').each(function(){
				 $(this).val(unformatNumber($(this).val()));
			 });
			$('#satarif-tindakan-m-form').submit();
		}

    $(document).ready(function() {
        renameInputRow($('#table-tariftindakan'));
				hitungTotal();
    });


</script>
