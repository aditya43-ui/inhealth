<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function changeIsPenyakit(obj){
  if($('.formNeonatus').find(obj).prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'neonatus_nutrisiasi_frekuensijml') ?>').attr('readonly',false);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'neonatus_nutrisiasi_frekuensikali') ?>').attr('readonly',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'neonatus_nutrisiasi_frekuensijml') ?>').attr('readonly',true);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'neonatus_nutrisiasi_frekuensikali') ?>').attr('readonly',true);
  }
}

function changeNurtrisiLainnya(obj){
  if($('.formNeonatus').find(obj).prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'neonatus_nutrisilainnyaket') ?>').attr('readonly',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'neonatus_nutrisilainnyaket') ?>').attr('readonly',true);
  }
}

function setKebEliminasiBab_neonatus(obj){
    if($('.formNeonatus').find(obj).val()==='1' && $('.formNeonatus').find(obj).prop('checked')===true){
         $('.formNeonatus').find('.kebEliminasiBab').attr('disabled',false);
    }else if($('.formNeonatus').find(obj).val()==='0' && $('.formNeonatus').find(obj).prop('checked')===true){
        $('.formNeonatus').find('.kebEliminasiBab').attr('disabled',true);
        $('.formNeonatus').find('.kebEliminasiBab').attr('checked',false);
    }
    setKebEliminasiKeluhanLainBab_neonatus($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_iskeluhanlainnya') ?>'));
}

function setKebEliminasiKeluhanLainBab_neonatus(obj){
    if($('.formNeonatus').find(obj).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_jeniskeluhanlainnya_neonatus') ?>').attr('readonly',false);
    }else{
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_jeniskeluhanlainnya_neonatus') ?>').attr('readonly',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_jeniskeluhanlainnya_neonatus') ?>').val('');
    }
}

function setKebEliminasiBak_neonatus(obj){
    if($('.formNeonatus').find(obj).val()==='1' && $('.formNeonatus').find(obj).prop('checked')===true){
         $('.formNeonatus').find('.kebEliminasiBak').attr('disabled',false);
    }else if($('.formNeonatus').find(obj).val()==='0' && $('.formNeonatus').find(obj).prop('checked')===true){
        $('.formNeonatus').find('.kebEliminasiBak').attr('disabled',true);
        $('.formNeonatus').find('.kebEliminasiBak').attr('checked',false);
    }
    setKebEliminasiKeluhanLainBak_neonatus($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_iskeluhanlainnya') ?>'));
}

function setKebEliminasiKeluhanLainBak_neonatus(obj){
    if($('.formNeonatus').find(obj).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_jeniskeluhanlainnya_neonatus') ?>').attr('readonly',false);
    }else{
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_jeniskeluhanlainnya_neonatus') ?>').attr('readonly',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_jeniskeluhanlainnya_neonatus') ?>').val('');
    }
}

function setStatusAlergi_neonatus(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === '3' && $('.formNeonatus').find(obj).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('readonly',false);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('readonly',false);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('readonly',false);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'ispasangtandaalergi') ?>').attr('checked',true);

    }else{
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('readonly',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('readonly',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('readonly',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'ispasangtandaalergi') ?>').attr('checked',false);
    }
}

function changeMasalahPerkawinan(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === 'Ada' && $('.formNeonatus').find(obj).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_masalahperkawinanortuket') ?>').attr('disabled',false);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_masalahperkawinanortuket') ?>').val('');
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_masalahperkawinanortuket') ?>').attr('disabled',true);
    }
}

function setJumlahRokokNeunatus(obj){
   var value = $('.formNeonatus').find(obj).val();

   if(value === '1' && $('.formNeonatus').find(obj).prop('checked')==true){
       $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'jmlrokok_btg_hr') ?>').attr('disabled',false);
   }else{
       $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'jmlrokok_btg_hr') ?>').attr('disabled',true);
   }
}

function changeKekerasanFisik(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === 'Ada' && $('.formNeonatus').find(obj).prop('checked')==true){
        $('.formNeonatus').find('.kekerasanfisik').attr('disabled',false);
    }else{
      $('.formNeonatus').find('.kekerasanfisik').attr('checked',false);
      $('.formNeonatus').find('.kekerasanfisik').attr('disabled',true);
    }
}

function changeTraumaKehidupan(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === 'Ada' && $('.formNeonatus').find(obj).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_traumadlmhiduportuket') ?>').attr('disabled',false);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_traumadlmhiduportuket') ?>').val('');
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_traumadlmhiduportuket') ?>').attr('disabled',true);
    }
}
function changeGangguanTidur(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === 'Ada' && $('.formNeonatus').find(obj).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'gangguantidur_keterangan') ?>').attr('disabled',false);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'gangguantidur_keterangan') ?>').val('');
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'gangguantidur_keterangan') ?>').attr('disabled',true);
    }
}

function changeDukunganSosialLainnya(obj){
    if($('.formNeonatus').find(obj).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_dukungansosialdr_lainnyaket') ?>').attr('disabled',false);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_dukungansosialdr_lainnyaket') ?>').val('');
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_dukungansosialdr_lainnyaket') ?>').attr('disabled',true);
    }
}

function changePihakDikaji(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === 'Lainnya' && $('.formNeonatus').find(obj).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_kebsosialekonomi_pihakygdikajilainnya') ?>').attr('disabled',false);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_kebsosialekonomi_pihakygdikajilainnya') ?>').val('');
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_kebsosialekonomi_pihakygdikajilainnya') ?>').attr('disabled',true);
    }
}

function changeStatusPernikahan(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === 'KAWIN'){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_jmlmenikahortu') ?>').attr('disabled',false);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_jmlmenikahortu') ?>').val('');
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_jmlmenikahortu') ?>').attr('disabled',true);
    }
}

function changeTinggalBersama(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === 'Lainnya'){
      $('.formNeonatus').find('.tinggalbersama').attr('disabled',false);
    }else{
      $('.formNeonatus').find('.tinggalbersama').val('');
      $('.formNeonatus').find('.tinggalbersama').attr('disabled',true);
    }
}

function changeEdukasiDiberikan(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === 'Keluarga' && $('.formNeonatus').find(obj).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_hubkeluargapenerimaedukasi') ?>').attr('disabled',false);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_hubkeluargapenerimaedukasi') ?>').val('');
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_hubkeluargapenerimaedukasi') ?>').attr('disabled',true);
    }
}

function changeBicaraStatusNeonatus(obj){
    var value = $('.formNeonatus').find(obj).val();

    if(value === 'Serangan awal gangguan bicara' && $('.formNeonatus').find(obj).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'mulaiseranganawal_neonatus') ?>').attr('disabled',false);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'mulaiseranganawal_neonatus') ?>').val('');
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'mulaiseranganawal_neonatus') ?>').attr('disabled',true);
    }
}

function changeSehariIndo(obj){
    if($('.formNeonatus').find(obj).prop('checked')==true){
      $('.formNeonatus').find('.bahasastatusindoAktif, .bahasastatusindoPasif').removeClass('disabledstatusspan');
      $('.formNeonatus').find('.bahasastatusindoAktif, .bahasastatusindoPasif').addClass('enabledstatusspan');

    }else{
      $('.formNeonatus').find('.bahasastatusindoAktif, .bahasastatusindoPasif').addClass('disabledstatusspan');
      $('.formNeonatus').find('.bahasastatusindoAktif, .bahasastatusindoPasif').removeClass('enabledstatusspan');
      $('.formNeonatus').find('.bahasastatusindoAktif, .bahasastatusindoPasif').removeClass('textstrikethrough');
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_indostatus') ?>').val('');
    }
}

function clickIndoStatus(obj, value){
  var check = false;
  if(!$('.formNeonatus').find(obj).hasClass('disabledstatusspan')){
    if(value=='Aktif' && $('.formNeonatus').find(obj).hasClass('textstrikethrough')){
      $('.formNeonatus').find('.bahasastatusindoAktif').removeClass('textstrikethrough');
      $('.formNeonatus').find('.bahasastatusindoPasif').removeClass('textstrikethrough');
    }else if($('.formNeonatus').find(obj).html()=='Aktif'){
      check = true;
      $('.formNeonatus').find('.bahasastatusindoAktif').addClass('textstrikethrough');
      $('.formNeonatus').find('.bahasastatusindoPasif').removeClass('textstrikethrough');
    }else if(value=='Pasif' && $('.formNeonatus').find(obj).hasClass('textstrikethrough')){
      $('.formNeonatus').find('.bahasastatusindoAktif').removeClass('textstrikethrough');
      $('.formNeonatus').find('.bahasastatusindoPasif').removeClass('textstrikethrough');
    }else if(value=='Pasif'){
      $('.formNeonatus').find('.bahasastatusindoAktif').removeClass('textstrikethrough');
      check = true;
      $('.formNeonatus').find('.bahasastatusindoPasif').addClass('textstrikethrough');
    }
    if(check){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_indostatus') ?>').val(value);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_indostatus') ?>').val('');
    }
  }

}

