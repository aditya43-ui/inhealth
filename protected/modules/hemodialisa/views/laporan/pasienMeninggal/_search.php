
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
		<div class="control-group">
                    <?php echo CHtml::hiddenField('type', ''); ?>

                    <?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
                    <?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
                    <?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
                    <?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
                    <?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
                    <?php echo CHtml::label("Tanggal Pasien Pulang",'', array('class' => 'control-label')) ?>
                    <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                    </div>       
                </div>
		<div class="col-sm-6">
                    <div id='searching'>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                'id' => 'wilayah',
    //                                    'disabled'=>true,
                                'content' => array(
                                    'content1' => array(
                                            'multi' => 'multi',
                                            'header' => 'Berdasarkan Wilayah',
                                            'isi' => CHtml::hiddenField('filter', 'wilayah').
                                                    '<div class="control-group">
                                                            '.CHtml::label('Propinsi','', array('class' => 'control-label')).' 
                                                            <div class="controls">
                                                                    '.$form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),array(
                                                                    'class'=>'form-control', 'multiple'=>'multiple')).'											
                                                            </div>
                                                    </div>
                                                    <div class="control-group">
                                                            '.CHtml::label('Kabupaten','', array('class' => 'control-label')).' 
                                                            <div class="controls">												 
                                                                    '.$form->dropDownList($model,'kabupaten_id',
                                                                            array(),
                                                                            array('class'=>'form-control', 'multiple'=>'multiple')).' 													
                                                            </div>
                                                    </div>
                                                    <div class="control-group">
                                                            '.CHtml::label('Kecamatan','', array('class' => 'control-label')).' 
                                                            <div class="controls">												 
                                                                    '.$form->dropDownList($model,'kecamatan_id',
                                                                            array(),
                                                                            array('class'=>'form-control', 'multiple'=>'multiple')).' 													
                                                            </div>
                                                    </div>
                                                    <div class="control-group">
                                                            '.CHtml::label('Kelurahan','', array('class' => 'control-label')).' 
                                                            <div class="controls">												 
                                                                    '.$form->dropDownList($model,'kelurahan_id',
                                                                            array(),
                                                                            array('class'=>'form-control', 'multiple'=>'multiple')).' 													
                                                            </div>
                                                    </div>',
                                            'active' => true,
                                    ),),
//                                    'htmlOptions'=>array('class'=>'aw',)
                                    ));
                            ?>			
                    </div> 
                </div> 

		<div class="span6">
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
					'id'=>'form-2',
					'content'=>array(
						'content2'=>array(
							'header'=>'Berdasarkan Golongan Umur',
							'isi'=>'<table><tr>
								<td>'.CHtml::hiddenField('filter', 'golonganumur', array('disabled'=>'disabled')).'<label>Golongan Umur</label></td>
								<td>'.$form->dropDownList($model, 'golonganumur_id', CHtml::listData($model->getGolonganUmur(), 'golonganumur_id', 'golonganumur_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",

								)).'</td>
									</tr></table>',           
							'active'=>false,
						),   
					),
			)); ?>
		</div>
	</div>
	
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan',
            'ajax' => array(
                 'type' => 'GET', 
                 'url' => array("/".$this->route), 
                 'update' => '#tableLaporan',
                 'beforeSend' => 'function(){
                                      $("#tableLaporan").addClass("animation-loading");
                                  }',
                 'complete' => 'function(){
                                      $("#tableLaporan").removeClass("animation-loading");
                                  }',
             ))); 
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
					array('class'=>'btn btn-danger',
						'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
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
<?php $this->renderPartial('hemodialisa.views.laporan._jsFunctions', array('model' => $model)); ?>
