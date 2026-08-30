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

function setStatik(){
  var index = 0;
  var indexLainnya = 0;
  $('.statik').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('#<?php echo CHtml::activeId($model, 'inspeksi_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 4 && indexLainnya == 0){
    $('#<?php echo CHtml::activeId($model, 'inspeksi_lainnya'); ?>').val('');
    $('#<?php echo CHtml::activeId($model, 'inspeksi_lainnya'); ?>').attr('readonly',true);
  }
}

function setDinamis(){
  var index = 0;
  var indexLainnya = 0;
  $('.dinamis').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('#<?php echo CHtml::activeId($model, 'dinamis_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 4 && indexLainnya == 0){
    $('#<?php echo CHtml::activeId($model, 'dinamis_lainnya'); ?>').val('');
    $('#<?php echo CHtml::activeId($model, 'dinamis_lainnya'); ?>').attr('readonly',true);
  }
}

function setPalpasi(){
  var index = 0;
  var indexLainnya = 0;
  $('.palpasi').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('#<?php echo CHtml::activeId($model, 'palpasi_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 5 && indexLainnya == 0){
    $('#<?php echo CHtml::activeId($model, 'palpasi_lainnya'); ?>').val('');
    $('#<?php echo CHtml::activeId($model, 'palpasi_lainnya'); ?>').attr('readonly',true);
  }
}

function tambahPemeriksaan(){
  var pemeriksaangerak_id = $('#pemeriksaanFungsiGerak').val();
  if(pemeriksaangerak_id != ''){
    $.ajax({
      type: "POST",
      url: "<?php echo $this->createUrl('tambahPeriksaFungsiGerakDasar')?>",
      data: {pemeriksaangerak_id:pemeriksaangerak_id},
      dataType: "json",
      success: function(data){
        if(data != null){
          $('.rowPemeriksaanFungsiGerakDasar').append(data.form);
          getRenamePeriksaGerakDasar($('.rowPemeriksaanFungsiGerakDasar'));
          $('#pemeriksaanFungsiGerak').val('');
        }else{
          myAlert(data.pesan);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
  }else{
    myAlert('Silakan Pilih Pemeriksaan !!');
  }
}

function getRenamePeriksaGerakDasar(obj){
  for(var i=0; i<$(obj).find('.rowPeriksaFungsiGerak').length; i++){
    var tr = $(obj).find('.rowPeriksaFungsiGerak').eq(i);
      tr.attr('id','rowPeriksaFungsiGerak_'+i);
  }

  for(var i=0; i<$(obj).find('.periksafungsigerakdasar_id').length; i++){
    var tr = $(obj).find('.periksafungsigerakdasar_id').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_periksafungsigerakdasar_id');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][periksafungsigerakdasar_id]');
  }

  for(var i=0; i<$(obj).find('.aktif_gerakan').length; i++){
    var tr = $(obj).find('.aktif_gerakan').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_aktif_gerakan');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][aktif_gerakan]');
  }

  for(var i=0; i<$(obj).find('.aktif_rom').length; i++){
    var tr = $(obj).find('.aktif_rom').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_aktif_rom');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][aktif_rom]');
  }

  for(var i=0; i<$(obj).find('.pasif_gerakan').length; i++){
    var tr = $(obj).find('.pasif_gerakan').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_pasif_gerakan');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][pasif_gerakan]');
  }

  for(var i=0; i<$(obj).find('.pasif_rom').length; i++){
    var tr = $(obj).find('.pasif_rom').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_pasif_rom');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][pasif_rom]');
  }

  for(var i=0; i<$(obj).find('.isometrik_gerakan').length; i++){
    var tr = $(obj).find('.isometrik_gerakan').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_isometrik_gerakan');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][isometrik_gerakan]');
  }

  for(var i=0; i<$(obj).find('.isometrik_rom').length; i++){
    var tr = $(obj).find('.isometrik_rom').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_isometrik_rom');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][isometrik_rom]');
  }

  for(var i=0; i<$(obj).find('.tblSinistra').length; i++){
    var tr = $(obj).find('.tblSinistra').eq(i);
      tr.attr('table_index',i);
  }

  for(var i=0; i<$(obj).find('.btnSinistra').length; i++){
    var tr = $(obj).find('.btnSinistra').eq(i);
      tr.attr('btn_index',i);
  }

  for(var i=0; i<$(obj).find('.batalSinistrasi').length; i++){
    var tr = $(obj).find('.batalSinistrasi').eq(i);
      tr.attr('btnremove_index',i);
  }
  
  for(var i=0; i<$(obj).find('.tblDextra').length; i++){
    var tr = $(obj).find('.tblDextra').eq(i);
      tr.attr('table_index',i);
  }

  for(var i=0; i<$(obj).find('.btnDextra').length; i++){
    var tr = $(obj).find('.btnDextra').eq(i);
      tr.attr('btn_index',i);
  }

  for(var i=0; i<$(obj).find('.batalDextra').length; i++){
    var tr = $(obj).find('.batalDextra').eq(i);
      tr.attr('btnremove_index',i);
  }

}

function print(pendaftaran_id, pasienmasukpenunjang_id)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}

$(document).ready(function(){
  setDinamis();
  setStatik();
  setPalpasi();
  getTekananDarah();

  getRenamePeriksaGerakDasar($('.rowPemeriksaanFungsiGerakDasar'));
});

</script>