function changeSehariEng(obj){
    if($('.formNeonatus').find(obj).prop('checked')==true){
      $('.formNeonatus').find('.bahasastatusinggrisAktif, .bahasastatusinggrisPasif').removeClass('disabledstatusspan');
      $('.formNeonatus').find('.bahasastatusinggrisAktif, .bahasastatusinggrisPasif').addClass('enabledstatusspan');

    }else{
      $('.formNeonatus').find('.bahasastatusinggrisAktif, .bahasastatusinggrisPasif').addClass('disabledstatusspan');
      $('.formNeonatus').find('.bahasastatusinggrisAktif, .bahasastatusinggrisPasif').removeClass('enabledstatusspan');
      $('.formNeonatus').find('.bahasastatusinggrisAktif, .bahasastatusinggrisPasif').removeClass('textstrikethrough');
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_inggrisstatus') ?>').val('');
    }
}

function clickEngStatus(obj, value){
  var check = false;

  if(!$('.formNeonatus').find(obj).hasClass('disabledstatusspan')){
    if(value=='Aktif' && $('.formNeonatus').find(obj).hasClass('textstrikethrough')){
      $('.formNeonatus').find('.bahasastatusinggrisAktif').removeClass('textstrikethrough');
      $('.formNeonatus').find('.bahasastatusinggrisPasif').removeClass('textstrikethrough');
    }else if($('.formNeonatus').find(obj).html()=='Aktif'){
      check = true;
      $('.formNeonatus').find('.bahasastatusinggrisAktif').addClass('textstrikethrough');
      $('.formNeonatus').find('.bahasastatusinggrisPasif').removeClass('textstrikethrough');
    }else if(value=='Pasif' && $('.formNeonatus').find(obj).hasClass('textstrikethrough')){
      $('.formNeonatus').find('.bahasastatusinggrisAktif').removeClass('textstrikethrough');
      $('.formNeonatus').find('.bahasastatusinggrisPasif').removeClass('textstrikethrough');
    }else if(value=='Pasif'){
      $('.formNeonatus').find('.bahasastatusinggrisAktif').removeClass('textstrikethrough');
      check = true;
      $('.formNeonatus').find('.bahasastatusinggrisPasif').addClass('textstrikethrough');
    }
    if(check){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_inggrisstatus') ?>').val(value);
    }else{
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_inggrisstatus') ?>').val('');
    }
  }
}

function changeSehariDaerah(obj){
  if($('.formNeonatus').find(obj).prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_daerahket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_daerahket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_daerahket') ?>').attr('disabled',true);
  }
}

function changeSehariLainnya(obj){
  if($('.formNeonatus').find(obj).prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_lainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_lainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_lainnyaket') ?>').attr('disabled',true);
  }
}

function setEdukasiPenerjemah_neonatus(obj){
    if($('.formNeonatus').find(obj).val()==='Ya' && $('.formNeonatus').find(obj).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa_neonatus') ?>').attr('disabled',false);
    }else if($('.formNeonatus').find(obj).val()==='Tidak' && $('.formNeonatus').find(obj).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa_neonatus') ?>').attr('disabled',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa_neonatus') ?>').val('');
    }
}

function setChangeDetEdukasiLain_neonatus(obj){
    var index = $('.formNeonatus').find(obj).attr('text_id');

    if($('.formNeonatus').find(obj).prop('checked')==true){
        $('.formNeonatus').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('disabled',false);
    }else{
        $('.formNeonatus').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('disabled',true);
        $('.formNeonatus').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').val('');
    }
}

function changeCriesCrying(obj){
  if($(obj).prop('checked')==true){
    var label = $(obj).attr('labelradio');
    var value = $(obj).val();
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_cryingket') ?>').val(label);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_cryingnilai') ?>').val(value);
  }
  getTotalSkorCries();
}

function changeCriesRequires(obj){
  if($(obj).prop('checked')==true){
    var label = $(obj).attr('labelradio');
    var value = $(obj).val();
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_requiresket') ?>').val(label);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_requiresnilai') ?>').val(value);
  }
  getTotalSkorCries();
}

function changeCriesIncreased(obj){
  if($(obj).prop('checked')==true){
    var label = $(obj).attr('labelradio');
    var value = $(obj).val();
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_increasedket') ?>').val(label);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_increasednilai') ?>').val(value);
  }
  getTotalSkorCries();
}

function changeCriesExpression(obj){
  if($(obj).prop('checked')==true){
    var label = $(obj).attr('labelradio');
    var value = $(obj).val();
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_expressionket') ?>').val(label);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_expressionnilai') ?>').val(value);
  }
  getTotalSkorCries();
}

function changeCriesSleepless(obj){
  if($(obj).prop('checked')==true){
    var label = $(obj).attr('labelradio');
    var value = $(obj).val();
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_sleeplessket') ?>').val(label);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_sleeplessnilai') ?>').val(value);
  }
  getTotalSkorCries();
}


function getTotalSkorCries(){
  var total = 0;
  $('.formNeonatus').find('.totalcries').each(function(){
    if($(this).val() !== ''){
      total += parseInt($(this).val());
    }
  });
  $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_cries_totalnilai') ?>').val(total);
}

function simpanAllDataNeonatus(){
  if(requiredCheck($('.formNeonatus').find('#riaskepneonatus-t-form'))){
    var indexNext = $('.formNeonatus').find('#rootwizardAskepNeonatus').data('bootstrapWizard').nextIndex();
    var indexstep = $('.formNeonatus').find('#rootwizardAskepNeonatus').data('bootstrapWizard').currentIndex();
    $(".formNeonatus").addClass("animation-loading");
    $('.formNeonatus').find(".integer-decimal, .integer2, .float2").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
    var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
    var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
    var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
    var jenisasesmen = $('#choise_neonatus').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
    var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

    var dataSerialized = $('.formNeonatus').find('#riaskepneonatus-t-form').serializeArray();
    dataSerialized.push({name: 'indexcurrent',value:indexstep});
    dataSerialized.push({name: 'indexNext',value:indexNext});
    dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pendaftaran_id]',value:pendaftaran_id});
    dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pasienadmisi_id]',value:pasienadmisi_id});
    dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pasien_id]',value:pasien_id});
    dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[jenisasesmen]',value:jenisasesmen});
    dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[asesmenawalkeperawatan_id]',value:asesmenawalkeperawatan_id});
    dataSerialized.push({name: 'RIAsesmenkebutuhanEdukasiT[pendaftaran_id]',value:pendaftaran_id});
    dataSerialized.push({name: 'RIAsesmenkebutuhanEdukasiT[pasienadmisi_id]',value:pasienadmisi_id});

    if(indexstep > 1){
      $('#checkSimpanData').val('simpan');
    }else if (indexstep == 1){
      $('#checkSimpanData').val('');
    }
    var checksimpan = $('#checkSimpanData').val();
    dataSerialized.push({name: 'checksimpan',value:checksimpan});

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SimpanOrLoad'); ?>',
        data: dataSerialized,
        dataType: "json",
        'async': false,
        success:function(data){
          suksesData = false;
          if(data != ""){
            if(data.sukses > 0){
              $('.formNeonatus').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              suksesData=true;
              $.fn.yiiGridView.update('riwayataskep-grid', {
                  data: $(this).serialize()
              });
            }else{
              $('.formNeonatus').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
            }
            if(suksesData==true){
              setTimeout(function(){
                  $('.formNeonatus').find('.divAlert').html('');
              }, 5000);
            }
          }else{
              $('.formNeonatus').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
          }
          $(".formNeonatus").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formNeonatus").removeClass("animation-loading");}
    });
  }
}

