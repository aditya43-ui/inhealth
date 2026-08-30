<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model,'profilrs_id',CHtml::listData(ProfilrumahsakitM::model()->findAll(),'profilrs_id','nama_rumahsakit'), array('multiple' => 'multiple')) ?>
        <div class="control-group">
		<?php echo CHtml::label("Tgl.Settlement",'tglsettlement', array('class' => 'control-label')) ?>
					<div class="controls">
						<div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
							<i class="entypo-calendar"></i>
							<span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
							<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
							<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
						</div>
					</div>
		</div>
        <div class="control-group">
		
			<?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . "Tgl.Pengajuan AP", 'tglpengajuan', array('class' => 'control-label')) ?>
		        <div class="controls">
						<div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal2)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir2)) ?>">
							<i class="entypo-calendar"></i>
							<span ><?php echo date('d M Y', strtotime($model->tgl_awal2)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir2)) ?></span>
							<?php echo $form->hiddenField($model,'tgl_awal2', array('class' => 'start')) ?>
							<?php echo $form->hiddenField($model,'tgl_akhir2', array('class' => 'end')) ?>
						</div>
					</div>
		</div>
        <?php 	echo $form->textFieldRow($model,'nosettlement') ?>
        <div class="control-group">
			<?php echo Chtml::label("No. Pengajuan AP", 'nopengajuan', array('class' => 'control-label')); ?>
			<div class="controls">
                 <?php echo $form->textField($model,'nopengajuan') ?>
			</div>
		</div>
    </div>
    <div class="col-sm-6">
	<div class="control-group ">
			<?php echo Chtml::label("Pegawai Yang Mengajukan AP", 'pegawai_id', array('class' => 'control-label')); ?>
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
        <?php echo $form->textFieldRow($model,'nip',array('readonly' => true)) ?>

		<div class="control-group ">
			<?php echo Chtml::label("Pegawai Settlement", 'pegawaisettlement_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'pegawaisettlement_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'pegawaisettlement_nama',
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
							$("#'.Chtml::activeId($model, 'pegawaisettlement_id') . '").val(ui.item.pegawai_id); 
						
                                                        return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder' => 'Ketik Nama Pegawai',
						'class'=>'span3 pegawai_nama  hurufs-only',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($model, 'pegawai_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiSettlement'),
				));
				?>
			</div>
		</div>

        <?php //echo $form->textFieldRow($model,'noanggaran') ?>
        <div class="control-group">
			<?php echo Chtml::label("Status Settlement", 'statussettlement', array('class' => 'control-label')); ?>
			<div class="controls">
                <?php echo $form->dropDownList($model,'statussettlement',array('LUNAS' => 'Lunas','BELUM LUNAS' => 'Belum Lunas'),array('empty' => 'Pilih')) ?>
			</div>
		</div>
        <div class="control-group">
			<?php echo Chtml::label("Status Pembatalan", 'statusbatal', array('class' => 'control-label')); ?>
			<div class="controls">
                <?php echo $form->dropDownList($model,'statusbatal',array('BELUM DIBATALKAN' => 'Belum Dibatalkan','SUDAH DIBATALKAN' => 'Sudah Dibatalkan'),array('empty' => 'Pilih')) ?>
			</div>
		</div>
    </div>
</div>


<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Pegawai Yang Mengajukan AP',
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


<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiSettlement',
    'options'=>array(
        'title'=>'Pegawai Settlement',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiS = new PegawaiM('search');

$modPegawaiS->unsetAttributes();
//$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawaiM'])) {
    $modPegawaiS->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawais-m-grid',
	'dataProvider'=>$modPegawaiS->search(),
	'filter'=>$modPegawaiS,
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
                                                  $(\"#'.CHtml::activeId($model,'pegawaisettlement_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaisettlement_nama').'\").val(\"$data->NamaLengkap\");
                                    
                                                  $(\"#dialogPegawaiSettlement\").dialog(\"close\"); 
                                                //   ambilDataGaji();
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                    'filter' => Chtml::activeTextField($modPegawaiS,'nomorindukpegawai',array('class'=>'numbers-only'))
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
                    'filter' => Chtml::activeTextField($modPegawaiS,'nama_pegawai',array('class'=>'hurufs-only'))
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
                    'filter' => Chtml::activeDropDownList($modPegawaiS, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
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
	var profil  = jQuery('#<?php echo CHtml::activeId($model, 'profilrs_id') ?>');	

    $(document).ready(function() {
        jQuery(profil).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '250px',
            enableCaseInsensitiveFiltering: true
        }).hide();
        
    });
</script>