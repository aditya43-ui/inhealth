<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
  $('.search-form').toggle();
  return false;
});
$('.search-form form').submit(function(){
  $.fn.yiiGridView.update('ppbuat-janji-poli-t-grid', {
    data: $(this).serialize()
  });
  return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<fieldset>
    <legend class="rim2">Buat Janji</legend>
    <?php $this->renderPartial('_form',array(
        'modPasien'=>$modPasien,
        'modPPBuatJanjiPoli'=>$modPPBuatJanjiPoli
    )); ?>
</fieldset> 
<?php
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppbuat-janji-poli-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

function daftarKeRJ(pasien_id,buatjanjipoli_id)
{
    $('#buatjanjipoli_id').val(buatjanjipoli_id);
    $('#pasien_id').val(pasien_id);
    $('#form_hidden').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
  'id'=>'form_hidden',
  'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'action'=>$urlPendaftaranRJ,
        'htmlOptions'=>array('target'=>'_new'),
)); ?>
    <?php echo CHtml::hiddenField('buatjanjipoli_id');?>
    <?php echo CHtml::hiddenField('pasien_id');?>
<?php $this->endWidget(); ?>