function simpanDataFormNeunatus(simpanDt, indexstep, handeland){
  var suksesData = false;
    if(requiredCheck($('.formNeonatus').find(simpanDt))){
      var indexNext = $('.formNeonatus').find('#rootwizardAskepNeonatus').data('bootstrapWizard').nextIndex();
      $(".formNeonatus").addClass("animation-loading");
      $('.formNeonatus').find(".integer-decimal, .integer2, .float2").each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
      var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
      var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
      var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
      var jenisasesmen = $('#choise_neonatus').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
      var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

      if(indexstep > 1){
        $('#checkSimpanData').val('simpan');
      }else if (indexstep == 1){
        $('#checkSimpanData').val('');
      }

      var checksimpan = $('#checkSimpanData').val();

      var dataSerialized = $('.formNeonatus').find(simpanDt).serializeArray();
      dataSerialized.push({name: 'indexcurrent',value:indexstep});
      dataSerialized.push({name: 'indexNext',value:indexNext});
      dataSerialized.push({name: 'checksimpan',value:checksimpan});
      dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pendaftaran_id]',value:pendaftaran_id});
      dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pasienadmisi_id]',value:pasienadmisi_id});
      dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pasien_id]',value:pasien_id});
      dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[jenisasesmen]',value:jenisasesmen});
      dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[asesmenawalkeperawatan_id]',value:asesmenawalkeperawatan_id});
      dataSerialized.push({name: 'RIAsesmenkebutuhanEdukasiT[pendaftaran_id]',value:pendaftaran_id});
      dataSerialized.push({name: 'RIAsesmenkebutuhanEdukasiT[pasienadmisi_id]',value:pasienadmisi_id});

      $.ajax({
          type:'POST',
          url:'<?php echo $this->createUrl('SimpanOrLoad'); ?>',
          data: dataSerialized,
          dataType: "json",
          'async': false,
          success:function(data){
            suksesData = false;
            if(data != ""){
              if(data.sukses > 0){
                suksesData = true;
                $('.formNeonatus').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');

                $.fn.yiiGridView.update('riwayataskep-grid', {
                    data: $(this).serialize()
                });
              }else{
                $('.formNeonatus').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              }
              if(suksesData == true){
                setTimeout(function(){
                    $('.formNeonatus').find('.divAlert').html('');
                }, 5000);
              }
            }else{
                $('.formNeonatus').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
            }
            $(".formNeonatus").removeClass("animation-loading");
          },
          error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formNeonatus").removeClass("animation-loading");}
      });
    }
    return suksesData;
}

function setSumberData_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.sumberdata').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',true);
  }
}

function setStatusPembedahanAnastesi_neonatus(obj){
  var parentForm = $(obj).parents().find('.formNeonatus');
    var value = $(parentForm).find(obj).val();

    if($('.formNeonatus').find('.riwayatpembedahan_status').length > 0){
        for(var i=0; i<$('.formNeonatus').find('.riwayatpembedahan_status').length; i++){
            if($('.formNeonatus').find('.riwayatpembedahan_status').eq(i).prop('checked') === true && $('.formNeonatus').find('.riwayatpembedahan_status').eq(i).val()=='Pernah'){
                $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('readonly',false);
            }else if($('.formNeonatus').find('.riwayatpembedahan_status').eq(i).prop('checked') === true && $('.formNeonatus').find('.riwayatpembedahan_status').eq(i).val()=='Tidak Pernah'){
                $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('readonly',true);
                $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').val('');
            }
        }
    }
}

function setStatusRiwayattransfusi_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.riwayattransfusi_status').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',false);
      $('.formNeonatus').find('.riwayattransfusi_isreaksi').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',true);
    $('.formNeonatus').find('.riwayattransfusi_isreaksi').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
  setReaksiRiwayattransfusi_neonatus();
}

function setReaksiRiwayattransfusi_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.riwayattransfusi_isreaksi').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',true);
  }
}

function setKomplikasiKehamilan(obj){
  if($(obj).prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_kompilkasikehamilanlainnya') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_kompilkasikehamilanlainnya') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_kompilkasikehamilanlainnya') ?>').attr('disabled',true);
  }
}

function setKebiasaanKehamilan(obj){
  if($(obj).prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_kebiasaansaathamillainnya') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_kebiasaansaathamillainnya') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_kebiasaansaathamillainnya') ?>').attr('disabled',true);
  }
}

function setKetubanpecah(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.neonatus_isketubanpecah').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_jamketubanpecah'); ?>').attr('disabled',false);
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_jamketubanpecah'); ?>_date').show();
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_jamketubanpecah'); ?>_date').hide();
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_jamketubanpecah'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_jamketubanpecah'); ?>').attr('disabled',true);
  }
}

function setKondisisaatlahir(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.neonatus_kondisisaatlahir').each(function(){
    if($(this).val()=='Mati' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_sebabkematian'); ?>').attr('disabled',false);
      $('.formNeonatus').find('.neonatus_statuskelahiranmati').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_sebabkematian'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_sebabkematian'); ?>').attr('disabled',true);
    $('.formNeonatus').find('.neonatus_statuskelahiranmati').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
}

function setKepalaLainnya(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'kepala_islainnya') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'kepala_lainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'kepala_lainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'kepala_lainnyaket') ?>').attr('disabled',true);
  }
}

function setStatusUbunubunbesar(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.ubunubunbesar_status').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'ubunubunbesar_ket'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 4 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'ubunubunbesar_ket'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'ubunubunbesar_ket'); ?>').attr('disabled',true);
  }
}

function setMulutLainnya(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'mulut_islainnya') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'mulut_lainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'mulut_lainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'mulut_lainnyaket') ?>').attr('disabled',true);
  }
}

function setPunggungLainnya(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'punggung_islainnya') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'punggung_lainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'punggung_lainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'punggung_lainnyaket') ?>').attr('disabled',true);
  }
}

function setEkstremitasLainnya(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'ekstremitas_islainnya') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'ekstremitas_islainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'ekstremitas_islainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'ekstremitas_islainnyaket') ?>').attr('disabled',true);
  }
}

function setStatusMata(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.mata_status').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'mata_ket'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 5 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'mata_ket'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'mata_ket'); ?>').attr('disabled',true);
  }
}

function setThtLainnya(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'tht_islainnya') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'tht_lainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'tht_lainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'tht_lainnyaket') ?>').attr('disabled',true);
  }
}

function setStatusThorax(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.thorax_status').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'thorax_lainnya'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'thorax_lainnya'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'thorax_lainnya'); ?>').attr('disabled',true);
  }
}

function setAbdomenLainnya(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'abdomen_islainnya') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'abdomen_lainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'abdomen_lainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'abdomen_lainnyaket') ?>').attr('disabled',true);
  }
}

function setGenitaKelainan(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'genitalia_iskelainan') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'genitalia_kelainanket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'genitalia_kelainanket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'genitalia_kelainanket') ?>').attr('disabled',true);
  }
}

function setGenitaliaLainnya(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'genitalia_islainnya') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'genitalia_lainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'genitalia_lainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'genitalia_lainnyaket') ?>').attr('disabled',true);
  }
}

function setKulitLainnya(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'kulit_islainnya') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'kulit_lainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'kulit_lainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'kulit_lainnyaket') ?>').attr('disabled',true);
  }
}

function setReflekMoro(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_ismoro') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_moroket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_moroket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_moroket') ?>').attr('disabled',true);
  }
}

function setReflekRasping(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_israsping') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_raspingket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_raspingket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_raspingket') ?>').attr('disabled',true);
  }
}

function setReflekSucking(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_issucking') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_suckingket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_suckingket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_suckingket') ?>').attr('disabled',true);
  }
}

function setReflekRooting(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_isrooting') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_rootingket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_rootingket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_rootingket') ?>').attr('disabled',true);
  }
}

function setReflekStepping(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_isstepping') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_steppingket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_steppingket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_steppingket') ?>').attr('disabled',true);
  }
}

function setReflekSwallowing(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_isswallowing') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_swallowingket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_swallowingket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_swallowingket') ?>').attr('disabled',true);
  }
}

function setReflekBabinski(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_isbabinski') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_babinskiket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_babinskiket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_babinskiket') ?>').attr('disabled',true);
  }
}

function setReflekGlabela(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_isglabela') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_glabelaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_glabelaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_glabelaket') ?>').attr('disabled',true);
  }
}

function setReflekNeck(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_istonickneck') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_tonickneckket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_tonickneckket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_tonickneckket') ?>').attr('disabled',true);
  }
}

function setReflekLainnya(){
  if($('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_islainnya') ?>').prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_lainnyaket') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_lainnyaket') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modPeriksaFisikNeonatusRI, 'reflek_lainnyaket') ?>').attr('disabled',true);
  }
}

