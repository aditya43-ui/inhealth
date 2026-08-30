<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
  function hitungGcs(){
    var gcsEye = parseInt($('#<?php echo CHtml::activeId($model, 'gcs_eye'); ?>').val());
    var gcsVerbal = parseInt($('#<?php echo CHtml::activeId($model, 'gcs_verbal'); ?>').val());
    var gcsMotorik = parseInt($('#<?php echo CHtml::activeId($model, 'gcs_motorik'); ?>').val());

    if(isNaN(gcsEye)){
      gcsEye = 0;
    }

    if(isNaN(gcsVerbal)){
      gcsVerbal = 0;
    }

    if(isNaN(gcsMotorik)){
      gcsMotorik = 0;
    }

    var hitungAll = (gcsEye + gcsVerbal + gcsMotorik);
    $('#<?php echo CHtml::activeId($model, 'nilai_gcs'); ?>').val(hitungAll);
  }

  function getTekananDarah(){
    var td_systolic = parseInt($('#<?php echo CHtml::activeId($model, 'td_systolic'); ?>').val());
    var td_diastolic = parseInt($('#<?php echo CHtml::activeId($model, 'td_diastolic'); ?>').val());

    if(isNaN(td_systolic)){
      td_systolic = 0;
    }

    if(isNaN(td_diastolic)){
      td_diastolic = 0;
    }
    var hasil = (td_systolic+'/'+td_diastolic);
    $('#tekanandarah').val(hasil);
  }

  function changeBak(){
    var index = 0;

    $('.isbak').each(function(){
      if($(this).val()=='1' &&  $(this).prop('checked')==true){
        $('#<?php echo CHtml::activeId($model, 'jeniskateter'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'no_kateter'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'tglpemasangan_kateter'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'tglpemasangan_kateter'); ?>_date').show();
      }else{
        index++;
      }
    });

    if(index == 2){
      $('#<?php echo CHtml::activeId($model, 'jeniskateter'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'jeniskateter'); ?>').val('');
      $('#<?php echo CHtml::activeId($model, 'no_kateter'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'no_kateter'); ?>').val('');
      $('#<?php echo CHtml::activeId($model, 'tglpemasangan_kateter'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'tglpemasangan_kateter'); ?>').val('');
      $('#<?php echo CHtml::activeId($model, 'tglpemasangan_kateter'); ?>_date').hide();
    }
  }

  function changeLukaPerawatan(){
    var index = 0;

    $('.islukaperawatan').each(function(){
      if($(this).val()==1 &&  $(this).prop('checked')==true){
        $('#<?php echo CHtml::activeId($model, 'kondisiperawatan'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'lokasiperawatan'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'ukuranperawatan'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'isinfus'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'infuscvc'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'isvasscore'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'vasscore'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'tglpemasangan_perawatan'); ?>').attr('disabled',false);
        $('#<?php echo CHtml::activeId($model, 'tglpemasangan_perawatan'); ?>_date').show();
      }else{
        index++;
      }
    });

    if(index == 2){
      $('#<?php echo CHtml::activeId($model, 'kondisiperawatan'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'kondisiperawatan'); ?>').val('');
      $('#<?php echo CHtml::activeId($model, 'lokasiperawatan'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'lokasiperawatan'); ?>').val('');
      $('#<?php echo CHtml::activeId($model, 'ukuranperawatan'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'ukuranperawatan'); ?>').val('');
      $('#<?php echo CHtml::activeId($model, 'isinfus'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'isinfus'); ?>').attr('checked',false);
      $('#<?php echo CHtml::activeId($model, 'infuscvc'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'infuscvc'); ?>').val('');
      $('#<?php echo CHtml::activeId($model, 'isvasscore'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'isvasscore'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'vasscore'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'vasscore'); ?>').val('');
      $('#<?php echo CHtml::activeId($model, 'tglpemasangan_perawatan'); ?>').attr('disabled',true);
      $('#<?php echo CHtml::activeId($model, 'tglpemasangan_perawatan'); ?>').val('');
      $('#<?php echo CHtml::activeId($model, 'tglpemasangan_perawatan'); ?>_date').hide();
    }
  }

  function tambahDiagnosaKep(){
    var diagnosa = $('#diagnosakkep').val();
    var statusdiagnosa = $('#statusdiagnosa').val();

    if(diagnosa != '' && statusdiagnosa != ''){
      var html = '<tr>'+
            '<td>'+
              '<input type="hidden" class="nama_diagnosa" value="'+diagnosa+'" />'+
              '<input type="hidden" class="statusdiagnosa" value="'+statusdiagnosa+'" />'+
              '<span class="nourut"></span>'+
            '</td>'+
            '<td>'+
             diagnosa +
            '</td>'+
            '<td>'+
            statusdiagnosa +
            '</td>'+
            '<td>'+
                '<a class="cl_diagnosakep" onclick="deleteDiagnosaKep(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Diagnosa Keperawatan"><i class="icon-remove"></i></a>'+
            '</td>'+
      '</tr>';

      $('#tbldiagnosakep').find('tbody').append(html);
      generateRowDiagnosaKep($('#tbldiagnosakep').find('tbody'));
      $('#diagnosakkep').val('');
      $('#statusdiagnosa').val('');
    }
  }

  function generateRowDiagnosaKep(obj){
    var noUrut = 1;

    for(var i=0; i<$(obj).find('.nourut').length; i++){
      var tr = $(obj).find('.nourut').eq(i);
      tr.html(noUrut);
      noUrut++;
    }
    for(var i=0; i<$(obj).find('.nama_diagnosa').length; i++){
      var tr = $(obj).find('.nama_diagnosa').eq(i);
      tr.attr('id','DiagnosakeperawatanT_'+i+'_nama_diagnosa');
      tr.attr('name','DiagnosakeperawatanT['+i+'][nama_diagnosa]');
    }
    for(var i=0; i<$(obj).find('.statusdiagnosa').length; i++){
      var tr = $(obj).find('.statusdiagnosa').eq(i);
      tr.attr('id','DiagnosakeperawatanT_'+i+'_statusdiagnosa');
      tr.attr('name','DiagnosakeperawatanT['+i+'][statusdiagnosa]');
    }
  }

  function deleteDiagnosaKep(obj){
    $(obj).parents('tr').remove();
    generateRowDiagnosaKep($('#tbldiagnosakep').find('tbody'));
  }

  function changeKelengkapan(obj){
    var index = $(obj).attr('index_urut');

    if($(obj).prop('checked')==true){
      $('.keterangan').eq(index).find('.radio_ket').each(function(){
        $(this).attr('disabled',false);
      });
      $('.datakelengkapan_nama').eq(index).attr('disabled',false);
      $('.keterangan').eq(index).attr('disabled',false);
    }else{
      $('.keterangan').eq(index).find('.radio_ket').each(function(){
        $(this).attr('checked',false);
        $(this).attr('disabled',true);
      });
      $('.datakelengkapan_nama').eq(index).attr('disabled',true);
      $('.keterangan').eq(index).attr('disabled',true);
      $('.keterangan').eq(index).val('');
    }
  }

  function changeDisetujui(obj){
    $('.disetujui').removeClass('required');
    if($(obj).val() != ''){
      if($(obj).val() == 'Pasien'){
        $('.disetujui').html($(obj).val());
        $('#<?php echo CHtml::activeId($model, 'disetujui_oleh'); ?>').val($('#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>').val());
      }else if($(obj).val() == 'Penanggung Jawab'){
        $('.disetujui').html($(obj).val()+' <span class="required">*</span>');
        $('.disetujui').addClass('required');
      }
    }else{
      $('.disetujui').html('Perawat / Penanggung Jawab');
    }
  }

  function changeDiserahkan(obj){
    $('.diserahkan').addClass('required');

    if($(obj).val() != ''){
      $('.diserahkan').html($(obj).val()+' <span class="required">*</span>');
    }else{
      $('.diserahkan').html('Perawat / Incharge <span class="required">*</span>');
    }
  }

  function changeDiterima(obj){
    $('.penerimaan').addClass('required');

    if($(obj).val() != ''){
      $('.penerimaan').html($(obj).val()+' <span class="required">*</span>');
    }else{
      $('.penerimaan').html('Perawat / Incharge <span class="required">*</span>');
    }
  }

  function print(id)
  {
      window.open('<?php echo $this->createUrl('print'); ?>&id='+id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
  }

$(document).ready(function(){
  hitungGcs();
  changeBak();
  changeLukaPerawatan();
  getTekananDarah();

  $('.iskelengkapan').each(function(){
      changeKelengkapan(this);
  });

  changeDisetujui($('#<?php echo CHtml::activeId($model, 'tipedisetujui'); ?>'));
  changeDiserahkan($('#<?php echo CHtml::activeId($model, 'tipediserahkan'); ?>'));

  <?php if(isset($_GET['pasienditerima']) && ($_GET['pasienditerima'] == 'diterima') && $model->ruanganasal_id == Yii::app()->user->getState("ruangan_id")){ ?>
    $('.form-allpemindahanpasien').each(function(){
        $(this).find('input,select,textarea').each(function(){
          $(this).attr('disabled',true);
        });
    });
    $('#<?php echo CHtml::activeId($model, 'tanggal_pemindahan'); ?>_date').hide();
    $('#<?php echo CHtml::activeId($model, 'jam_pemindahan'); ?>_date').hide();
    $('#<?php echo CHtml::activeId($model, 'tanggal_prosedur'); ?>_date').hide();
    $('#<?php echo CHtml::activeId($model, 'observasiterakhir'); ?>_date').hide();
    $('#<?php echo CHtml::activeId($model, 'tglpemasangan_kateter'); ?>_date').hide();
    $('#<?php echo CHtml::activeId($model, 'tglpemasangan_perawatan'); ?>_date').hide();
    $('.btndiagnosaKep').hide();
    $('.cl_diagnosakep').hide();
  <?php } ?>

});
</script>
