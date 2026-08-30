<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'POST',
            'type' => 'horizontal',
            'id' => 'formSetor',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit'=>'return true'
            ),
        )
    );

$this->renderPartial($this->path_view.'_formSetorBank',array('form'=>$form, 'modSetor'=>$modSetor)); 

$this->endWidget();
?>
<script>
    $("#formSetor").find('input').each(function(){
        $(this).attr('disabled',true)
    });
</script>