function pilihFungsional_neonatus(obj){
    if($('.formNeonatus').find(obj).val() == 1 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#pilih_fungsional').find('.panel-body'));
        $('.formNeonatus').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').show();

        inputAllDisabled($('.formNeonatus').find('#pilih_fungsionaladl').find('.panel-body'));
       $('.formNeonatus').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').hide();
    }else if($('.formNeonatus').find(obj).val() == 2 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#pilih_fungsionaladl').find('.panel-body'));
        $('.formNeonatus').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').show();

        inputAllDisabled($('.formNeonatus').find('#pilih_fungsional').find('.panel-body'));
        $('.formNeonatus').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').hide();
    }
}

function unpilihFungsional_neonatus(){
  inputAllDisabled($('.formNeonatus').find('#pilih_fungsional').find('.panel-body'));
  $('.formNeonatus').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').hide();

  inputAllDisabled($('.formNeonatus').find('#pilih_fungsionaladl').find('.panel-body'));
 $('.formNeonatus').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').hide();
}

function klikBtnMakan_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_makan') ?>').val(nilai);
skorskrinningfungsional_neonatus();
}

function klikBtnToilet_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_aktifitastoilet') ?>').val(nilai);
skorskrinningfungsional_neonatus();
}

function klikBtnRodaTidur_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpindahkursi') ?>').val(nilai);
skorskrinningfungsional_neonatus();
}

function klikBtnGosokGigi_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_kebersihanmandiri') ?>').val(nilai);
skorskrinningfungsional_neonatus();
}

function klikBtnMandi_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mandi') ?>').val(nilai);
skorskrinningfungsional_neonatus();
}

function klikBtnBerjalanDasar_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berjalanpermukaankasar') ?>').val(nilai);
skorskrinningfungsional_neonatus();
}

function klikBtnNaikTangga_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_naikturuntangga') ?>').val(nilai);
skorskrinningfungsional_neonatus();
}

function klikBtnBerpakaian_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpakaian') ?>').val(nilai);
skorskrinningfungsional_neonatus();
}

function klikBtnDefekasi_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontroldefekasi') ?>').val(nilai);
    skorskrinningfungsional_neonatus();
}

function klikBtnBerkemih_neonatus(nilai){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontrolberkemih') ?>').val(nilai);
    skorskrinningfungsional_neonatus();
}

function skorskrinningfungsional_neonatus(){
    var totalSkor = 0;

    $('.formNeonatus').find('#tblInputFungsional').find('.skinningfungsional_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkor += parseInt(skor);
    });
    var keterangan = "";
    var kategori = "";

   if(totalSkor == 100){
       keterangan = "Mandiri";
       kategori = "I";
   }else if(totalSkor >= 91 && totalSkor <= 99){
       keterangan = "Ketergantungan Ringan";
       kategori = "II";
   }else if(totalSkor >= 62 && totalSkor <= 90){
       keterangan = "Sedang";
       kategori = "III";
   }else if(totalSkor >= 21 && totalSkor <= 60){
       keterangan = "Ketergantungan Berat";
       kategori = "IV";
   }else if(totalSkor <= 20){
       keterangan = "Ketergantungan Total";
       kategori = "V";
   }

    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_jumlah_skor') ?>').val(totalSkor);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_keterangan') ?>').val(keterangan);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_kategori') ?>').val(kategori);
}

function klikBtnAdl_neonatus(skor, type){
  if(type == 'bab'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_bab'); ?>').val(skor);
  }else if(type == 'bak'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_bak'); ?>').val(skor);
  }else if(type == 'kebersihan'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_kebersihanmandiri'); ?>').val(skor);
  }else if(type == 'penggunaanjamban'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_pengunaanjamban'); ?>').val(skor);
  }else if(type == 'makan'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_makan'); ?>').val(skor);
  }else if(type == 'sikap'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_sikap'); ?>').val(skor);
  }else if(type == 'pindah'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_berpindah'); ?>').val(skor);
  }else if(type == 'baju'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_baju'); ?>').val(skor);
  }else if(type == 'tangga'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_naikturuntangga'); ?>').val(skor);
  }else if(type == 'mandi'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_mandi'); ?>').val(skor);
  }

  var skor = 0;
  var keterangan = "";

  $('.formNeonatus').find('#tblInputFungsionalAdl').find('.skinningfungsionaladl_skor').each(function(){
    var skorAdl = $('.formNeonatus').find(this).val();

    if(skorAdl == ''){
        skorAdl = 0;
    }
    skor += parseInt(skorAdl);
  });

  if(skor >= 0 && skor <= 4){
    keterangan = "Tergantungan Total";
  }else if(skor >= 5 && skor <= 8){
    keterangan = "Tergantungan Berat";
  }else if(skor >= 9 && skor <= 11){
    keterangan = "Tergantungan sedang";
  }else if(skor >= 12 && skor <= 15){
    keterangan = "Tergantungan Ringan";
  }else if(skor > 15){
    keterangan = "Mandiri";
  }

  $('.formNeonatus').find('#tblInputFungsionalAdl').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_jumlah_skor'); ?>').val(skor);
  $('.formNeonatus').find('#tblInputFungsionalAdl').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_keterangan'); ?>').val(keterangan);
}

function resikojatuhanak_usia_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skor_usia_anak') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'usia_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function resikojatuhanak_jeniskelamin_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skor_jeniskelamin_anak') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'jeniskelamin_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function resikojatuhanak_diagnosa_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skor_diagnosa_anak') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'diagnosa_asessment_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function resikojatuhanak_gangguan_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skor_gangguan_kognitif_anak') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'gangguan_kognitif_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}


function resikojatuhanak_faktor_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skor_faktor_lingkungan_anak') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'faktor_lingkungan_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}


function resikojatuhanak_respon_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skor_responterhadap_pembedahan_anak') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'responterhadap_pembedahan_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function resikojatuhanak_bedah_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skor_medikamentosa_anak') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'penggunaan_medikamentosa') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function skorresikojatuh_neonatus(){
  var totalSkorDewasa = 0;
  var totalSkorAnak = 0;
  var totalSkorLansia = 0;

  $('.formNeonatus').find('#tblResikojatuhDewasa').find('.resikojatuhdewasa_skor').each(function(){
      var skor = $(this).val();

      if(skor == ''){
          skor = 0;
      }
      totalSkorDewasa += parseInt(skor);
  });
  var ketResikoDewasa = "";
  if (totalSkorDewasa >= 0  && totalSkorDewasa <=24)  {
     ketResikoDewasa = "Risiko Rendah";
  }
  else if(totalSkorDewasa >= 25 && totalSkorDewasa <= 45) {
      ketResikoDewasa = "Risiko Sedang";
  }
  else if(totalSkorDewasa > 45) {
      ketResikoDewasa = "Risiko Tinggi";
  }

  $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'resikojatuh_skor') ?>').val(totalSkorDewasa);
  $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'resikojatuh_keterangan') ?>').val(ketResikoDewasa);

  $('.formNeonatus').find('#tblResikojatuhAnak').find('.resikojatuhanak_skor').each(function(){
      var skor = $(this).val();

      if(skor == ''){
          skor = 0;
      }
      totalSkorAnak += parseInt(skor);
  });
  var ketResikoAnak = "";
  if (totalSkorAnak >= 7  && totalSkorAnak <=11)  {
     ketResikoAnak = "Risiko Rendah";
  }
  else if(totalSkorAnak >= 12) {
      ketResikoAnak = "Risiko Tinggi";
  }

  $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'jumlah_skor_anak') ?>').val(totalSkorAnak);
  $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'keterangan_resiko_jatuh_anak') ?>').val(ketResikoAnak);

  $('.formNeonatus').find('#tblResikojatuhLansia').find('.resikojatuhlansia_skor').each(function(){
      var skor = $(this).val();

      if(skor == ''){
          skor = 0;
      }
      totalSkorLansia += parseInt(skor);
  });
  var ketResikoLansia = "";
  if(totalSkorLansia >= 0 && totalSkorLansia<=5){
          ketResikoLansia = "Resiko Rendah";
      }else if(totalSkorLansia >= 6 && totalSkorLansia<=16){
          ketResikoLansia = "Resiko Sedang";
      }else if(totalSkorLansia >= 17 && totalSkorLansia<=30){
          ketResikoLansia = "Resiko Tinggi";
      }
  $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'jumlah_skor_lansia') ?>').val(totalSkorLansia);
  $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'keterangan_skor_lansia') ?>').val(ketResikoLansia);


  $('.formNeonatus').find('.pilih_resikoJatuh').each(function(){
    if($('.formNeonatus').find(this).val() == 0 && $('.formNeonatus').find(this).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoDewasa);
    }else if($('.formNeonatus').find(this).val() == 0 && $('.formNeonatus').find(this).prop('checked')==true){
       <?php if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR){ ?>
           $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val("Resiko Tinggi");
       <?php }else{ ?>
           $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoAnak);
        <?php } ?>
    }else if($('.formNeonatus').find(this).val() == 0 && $('.formNeonatus').find(this).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoLansia);
    }
  });
}

