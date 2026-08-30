<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
	));
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
	<div class="row-fluid">
		<div class="span8">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Tanggal</legend>
				<?php echo CHtml::hiddenField('type', ''); ?>
				<?php //echo CHtml::hiddenField('src', ''); ?>
				<div class = 'control-label'>Tanggal Kunjungan</div>
				<div class="controls">  
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_awal',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions' => array('readonly' => true,
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
				<?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
				<div class="controls">  
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_akhir',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions' => array('readonly' => true,
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</fieldset>
	</div>  
		<div class="span8">
			<fieldset class="box2">
				<legend class="rim">Search</legend>
				<?php echo CHtml::hiddenField('type', ''); ?>
				<?php //echo CHtml::hiddenField('src', ''); ?>
					<div class="controls">
						<?php echo $form->dropDownListRow($model,'lamahd_jam', LookupM::getItems('lamadialiser'),  
										array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:100px')); ?>  
					</div>
					<div class="controls">
						<?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData($model->getRuanganItems(),'ruangan_id', 'ruangan_nama'),  
										array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:100px')); ?>  
					</div> 
				<div class="control-group ">
					<div class="controls"> 
						<?php echo $form->dropDownListRow($model,'aksesvaskular_nama', array('CIMINO'=>'CIMINO','FEMORAL'=>'FEMORAL','CDL SUBCLAVIA'=>'CDL SUBCLAVIA','CDL JUGULARIS'=>'CDL JUGULARIS'),array('empty'=>'--Pilih--','class'=>'span2')); ?>
					</div>
				</div> 
				  <div class="controls">
					  <?php echo $form->dropDownListRow($model,'obat_hemapo', array('0'=>'0','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),
										array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:100px')); ?>
				  </div>
				  <div class="controls">
					 	<?php echo $form->dropDownListRow($model,'obat_recormon', array('0'=>'0','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:100px')); ?>
				  </div>
				<div class="control-group"> 
				  <div class="controls">
					 	<?php echo $form->dropDownListRow($model,'obat_eprex', array('0'=>'0','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),array('empty'=>'--Pilih--','class'=>'span2')); ?>
				  </div>
				</div> 
                <div class="control-group"> 
				  <div class="controls">
					 	<?php echo $form->dropDownListRow($model,'obat_renogen', array('0'=>'0','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),array('empty'=>'--Pilih--','class'=>'span2')); ?>
				  </div>
				</div>
			</fieldset>
	</div>    
		
		<div class="span8">
			<fieldset class="box2">
			<legend class="rim">Penyulit</legend> 
			<div class="controls">
					Teknis : 
					<?php echo CHtml::activecheckBoxList($model, 'penyulit_teknis', LookupM::getItemsPenyulit('penyulit_teknis'), array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?> 
			</div>   
			<div class='controls'>
					Klinis :
					<?php echo CHtml::activecheckBoxList($model, 'periksahd_penyulit', LookupM::getItemsPenyulit('penyulit_klinis'), array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
				
			</div>
			</fieldset>
		</div>  
        
        <div class="span8">
			<fieldset class="box2">
			<legend class="rim">Sesuai Data Heparin Yang Yang Tidak Kosong</legend> 
			<div class="controls">
					Heparin Kontinyu : 
					<?php echo CHtml::activecheckBox($model, 'heparin_continyu_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?> 
			</div>   
            <div class="controls">
                    Tanpa Heparin : 
                    <?php echo CHtml::activecheckBox($model, 'tanpaheparin_nama_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?> 
            </div>    
            <div class="controls">
                    Heparin Lmwh : 
                    <?php echo CHtml::activecheckBox($model, 'heparin_lmwh_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?> 
            </div> 
            <div class="controls">
                    Heparin Intermiten : 
                    <?php echo CHtml::activecheckBox($model, 'heparin_intermiten_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?> 
            </div>
			</fieldset>
		</div> 
        
        <div class="span8">
			<fieldset class="box2">
			<legend class="rim">Sesuai Data Preparat Besi Yang Yang Tidak Kosong</legend>   
            <div class ="controls">
                    Preparat Besi :
                    <?php echo CHtml::activecheckBox($model, 'prep_besi_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
            </div>   
			</fieldset>
		</div> 
        
        <div class="span8">
			<fieldset class="box2">
			<legend class="rim">Sesuai Data Profiling Yang Yang Tidak Kosong</legend>   
            <div class ="controls">
                    Ultrafiltrasi Mode :
                    <?php echo CHtml::activecheckBox($model, 'ultrafiltrasi_mode_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
            </div> 
            <div class ="controls">
                    Natrium Mode :
                    <?php echo CHtml::activecheckBox($model, 'natrium_mode_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
            </div>  
            <div class="controls">
                   Lama Uso Uf : 
                   <?php echo CHtml::activecheckBox($model, 'lama_uso_uf_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
            </div> 
            <div class="controls">
                   Iso Uf Ml : 
                   <?php echo CHtml::activecheckBox($model, 'iso_uf_ml_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
            </div> 
            <div class="controls">
                   Bicarbonat Mode : 
                   <?php echo CHtml::activecheckBox($model, 'bicarbonat_mode_cek', array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
            </div>
			</fieldset>
		</div>  
        
        <div class="span8">
            <fieldset class="box2">
                <legend class="rim">QB</legend> 
                <div class="controls">
                 <?php echo $form->dropDownListRow($model,'kec_darah_qb', array('< 150'=>'< 150','150 - 199'=>'150 - 199','200 - 249'=>'200 - 249','> 250'=>'> 250'),array('empty'=>'--Pilih--','class'=>'span2')); ?>
                </div>
            </fieldset>
        </div> 
        
         <div class="span8">
            <fieldset class="box2">
                <legend class="rim">Dializer</legend> 
                <div class="controls">
                 <?php echo $form->dropDownListRow($model,'dialiserke', array('nol'=>'N','1-5'=>'R1-R5','6-10'=>'R6-R10'),array('empty'=>'--Pilih--','class'=>'span2')); ?>
                </div>
            </fieldset>
        </div>
         
        
<!--        <div class="span8"> 
            <fieldset class="box2">  
                <div class="controls">
					Heparin Kontinyu : 
					<?php //echo CHtml::activecheckBoxList($model, 'heparin_continyu', PeriksahdT::getItemsHeparin_Continyu(), array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?> 
			    </div>   
            </fieldset>
        </div> 
        
        
        <div class="span8">
            <fieldset class="box2">
                <div class="controls">
                    Preparat Besi : 
                    <?php //echo CHtml::activecheckBoxList($model, 'injeksi_preb_besi', PeriksahdT::getItemsPrep_besi(), array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>       
                </div>
            </fieldset>
        </div> 
        
        <div class="span8">
            <fieldset class="box2"> 
                <div class="controls">
                Ultrafiltrasi Mode : 
                   <?php //echo CHtml::activeCheckBoxlIST($model, 'ultrafiltrasi_mode', PeriksahdT::getItemsUltrafiltrasi_Mode(), array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
                </div>
            </fieldset>
        </div> 
        
        <div class="span8">
            <fieldset class="box2">
                <div class="controls">
                    Natrium Mode : 
                   <?php //echo CHtml::activeCheckBoxlIST($model, 'natrium_mode', PeriksahdT::getItemsNatrium_Mode(), array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
                </div>
            </fieldset>
        </div>-->
	</div>
	
    <div class="form-actions">
       <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        echo "&nbsp;";
        ?>
<?php
echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
?>
    </div> 
    </div>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
$this->renderPartial('_jsFunctions', array('model' => $model)); 
?>
<script type="text/javascript">	
/** bersihkan dropdown kecamatan */
function setClearDropdownKecamatan()
{
    $("#<?php echo CHtml::activeId($model,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
/** bersihkan dropdown kelurahan */
function setClearDropdownKelurahan()
{
    $("#<?php echo CHtml::activeId($model,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
</script>