
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

function print(pendaftaran_id, pasienmasukpenunjang_id)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
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