function changeInformasiResikoJatuh_neonatus(obj){
   var html = "Lakukan intervensi pencegahan resiko jatuh: Beritahu pendamping untuk tidak meninggalkan pasien";
    if($('.formNeonatus').find(obj).val() === 'Kursi Roda' && $('.formNeonatus').find(obj).prop('checked')===true && $('.formNeonatus').find(obj).hasClass('jenisalatbantu')){
        html = "Lakukan intervensi pencegahan resiko jatuh: Beritahu pendamping untuk tidak meninggalkan pasien dan pastikan kursi roda terkunci";
    }

    if($('.formNeonatus').find(obj).val() === 'Lainnya' && $('.formNeonatus').find(obj).prop('checked')===true && $('.formNeonatus').find(obj).hasClass('jenisalatbantu')){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',false);
    }else if($('.formNeonatus').find(obj).val() !== 'Lainnya' && $('.formNeonatus').find(obj).prop('checked')===true && $('.formNeonatus').find(obj).hasClass('jenisalatbantu')){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',true);
    }

    if($('.formNeonatus').find(obj).val() === '1' && $('.formNeonatus').find(obj).prop('checked')===true && $('.formNeonatus').find(obj).hasClass('riwayatjatuh_alatbantu')){
        $('.formNeonatus').find('.jenisalatbantu').attr('disabled',false);
    }else{
        if($('.formNeonatus').find(obj).val() === '0' && $('.formNeonatus').find(obj).prop('checked')===true  && $('.formNeonatus').find(obj).hasClass('riwayatjatuh_alatbantu')){
            $('.formNeonatus').find('.jenisalatbantu').attr('disabled',true);
            $('.formNeonatus').find('.jenisalatbantu').attr('checked',false);
            $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',true);
        }
    }
    if($('.formNeonatus').find('.riwayatjatuh_alatbantu').prop('checked')===true && $('.formNeonatus').find('.riwayatjatuh_3bln_terakhir').prop('checked')===false){
        $('.formNeonatus').find('#informasiResikoJatuh').hide();
        $('.formNeonatus').find('#informasiResikoJatuh').html("");
    }else{
        $('.formNeonatus').find('#informasiResikoJatuh').show();
        $('.formNeonatus').find('#informasiResikoJatuh').html(html);
    }

    if($('.formNeonatus').find('.riwayatjatuh_alatbantu').prop('checked')===false && $('.formNeonatus').find('.riwayatjatuh_3bln_terakhir').prop('checked')===false){
        $('.formNeonatus').find('#informasiResikoJatuh').hide();
        $('.formNeonatus').find('#informasiResikoJatuh').html("");
    }

}

function setKesadaranNyeri_neonatus(){
  var indexLainnya = 0;
  $('.formNeonatus').find('.kesadaranpasien_pengkajiannyeri').each(function(){
    if($(this).val()=='Sadar' &&  $(this).prop('checked')==true){
      inputAllEnabled($('.formNeonatus').find('.panelsadar'));
      $('.formNeonatus').find('.panelsadar').show();

      inputAllDisabled($('.formNeonatus').find('.paneltidaksadar'));
      $('.formNeonatus').find('.paneltidaksadar').hide();
      indexLainnya += 1;
    }else if($(this).val()=='Tidak Sadar' &&  $(this).prop('checked')==true){
      inputAllDisabled($('.formNeonatus').find('.panelsadar'));
      $('.formNeonatus').find('.panelsadar').hide();

      inputAllEnabled($('.formNeonatus').find('.paneltidaksadar'));
      $('.formNeonatus').find('.paneltidaksadar').show();
      indexLainnya += 1;
    }
  });



  if(indexLainnya == 0){
    inputAllDisabled($('.formNeonatus').find('.paneltidaksadar'));
    inputAllDisabled($('.formNeonatus').find('.panelsadar'));
    $('.formNeonatus').find('.panelsadar').hide();
    $('.formNeonatus').find('.paneltidaksadar').hide();
  }
}

function pilihNyeri_neonatus(obj){
  if($('.formNeonatus').find(obj).val() == 0 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#nyeri_anak').find('.panel-body'));
        $('.formNeonatus').find('#nyeri_anak').find('.panel-body').show();

        inputAllDisabled($('.formNeonatus').find('#nyeri_dewasa').find('.panel-body'));
        $('.formNeonatus').find('#nyeri_dewasa').find('.panel-body').hide();

        inputAllDisabled($('.formNeonatus').find('#nyeri_cries').find('.panel-body'));
        $('.formNeonatus').find('#nyeri_cries').find('.panel-body').hide();
    } else if($('.formNeonatus').find(obj).val() == 1 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#nyeri_dewasa').find('.panel-body'));
        $('.formNeonatus').find('#nyeri_dewasa').find('.panel-body').show();

        inputAllDisabled($('.formNeonatus').find('#nyeri_anak').find('.panel-body'));
        $('.formNeonatus').find('#nyeri_anak').find('.panel-body').hide();

        inputAllDisabled($('.formNeonatus').find('#nyeri_cries').find('.panel-body'));
        $('.formNeonatus').find('#nyeri_cries').find('.panel-body').hide();

        resetFormFlasCCs();
    } else if($('.formNeonatus').find(obj).val() == 2 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#nyeri_cries').find('.panel-body'));
        $('.formNeonatus').find('#nyeri_cries').find('.panel-body').show();

        inputAllDisabled($('.formNeonatus').find('#nyeri_anak').find('.panel-body'));
        $('.formNeonatus').find('#nyeri_anak').find('.panel-body').hide();

        inputAllDisabled($('.formNeonatus').find('#nyeri_dewasa').find('.panel-body'));
        $('.formNeonatus').find('#nyeri_dewasa').find('.panel-body').hide();
    }
}

function pilihScala_neonatus(skor){
    var keterangan;

    if (skor == 0){
        keterangan = '<?php echo Params::SKALA_NYERI_0; ?>';
    }else if (skor >= 1 && skor <= 2){
        keterangan = '<?php echo Params::SKALA_NYERI_1_2; ?>';
    }else if (skor >= 3 && skor <= 4){
        keterangan = '<?php echo Params::SKALA_NYERI_3_4; ?>';
    }else if (skor >= 5 && skor <= 6){
        keterangan = '<?php echo Params::SKALA_NYERI_5_6; ?>';
    }else if (skor >= 7 && skor <= 8){
        keterangan = '<?php echo Params::SKALA_NYERI_7_8; ?>';
    }else if (skor >= 9 && skor <= 10){
        keterangan = '<?php echo Params::SKALA_NYERI_9_10; ?>';
    }
    //if(skor != 0){
        $('.formNeonatus').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val(skor);
        $('.formNeonatus').find("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").val(keterangan);
    //}

    $('.formNeonatus').find(".nyeri-nomor").css("border", "none");
    $('.formNeonatus').find(".nyeri-nomor").css("border-radius", "5px");
    $('.formNeonatus').find("#nyerinomor_" + skor).css("border", "1px solid black");
}

function getSkorFla_neonatus(id,skor,obj){
    $('.formNeonatus').find("#skor_"+id).html(skor);
    $('.formNeonatus').find(obj).parents("tr").find('.params').val(skor);
    $('.formNeonatus').find(obj).parents("tr").find('.nilai').val(skor);
    $('.formNeonatus').find(obj).parents("tr").find('.kategoriid').val(id);

    totalSkorFla_neonatus();
}

function totalSkorFla_neonatus(){
    var total = 0;

    $('.formNeonatus').find("#master_falsccs > tbody > tr").each(function(){
        $(this).find('.nilai').parents('tr').find('.params-nilai0').attr('style','');
        $(this).find('.nilai').parents('tr').find('.params-nilai1').attr('style','');
        $(this).find('.nilai').parents('tr').find('.params-nilai2').attr('style','');
        if ($(this).find('.nilai').val() != ''){
            $(this).find('.nilai').parents('tr').find('.params-nilai'+$(this).find('.nilai').val()).attr('style','border:4px solid #333 !important;');
            total = total + parseInt($(this).find('.nilai').val());
        }else{
            total = total + 0;
        }
    });

    $('.formNeonatus').find("#totalskor").html(total);

    if (total == 0){
        var keterangan = 'tidak nyeri';
    }else if(total >= 1 && total <= 3){
        var keterangan = 'nyeri ringan';
    }else if(total >= 4 && total <= 6){
        var keterangan = 'nyeri sedang';
    }else if(total >= 7 && total <= 10){
        var keterangan = 'nyeri berat sekali';
    }

    $('.formNeonatus').find('.panelsadar').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri_anak') ?>").val(total);
    $('.formNeonatus').find('.panelsadar').find("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri_anak') ?>").val(keterangan);
}

