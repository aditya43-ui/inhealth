<?php 
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sabarang-m-search',
        'type'=>'horizontal',
)); 
?>

	<div class="col-sm-12">
		<div class="control-group">
                    <?php echo CHtml::label("Tanggal",'',array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php  
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tglnotifikasi',
                                'mode'=>'date',
                                'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        //'minDate'=>$minDate,
                                        'maxDate' => 'd'
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                            )); 
                        ?>                        	
                        
                    </div>
                   
                    <div class="control" style="padding-left:20px;">
                        <?php  echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'buttonSubmit')); ?>
                    </div>
                </div>
		
	</div>	
        



<?php $this->endWidget(); ?>

<script>
    function submit(){
        $("#buttonSubmit").trigger('click');
    }
</script>
