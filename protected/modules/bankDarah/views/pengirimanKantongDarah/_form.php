<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pengeluaranaset-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)'
        ),
        'focus' => '#nomorbarcode',
)); ?>
<div class="panel panel-primary panel-success">
	<div class="panel-heading">
            <div class="panel-title">Data Pengiriman Kantong Darah</div>
	</div>
	<div class="panel-body">
		<?php  $this->renderPartial($this->path_view.'_formDetail', array('modKirimKantong'=>$modKirimKantong,'modKirimKantongDetail'=>$modKirimKantongDetail,'modMonitoringKantong'=>$modMonitoringKantong,'form'=>$form)); ?>		
		<div class="panel panel-primary panel-success">
			<div class="panel-body table-responsive">
				<?php $this->renderPartial($this->path_view.'_tableDetail', array('form'=>$form, 'modKirimKantong'=>$modKirimKantong,'modKirimKantongDetail'=>$modKirimKantongDetail,'modMonitoringKantong'=>$modMonitoringKantong)); ?>
			</div>
		</div>
	</div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Waktu Pengiriman','',array('class'=>'control-label')); ?>
                    <div class="controls">
                    <?php $modKirimKantong->tglkirimkantongdarah = MyFormatter::formatDateTimeForUser($modKirimKantong->tglkirimkantongdarah); ?>
                    <?php
                        $this->widget('MyDateTimePicker', array(
                        'model' => $modKirimKantong,
                        'attribute' => 'tglkirimkantongdarah',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                           
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                        ));
                    ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Suhu','',array('class'=>'control-label')); ?>
                    <div class="controls">
                         <?php echo $form->textField($modKirimKantong,'suhu',array('class'=>'span3 integerFloat','readonly'=>false)); ?> <label><sup>o</sup>C</label>

                    </div>
                </div>
                
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Nama Petugas','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modKirimKantong,'petugaskirim_id',array('class'=>'span3 numbers-only','readonly'=>true)); ?>
                        <?php
                           $petugaskirim='';
                           if(isset($modKirimKantong->petugaskirim_id)) {
                            $modPegawai = PegawaiM::model()->findByPk($modKirimKantong->petugaskirim_id);
                            $petugaskirim = $modPegawai->nama_pegawai;
                        } ?>
                        <?php echo CHtml::textField('petugaskirim_nama',$petugaskirim,array('class'=>'span3','readonly'=>true)); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Petugas Pengirim','',array('class'=>'control-label')); ?>
                     <div class="controls">
                        <?php 		
			echo $form->hiddenField($modKirimKantong,'petugastransporter_id', array('readonly' => true));
		
			$this->widget('MyJuiAutoComplete', array(
                                'model' => $modKirimKantong,
                                'attribute' => 'petugastransporter_nama',
				'source'=>'js: function(request, response) {
					$.ajax({
					url: "'.$this->createUrl('/ActionAutoComplete/dropPetugasRuangan').'",
					dataType: "json",
					data: {
						term: request.term,
                                                ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
					},
					success: function (data) {
						response(data);
					}
				})
			}',
			'options'=>array(
				'showAnim'=>'fold',
				'minLength' => 3,
				'focus'=> 'js:function( event, ui ) {
					 $(this).val( ui.item.label);
					 return false;
				 }',
				'select'=>'js:function( event, ui ) {
					 $("#'.CHtml::ActiveId($modKirimKantong, 'petugastransporter_id').'").val(ui.item.value); 
					 return false;
				 }',
			),		
			'htmlOptions' => array('class'=>'span3','rel'=>'tooltip','title'=>'Ketik nama untuk petugas transporter',),
                        'tombolDialog' => array('idDialog' => 'dialogTransporter', 'idTombol' => 'tombolKoordinator'),
			)); 
		?>
                    </div>
                </div> 
            </div>
        </div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton($modKirimKantong->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>(isset($_GET['sukses']))? true : false));
?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		$this->createUrl($this->module->id.'/Index'), 
		array('class'=>'btn btn-danger',
			'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));  ?>
	<?php
		if(isset($_GET['sukses']) || isset($_GET['kirimkantongdarah_id'])){
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print(".$_GET['kirimkantongdarah_id'].")",'disabled'=>false)).'&nbsp;';
                        echo CHtml::link(Yii::t('mds', '{icon} Print PDF', array('{icon}'=>'<i class="entypo-book"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"printPDF(".$_GET['kirimkantongdarah_id'].")",'disabled'=>false));
		}else{
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
		}
	?>
</div>
<?php $this->endWidget(); ?>
<?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print',array('kirimkantongdarah_id'=>''));
    
?>
<?php  $this->renderPartial($this->path_view.'_jsFunctions',array('modKirimKantong'=>$modKirimKantong,'modKirimKantongDetail'=>$modKirimKantongDetail,'modMonitoringKantong'=>$modMonitoringKantong)); ?>
<script type="text/javascript">
    function print(kirimkantongdarah_id){
        window.open('<?php echo $urlPrint?>'+kirimkantongdarah_id+'&caraPrint=PRINT','printwin','left=400,top=400,width=800,height=600');
    }
    
    function printPDF(kirimkantongdarah_id){
        window.open('<?php echo $urlPrint?>'+kirimkantongdarah_id+'&caraPrint=PDF','printwin','left=400,top=400,width=800,height=600');
    }
    
    $("#pengeluaranaset-t-form").find('[class*="integerFloat"]').maskMoney(
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":2}
                );
    
    $(document).ready(function () {
       
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');                
     });
</script>

<?php 
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTransporter',
    'options'=>array(
        'title'=>'Pencarian Petugas Pengirim',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,        
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai -> unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipelaksana-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($modKirimKantong, 'petugastransporter_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($modKirimKantong, 'petugastransporter_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogTransporter\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>