function setAdaNyeri_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.isadakeluhannyeri').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('.jenisnyeri').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('.jenisnyeri').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
  }
}

function setKualitasNyeri_neonatus(){
  $('.formNeonatus').find('.kualitasnyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',false);
      }else{
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').val('');
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',true);
      }
  });
}

function setFrekuensiNyeri_neonatus(){
  $('.formNeonatus').find('.frekuensinyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',false);
      }else{
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').val('');
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',true);
      }
  });
}

function changeDeskripsinyeri_ismenjalar_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.deskripsinyeri_ismenjalar').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('readonly',true);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').val('');
  }
}

function changeNyeriHilangLain_neonatus(){
    if($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'isnyerihilangdgn_lainlain') ?>').prop('checked')==true){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',false);
    }else{
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').val('');
    }
}

function venekpresi_neonatus(obj){
  if($('.formNeonatus').find(obj).val() != ''){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahskor') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahpenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahskor') ?>').val(0);
  }
    skorventilator_neonatus();
}

function venekstremitas_neonatus(obj){
  if($('.formNeonatus').find(obj).val() != ''){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasatasskor') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasataspenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasatasskor') ?>').val(0);
  }
    skorventilator_neonatus();
}

function venpatuh_neonatus(obj){
  if($('.formNeonatus').find(obj).val() != ''){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorskor') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorpenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorskor') ?>').val(0);
  }
    skorventilator_neonatus();
}


function skorventilator_neonatus(){
    var totalSkor = 0;

    $('.formNeonatus').find('#tbl_ventilator').find('.skor_ventilator').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkor += parseInt(skor);
    });

    var ketdewasa = "";
    var risDewasa = "";

    if(totalSkor <= 5){
      risDewasa = "Tidak Nyeri";
    }else if(totalSkor >= 6){
      risDewasa = "Nyeri";
    }

    $('.formNeonatus').find('.paneltidaksadar').find('#<?php echo CHtml::activeId($model,'score_skalanyeri_anak') ?>').val(totalSkor);
    $('.formNeonatus').find('.paneltidaksadar').find('#<?php echo CHtml::activeId($model,'keteranganskala_nyeri_anak') ?>').val(risDewasa);
}

function choiseSkrinningGizi_neonatus(obj){
    if($('.formNeonatus').find(obj).val() == 1 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#skrinninggizi_dewasa_panel'));
        $('.formNeonatus').find('#skrinninggizi_dewasa_panel').show();

        inputAllDisabled($('.formNeonatus').find('#skrinninggizi_anak_panel'));
        $('.formNeonatus').find('#skrinninggizi_anak_panel').hide();
    } else if($('.formNeonatus').find(obj).val() == 0 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#skrinninggizi_anak_panel'));
        $('.formNeonatus').find('#skrinninggizi_anak_panel').show();

        inputAllDisabled($('.formNeonatus').find('#skrinninggizi_dewasa_panel'));
        $('.formNeonatus').find('#skrinninggizi_dewasa_panel').hide();
    }
}

function skrinninggizidewasa_penurunbb_neonatus(obj){
  if($('.formNeonatus').find(obj).val() != ''){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penurunanbb_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val(0);
  }
  skorskrinninggizi_neonatus();
}

function skrinninggizidewasa_asupan_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_asupanmakanan_dewasa') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_asupanmakanan_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_neonatus();
}

function skrininggizianak_tampakkurus_neonatus(obj){
  if($('.formNeonatus').find(obj).val() == 'Ya'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_tampakkurus') ?>').val(1);
  }else if($('.formNeonatus').find(obj).val() == 'Tidak'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_tampakkurus') ?>').val(0);
  }

    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_tampakkurus') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_neonatus();
}

function skrininggizianak_bb_neonatus(obj){
  if($('.formNeonatus').find(obj).val() == 'Ya'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb') ?>').val(1);
  }else if($('.formNeonatus').find(obj).val() == 'Tidak'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb') ?>').val(0);
  }

    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penurunanbb') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_neonatus();
}

function skrininggizianak_kondisi_neonatus(obj){
  if($('.formNeonatus').find(obj).val() == 'Ya'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_kondisi') ?>').val(1);
  }else if($('.formNeonatus').find(obj).val() == 'Tidak'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_kondisi') ?>').val(0);
  }
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_kondisi') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_neonatus();
}

function skrininggizianak_penyakit_neonatus(obj){
  if($('.formNeonatus').find(obj).val() == 'Ya'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penyakit') ?>').val(2);
  }else if($('.formNeonatus').find(obj).val() == 'Tidak'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penyakit') ?>').val(0);
  }
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penyakit') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_neonatus();
}

function skorskrinninggizi_neonatus(){
    var totalSkorDewasa = 0;
    var totalSkorAnak = 0;

    $('.formNeonatus').find('#tblInputSkrinningGiziDewasa').find('.skrinninggizidewasa_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorDewasa += parseInt(skor);
    });

    $('.formNeonatus').find('#tblInputSkrinningGiziAnak').find('.skrinninggizianak_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorAnak += parseInt(skor);
    });

    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_totaldewasa') ?>').val(totalSkorDewasa);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_totalanak') ?>').val(totalSkorAnak);

    var ket = "";
    var ris = "";

    if(totalSkorDewasa <= 1){
      ket = "Lakukan skrinning setiap 7 hari";
      ris = "Resiko Rendah";
    }else if(totalSkorDewasa >= 2 && totalSkorDewasa <= 3){
      ket = "Lakukan pengkajian gizi lebih lanjut oleh ahli gizi";
      ris = "Resiko Sedang";
    }else if(totalSkorDewasa >= 4){
      ket = "Lakukan pengkajian gizi lebih lanjut oleh ahli gizi";
      ris = "Resiko Tinggi";
    }

    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrininggizidewasa_resiko') ?>').val(ris);
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'skrininggizidewasa_tindakanygdilakukan') ?>').val(ket);
}

function gantiJumlah_neonatus(obj){
    var value = parseFloat($('.formNeonatus').find(obj).val());
    var teman = $('.formNeonatus').find(obj).parent('.groupUkurans').find('input[type="text"]');
    var valueTeman = parseFloat(teman.val());
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}

function setB2isoedem_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.b2_isoedem').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b2_lokasioedem'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b2_lokasioedem'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b2_lokasioedem'); ?>').attr('disabled',true);
  }
}

function setB5Nyeritekan_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.b5_abdomen_isnyeritekan').each(function(){
    if($(this).val()==1 && $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b5_abdomen_nyeritekanlokasi'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b5_abdomen_nyeritekanlokasi'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b5_abdomen_nyeritekanlokasi'); ?>').attr('disabled',true);
  }
}

function setB6Fraktur_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.b6_isfraktur').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b6_lokasifraktur'); ?>').attr('disabled',false);
      $('.formNeonatus').find('.b6_jenisfraktur').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b6_lokasifraktur'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b6_lokasifraktur'); ?>').attr('disabled',true);
    $('.formNeonatus').find('.b6_jenisfraktur').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
}

function setB6ResikoDekubitus_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.b6_isresikodekubitus').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b6_skorbraden'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b6_skorbraden'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b6_skorbraden'); ?>').attr('disabled',true);
  }
}

function setB6Luka_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.b6_isluka').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b6_lokasiluka'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b6_lokasiluka'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b6_lokasiluka'); ?>').attr('disabled',true);
  }
}

function setJenisPernapasan_neonatus(obj){
  if($('.formNeonatus').find(obj).prop('checked')==true){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'b1jenispernapasan_lainnya') ?>').attr('disabled',false);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'b1jenispernapasan_lainnya') ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'b1jenispernapasan_lainnya') ?>').attr('disabled',true);
  }
}

function setKesulitanbernafas_neonatus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formNeonatus').find('.b1_kesulitanbernafas').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b1_jmloksigenperliter'); ?>').attr('disabled',false);
      $('.formNeonatus').find('.b1_jenisterapioksigen').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b1_jmloksigenperliter'); ?>').val('');
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'b1_jmloksigenperliter'); ?>').attr('disabled',true);
    $('.formNeonatus').find('.b1_jenisterapioksigen').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
}

