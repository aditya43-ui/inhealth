<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function changeSkor(obj, index){
  if($(obj).prop('checked')==true){
    var label = $(obj).attr('labelradio');
    var vals = $(obj).val();
    var valLabel = $(obj).parent('.skriningskor').find('.skrinning_lainnya').val();
    if(valLabel !== undefined && valLabel !== ''){
      label = valLabel;
    }
    $('.nilai_skrining').eq(index).val(label);
    $('.nilai_skor').eq(index).val(vals);
    getTotalSkorSkrining();
  }
}

function getTextSkriningLainnya(obj, index){
  var label = "";
  $('.isSkrinning').each(function(){
    if($(this).prop('checked')==true){
      label = $(obj).val();
    }
  });
  $('.nilai_skrining').eq(index).val(label);
}


function getTotalSkorSkrining(){
  var nilai = 0;
  for(var i=0; i<$('#tblSkrining').find('.nilai_skor').length; i++){
    if($('#tblSkrining').find('.nilai_skor').eq(i).val() != ''){
        nilai += parseInt($('#tblSkrining').find('.nilai_skor').eq(i).val());
    }
  }

  $('#<?php echo CHtml::activeId($model,'jumlahskor') ?>').val(nilai);
}

function print(pendaftaran_id,skrinning_id,typeinstalasi,caraPrint)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&skriningpasien_id='+skrinning_id+'&typeinstalasi='+typeinstalasi+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}

</script>
