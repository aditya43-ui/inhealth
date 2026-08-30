<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pengeluaranaset-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<div class="panel panel-primary panel-success">
	<div class="panel-heading">
            <div class="panel-title"><i class="glyphicon glyphicon-file"></i>Pengeluaran Aset</div>
	</div>
	<div class="panel-body">
		<div class="row-fluid">
			<p class="help-block" style="color:#333"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
			<?php echo $form->errorSummary($model); ?>
			<div class="col-sm-6">
                            <div class="control-group ">
					<?php echo CHtml::label('Tanggal Pengeluaran','',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php
                                                 $model->tglpengeluaranaset = MyFormatter::formatDateTimeForUser($model->tglpengeluaranaset);
						 $this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglpengeluaranaset',
							'mode' => 'date',
							'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate' => 'd',
							),
							'htmlOptions' => array('class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
							)); ?>	
					</div>
			    </div>
                            <div class="control-group">
                                	<?php echo CHtml::label('Kode Lokasi <span class="required">*</span>','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->dropDownList($model,'kd_lokasi_kode', CHtml::listData(LokasiasetM::model()->findAllByAttributes(array('jenis_lokasi'=>'ENTRY')), 'lokasiaset_kode', 'lokasiaset_kode'),array('empty'=>'-- Pilih --','class'=>'span3 required', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                	<?php echo CHtml::label('Lokasi Aset <span class="required">*</span>','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->dropDownList($model,'lokasiaset_kode', CHtml::listData(LokasiasetM::model()->findAll(), 'lokasiaset_namalokasi', 'lokasiaset_namalokasi'),array('empty'=>'-- Pilih --','class'=>'span3 required', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                	<?php echo CHtml::label('Lokasi Penerimaan <span class="required">*</span>','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->dropDownList($model,'lokasipenerima_kode', CHtml::listData(LokasiasetM::model()->findAll(), 'lokasiaset_namalokasi', 'lokasiaset_namalokasi'),array('empty'=>'-- Pilih --','class'=>'span3 required', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                                </div>
                            </div>
                             <div class="control-group">
                                	<?php echo CHtml::label('Ruangan Aset <span class="required">*</span>','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3 required', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                	<?php echo CHtml::label('Penerimaan Barang','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->textField($model, 'penerimaaset', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                	<?php echo CHtml::label('Jenis/Peruntukan','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->dropDownList($model, 'jenisperuntukan', LookupM::getItems('jenisperuntukan'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                                </div>
                            </div>
                            
			    <div class="control-group">
					<?php echo CHtml::label('Pengawai Mengeluarkan <span class="required">*</span>','',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php 
							echo $form->hiddenField($model,'pegpengeluaran_id', array('readonly' => true, 'class' => 'required'));

							$this->widget('MyJuiAutoComplete', array(
								'name'=>'pegpengeluaran_nama',
								'source'=>'js: function(request, response) {
									$.ajax({
									url: "'.$this->createUrl('/ActionAutoComplete/GetPegawaiRuanganLogin').'",
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
								'minLength' => 0,
								'focus'=> 'js:function( event, ui ) {
									$(this).val( ui.item.label);
									return false;
								 }',
								'select'=>'js:function( event, ui ) {
									$("#'.CHtml::ActiveId($model, 'pegpengeluaran_id').'").val(ui.item.value); 
									
									return false;
								 }',
							),		
							'htmlOptions' => array('placeholder' => 'Ketik Nama Pegawai','class'=>'span3 required'),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiPengeluaran'),
							)); 
						?>
					</div>
			    </div>
				<div class="control-group">
					<?php echo CHtml::label('Pengawai Menyetujui <span class="required">*</span>','',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php 
							echo $form->hiddenField($model,'pegmengetahui_id', array('readonly' => true, 'class' => 'required'));

							$this->widget('MyJuiAutoComplete', array(
								'name'=>'pegmengetahui_nama',
								'source'=>'js: function(request, response) {
									$.ajax({
									url: "'.$this->createUrl('/ActionAutoComplete/GetPegawaiRuanganLogin').'",
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
								'minLength' => 0,
								'focus'=> 'js:function( event, ui ) {
									$(this).val( ui.item.label);
									return false;
								 }',
								'select'=>'js:function( event, ui ) {
									$("#'.CHtml::ActiveId($model, 'pegmengetahui_id').'").val(ui.item.value); 
									
									return false;
								 }',
							),		
							'htmlOptions' => array('placeholder' => 'Ketik Nama Pegawai','class'=>'span3 required'),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiPenyetujui'),
							)); 
						?>
					</div>
				</div>				
			</div>
                        <div class='col-sm-6'>
                            <div class="control-group">
                                	<?php echo CHtml::label('Nomor Pengeluaran <span class="required">*</span>','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->textField($model, 'nopengeluaranaset', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                	<?php echo CHtml::label('Surat Perintah <span class="required">*</span>','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->textField($model, 'no_suratperintah', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                             <div class="control-group ">
					<?php echo CHtml::label('Tanggal Surat Perintah','',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php
                                                $model->tglsuratperintah = MyFormatter::formatDateTimeForUser($model->tglsuratperintah);
						 $this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglsuratperintah',
							'mode' => 'date',
							'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate' => 'd',
							),
							'htmlOptions' => array('class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
							)); ?>	
					</div>
			    </div>
                             <div class="control-group ">
					<?php echo CHtml::label('Tanggal Penyerahan','',array('class'=>'control-label')); ?>
					<div class="controls">
						<?php
                                                $model->tglpenyerahan = MyFormatter::formatDateTimeForUser($model->tglpenyerahan);
						 $this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglpenyerahan',
							'mode' => 'date',
							'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate' => 'd',
							),
							'htmlOptions' => array('class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
							)); ?>	
					</div>
			    </div>
                            <div class="control-group">
                                        <?php echo CHtml::label('Alasan','',array('class'=>'control-label')); ?>
                                <div class="controls">
                                    	<?php echo $form->textArea($model,'alasan_pengeluaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                                </div>
                            </div>
                        </div>
		</div>
	</div>
</div>

<div class="panel panel-primary panel-success">
	<div class="panel-heading">
            <div class="panel-title"> <i class="glyphicon glyphicon-file"></i>Data Aset</div>
	</div>
	<div class="panel-body">
		<?php //  $this->renderPartial($this->path_view.'_formDetailAset', array('model'=>$model, 'form'=>$form)); ?>		
<!--		<div class="panel panel-primary panel-success">
			<div class="panel-body table-responsive">
				<?php // $this->renderPartial($this->path_view.'_tableDetailAset', array('model'=>$model, 'form'=>$form, 'modDetail'=>$modDetail)); ?>
			</div>
		</div>-->
                <?php echo $this->renderPartial($this->path_view.'_formPeralatan', array(
                                               'model'=>$model, 'form'=>$form, 'modDetail'=>$modDetail)); ?>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		$this->createUrl($this->module->id.'/Index'), 
		array('class'=>'btn btn-default',
			'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));  ?>
	<?php
		if(isset($_GET['sukses'])){
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
		}else{
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
		}
	?>
</div>
<?php $this->endWidget(); ?>
<?php  $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modDetail'=>$modDetail)); ?>
<?php 
//========= Dialog buat cari data Pegawai Pengeluar =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiPengeluaran',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));
Yii::import('gudangFarmasi.models.GFPegawairuanganV');
$modPegawaiMengetahui = new GFPegawairuanganV('search');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['GFPegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaipengeluaran-grid',
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
					$(\"#'.CHtml::activeId($model,'pegpengeluaran_id').'\").val(\"$data->pegawai_id\");
					$(\"#pegpengeluaran_nama\").val(\"$data->NamaLengkap\").blur();
					$(\"#dialogPegawaiPengeluaran\").dialog(\"close\"); 
					
					
					return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                    'filter' => Chtml::activeTextField($modPegawaiMengetahui,'nomorindukpegawai',array('class'=>'numbers-only'))
                ),
               
                array(
                    'header'=>'Nama Pegawai',
                    'name' => 'nama_pegawai',
                    'value'=>'$data->namaLengkap',
                    'filter' => Chtml::activeTextField($modPegawaiMengetahui,'nama_pegawai',array('class'=>'hurufs-only'))
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
                    'filter' => Chtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
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
<?php
//========= Dialog buat cari data Pegawai Penyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiPenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));
Yii::import('gudangFarmasi.models.GFPegawairuanganV');
$modPegawaiMenyetujui = new GFPegawairuanganV('search');
$modPegawaiMenyetujui->unsetAttributes();
$modPegawaiMenyetujui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['GFPegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['GFPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->searchPegawaiMengetahui(),
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
					$(\"#'.CHtml::activeId($model,'pegmengetahui_id').'\").val(\"$data->pegawai_id\");
					$(\"#pegmengetahui_nama\").val(\"$data->NamaLengkap\").blur();
					$(\"#dialogPegawaiPenyetujui\").dialog(\"close\"); 
					
					
					return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                    'filter' => Chtml::activeTextField($modPegawaiMenyetujui,'nomorindukpegawai',array('class'=>'numbers-only'))
                ),
               
                array(
                    'header'=>'Nama Pegawai',
                    'name' => 'nama_pegawai',
                    'value'=>'$data->namaLengkap',
                    'filter' => Chtml::activeTextField($modPegawaiMenyetujui,'nama_pegawai',array('class'=>'hurufs-only'))
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
                    'filter' => Chtml::activeDropDownList($modPegawaiMenyetujui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
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
<script>
   $(document).ready(function () {
        <?php if(isset($_GET['sukses'])){ ?>
        $("input, select, textarea").attr("disabled",true);
        <?php } ?>
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
     }); 
</script>