function choiseResikoJatuh_neonatus(obj){
    if($('.formNeonatus').find(obj).val() == 0 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formNeonatus').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').show();

        inputAllDisabled($('.formNeonatus').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formNeonatus').find('#panelresikojatuh_anak').find('#resikojatuhanak').hide();
        inputAllDisabled($('.formNeonatus').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formNeonatus').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').hide();
    } else if($('.formNeonatus').find(obj).val() == 1 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formNeonatus').find('#panelresikojatuh_anak').find('#resikojatuhanak').show();

        inputAllDisabled($('.formNeonatus').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formNeonatus').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
        inputAllDisabled($('.formNeonatus').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formNeonatus').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').hide();
    }
    else if($('.formNeonatus').find(obj).val() == 2 && $('.formNeonatus').find(obj).prop('checked')==true){
        inputAllEnabled($('.formNeonatus').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formNeonatus').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').show();

        inputAllDisabled($('.formNeonatus').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formNeonatus').find('#panelresikojatuh_anak').find('#resikojatuhanak').hide();
        inputAllDisabled($('.formNeonatus').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formNeonatus').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
    }
}

function resikojatuhdewasa_penilaian_neonatus(obj){
  if($('.formNeonatus').find(obj).val() =='Ya'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_skor') ?>').val(25);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_skor') ?>').val(0);
  }

    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function resikojatuhdewasa_diagnosa_neonatus(obj){
  if($('.formNeonatus').find(obj).val() =='Ya'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'diagnosismedis_skor') ?>').val(15);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'diagnosismedis_skor') ?>').val(0);
  }
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'diagnosismedis_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function resikojatuhdewasa_alatbantu_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'alatbantujalan_skor') ?>').val($(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'alatbantujalan_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function resikojatuhdewasa_terapi_neonatus(obj){
  if($('.formNeonatus').find(obj).val() =='Ya'){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_skor') ?>').val(20);
  }else{
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_skor') ?>').val(0);
  }
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function resikojatuhdewasa_berjalan_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'caraberjalan_skor') ?>').val($('.formNeonatus').find(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'caraberjalan_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function resikojatuhdewasa_mental_neonatus(obj){
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'statusmental_skor') ?>').val($('.formNeonatus').find(obj).val());
    $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'statusmental_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_neonatus();
}

function setRiwayatJatuh_neonatus(obj){
    if($('.formNeonatus').find('.resiko_jatuh_lansia').val() != '' && $('.formNeonatus').find('.resiko_jatuh_lansia').val() == 1){
        $('.formNeonatus').find('#riwayatJatuhRSLansia_0').attr('checked',true);
        $('.formNeonatus').find('#riwayatJatuhBulanLansia_0').attr('checked',true);
    }
    if($('.formNeonatus').find('#riwayatJatuhRSLansia_0').prop('checked')==true || $('.formNeonatus').find('#riwayatJatuhBulanLansia_0').prop('checked')==true){
        $('.formNeonatus').find('.resiko_jatuh_lansia').val(true);
        $('.formNeonatus').find('.skor_resiko_jatuh_lansia').val(6);
    }else if($('.formNeonatus').find('#riwayatJatuhRSLansia_0').prop('checked')==false || $('.formNeonatus').find('#riwayatJatuhBulanLansia_0').prop('checked')==false){
        $('.formNeonatus').find('.resiko_jatuh_lansia').val(false);
        $('.formNeonatus').find('.skor_resiko_jatuh_lansia').val(0);
    }
    skorresikojatuh_neonatus();
}

function setStatusMental_neonatus(obj){
    if($('.formNeonatus').find('.status_mental_lansia').val() != '' && $('.formNeonatus').find('.status_mental_lansia').val() == 1){
        $('.formNeonatus').find('#statusMentalDeliriumLansia_0').attr('checked',true);
        $('.formNeonatus').find('#statusMentalDisorientasiLansia_0').attr('checked',true);
        $('.formNeonatus').find('#statusMentalAgitasiLansia_0').attr('checked',true);
    }
     if($('.formNeonatus').find('#statusMentalDeliriumLansia_0').prop('checked')==true ||
           $('.formNeonatus').find('#statusMentalDisorientasiLansia_0').prop('checked')==true ||
           $('.formNeonatus').find('#statusMentalAgitasiLansia_0').prop('checked')==true){
            $('.formNeonatus').find('.status_mental_lansia').val(true);
            $('.formNeonatus').find('.skor_status_mental_lansia').val(14);
        }else if($('.formNeonatus').find('#statusMentalDeliriumLansia_0').prop('checked')==false ||
           $('.formNeonatus').find('#statusMentalDisorientasiLansia_0').prop('checked')==false ||
           $('.formNeonatus').find('#statusMentalAgitasiLansia_0').prop('checked')==false){
            $('.formNeonatus').find('.status_mental_lansia').val(false);
            $('.formNeonatus').find('.skor_status_mental_lansia').val(0);
        }
    skorresikojatuh_neonatus();
}

function setPengelihatan_neonatus(obj){
    if($('.formNeonatus').find('.penglihatan_lansia').val() != '' && $('.formNeonatus').find('.penglihatan_lansia').val() == 1){
        $('.formNeonatus').find('#penglihatanKacamataLansia_0').attr('checked',true);
        $('.formNeonatus').find('#penglihatanBuramLansia_0').attr('checked',true);
        $('.formNeonatus').find('#penglihatanKatarakLansia_0').attr('checked',true);
    }

     if($('.formNeonatus').find('#penglihatanKacamataLansia_0').prop('checked')==true ||
           $('.formNeonatus').find('#penglihatanBuramLansia_0').prop('checked')==true ||
           $('.formNeonatus').find('#penglihatanKatarakLansia_0').prop('checked')==true){
            $('.formNeonatus').find('.penglihatan_lansia').val(true);
            $('.formNeonatus').find('.skor_penglihatan_lansia').val(1);
        }else{
            $('.formNeonatus').find('.penglihatan_lansia').val(false);
            $('.formNeonatus').find('.skor_penglihatan_lansia').val(0);
        }
    skorresikojatuh_neonatus();
}

function setKebiasaanBerkemih_neonatus(obj){
     if ($('.formNeonatus').find(obj).val()=='1' && $('.formNeonatus').find(obj).prop('checked')==true){
            $('.formNeonatus').find('.skor_berkemih_lansia').val(2);
        }else if ($('.formNeonatus').find(obj).val()=='0' && $('.formNeonatus').find(obj).prop('checked')==true){
            $('.formNeonatus').find('.skor_berkemih_lansia').val(0);
        }
    skorresikojatuh_neonatus();
}

function getTransferLansia_neonatus(){
    if($('.formNeonatus').find('.transfer_mobilitas_lansia').val() != ''){
        var trs = '';
         $('.formNeonatus').find('#transferLansia').find('option').each(function(){
            if($(this).text() == $('.formNeonatus').find('.transfer_mobilitas_lansia').val()){
                trs = $(this).val();
            }
        });
        $('.formNeonatus').find('#transferLansia').val(trs);
    }

    if($('.formNeonatus').find('#transferLansia').val() != ""){
        $('.formNeonatus').find('.transfer_mobilitas_lansia').val($('.formNeonatus').find('#transferLansia').find('option:selected').text());
        $('.formNeonatus').find('#transferLansiaHidden').val($('.formNeonatus').find('#transferLansia').val());
    }else{
         $('.formNeonatus').find('.transfer_mobilitas_lansia').val("");
        $('.formNeonatus').find('#transferLansiaHidden').val(0);
    }

    totalTransferMobilitas_neonatus();
}

function getMobilitasLansia_neonatus(){
    if($('.formNeonatus').find('.mobilitas_lansia').val() != ''){
        var mob = '';
         $('.formNeonatus').find('#mobilitasLansia').find('option').each(function(){
            if($(this).text() == $('.formNeonatus').find('.mobilitas_lansia').val()){
                mob = $(this).val();
            }
        });
        $('.formNeonatus').find('#mobilitasLansia').val(mob);
    }

    if($('.formNeonatus').find('#mobilitasLansia').val() != ""){
        $('.formNeonatus').find('.mobilitas_lansia').val($('.formNeonatus').find('#mobilitasLansia').find('option:selected').text());
         $('.formNeonatus').find('#mobilitasLansiaHidden').val($('.formNeonatus').find('#mobilitasLansia').val());
    }else{
        $('.formNeonatus').find('.mobilitas_lansia').val("");
      $('.formNeonatus').find('#mobilitasLansiaHidden').val(0);
    }

    totalTransferMobilitas_neonatus();
}

