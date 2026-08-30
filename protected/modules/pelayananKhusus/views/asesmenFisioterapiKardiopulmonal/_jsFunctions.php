<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function getTekananDarah(){
  var sys = parseInt($('#<?php echo CHtml::activeId($model, 'td_systolic'); ?>').val());
  var dys = parseInt($('#<?php echo CHtml::activeId($model, 'td_dyastolic'); ?>').val());

  if(isNaN(sys)){
    sys = 0;
  }
  if(isNaN(dys)){
    dys = 0;
  }
  $('#tekanandarah').val(sys+'/'+dys);
}


    $(document).ready(function(){
        $(".satu-check").on('click','input:checkbox',function(){
            var cek = $(this).prop("checked");
            $(this).parents(".control-group").find('input:checkbox').each(function(){
                $(this).prop("checked",false);
            });

            if (cek == true){
                $(this).prop("checked",true);
            }
        });

        $(".one-dropdown").on('click','input:checkbox',function(){
            var cek = $(this).prop("checked");
            $(this).parents(".one-dropdown").find('input:checkbox').each(function(){
                $(this).prop("checked",false);
            });

            if (cek == true){
                $(this).prop("checked",true);
            }
        });
        
        getTekananDarah();
    });
</script>
