<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    $format = new MyFormatter();
    ?>
    <style>

        label.checkbox, label.radio{
            width:150px;
            display:inline-block;
        }
        

    </style>
    <div class="row-fluid">
        <div class="col-sm-6">
			<?php echo CHtml::hiddenField('type', ''); ?>
			<div class="control-group">
				<?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
				<?php echo CHtml::label("Periode Laporan",'tgl_rekam', array('class' => 'control-label')) ?>
				<div class="controls">
					<div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
						<i class="entypo-calendar"></i>
						<span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
						<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
						<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
					</div>
				</div>
			</div>            
        </div>        
    </div> 
	<div class="row-fluid">
		<div class="col-sm-6">
			<?php
				$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
					'id' => 'instalasi',
					'slide' => true,
					'content' => array(
						'content2' => array(
							'multi' => 'multi',
							'header' => 'Berdasarkan Instalasi dan Ruangan',
							'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . 
								'<div class="control-group">
									'.CHtml::label('Instalasi','instalasiasal_id', array('class' => 'control-label')).' 
									<div class="controls">
										'.$form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'),array(
										'class'=>'form-control', 'multiple'=>'multiple')).'											
									</div>
								</div>
								<div class="control-group">
									'.CHtml::label('Ruangan','ruanganasal_id', array('class' => 'control-label')).' 
									<div class="controls">												 
										'.$form->dropDownList($model,'ruanganasal_id', array(),									
											array('class'=>'form-control', 'multiple'=>'multiple')).' 													
									</div>
								</div>',
							'active' => true,
						),
					),
				));
			?>
		</div>
		<div class="col-sm-6">
			<?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'rujukan',
                    'slide' => true,
                    'content' => array(
                        'content3' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Rujukan',
                            'isi' => CHtml::hiddenField('filter', 'jenisobat', array('disabled' => 'disabled')) . 
                                '<div class="control-group">
                                    '.CHtml::label('Rujukan','asalrujukan_id', array('class' => 'control-label')).' 
                                    <div class="controls">
                                        '.$form->dropDownList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_nama'),array(
                                        'class'=>'form-control', 'multiple'=>'multiple')).'											
                                    </div>
                                </div>',
                            'active' => true,
                        ),
                    ),
                ));
            ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="col-sm-6">
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
				'id'=>'grafik',
				'slide'=>false,
				'content'=>array(
					'content4'=>array(
						'header'=>'Data grafik',
						'isi'=>
							'<table>                                                                               
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'instalasi')).' <label>Instalasi Asal</label></td>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'ruangan')).' <label>Ruangan Asal</label></td>
								</tr>
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'rujukan')).' <label>Rujukan</label></td>                                                                                           
								</tr>     
							</table>',          
						'active'=>TRUE,
					),
				),
			)); ?>	
		</div>
	</div>
    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        ?>
    </div>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
', CClientScript::POS_READY);
?>


<script>
    function checkAll() {
        if($('#checkAllRuangan').is(':checked')){
           $('#searchLaporan input[name*="ruanganasal_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchLaporan input[name*="ruanganasal_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }

        if ($("#checkAllRujukan").is(":checked")) {
            $('#rujukan input[name*="asalrujukan_id"]').each(function () {
                $(this).attr('checked', true);
            })
//        myAlert('Checked');
        } else {
            $('#rujukan input[name*="asalrujukan_id"]').each(function () {
                $(this).removeAttr('checked');
            })
        }
    }
</script>

<?php
//Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
