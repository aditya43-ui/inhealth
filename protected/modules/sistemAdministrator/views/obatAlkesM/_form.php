<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<style>
    .float3, .float2, .integer2, .integer-decimal {
        text-align: right;
    }

</style>
<?php
$cs=Yii::app()->clientScript;
$cs->scriptMap=array(
	'bootstrap-multiselect.js'=>false,
);

$this->widget('application.extensions.moneymask.MMask',array(
	'element'=>'.currency',
	'currency'=>'PHP',
	'config'=>array(
		'symbol'=>'Rp. ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
		'defaultZero'=>true,
		'allowZero'=>true,
		'precision'=>0,
	)
));

$this->widget('application.extensions.moneymask.MMask',array(
	'element'=>'.number',
	'config'=>array(
		'defaultZero'=>true,
		'allowZero'=>true,
		'precision'=>2,
	)
));

?>
<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfobat-alkes-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'obatalkes_kode'),
)); ?>
<div class="row-fluid">
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
	<div class="col-sm-6">
		<?php echo $form->hiddenField($model,'obatalkes_id'); ?>
		<?php echo $form->textFieldRow($model,'obatalkes_kode',array('placeholder'=>'Kode Obat Alkes','class'=>'span2',
			'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'disabled'=>true
		)); ?>
		<div class="control-group ">
			<?php echo $form->labelEx($model,'obatalkes_nama', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'obatalkes_nama',array('placeholder'=>'Nama Obat Alkes','class'=>'span3 all-caps',
					'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,
					'onkeyup'=>'generateKode(this); AutoTextNamaOA();')); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Nama Lain Obat Alkes <span class="required">*</span>','obatalkes_nama', array('class'=>'control-label required')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'obatalkes_namalain',array('placeholder'=>'Nama Lain Obat Alkes','class'=>'span3 all-caps',
					'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,
					'readonly'=>true
				)); ?>
			</div>
		</div>
		<div class="control-group">
                            <?php echo $form->labelEx($model, 'pemakaian', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'pemakaian', array('DALAM' => 'DALAM', 'LUAR' => 'LUAR'),array('class' => 'span2')); ?>
                            </div>
                        </div>
		<?php echo $form->dropDownListRow($model,'obatalkes_kadarobat',LookupM::getItems('obatalkes_kadarobat'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>
        <?php echo $form->dropDownlistRow($model, 'bentuk_obat', LookupM::getItems(Params::LOOKUPTYPE_SEDIAANOBATRACIKAN), array(
            'empty'=>'-- Pilih --', 'class'=>'span2',
        )); ?>
		<div class="control-group ">
		<?php echo CHtml::label('Kekuatan', 'kekuatan', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'kekuatan',array('placeholder'=>'Kekuatan Obat Alkes','class'=>'span2 float3',
					'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'AutoTextNamaOA();')); ?>
				<?php echo $form->dropDownList($model,'satuankekuatan',  LookupM::getItems('satuankekuatan'),
					array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",
					'empty'=>'-- Pilih --','style'=>'width:70px;',
					'onchange'=>'AutoTextNamaOA();',
				)); ?>
			</div>
		</div>
		<?php echo $form->dropDownListRow($model,'signa_obatalkes',
			LookupM::getItems('signa_oa'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>
		<?php echo $form->dropDownListRow($model,'sumberdana_id',
			CHtml::listData($model->SumberDanaItems, 'sumberdana_id', 'sumberdana_nama'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>
		<div class="control-group ">
			<?php echo CHtml::label('Jenis Kelompok <span class="required">*</span>', 'Jenis Kelompok', array('class'=>'control-label required')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'jnskelompok',
					LookupM::getItems('jnskelompok'),
					array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
					'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Jenis Obat Alkes <span class="required">*</span>','jenisobatalkes_id', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->hiddenField($model,'jenisobatalkes_id',array('class'=>'required')); ?>
				<?php

                $jenis = "";
                if (!empty($model->jenisobatalkes_id)) {
                    $mjenis = JenisobatalkesM::model()->findByPk($model->jenisobatalkes_id);
                    $jenis = $mjenis->jenisobatalkes_nama;
                }

                $this->widget('MyJuiAutoComplete', array(
					'name'=>'jenisobatalkes',
                    'value'=>$jenis,
					'source'=>'js: function(request, response) {
						$.ajax({
							url: "'.$this->createUrl('AutocompleteJenisObatAlkes').'",
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
						'focus'=> 'js:function( event, ui ){
							$(this).val(ui.item.label);
							return false;
						}',
					   'select'=>'js:function( event, ui ) {
							$(\'#SAObatAlkesM_jenisobatalkes_id\').val(ui.item.jenisobatalkes_id);
							$(\'#jenisobatalkes\').val(ui.item.jenisobatalkes_nama);
							return false;
						}',
					),
					'htmlOptions'=>array(
						'readonly'=>false,
						'placeholder'=>'Jenis Obat Alkes',
						'size'=>13,
						'class'=>'span2 required',
						'onkeypress'=>"return $(this).focusNextInputField(event);",
					),
					'tombolDialog'=>array('idDialog'=>'dialogjenisobatalkes'),
				)); ?>
			</div>
		</div>
		<?php
        echo $form->dropDownListRow($model, 'subjenis_id', CHtml::listData(SubjenisM::model()->findAll('subjenis_aktif = true ORDER BY subjenis_nama ASC'), 'subjenis_id', 'subjenis_nama'),
                array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --', 'style' => 'width:150px;'));
        ?>
		<?php echo $form->dropDownListRow($model,'obatalkes_golongan',  LookupM::getItemsUrutan('obatalkes_golongan'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --','style'=>'width:150px;')); ?>
		<?php echo $form->dropDownListRow($model,'obatalkes_kategori',LookupM::getItems('obatalkes_kategori'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>
		<?php echo $form->dropDownListRow($model,'formularium',  LookupM::getItems('formularium'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --','style'=>'width:140px;')); ?>
		<?php echo $form->dropDownListRow($model,'generik_id',
			CHtml::listData($model->generikItems, 'generik_id', 'generik_nama'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --','style'=>'width:140px;')); ?>
            <div class='control-group'>
			<?php  echo CHtml::label("Tanggal Kadaluarsa",'tglkadaluarsa', array('class'=>'control-label')) ?>
			<div class="controls">
					<?php  $minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; ?>
					<?php  $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'tglkadaluarsa',
                                                        'mode'=>'date',
                                                        'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                //'minDate'=>$minDate,
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
			</div>
		</div>
		<?php // echo $form->textFieldRow($model,'noregister',array('placeholder'=>'No. Register Obat Alkes','class'=>'span3',
//                                                    'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                <div class="control-group">
                    <?php echo CHtml::label("No. Batch",'nobatch', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'nobatch',array('placeholder'=>'No. Batch Obat Alkes','class'=>'span3',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                    </div>
                </div>
		<?php echo $form->dropDownListRow($model,'pabrik_id',
			CHtml::listData($model->PabrikItems, 'pabrik_id', 'pabrik_nama'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --')); ?>
		<?php echo $form->dropDownListRow($model,'discountinue',array('1'=>'Ya','0'=>'Tidak'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --',)); ?>

		<?php echo $form->dropDownListRow($model,'ven',  LookupM::getItems('ven'),
			array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --','style'=>'width:70px;')); ?>
		<?php echo $form->dropDownListRow($model,'atc_id',
			CHtml::listData($model->AtcItems, 'atc_id', 'atc_nama'),
			array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			'empty'=>'-- Pilih --')); ?>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'obatalkes_aktif', array('class' => 'control-label')) ?>
			<div class="controls">
				<div class="radio inline">
					<div class="form-inline">
						<?php echo $form->checkBox($model,'obatalkes_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
					</div>
				</div>
				<?php echo $form->error($model, 'obatalkes_aktif'); ?>
			</div>
		</div>
                
                <?= $this->renderPartial('sistemAdministrator.views.obatAlkesM/obat-prb/index',['model'=>$model, 'form'=>$form]) ?>
            
        <div class="panel panel-success panel-shadow">
			<div class="panel-heading">
				<div class="panel-title">Zat Aktif</div>
			</div>
            <div class="panel-body" id="fieldsetZatAktif" style="width: 100%;">
                <table class="table table-bordered" id="tab_zat_aktif">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th style="text-align: center;"><?php echo CHtml::htmlButton('<i class="entypo-plus"></i>', array(
                                'onclick'=>'tambahZatAktif();', 'class'=>'btn btn-green'
                            )); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count((array)$modZatAktif) == 0) {
                            echo $this->renderPartial($this->path_view.'_rowZatAktif', array(), true);
                        } else {
                            foreach ($modZatAktif as $item) {
                                echo $this->renderPartial($this->path_view.'_rowZatAktif', array('nama'=>$item->obatalkeszataktif_nama), true);
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
	<div class="col-sm-6">

            <?php
                $modKonfigF = KonfigfarmasiK::model()->find();

                if($modKonfigF->isstokminimalfarmasi==true){
                    ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                                <div class="panel-title">Stok Farmasi</div>
                        </div>
                        <div class="panel-body" id="fieldsetStok">
                            <div class="toggle">
                                    <div class="row-fluid">
                                            <div class="col-sm-12">
                                                    <div class="control-group">
                                                            <?php echo $form->labelEx($model,'minimalstok',array('class'=>'control-label'));?>
                                                            <div class="controls">
                                                                    <?php echo $form->textField($model,'minimalstok',array('class'=>'span1 integer2',
                                                                    'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                                            </div>
                                                    </div>
                                                    <!--<div class="control-group">-->
                                                            <?php // echo $form->labelEx($model,'lokasigudang_id',array('class'=>'control-label'));?>
                                                            <!--<div class="controls">-->
                                                                    <?php // echo $form->dropDownList($model,'lokasigudang_id',
//                                                                            CHtml::listData($model->lokasiGudangItems, 'lokasigudang_id', 'lokasigudang_nama'),
//                                                                            array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
//                                                                            'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
                                                            <!--</div>-->
                                                    <!--</div>-->
                                                    <?php echo $form->textFieldRow($model,'maksimalstok',array('class'=>'span1 integer2',
                                                    'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                            </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                    <div class="panel-title">Stok Minimal Ruangan</div>
                            </div>
                            <div class="panel-body" style="width: 100%;">
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <div class="control-group">
                                                <?php echo CHtml::label('Ruangan','',array('class'=>'control-label'));?>
                                                <div class="controls">
                                                        <?php echo CHtml::dropDownList('ruangan_minimal','',
                                                                CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),
                                                                array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="control-group ">
                                            <label class='control-label'>Jumlah Minimal Stok</label>
                                            <div class="controls">
                                                <?php echo Chtml::textField('jumlah', '', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;')); ?>
                                                <?php
                                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                                       array('onclick'=>'tambahMinimalStokRuangan();return false;',
                                                          'class'=>'btn btn-primary',
                                                          'rel'=>"tooltip",
                                                          'title'=>"Klik untuk menambahkan Stok Minimal Ruangan",)); ?>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table table-bordered" id="stokmimalruangan">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">No</th>
                                            <th style="text-align: center;">Ruangan</th>
                                            <th style="text-align: center;">Jumlah Minimal Stok</th>
                                            <th style="text-align: center;">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(isset($minimalStokDet) && count((array)$minimalStokDet) > 0){
                                                $indxMn = 1;
                                                foreach ($minimalStokDet as $i => $minimalSt){
                                                    $minimalStk = new StokminimalT();
                                                    $minimalStk->ruangan_id = $minimalSt->ruangan_id;
                                                    $minimalStk->jmlminimalstok = $minimalSt->jmlminimalstok;
                                                    ?>
                                                        <tr>
                                                            <td class="nomor"><?php echo $indxMn; ?></td>
                                                            <td>
                                                                <?php echo CHtml::activeHiddenField($minimalStk, '['.$i.']ruangan_id', array('class'=>'ruangan_idcls')) ?>
                                                                <span class="ruangannama">
                                                                    <?php
                                                                        echo (isset($minimalSt->ruangan)? $minimalSt->ruangan->ruangan_nama: "")
                                                                    ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <?php echo CHtml::activeHiddenField($minimalStk, '['.$i.']jmlminimalstok', array('class'=>'jumlah_cls')) ?>
                                                                <span>
                                                                    <?php echo number_format($minimalSt->jmlminimalstok,2,',','.'); ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')) ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    $indxMn++;
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php
                }
            ?>

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">HPP</div>
			</div>
			<div class="panel-body" id="fieldsetHargaNetto">
				<!--fieldset class='box' id="fieldsetHargaNetto"-->
					<div class="toggle">
						<div class="row-fluid">
							<div class="col-sm-12">
								<div class="control-group">
									<?php echo CHtml::label('Harga Beli', 'hargabeli', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo CHtml::textField('hargabeli', '', array('class' => 'control-label integer-decimal hargabeli', 'onkeyup' => 'hitung_harganetto()')); ?>
										<?php echo CHtml::hiddenField('hargabelilama', ''); ?>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model, 'satuanbesar_id', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php
											echo $form->dropDownList($model, 'satuanbesar_id', CHtml::listData($model->SatuanBesarItems, 'satuanbesar_id', 'satuanbesar_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
											'empty' => '-- Pilih --', 'style' => 'width:130px;'));
										?>
									</div>
								</div>

								<div class="control-group" >
									<?php echo CHtml::label('Isi Netto', 'kemasanbesar', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'kemasanbesar', array('class' => 'span1 integer2',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_harganetto()', 'onblur'=>'validasiKemasanBesar()',));
										?>
									</div>
								</div>

								<div class="control-group" >
									<?php echo $form->labelEx($model, 'satuankecil_id', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php
										echo $form->dropDownList($model, 'satuankecil_id', CHtml::listData($model->SatuanKecilItems, 'satuankecil_id', 'satuankecil_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'AutoTextNamaOA();',
											'empty' => '-- Pilih --', 'style' => 'width:130px;'));
										?>
									</div>
								</div>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'satuanterkecil_id', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php
                                        echo $form->dropDownList($model, 'satuanterkecil_id', CHtml::listData($model->SatuanKecilItems, 'satuankecil_id', 'satuankecil_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'empty' => '-- Pilih --',));
                                        ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'kemasanterkecil', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php
                                        echo $form->textField($model, 'kemasanterkecil',array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                                        ?>
                                    </div>
                                </div>

                <div class="control-group" >
									<?php echo $form->labelEx($model, 'het', array('class' => 'control-label required','label'=>'Harga Eceran Tertinggi (HET) <span class="required">*</span>')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'het', array('class' => 'span2 integer-decimal',
											'onkeypress' => "return $(this).focusNextInputField(event);"));
										?>
									</div>
								</div>
								<div class="control-group" >
									<?php echo $form->labelEx($model, 'harganetto', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'harganetto', array('class' => 'span2 integer-decimal harganetto',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hargabeli();','readonly'=>true));
										?>
										<i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Harga Netto = (Harga Beli / Isi Netto)" data-html="true"></i>
										<?php echo CHtml::hiddenField('harganettolama', $model->harganetto); ?>
									</div>
								</div>

								<div class="control-group" >
									<?php echo $form->labelEx($model, 'discount', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'discount', array('class' => 'span1 float3',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungHpp();'));
										?> %
									</div>
								</div>

								<div class="control-group" >
									<?php echo $form->labelEx($model, 'ppn_persen', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'ppn_persen', array('class' => 'span1 integer-decimal',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungHpp();'));
										?> %
									</div>
								</div>
								<div class="control-group" >
									<?php echo Chtml::label('HPP', 'hpp', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'hpp', array('class' => 'span2 integer-decimal', 'onkeyup' => 'marginResep();',
											'onkeypress' => "return $(this).focusNextInputField(event);"));
										?>
                                                                            <i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="((Harga Netto - Discount) + PPN)" data-html="true"></i>
                                                                            <!--<font size="1px">(Harga Netto - (Discount + Ppn))</font>-->
									</div>
								</div>
							</div>
						</div>
					</div>
				<!--/fieldset-->
			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Harga Jual Apotek</div>
			</div>
			<div class="panel-body" id="fieldsetHargaJualApotek">
				<!--fieldset class='box' id="fieldsetHargaJualApotek"-->
					<div class="toggle">
						<div class="row-fluid">
							<div class="col-sm-12">
								<div class="control-group" >
									<?php echo $form->labelEx($model, 'margin', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'margin', array('class' => 'span1 float3',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hargajual()'));
										?> %
									</div>
								</div>
								<div class="control-group" >
									<?php echo $form->labelEx($model, 'hargajual', array('class' => 'control-label', 'label'=>'Harga Jual')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'hargajual', array('class' => 'span2 integer-decimal hargajual',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_margin(); hitunghet(this,"hargajual");'));
										?> <font size="1px">Rupiah</font>
										<?php echo CHtml::hiddenField('hargajuallama', $model->hargajual, array('class'=>'integer-decimal')); ?>
									<i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="(HPP + Margin * HPP)" data-html="true"></i>
                                                                        </div>
								</div>
                                <?php /*
								<div class="control-group" >
									<?php echo $form->labelEx($model, 'hargajualnonrj', array('class' => 'control-label', 'label'=>'Harga Jual RI / RD / VK / Intensif')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'hargajualnonrj', array('class' => 'span2 integer2',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_margin()'));
										?> <font size="1px">Rupiah</font>
									</div>
								</div>
                                 *
                                 */ ?>
								<div class="control-group" >
									<?php echo $form->labelEx($model, 'marginnonresep', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'marginnonresep', array('class' => 'span1 float3',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hjanonresep()'));
										?> %
									</div>
								</div>
								<div class="control-group" >
									<?php echo $form->labelEx($model, 'hjanonresep', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'hjanonresep', array('class' => 'span2 integer-decimal',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_margin_hjanonresep();  hitunghet(this,"hjanonresep");'));
										?> <font size="1px">Rupiah</font>
                                                                                <i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Harga Ini Digunakan Untuk Penjualan Resep Umum" data-html="true"></i>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model, 'marginresep', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'marginresep', array('class' => 'span1 float3',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hjaresep()'));
										?> %
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model, 'hjaresep', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'hjaresep', array('class' => 'span2 integer-decimal',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_margin_hjaresep(); hitunghet(this,"hjaresep");'));
										?> <font size="1px">Rupiah</font>
                                                                                <i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Harga Ini Digunakan Untuk Penjualan Dokter dan Pegawai" data-html="true"></i>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model, 'jasadokter', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'jasadokter', array('class' => 'span2 integer-decimal',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hjaresep()'));
										?> <font size="1px">Rupiah</font>
									</div>
								</div>
								<div class="control-group" >
									<?php echo $form->labelEx($model, 'hargamaksimum', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'hargamaksimum', array('class' => 'span2 integer-decimal	',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
										?> <font size="1px">Rupiah</font>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model, 'hargaminimum', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'hargaminimum', array('class' => 'span2 integer-decimal',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
										?> <font size="1px">Rupiah</font>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model, 'hargaaverage', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->textField($model, 'hargaaverage', array('class' => 'span2 integer-decimal',
											'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
										?> <font size="1px">Rupiah</font>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!--/fieldset-->
			</div>
		</div>

	</div>
</div>
<div class="row-fluid" style="overflow-x: scroll">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo Chtml::label('Therapi Obat', 'Therapi Obat', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				if ($model->isNewRecord) {
					$this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true)
					);
					echo CHtml::dropDownList(
							'therapiobat_id[]', '', CHtml::listData(SATherapiobatM::model()->findAll('therapiobat_aktif=TRUE ORDER BY therapiobat_nama'), 'therapiobat_id', 'therapiobat_nama'), array('multiple' => 'multiple', 'key' => 'therapiobat_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
					);
				} else {
					$arrTherapiObat = array();
					if(!empty($modTherapiObat)){
						foreach ($modTherapiObat as $dataTherapiObat) {
							$arrTherapiObat[] = $dataTherapiObat['therapiobat_id'];
						}
					}
					
					$this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true)
					);
					echo CHtml::dropDownList(
							'therapiobat_id[]', $arrTherapiObat, CHtml::listData(SATherapiobatM::model()->findAll('therapiobat_aktif=TRUE ORDER BY therapiobat_nama'), 'therapiobat_id', 'therapiobat_nama'), array('multiple' => 'multiple', 'key' => 'therapiobat_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
					);
				}
				?>
			</div>
		</div>
	</div>
    <div class="clear"></div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo Chtml::label('Supplier', 'Supplier', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				if ($model->isNewRecord) {
					$this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true)
					);
					echo CHtml::dropDownList(
							'supplier_id[]', '', CHtml::listData(SASupplierM::model()->findAll('supplier_aktif=TRUE ORDER BY supplier_nama'), 'supplier_id', 'supplier_nama'), array('multiple' => 'multiple', 'key' => 'supplier_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
					);
				} else {
					$arrSuplier = array();
					if(!empty($modObatSupplier)){
						foreach ($modObatSupplier as $dataObatSupplier) {
							$arrSuplier[] = $dataObatSupplier['supplier_id'];
						}
					}
					
					$this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true)
					);
					echo CHtml::dropDownList(
							'supplier_id[]', $arrSuplier, CHtml::listData(SASupplierM::model()->findAll('supplier_aktif=TRUE ORDER BY supplier_nama'), 'supplier_id', 'supplier_nama'), array('multiple' => 'multiple', 'key' => 'supplier_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
					);
				}
				?>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<?php echo CHtml::hiddenField('alasanperubahan_hidden',''); ?>
	<?php echo CHtml::hiddenField('disetujuioleh_hidden',''); ?>
	<?php echo $this->renderPartial($this->path_view.'_ObatAlkesDetail', array('model'=>$model,'modObatAlkesDetail'=>$modObatAlkesDetail, 'form'=>$form)); ?>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();'));?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
		$this->createUrl('admin'),
		array('class'=>'btn btn-danger',
		'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Obat Alkes', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php
		$content = $this->renderPartial($this->path_view.'tips.tipsCreateUpdate',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>
<?php $this->endWidget(); ?>

<!-- =============================== beginWidget Jenis Obat Alkes ============================= -->
<?php
   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id'=>'dialogjenisobatalkes',
	'options'=>array(
		'title'=>'Pencarian Jenis Obat Alkes',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>900,
		'height'=>600,
		'resizable'=>false,
		),
	));

$modJenisObat = new JenisobatalkesM('search');
$modJenisObat->unsetAttributes();
if(isset($_GET['JenisobatalkesM'])) {
	$modJenisObat->attributes = $_GET['JenisobatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'jenisobatalkes-grid',
	'dataProvider'=>$modJenisObat->searchObatMaster(),
	'filter'=>$modJenisObat,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
				array(
					"class"=>"btn-small",
					"id" => "selectjenisobatalkes",
					"onClick" => "\$(\"#SAObatalkesM_jenisobatalkes_id\").val($data->jenisobatalkes_id);
								  \$(\"#jenisobatalkes\").val(\"$data->jenisobatalkes_nama\");
								  \$(\"#dialogjenisobatalkes\").dialog(\"close\");"
				 )
			 )',
		),
		'jenisobatalkes_nama',
		'jenisobatalkes_namalain',
	),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
 <?php
$urlgetKodeObatAlkes=$this->createUrl('GetKodeObatAlkes');
$kodeObat = CHtml::activeId($model,'obatalkes_kode');

$js = <<< JS
function generateKode(obj)
{
//   Generate kode obat di nonaktifkan (Input Manual)
//   namaObat =obj.value;
//   if(namaObat!=''){//Jika nama Obat Tidak Kosong
//       $.post("${urlgetKodeObatAlkes}",{namaObat: namaObat},
//            function(data){
//                $('#${kodeObat}').val(data.kodeObatBaru);
//        },"json");
//   }else{//Jika Nama Obat Kosong
//                $('#${kodeObat}').val('');
//   }
}

JS;
Yii::app()->clientScript->registerScript('sfdasdasda',$js,CClientScript::POS_HEAD);



?>
<script type="text/javascript">
<?php
$urlGetResepDokter =  $this->createUrl('getPersenDokter');
$rowZatAktif = $this->renderPartial($this->path_view.'_rowZatAktif', array(), true);
$rowZatAktif = str_replace("\n", "", $rowZatAktif);
$rowZatAktif = str_replace("\r", "", $rowZatAktif);
$modKonfigFarmasi = KonfigfarmasiK::model()->find();
?>

var rowZatAktif = '<?php echo $rowZatAktif; ?>';


function tambahZatAktif() {
    $("#tab_zat_aktif tbody").append(rowZatAktif);
}

function removeRowZatAktif(obj) {
    $(obj).parents("tr").remove();
}

function parseUnformat(v)
{
	return parseFloat(unformatNumber(v));
    // return formatThousandDecimal(unformatNumber(v));
}

function hitungHpp()
{
	var harganetto = parseUnformat($('#<?php echo CHtml::activeId($model,"harganetto"); ?>').val());
	var discount = parseUnformat($('#<?php echo CHtml::activeId($model,"discount"); ?>').val());
	var ppn = parseUnformat($('#<?php echo CHtml::activeId($model,"ppn_persen"); ?>').val());

    if (discount > 100) {
        discount = 100;
        $('#<?php echo CHtml::activeId($model,"discount"); ?>').val(formatFloat(discount));
        myAlert("Diskon tidak boleh lebih dari 100%");
    }
    if (ppn > 100) {
        ppn = 100;
        $('#<?php echo CHtml::activeId($model,"ppn_persen"); ?>').val(formatFloat(ppn));
        myAlert("PPN tidak boleh lebih dari 100%");
    }


	var jumlahDiskon = (harganetto - (harganetto * (discount/100)));
  if(jumlahDiskon > 0){
    jumlahDiskon = parseFloat(jumlahDiskon.toFixed(2));
  }
	var jumlahPpn = (jumlahDiskon * (ppn / 100));
  if(jumlahPpn > 0){
    jumlahPpn = parseFloat(jumlahPpn.toFixed(2));
  }
	var hpp = jumlahDiskon + jumlahPpn;
  if(hpp > 0){
    hpp = parseFloat(hpp.toFixed(2));
  }

	$('#<?php echo CHtml::activeId($model,"hpp"); ?>').val(formatThousandDecimal(hpp));
        hitung_hargajual();
        hitung_hjanonresep();
        hitung_hjaresep();
}

function cekInput()
{
	$('.integer2').each(function(){this.value = unformatNumber(this.value)});
	$('.number').each(function(){this.value = unformatNumber(this.value)});
	return true;
}

function hitung_hargabeli(){
	var harganetto  = parseUnformat($('#<?php echo CHtml::activeId($model,"harganetto"); ?>').val());
	var isinetto = parseUnformat($('#<?php echo CHtml::activeId($model,"kemasanbesar"); ?>').val());
	var total_hargabeli = harganetto * isinetto;
	$('#hargabeli').val(formatThousandDecimal(total_hargabeli));
	hitungHpp();
}

function hitung_harganetto(){
	var hargabeli = parseUnformat($('#hargabeli').val());
	var isinetto  = parseUnformat($('#<?php echo CHtml::activeId($model,"kemasanbesar"); ?>').val());
	var total_harganetto = hargabeli / isinetto;
	$('#<?php echo CHtml::activeId($model,"harganetto"); ?>').val(formatThousandDecimal(total_harganetto));
	hitungHpp();
}

function hitunghet(obj, type){
  var hargajual = parseUnformat($(obj).val());
  var het = parseUnformat($('#<?php echo CHtml::activeId($model,"het"); ?>').val());
  var label = "Harga Jual";

  if(type=='hargajual'){
    label = "Harga Jual";
  }else if(type=='hjanonresep'){
    label = "HJA Non Resep";
  }else if(type=='hjaresep '){
    label = "HJA Resep";
  }

  <?php if($modKonfigFarmasi->ishargajualhet==true){ ?>
    if(hargajual > het){
      myAlert(label + ' Tidak Boleh Melebihi Harga Eceran Tertinggi (HET)');
      $(obj).val(formatThousandDecimal(het));
    }
  <?php } ?>
}

function hitung_margin(){
    return false;
    /*
	var hargajual = parseUnformat($('#<?php echo CHtml::activeId($model,"hargajual"); ?>').val());
	var hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
	var margin = ((hargajual - hpp)/hpp)*100;
	$('#<?php echo CHtml::activeId($model,"margin"); ?>').val(formatFloat(margin));
    *
    */
}

function hitung_hargajual(){
	var margin = parseUnformat($('#<?php echo CHtml::activeId($model,"margin"); ?>').val());
	//var netto = parseUnformat($('#<?php //echo CHtml::activeId($model,"harganetto"); ?>').val());
	//var diskon = parseUnformat($('#<?php //echo CHtml::activeId($model,"discount"); ?>').val());
	var hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());

    //var pre_hpp = netto * (100 - diskon) / 100;

    // harga jual rj
  var marginjumlah = (hpp * (margin / 100));
  if(marginjumlah > 0){
    marginjumlah = parseFloat(marginjumlah.toFixed(2));
  }
	var hargajual = (hpp + marginjumlah);
  if(hargajual > 0){
    hargajual = parseFloat(hargajual.toFixed(2));
  }
	$('#<?php echo CHtml::activeId($model,"hargajual"); ?>').val(formatThousandDecimal(hargajual));

    // harga jual non rj
    //hargajual = pre_hpp + ((pre_hpp/100)*margin);
	//$('#<?php // echo CHtml::activeId($model,"hargajualnonrj"); ?>').val(formatNumber(hargajual));

}

function hitung_margin_hjanonresep(){
    return false;
    /*
	var hjanonresep = parseUnformat($('#<?php echo CHtml::activeId($model,"hjanonresep"); ?>').val());
	var hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
	var marginnonresep = ((hjanonresep - hpp)/hpp)*100;
	$('#<?php echo CHtml::activeId($model,"marginnonresep"); ?>').val(formatFloat(marginnonresep));
    */
}

function hitung_hjanonresep(){
	var marginnonresep = parseUnformat($('#<?php echo CHtml::activeId($model,"marginnonresep"); ?>').val());
	var hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());

  var marginjumlah = (hpp * (marginnonresep / 100));
  if(marginjumlah > 0){
    marginjumlah = parseFloat(marginjumlah.toFixed(2));
  }
	var hjanonresep = (hpp + marginjumlah);

  if(hjanonresep > 0){
    hjanonresep = parseFloat(hjanonresep.toFixed(2));
  }

	$('#<?php echo CHtml::activeId($model,"hjanonresep"); ?>').val(formatThousandDecimal(hjanonresep));
}

function hitung_margin_hjaresep(){
    return false;
    /*
	var hjaresep = parseUnformat($('#<?php echo CHtml::activeId($model,"hjaresep"); ?>').val());
	var jasadokter = parseUnformat($('#<?php echo CHtml::activeId($model,"jasadokter"); ?>').val());
	var hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
	var marginresep = (((hjaresep - hpp - jasadokter)/hpp)*100);
	$('#<?php echo CHtml::activeId($model,"marginresep"); ?>').val(formatFloat(marginresep));
    */
}

function hitung_hjaresep(){
	var marginresep = parseUnformat($('#<?php echo CHtml::activeId($model,"marginresep"); ?>').val());
	//var jasadokter = parseUnformat($('#<?php echo CHtml::activeId($model,"jasadokter"); ?>').val());
	var hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());

  var marginjumlah = (hpp * (marginresep / 100));
  if(marginjumlah > 0){
    marginjumlah = parseFloat(marginjumlah.toFixed(2));
  }
	var hjaresep = (hpp + marginjumlah);// + jasadokter;
  if(hjaresep > 0){
    hjaresep = parseFloat(hjaresep.toFixed(2));
  }
	$('#<?php echo CHtml::activeId($model,"hjaresep"); ?>').val(formatThousandDecimal(hjaresep));
}
/**
* tombol batal pada dialogbox
* @param {type} dialog_id
* @returns {undefined}
*/
function batalDialog(dialog_id){
   if(confirm("Apakah anda yakin akan membatalkan ini ?"))
       $('#'+dialog_id).dialog("close");
}

/**
 * menampilkan form verifikasi
 * @returns {undefined}
 */
function setVerifikasi(){
	<?php if(isset($_GET['id'])){?>
	hargabeli = unformatNumber($('.hargabeli').val());
	hargabelilama = unformatNumber($('#hargabelilama').val());
	harganetto = unformatNumber($('.harganetto').val());
	harganettolama = unformatNumber($('#harganettolama').val());
	hargajual = unformatNumber($('.hargajual').val());
	hargajuallama =  unformatNumber($('#hargajuallama').val());

	if (!validasiKemasanBesar()) {
		return false;
	}

    if(requiredCheck($("form"))){
    	if(hargabeli!=hargabelilama||harganetto!=harganettolama||hargajual!=hargajuallama){
    		$('#dialog-verifikasi').dialog("open");
	        $.ajax({
	           type:'POST',
	           url:'<?php echo $this->createUrl('verifikasi'); ?>',
	           data: $("form").serialize(),
	           dataType: "json",
	           success:function(data){
	                $('#dialog-verifikasi > .dialog-content').html(data.content);
	           },
	            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
	        });
	        //untuk verifikasi hilangkan srbac loading
	        $(".animation-loading").removeClass("animation-loading");
	        $("form").find('.float2').each(function(){
	            $(this).val(formatFloat($(this).val()));
	        });
	        $("form").find('.integer2').each(function(){
	            $(this).val(formatInteger($(this).val()));
	        });
    	}else{
			$('.integer-decimal, .float2, .integer2').each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
    		$("#gfobat-alkes-m-form").submit();
    	}
    }
    <?php }else{ ?>
		$('.integer-decimal, .float2, .integer2').each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
    	$("#gfobat-alkes-m-form").submit();
    <?php } ?>
    return false;
}

function AutoTextNamaOA()
{
	var nama = $('#<?php echo CHtml::activeId($model,"obatalkes_nama"); ?>').val();
	var kekuatan = $('#<?php echo CHtml::activeId($model,"kekuatan"); ?>').val();
	var satuan = $('#<?php echo CHtml::activeId($model,"satuankekuatan"); ?>').val();
	var satuankecil = $('#<?php echo CHtml::activeId($model,"satuankecil_id"); ?> option:selected').html();

	if(nama == ''){
		var nama = '';
	}
	if(kekuatan == ''){
		var kekuatan = '';
	}
	if(satuan == ''){
		var satuan = '';
	}
	if((satuankecil == '') || (satuankecil == '-- Pilih --')){
		var satuankecil = '';
	}
	document.getElementById('SAObatalkesM_obatalkes_namalain').value = (nama+' '+kekuatan+' '+satuan+' '+satuankecil).toUpperCase();
}

function validasiKemasanBesar() {
	var isinetto  = parseUnformat($('#<?php echo CHtml::activeId($model,"kemasanbesar"); ?>').val());
	if (isinetto <= 0) {
		myAlert("Isi netto harus lebih dari 0");
		$('#<?php echo CHtml::activeId($model,"kemasanbesar"); ?>').val(1).keyup();
		return false;
	}
	return true;
}

function setAlasan() {
    var alasan = $("#alasanperubahan").val();
    var disetujui = $("#disetujuioleh").val();

    $("#alasanperubahan_hidden").val(alasan);
    $("#disetujuioleh_hidden").val(disetujui);
}

function submitVerifikasi(obj) {
    if ($("#alasanperubahan").val().trim() == '') {
        myAlert("'Alasan Perubahan' wajib diisi");
        return false;
    }
    if ($("#disetujuioleh").val().trim() == '') {
        myAlert("'Disetujui Oleh' wajib diisi");
        return false;
    }


    disableOnSubmit(obj); $("#gfobat-alkes-m-form").submit();
}

function tambahMinimalStokRuangan()
{
    var ruangan = $('#ruangan_minimal').val();
    var obatnama = $('#<?php echo CHtml::activeId($model,'obatalkes_nama'); ?>').val();
    var ruangan_nama = $('#ruangan_minimal').find('option:selected').text();
    var jumlah = $('#jumlah').val();
//    $modMinimalStok
        if(ruangan != '' && jumlah != '')
        {
            var indexRuangan = 0;
            var jmlSeb = 0;

            for(var i=0; i<$('#stokmimalruangan tbody').find('.ruangan_idcls').length; i++){
                if(ruangan == $('#stokmimalruangan tbody').find('.ruangan_idcls').eq(i).val()){
                    indexRuangan += 1;
                    jmlSeb = $('#stokmimalruangan tbody').find('.jumlah_cls').eq(i).val();
                }
            }

            if(indexRuangan == 0){
                var html = '<tr>'+
                            '<td class="nomor"></td>' +
                            '<td>'+
                            '<?php echo CHtml::activeHiddenField($modMinimalStok, 'ruangan_id', array('class'=>'ruangan_idcls')) ?>' +
                            '<span  class="ruangannama">'+ ruangan_nama +'</span>' +
                            '</td>' +
                            '<td>'+
                            '<?php echo CHtml::activeHiddenField($modMinimalStok, 'jmlminimalstok', array('class'=>'jumlah_cls')) ?>' +
                            '<span>'+ jumlah +'</span>' +
                            '</td>' +
                            '<td>'+
                            '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')) ?>' +
                            '</td>' +
                        '</tr>';
                $('#stokmimalruangan tbody').append(html);
                $('#stokmimalruangan tbody').find('tr:last-child').find('.ruangan_idcls').val(ruangan);
                $('#stokmimalruangan tbody').find('tr:last-child').find('.jumlah_cls').val(parseFloat(unformatNumber((jumlah))));
                renameInputanMinimal($('#stokmimalruangan tbody'));
                $('#ruangan_minimal').val('');
                $('#jumlah').val('');
            }else{
                myAlert("Stok Minimal untuk "+obatnama+" di ruangan "+ruangan_nama+" sudah dimappingkan sebelumnya dengan memiliki jumlah stok minimal "+jmlSeb);
            }
        }else{
            myAlert("Isikan Ruangan dan Jumlah Minimal Stok pada panel Stok Minimal Ruangan");
        }
}

function renameInputanMinimal(obj){
    var index = 1;
   for (var i=0; i<obj.find('.nomor').length; i++){
       var trinput = obj.find('.nomor').eq(i);
       trinput.html(index);
       index++;
   }
   for (var i=0; i<obj.find('.ruangan_idcls').length; i++){
       var trinput = obj.find('.ruangan_idcls').eq(i);
       trinput.attr('id','StokminimalT_'+i+'_ruangan_id');
       trinput.attr('name','StokminimalT['+i+'][ruangan_id]');
   }
   for (var i=0; i<obj.find('.jumlah_cls').length; i++){
       var trinput = obj.find('.jumlah_cls').eq(i);
       trinput.attr('id','StokminimalT_'+i+'_jmlminimalstok');
       trinput.attr('name','StokminimalT['+i+'][jmlminimalstok]');
   }
}

function delRow(obj)
{
    var obatnama = $('#<?php echo CHtml::activeId($model,'obatalkes_nama'); ?>').val();
    var ruangan = $(obj).parent().parent().find('.ruangannama').html();

    myConfirm("Apakah anda akan menghapus data stok minimal untuk "+obatnama+" di "+ruangan.trim(),'Perhatian!',function(r){
        if(r){
            $(obj).parent().parent().remove();
            renameInputanMinimal($('#stokmimalruangan tbody'));
        }
    });
}

$(document).ready(function(){
	hitung_hargabeli();
    $(".float3").maskMoney(
        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
    );
	$('#hargabelilama').val(unformatNumber($('.hargabeli').val()));
	<?php if((isset($_GET['id'])) && empty($model->obatalkes_namalain)){ ?>
		var namalain = '<?php echo $model->obatalkes_nama; ?>';
		$('#<?php echo CHtml::activeId($model,"obatalkes_namalain"); ?>').val(namalain);
	<?php } ?>
});

</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialog-verifikasi',
    'options'=>array(
        'title'=>'Verifikasi Perubahan Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>750,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

echo '<div class="dialog-content"></div>';
?>
<div class="row-fluid">
	<div class="col-sm-12">
		<div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'submitVerifikasi(this);')); ?>
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>
