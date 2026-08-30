<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function changeKelompokResiko(obj){
  if($(obj).val() == 'LAINNYA'){
    $('#<?php echo CHtml::activeId($model,'kelompok_resikolainnya') ?>').addClass('required');
    $('#<?php echo CHtml::activeId($model,'kelompok_resikolainnya') ?>').attr('disabled',false);
  }else{
    $('#<?php echo CHtml::activeId($model,'kelompok_resikolainnya') ?>').removeClass('required');
    $('#<?php echo CHtml::activeId($model,'kelompok_resikolainnya') ?>').val('');
    $('#<?php echo CHtml::activeId($model,'kelompok_resikolainnya') ?>').attr('disabled',true);
  }
}

function print(pendaftaran_id,evaluasi_id,typeinstalasi,pasien_id,caraPrint)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&pasien_id=' + pasien_id + '&evaluasi_id='+evaluasi_id+'&typeinstalasi='+typeinstalasi+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}

</script>