function totalTransferMobilitas_neonatus(){
   var trf = $('.formNeonatus').find('#transferLansiaHidden').val();
   var mobil = $('.formNeonatus').find('#mobilitasLansiaHidden').val();
   var jumlah = parseInt(trf) + parseInt(mobil);
   var totalJml = 0;
   if (!isNaN(jumlah)) {
       if(jumlah >=0 && jumlah <= 3){
           totalJml = 0;
       }else{
           totalJml = 7;
       }
   }
   $('.formNeonatus').find('.skor_transfer_mobilitas_lansia').val(totalJml);
   skorresikojatuh_neonatus();
}

function gantiJumlah_neonatus(obj){
    var value = parseFloat($('.formNeonatus').find(obj).val());
    var teman = $('.formNeonatus').find(obj).parent('.groupUkurans').find('input[type="text"]');
    var valueTeman = parseFloat(teman.val());
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}

function gantiHidden_neonatus(){
    var defaultBB = parseFloat(0.001);
    var defaultTB = parseFloat(100);
    var valueBB = parseFloat($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
    var valueTB = parseFloat($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').val());

    if ($('.formNeonatus').find('#gram').val() != defaultBB){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB*defaultBB);
    }
    else{
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB);
    }

    if ($('.formNeonatus').find('#meter').val() != defaultTB){
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB*defaultTB);
    }
    else{
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB);
    }
}

function getBeratBadanIdeal_neonatus(){
    var beratBadan = parseFloat($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
    var tinggiBadan = parseFloat($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var jenisKelamin = $('.formNeonatus').find('#<?php echo CHtml::activeId($modPasien, 'jenis_kelamin') ?>').val();
    var hasil = Math.floor((beratBadan/((tinggiBadan / 100)*(tinggiBadan / 100))));

    if(isNaN(hasil)==true){
      hasil = 0;
    }
    if (hasil < 0){
        hasil = 0;
    }

    if (jenisKelamin == "<?php echo Params::JENIS_KELAMIN_PEREMPUAN; ?>"){
        //hasil = (tinggiBadan - 100) - ((15/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
    }
    else{
        //hasil = (tinggiBadan - 100) - ((10/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
    }
}

function getBMI_neonatus(){
    var beratBadan = parseFloat($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var tinggiBadan = parseFloat($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var hasil;

    hasil = (beratBadan/((tinggiBadan*tinggiBadan)/10000));
    if (jQuery.isNumeric(hasil)){
        $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText'); ?>', {bmi:hasil}, function(data){
            $('.formNeonatus').find('#imt').val(data.text);
            $('.formNeonatus').find('#imtValue').val(Math.floor(hasil));
        },'json');
    }
}

$(document).ready(function(){
  $('.formNeonatus').find('.groupUkurans').find('input').keyup(function(){
       gantiHidden_neonatus();
       getBeratBadanIdeal_neonatus();
       getBMI_neonatus();
   });
   getBeratBadanIdeal_neonatus();
   getBMI_neonatus();
   $('.formNeonatus').find('#informasiResikoJatuh').hide();
   $('.formNeonatus').find('#informasiResikoJatuh').html("");

    $('.formNeonatus').find('.neonatus_masalahperkawinanortu').each(function(){
        changeMasalahPerkawinan($(this));
    });

    $('.formNeonatus').find('.keb_eliminasi_bab_keluhanstatus').each(function(){
        setKebEliminasiBab_neonatus($(this));
    });
    $('.formNeonatus').find(".riwayatpembedahan_status").each(function(){
         setStatusPembedahanAnastesi_neonatus($(this));
     });

     $('.formNeonatus').find(".statusalergipasien").each(function(){
        setStatusAlergi_neonatus($(this));
     });

     $('.formNeonatus').find(".statusrokok").each(function(){
        setJumlahRokokNeunatus($(this));
     });

     $('.formNeonatus').find(".riwayatjatuh_3bln_terakhir").each(function(){
         changeInformasiResikoJatuh_neonatus($(this));
     });
    $('.formNeonatus').find(".riwayatjatuh_alatbantu").each(function(){
         changeInformasiResikoJatuh_neonatus($(this));
     });
     $('.formNeonatus').find(".jenisalatbantu").each(function(){
         changeInformasiResikoJatuh_neonatus($(this));
     });

     $('.formNeonatus').find(".pilih_SkrinningGizi").each(function(){
         choiseSkrinningGizi_neonatus($(this));
     });

     $('.formNeonatus').find(".pilih_resikoJatuh").each(function(){
          choiseResikoJatuh_neonatus($(this));
      });

      $('.formNeonatus').find('.riwayatJatuh').each(function(){
          setRiwayatJatuh_neonatus($(this));
      });

      $('.formNeonatus').find('.statusMentalLansia').each(function(){
          setStatusMental_neonatus($(this));
      });

      $('.formNeonatus').find('.penglihatanLansia').each(function(){
          setPengelihatan_neonatus($(this));
      });
      $('.formNeonatus').find('.kebiasaanBerkemihLansia').each(function(){
          setKebiasaanBerkemih_neonatus($(this));
      });

    setSumberData_neonatus();
    setStatusRiwayattransfusi_neonatus();
    setKetubanpecah();
    setKondisisaatlahir();
    changeTinggalBersama($('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'neonatus_tinggalbersama') ?>'));
    setKepalaLainnya();
    setStatusUbunubunbesar();
    setMulutLainnya();
    setPunggungLainnya();
    setEkstremitasLainnya();
    setStatusMata();
    setThtLainnya();
    setStatusThorax();
    setAbdomenLainnya();
    setGenitaKelainan();
    setGenitaliaLainnya();
    setKulitLainnya();
    setReflekMoro();
    setReflekRasping();
    setReflekSucking();
    setReflekRooting();
    setReflekStepping();
    setReflekSwallowing();
    setReflekBabinski();
    setReflekGlabela();
    setReflekNeck();
    setReflekLainnya();
    setKesadaranNyeri_neonatus();
    setAdaNyeri_neonatus();
    setKualitasNyeri_neonatus();
    setFrekuensiNyeri_neonatus();
    changeDeskripsinyeri_ismenjalar_neonatus();
    changeNyeriHilangLain_neonatus();
    setB2isoedem_neonatus();
    setB5Nyeritekan_neonatus();
    setB6Fraktur_neonatus();
    setB6ResikoDekubitus_neonatus();
    setB6Luka_neonatus();
    setKesulitanbernafas_neonatus();

    var indexSknFungsional = 0;
    $('.formNeonatus').find('.pilih_fungsional').each(function(){
        pilihFungsional_neonatus($(this));

        if(($('.formNeonatus').find(this).val() == 1 || $('.formNeonatus').find(this).val() == 2) && $('.formNeonatus').find(this).prop('checked')==false){
          indexSknFungsional++;
        }
    });

    if(indexSknFungsional==2){
        unpilihFungsional_neonatus();
    }

    setTimeout(function(){
      $('.formNeonatus').find('.pilih_nyeri').each(function(){
          pilihNyeri_neonatus($(this));
      });
    }, 500);

    var skor = $('.formNeonatus').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val();
    if (skor != "") {
        $('.formNeonatus').find(".nyeri-nomor").css("border-radius", "5px");
        $('.formNeonatus').find("#nyerinomor_" + skor).css("border", "1px solid black");
    }


  $('#checkSimpanData').val('');
  $('.formNeonatus').find('#rootwizardAskepNeonatus').bootstrapWizard({
    tabClass: "",
      onTabShow: function($tab, $navigation, index)
      {
        setCurrentProgressTab($(this), $navigation, $tab, $(this).find(".steps-progress div"), index);
      },
      onPrevious: function(tab, navigation, index){
        //alert('prev');
      },
      onNext: function(tab, navigation, index){
        var postdata = $('.formNeonatus').find('#riaskepneonatus-t-form');
        var indexStepNeonatus = 8;

        var cek = simpanDataFormNeunatus(postdata, index);
        if(index == indexStepNeonatus && cek==true){
            $('.formNeonatus').find('.next').hide();
        }else{
          $('.formNeonatus').find('.next').show();
        }

        return cek;
        // return true;
      },
      onTabClick: function(tab, navigation, index){
        // alert('assdssds');
      }
    });
});

</script>
