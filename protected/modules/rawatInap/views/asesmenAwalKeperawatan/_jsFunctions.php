<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function choiseAskep(obj){
    if($(obj).val() == 1 && $(obj).prop('checked')==true){
        inputAllEnabled($('#choise_neonatus').find('.panel-body'));
        $('#choise_neonatus').find('.panel-body').find('.formNeonatus').show();

        inputAllDisabled($('#choise_anak').find('.panel-body'));
       $('#choise_anak').find('.panel-body').find('.formAnak').hide();

       inputAllDisabled($('#choise_dewasa').find('.panel-body'));
      $('#choise_dewasa').find('.panel-body').find('.formDewasa').hide();

      inputAllDisabled($('#choise_obgyn').find('.panel-body'));
     $('#choise_obgyn').find('.panel-body').find('.formObgyn').hide();

     inputAllDisabled($('#choise_geriatri').find('.panel-body'));
    $('#choise_geriatri').find('.panel-body').find('.formGeriatri').hide();
    }else if($(obj).val() == 2 && $(obj).prop('checked')==true){
        inputAllEnabled($('#choise_anak').find('.panel-body'));
        $('#choise_anak').find('.panel-body').find('.formAnak').show();

        inputAllDisabled($('#choise_neonatus').find('.panel-body'));
        $('#choise_neonatus').find('.panel-body').find('.formNeonatus').hide();

        inputAllDisabled($('#choise_dewasa').find('.panel-body'));
       $('#choise_dewasa').find('.panel-body').find('.formDewasa').hide();

       inputAllDisabled($('#choise_obgyn').find('.panel-body'));
      $('#choise_obgyn').find('.panel-body').find('.formObgyn').hide();

      inputAllDisabled($('#choise_geriatri').find('.panel-body'));
     $('#choise_geriatri').find('.panel-body').find('.formGeriatri').hide();
    }else if($(obj).val() == 3 && $(obj).prop('checked')==true){
      inputAllEnabled($('#choise_dewasa').find('.panel-body'));
      $('#choise_dewasa').find('.panel-body').find('.formDewasa').show();

      inputAllDisabled($('#choise_neonatus').find('.panel-body'));
      $('#choise_neonatus').find('.panel-body').find('.formNeonatus').hide();

       inputAllDisabled($('#choise_anak').find('.panel-body'));
      $('#choise_anak').find('.panel-body').find('.formAnak').hide();

      inputAllDisabled($('#choise_obgyn').find('.panel-body'));
     $('#choise_obgyn').find('.panel-body').find('.formObgyn').hide();

     inputAllDisabled($('#choise_geriatri').find('.panel-body'));
    $('#choise_geriatri').find('.panel-body').find('.formGeriatri').hide();
    }else if($(obj).val() == 4 && $(obj).prop('checked')==true){
      inputAllEnabled($('#choise_obgyn').find('.panel-body'));
      $('#choise_obgyn').find('.panel-body').find('.formObgyn').show();

      inputAllDisabled($('#choise_neonatus').find('.panel-body'));
      $('#choise_neonatus').find('.panel-body').find('.formNeonatus').hide();

       inputAllDisabled($('#choise_anak').find('.panel-body'));
      $('#choise_anak').find('.panel-body').find('.formAnak').hide();

      inputAllDisabled($('#choise_dewasa').find('.panel-body'));
      $('#choise_dewasa').find('.panel-body').find('.formDewasa').hide();

      inputAllDisabled($('#choise_geriatri').find('.panel-body'));
     $('#choise_geriatri').find('.panel-body').find('.formGeriatri').hide();
    }else if($(obj).val() == 5 && $(obj).prop('checked')==true){
      inputAllEnabled($('#choise_geriatri').find('.panel-body'));
      $('#choise_geriatri').find('.panel-body').find('.formGeriatri').show();

      inputAllDisabled($('#choise_neonatus').find('.panel-body'));
      $('#choise_neonatus').find('.panel-body').find('.formNeonatus').hide();

       inputAllDisabled($('#choise_anak').find('.panel-body'));
      $('#choise_anak').find('.panel-body').find('.formAnak').hide();

      inputAllDisabled($('#choise_dewasa').find('.panel-body'));
      $('#choise_dewasa').find('.panel-body').find('.formDewasa').hide();

      inputAllDisabled($('#choise_obgyn').find('.panel-body'));
     $('#choise_obgyn').find('.panel-body').find('.formObgyn').hide();
    }

}

function uncheckchoiseAskep(){
  inputAllDisabled($('#choise_neonatus').find('.panel-body'));
  $('#choise_neonatus').find('.panel-body').find('.formNeonatus').hide();

   inputAllDisabled($('#choise_anak').find('.panel-body'));
  $('#choise_anak').find('.panel-body').find('.formAnak').hide();

  inputAllDisabled($('#choise_dewasa').find('.panel-body'));
  $('#choise_dewasa').find('.panel-body').find('.formDewasa').hide();

  inputAllDisabled($('#choise_obgyn').find('.panel-body'));
  $('#choise_obgyn').find('.panel-body').find('.formObgyn').hide();

  inputAllDisabled($('#choise_geriatri').find('.panel-body'));
 $('#choise_geriatri').find('.panel-body').find('.formGeriatri').hide();
}

function inputAllDisabled(obj){
    $(obj).find('input,select,textarea').not('.disabledinputan').each(function(){ //element <input>
        $(this).attr('disabled',true);
    });
}

function inputAllEnabled(obj){
    $(obj).find('input,select,textarea').not('.disabledinputan').each(function(){ //element <input>
        $(this).attr('disabled',false);
    });
}


$(document).ready(function(){
  var indexaswkep = 0;
  $('.pilih_aswkep').each(function(){
      choiseAskep($(this));

      if(($(this).val() == 1 || $(this).val() == 2 || $(this).val() == 3 || $(this).val() == 4 || $(this).val() == 5) && $(this).prop('checked')==false){
        indexaswkep++;
      }
  });

  if(indexaswkep==$('.pilih_aswkep').length){
      uncheckchoiseAskep();
  }
});

</script>
