
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
        #rujukankeluar tr td label.checkbox{
            width: 100px;
            display:inline-block;
        }
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
                    <?php echo CHtml::label("Tanggal Pemeriksaan",'', array('class' => 'control-label')) ?>
                    <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                    </div>       
                </div>
        </div>
    <div class="row-fluid">
        <div class="col-sm-6">
		<div id='searching'>
			<?php
//                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//                    'id' => 'penunjang',
//                    'slide' => true,
//                    'content' => array(
//                        'content2' => array(
//                            'multi' => 'multi',
//                            'header' => 'Berdasarkan Tujuan Rujukan',
//                            'isi' => CHtml::hiddenField('filter', 'rujukankeluar_id', array('disabled' => 'disabled')) . 
//                                '<div class="control-group">
//                                    '.CHtml::label('Ruangan Penunjang','rujukankeluar_id', array('class' => 'control-label')).' 
//                                    <div class="controls">
//                                        '.$form->dropDownList($model, 'rujukankeluar_id', $model->getRujukanItems(),array(
//                                        'class'=>'form-control', 'multiple'=>'multiple')).' 										
//                                    </div>
//                                </div>',
//                            'active' => true,
//                        ),
//                    ),
//                ));
            ?>															
		</div>		                
	</div>
		<div class="span12">
			<div class="panel-heading">
                            <div class="panel-title">Berdasarkan Tujuan Rujukan &nbsp; <?php echo CHtml::checkBox('cek_all', true, array('value'=>'cek', 'onchange'=>'cek_all_tindakan(this)'));?></div>
                            </div>
                            <div class="panel-body">
				<?php echo '<table width="100%" id="rujukankeluar">
						<tr>
							<td>'.

								$form->checkBoxList($model, 'rujukankeluar_id', CHtml::listData(RujukankeluarM::model()->findAll(), 'rujukankeluar_id', 'rumahsakitrujukan'),
										array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",'checked'=>'checked','template'=>'<div style="width:298px; float:left; padding:2.5px;">{input} {label}</div>')).'

							</td>
						</tr>
					 </table>'; ?>
		</div>
	</div>
        </div>
        
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan',
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
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<script type="text/javascript">
    function cek_all_tindakan(obj){
        if($(obj).is(':checked')){
            $("#rujukankeluar").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#rujukankeluar").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    $(document).ready(function(){
        $('.checkbox').addClass();
    });
</script>

