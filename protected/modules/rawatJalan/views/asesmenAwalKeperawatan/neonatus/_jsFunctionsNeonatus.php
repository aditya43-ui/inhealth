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
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat_neonatus') ?>').attr('readonly',false);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan_neonatus') ?>').attr('readonly',false);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya_neonatus') ?>').attr('readonly',false);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'ispasangtandaalergi_neonatus') ?>').attr('checked',true);

    }else{
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat_neonatus') ?>').attr('readonly',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan_neonatus') ?>').attr('readonly',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya_neonatus') ?>').attr('readonly',true);
        $('.formNeonatus').find('#<?php echo CHtml::activeId($model,'ispasangtandaalergi_neonatus') ?>').attr('checked',false);
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
        $('.formNeonatus').find('#RJAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('disabled',false);
    }else{
        $('.formNeonatus').find('#RJAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('disabled',true);
        $('.formNeonatus').find('#RJAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').val('');
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
    dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[pendaftaran_id]',value:pendaftaran_id});
    dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[pasienadmisi_id]',value:pasienadmisi_id});
    dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[pasien_id]',value:pasien_id});
    dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[jenisasesmen]',value:jenisasesmen});
    dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[asesmenawalkeperawatan_id]',value:asesmenawalkeperawatan_id});
    dataSerialized.push({name: 'RJAsesmenkebutuhanEdukasiT[pendaftaran_id]',value:pendaftaran_id});
    dataSerialized.push({name: 'RJAsesmenkebutuhanEdukasiT[pasienadmisi_id]',value:pasienadmisi_id});

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
      dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[pendaftaran_id]',value:pendaftaran_id});
      dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[pasienadmisi_id]',value:pasienadmisi_id});
      dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[pasien_id]',value:pasien_id});
      dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[jenisasesmen]',value:jenisasesmen});
      dataSerialized.push({name: 'RJAsesmenawalkeperawatanT[asesmenawalkeperawatan_id]',value:asesmenawalkeperawatan_id});
      dataSerialized.push({name: 'RJAsesmenkebutuhanEdukasiT[pendaftaran_id]',value:pendaftaran_id});
      dataSerialized.push({name: 'RJAsesmenkebutuhanEdukasiT[pasienadmisi_id]',value:pasienadmisi_id});

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

$(document).ready(function(){
    $('.formNeonatus').find('.neonatus_masalahperkawinanortu').each(function(){
        changeMasalahPerkawinan($(this));
    });

    $('.formNeonatus').find('.keb_eliminasi_bab_keluhanstatus').each(function(){
        setKebEliminasiBab_neonatus($(this));
    });

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
        var cek = simpanDataFormNeunatus(postdata, index);
        if(index == 3 && cek==true){
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
