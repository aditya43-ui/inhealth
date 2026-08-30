<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function simpanAllData_obgyn(){
  if(requiredCheck($('.formObgyn').find("#askepobgynri-t-form"))){
    var indexNext = $('.formObgyn').find('#rootwizardAskepObgyn').data('bootstrapWizard').nextIndex();
    var indexstep = $('.formObgyn').find('#rootwizardAskepObgyn').data('bootstrapWizard').currentIndex();
    $(".formObgyn").addClass("animation-loading");
    $('.formObgyn').find(".integer-decimal, .integer2, .float2").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
    var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
    var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
    var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
    var jenisasesmen = $('#choise_obgyn').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
    var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

    var dataSerialized = $('.formObgyn').find('#askepobgynri-t-form').serializeArray();
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
              suksesData = true;
              $('.formObgyn').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              $.fn.yiiGridView.update('riwayataskep-grid', {
                  data: $(this).serialize()
              });
            }else{
              $('.formObgyn').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
            }
            if(suksesData==true){
              setTimeout(function(){
                  $('.formObgyn').find('.divAlert').html('');
              }, 5000);
            }
          }else{
              $('.formObgyn').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');

          }
          $(".formObgyn").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formDewasa").removeClass("animation-loading");}
    });
  }
}

function simpanDataForm_obgyn(simpanDt, indexstep, handeland){
  var suksesData = false;
    if(requiredCheck($('.formObgyn').find(simpanDt))){
      var indexNext = $('.formObgyn').find('#rootwizardAskepObgyn').data('bootstrapWizard').nextIndex();
      $(".formObgyn").addClass("animation-loading");
      $('.formObgyn').find(".integer-decimal, .integer2, .float2").each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
      var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
      var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
      var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
      var jenisasesmen = $('#choise_obgyn').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
      var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

      if(indexstep > 1){
        $('#checkSimpanData').val('simpan');
      }else if (indexstep == 1){
        $('#checkSimpanData').val('');
      }

      var checksimpan = $('#checkSimpanData').val();

      var dataSerialized = $('.formObgyn').find(simpanDt).serializeArray();
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
                $('.formObgyn').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                $.fn.yiiGridView.update('riwayataskep-grid', {
                    data: $(this).serialize()
                });
              }else{
                $('.formObgyn').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              }

              if(suksesData==true){
                setTimeout(function(){
                    $('.formObgyn').find('.divAlert').html('');
                }, 5000);
              }


            }else{
                $('.formObgyn').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
            }
            $(".formObgyn").removeClass("animation-loading");
          },
          error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formDewasa").removeClass("animation-loading");}
      });
    }
    return suksesData;
}

function setStatusAlergi_obgyn(obj){
    var parentForm = $(obj).parents().find('.formObgyn');
    var value = $(parentForm).find(obj).val();

    if(value === '3' && $(parentForm).find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('readonly',false);
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('readonly',false);
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('readonly',false);
    }else{
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('readonly',true);
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('readonly',true);
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('readonly',true);
    }
}

function setStatusPembedahanAnastesi_obgyn(obj){
  var parentForm = $(obj).parents().find('.formDewasa');
    var value = $(parentForm).find(obj).val();

    if($('.formObgyn').find('.riwayatpembedahan_status').length > 0){
        for(var i=0; i<$('.formObgyn').find('.riwayatpembedahan_status').length; i++){
            if($('.formObgyn').find('.riwayatpembedahan_status').eq(i).prop('checked') === true && $('.formObgyn').find('.riwayatpembedahan_status').eq(i).val()=='Pernah'){
                $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('readonly',false);
            }else if($('.formObgyn').find('.riwayatpembedahan_status').eq(i).prop('checked') === true && $('.formObgyn').find('.riwayatpembedahan_status').eq(i).val()=='Tidak Pernah'){
                $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('readonly',true);
                $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').val('');
            }
        }
    }
}

function setStatusRiwayattransfusi_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.riwayattransfusi_status').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',false);
      $('.formObgyn').find('.riwayattransfusi_isreaksi').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',true);
    $('.formObgyn').find('.riwayattransfusi_isreaksi').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
  setReaksiRiwayattransfusi_obgyn();
}

function setReaksiRiwayattransfusi_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.riwayattransfusi_isreaksi').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',true);
  }
}

function setSumberData_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.sumberdata').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',true);
  }
}

function setJumlahRokok_obgyn(obj){
   var value = $('.formObgyn').find(obj).val();

   if(value === '1' && $('.formObgyn').find(obj).prop('checked')==true){
       $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'jmlrokok_btg_hr') ?>').attr('readonly',false);
   }else if(value === '0' && $('.formObgyn').find(obj).prop('checked')==true){
       $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'jmlrokok_btg_hr') ?>').attr('readonly',true);
   }
}

function returnValue_obgyn(obj){
  var value = $('.formObgyn').find(obj).val();
  var attrID = $('.formObgyn').find(obj).attr('id');

  var td = $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val();
  var splitTD = td.split(' / ');

  if (attrID == $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'td_diastolic') ?>').attr('id')){
     splitTD[0] = splitTD[0].replace(/_/gi, "0");
     $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val(splitTD[0]+' / '+value);
  }
  else if (attrID == $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'td_systolic') ?>').attr('id')){
     splitTD[1] = splitTD[1].replace(/_/gi, "0");
     $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val(value+' / '+splitTD[1]);
  }
}

function gantiJumlah_obgyn(obj){
  var value = parseFloat($('.formObgyn').find(obj).val());
  var teman = $('.formObgyn').find(obj).parent('.groupUkurans').find('input[type="text"]');
  var valueTeman = parseFloat(teman.val());
  var hasil;

  hasil = valueTeman*value;
  teman.val(hasil);
}

function gantiHidden_obgyn(){
  var defaultBB = parseFloat(0.001);
  var defaultTB = parseFloat(100);
  var valueBB = parseFloat($('.formObgyn').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
  var valueTB = parseFloat($('.formObgyn').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').val());

  if ($('.formObgyn').find('#gram').val() != defaultBB){
     $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB*defaultBB);
  }
  else{
     $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB);
  }

  if ($('.formObgyn').find('#meter').val() != defaultTB){
     $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB*defaultTB);
  }
  else{
     $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB);
  }
}

function getBeratBadanIdeal_obgyn(){
  var beratBadan = parseFloat($('.formObgyn').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
  var tinggiBadan = parseFloat($('.formObgyn').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
  var jenisKelamin = $('.formObgyn').find('#<?php echo CHtml::activeId($modPasien, 'jenis_kelamin') ?>').val();
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
     $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
  }
  else{
     //hasil = (tinggiBadan - 100) - ((10/100)*(tinggiBadan-100));
     if (hasil < 0){
         hasil = 0;
     }
     $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
  }
}

function getBMI_obgyn(){
  var beratBadan = parseFloat($('.formObgyn').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
  var tinggiBadan = parseFloat($('.formObgyn').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
  var hasil;

  hasil = (beratBadan/((tinggiBadan*tinggiBadan)/10000));
  if (jQuery.isNumeric(hasil)){
     $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText'); ?>', {bmi:hasil}, function(data){
         $('.formObgyn').find('#imt').val(data.text);
         $('.formObgyn').find('#imtValue').val(Math.floor(hasil));
     },'json');
  }
}

function getText_obgyn(){
  var dias = parseFloat($('.formObgyn').find('#<?php echo CHtml::activeId($model, 'td_diastolic') ?>').val());
  var sys = parseFloat($('.formObgyn').find('#<?php echo CHtml::activeId($model, 'td_systolic') ?>').val());
  var arteri = ((sys+(2*dias))/3);

  if (jQuery.isNumeric(dias)){
     if (jQuery.isNumeric(sys)){
         $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/GetTextTekananDarah'); ?>', {diastolic:dias, systolic:sys}, function(data){
             if (data.text == null){
                 $('.formObgyn').find('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
             } else {
                 $('.formObgyn').find('#tekananDarah').val(data.text);
             }
         },'json');
         $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'meanarteripressure') ?>').val(arteri.toFixed(2));
     }
  }
}

function setStatusKontrolRisiko_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.kontrolrisikoinfeksi_status').each(function(){
    if($(this).val()=='Diketahui' &&  $(this).prop('checked')==true){
      indexLainnya = 1;
      $('.formObgyn').find('.jenisrisiko').each(function(){
        $(this).attr('disabled',false);
      });
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formObgyn').find('.jenisrisiko').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
  }
  $('.formObgyn').find('.jenisrisiko').each(function(){
    setJenisRisikoLainnya_obgyn($(this));
  });
}

function setJenisRisikoLainnya_obgyn(obj){
  if($('.formObgyn').find(obj).attr('datavalue')== 'Lainnya' && $('.formObgyn').find(obj).prop('checked') == true){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'jenisrisikoinfeksi_lainnya'); ?>').attr('readonly',false);
  }else{
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'jenisrisikoinfeksi_lainnya'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'jenisrisikoinfeksi_lainnya'); ?>').attr('readonly',true);
  }
}

function setAnak_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.isada_anak').each(function(){
    if($(this).val()=='Ada' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'jml_anak'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'jml_anak'); ?>').val('0');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'jml_anak'); ?>').attr('readonly',true);
  }
}

function changeTinggalBersama_obgyn(obj){
    var value = $('.formObgyn').find(obj).val();

    if(value === 'Lainnya'){
      $('.formObgyn').find('.tinggalbersama').attr('disabled',false);
    }else{
      $('.formObgyn').find('.tinggalbersama').val('');
      $('.formObgyn').find('.tinggalbersama').attr('disabled',true);
    }
}

function setMasalahDlmBerbicara_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.masalahdlm_berbicara').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'masalahbicara_ket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'masalahbicara_ket'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'masalahbicara_ket'); ?>').attr('readonly',true);
  }
}

function setEduBahasaSehari_obgyn(obj){
    if($('.formObgyn').find(obj).val()==='Daerah' && $('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama') ?>').attr('readonly',false);
    }else if($('.formObgyn').find(obj).val()==='Indonesia' && $('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama') ?>').attr('readonly',true);
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama') ?>').val('');
    }
}

function setEdukasiPenerjemah_obgyn(obj){
    if($('.formObgyn').find(obj).val()==='Ya' && $('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').attr('readonly',false);
    }else if($('.formObgyn').find(obj).val()==='Tidak' && $('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').attr('readonly',true);
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').val('');
    }
}

function pilihFungsional_obgyn(obj){
    if($('.formObgyn').find(obj).val() == 1 && $('.formObgyn').find(obj).prop('checked')==true){
        inputAllEnabled($('.formObgyn').find('#pilih_fungsional').find('.panel-body'));
        $('.formObgyn').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').show();

        inputAllDisabled($('.formObgyn').find('#pilih_fungsionaladl').find('.panel-body'));
       $('.formObgyn').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').hide();
    }else if($('.formObgyn').find(obj).val() == 2 && $('.formObgyn').find(obj).prop('checked')==true){
        inputAllEnabled($('.formObgyn').find('#pilih_fungsionaladl').find('.panel-body'));
        $('.formObgyn').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').show();

        inputAllDisabled($('.formObgyn').find('#pilih_fungsional').find('.panel-body'));
        $('.formObgyn').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').hide();
    }
}

function unpilihFungsional_obgyn(){
  inputAllDisabled($('.formObgyn').find('#pilih_fungsional').find('.panel-body'));
  $('.formObgyn').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').hide();

  inputAllDisabled($('.formObgyn').find('#pilih_fungsionaladl').find('.panel-body'));
 $('.formObgyn').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').hide();
}

function klikBtnMakan_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_makan') ?>').val(nilai);
skorskrinningfungsional_obgyn();
}

function klikBtnToilet_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_aktifitastoilet') ?>').val(nilai);
skorskrinningfungsional_obgyn();
}

function klikBtnRodaTidur_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpindahkursi') ?>').val(nilai);
skorskrinningfungsional_obgyn();
}

function klikBtnGosokGigi_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_kebersihanmandiri') ?>').val(nilai);
skorskrinningfungsional_obgyn();
}

function klikBtnMandi_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mandi') ?>').val(nilai);
skorskrinningfungsional_obgyn();
}

function klikBtnBerjalanDasar_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berjalanpermukaankasar') ?>').val(nilai);
skorskrinningfungsional_obgyn();
}

function klikBtnNaikTangga_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_naikturuntangga') ?>').val(nilai);
skorskrinningfungsional_obgyn();
}

function klikBtnBerpakaian_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpakaian') ?>').val(nilai);
skorskrinningfungsional_obgyn();
}

function klikBtnDefekasi_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontroldefekasi') ?>').val(nilai);
    skorskrinningfungsional_obgyn();
}

function klikBtnBerkemih_obgyn(nilai){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontrolberkemih') ?>').val(nilai);
    skorskrinningfungsional_obgyn();
}

function skorskrinningfungsional_obgyn(){
    var totalSkor = 0;

    $('.formObgyn').find('#tblInputFungsional').find('.skinningfungsional_skor').each(function(){
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

    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_jumlah_skor') ?>').val(totalSkor);
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_keterangan') ?>').val(keterangan);
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_kategori') ?>').val(kategori);
}

function klikBtnAdl_obgyn(skor, type){
  if(type == 'bab'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_bab'); ?>').val(skor);
  }else if(type == 'bak'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_bak'); ?>').val(skor);
  }else if(type == 'kebersihan'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_kebersihanmandiri'); ?>').val(skor);
  }else if(type == 'penggunaanjamban'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_pengunaanjamban'); ?>').val(skor);
  }else if(type == 'makan'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_makan'); ?>').val(skor);
  }else if(type == 'sikap'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_sikap'); ?>').val(skor);
  }else if(type == 'pindah'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_berpindah'); ?>').val(skor);
  }else if(type == 'baju'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_baju'); ?>').val(skor);
  }else if(type == 'tangga'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_naikturuntangga'); ?>').val(skor);
  }else if(type == 'mandi'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_mandi'); ?>').val(skor);
  }

  var skor = 0;
  var keterangan = "";

  $('.formObgyn').find('#tblInputFungsionalAdl').find('.skinningfungsionaladl_skor').each(function(){
    var skorAdl = $('.formObgyn').find(this).val();

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

  $('.formObgyn').find('#tblInputFungsionalAdl').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_jumlah_skor'); ?>').val(skor);
  $('.formObgyn').find('#tblInputFungsionalAdl').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_keterangan'); ?>').val(keterangan);
}

function choiseSkrinningGizi_obgyn(obj){
    if($('.formObgyn').find(obj).val() == 1 && $('.formObgyn').find(obj).prop('checked')==true){
        inputAllEnabled($('.formObgyn').find('#skrinninggizi_dewasa_panel'));
        $('.formObgyn').find('#skrinninggizi_dewasa_panel').show();

        inputAllDisabled($('.formObgyn').find('#skrinninggizi_anak_panel'));
        $('.formObgyn').find('#skrinninggizi_anak_panel').hide();
    } else if($('.formDewasa').find(obj).val() == 0 && $('.formObgyn').find(obj).prop('checked')==true){
        inputAllEnabled($('.formObgyn').find('#skrinninggizi_anak_panel'));
        $('.formObgyn').find('#skrinninggizi_anak_panel').show();

        inputAllDisabled($('.formObgyn').find('#skrinninggizi_dewasa_panel'));
        $('.formObgyn').find('#skrinninggizi_dewasa_panel').hide();
    }
}

function skorskrinninggizi_obgyn(){
    var totalSkorDewasa = 0;
    var totalSkorAnak = 0;

    $('.formObgyn').find('#tblInputSkrinningGiziDewasa').find('.skrinninggizidewasa_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorDewasa += parseInt(skor);
    });

    $('.formObgyn').find('#tblInputSkrinningGiziAnak').find('.skrinninggizianak_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorAnak += parseInt(skor);
    });
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_totaldewasa') ?>').val(totalSkorDewasa);
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_totalanak') ?>').val(totalSkorAnak);

    var ketdewasa = "";
    var risDewasa = "";

    if(totalSkorDewasa <= 1){
      ketdewasa = "Lakukan skrinning setiap 7 hari";
      risDewasa = "Resiko Rendah";
    }else if(totalSkorDewasa >= 2 && totalSkorDewasa <= 3){
      ketdewasa = "Lakukan pengkajian gizi lebih lanjut oleh ahli gizi";
      risDewasa = "Resiko Sedang";
    }else if(totalSkorDewasa >= 4){
      ketdewasa = "Lakukan pengkajian gizi lebih lanjut oleh ahli gizi";
      risDewasa = "Resiko Tinggi";
    }

    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrininggizidewasa_resiko') ?>').val(risDewasa);
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrininggizidewasa_tindakanygdilakukan') ?>').val(ketdewasa);
}

function skrinninggizidewasa_penurunbb_obgyn(obj){
  if($('.formObgyn').find(obj).val() != ''){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val($(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penurunanbb_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val(0);
  }
  skorskrinninggizi_obgyn();
}

function skrinninggizidewasa_asupan_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_asupanmakanan_dewasa') ?>').val($(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_asupanmakanan_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_obgyn();
}

function setKesadaranNyeri_obgyn(){
  var indexLainnya = 0;
  $('.formObgyn').find('.kesadaranpasien_pengkajiannyeri').each(function(){
    if($(this).val()=='Sadar' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('.panelsadar').show();
      $('.formObgyn').find('.paneltidaksadar').hide();
      indexLainnya += 1;
    }else if($(this).val()=='Tidak Sadar' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('.panelsadar').hide();
      $('.formObgyn').find('.paneltidaksadar').show();
      indexLainnya += 1;
    }
  });

  if(indexLainnya == 0){
    $('.formObgyn').find('.panelsadar').hide();
    $('.formObgyn').find('.paneltidaksadar').hide();
  }
}

function venekpresi_obgyn(obj){
  if($('.formObgyn').find(obj).val() != ''){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahskor') ?>').val($(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahpenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahskor') ?>').val(0);
  }
    skorventilator_obgyn();
}

function venekstremitas_obgyn(obj){
  if($('.formObgyn').find(obj).val() != ''){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasatasskor') ?>').val($(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasataspenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasatasskor') ?>').val(0);
  }
    skorventilator_obgyn();
}

function venpatuh_obgyn(obj){
  if($('.formObgyn').find(obj).val() != ''){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorskor') ?>').val($(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorpenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorskor') ?>').val(0);
  }
    skorventilator_obgyn();
}

function skorventilator_obgyn(){
    var totalSkor = 0;

    $('.formObgyn').find('#tbl_ventilator').find('.skor_ventilator').each(function(){
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

    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'score_skalanyeri') ?>').val(totalSkor);
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'keteranganskala_nyeri') ?>').val(risDewasa);
}

function pilihScala_obgyn(skor){
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
        $('.formObgyn').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val(skor);
        $('.formObgyn').find("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").val(keterangan);
    //}

    $('.formObgyn').find(".nyeri-nomor").css("border", "none");
    $('.formObgyn').find(".nyeri-nomor").css("border-radius", "5px");
    $('.formObgyn').find("#nyerinomor_" + skor).css("border", "1px solid black");
}

function setAdaNyeri_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.isadakeluhannyeri').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('.jenisnyeri').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('.jenisnyeri').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
  }
}

function setKualitasNyeri_obgyn(){
  $('.formObgyn').find('.kualitasnyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',false);
      }else{
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').val('');
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',true);
      }
  });
}

function changeDeskripsinyeri_ismenjalar_obgyn(obj){
    if($('.formObgyn').find(obj).val()==='1'){
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('readonly',false);
    }else{
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('readonly',true);
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').val('');
    }
}

function setFrekuensiNyeri_obgyn(){
  $('.formObgyn').find('.frekuensinyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',false);
      }else{
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').val('');
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',true);
      }
  });
}

function changeNyeriHilangLain_obgyn(obj){
    if($('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',false);
    }else{
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',true);
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').val('');
    }
}

function choiseResikoJatuh_obgyn(obj){
    if($('.formObgyn').find(obj).val() == 0 && $('.formObgyn').find(obj).prop('checked')==true){
        inputAllEnabled($('.formObgyn').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formObgyn').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').show();

        inputAllDisabled($('.formObgyn').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formObgyn').find('#panelresikojatuh_anak').find('#resikojatuhanak').hide();
        inputAllDisabled($('.formObgyn').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formObgyn').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').hide();
    } else if($('.formObgyn').find(obj).val() == 1 && $('.formObgyn').find(obj).prop('checked')==true){
        inputAllEnabled($('.formObgyn').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formObgyn').find('#panelresikojatuh_anak').find('#resikojatuhanak').show();

        inputAllDisabled($('.formObgyn').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formObgyn').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
        inputAllDisabled($('.formObgyn').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formObgyn').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').hide();
    }
    else if($('.formObgyn').find(obj).val() == 2 && $('.formObgyn').find(obj).prop('checked')==true){
        inputAllEnabled($('.formObgyn').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formObgyn').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').show();

        inputAllDisabled($('.formObgyn').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formObgyn').find('#panelresikojatuh_anak').find('#resikojatuhanak').hide();
        inputAllDisabled($('.formObgyn').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formObgyn').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
    }
}

function resikojatuhdewasa_penilaian_obgyn(obj){
  if($('.formObgyn').find(obj).val() =='Ya'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_skor') ?>').val(25);
  }else{
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_skor') ?>').val(0);
  }

    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhdewasa_diagnosa_obgyn(obj){
  if($('.formObgyn').find(obj).val() =='Ya'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'diagnosismedis_skor') ?>').val(15);
  }else{
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'diagnosismedis_skor') ?>').val(0);
  }
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'diagnosismedis_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhdewasa_alatbantu_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'alatbantujalan_skor') ?>').val($(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'alatbantujalan_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhdewasa_terapi_obgyn(obj){
  if($('.formObgyn').find(obj).val() =='Ya'){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_skor') ?>').val(20);
  }else{
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_skor') ?>').val(0);
  }
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhdewasa_berjalan_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'caraberjalan_skor') ?>').val($('.formDewasa').find(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'caraberjalan_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhdewasa_mental_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'statusmental_skor') ?>').val($('.formDewasa').find(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'statusmental_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhanak_usia_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skor_usia_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'usia_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhanak_jeniskelamin_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skor_jeniskelamin_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'jeniskelamin_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhanak_diagnosa_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skor_diagnosa_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'diagnosa_asessment_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhanak_gangguan_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skor_gangguan_kognitif_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'gangguan_kognitif_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}


function resikojatuhanak_faktor_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skor_faktor_lingkungan_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'faktor_lingkungan_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}


function resikojatuhanak_respon_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skor_responterhadap_pembedahan_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'responterhadap_pembedahan_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function resikojatuhanak_bedah_obgyn(obj){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'skor_medikamentosa_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'penggunaan_medikamentosa') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_obgyn();
}

function skorresikojatuh_obgyn(){
    var totalSkorDewasa = 0;
    var totalSkorAnak = 0;
    var totalSkorLansia = 0;

    $('.formObgyn').find('#tblResikojatuhDewasa').find('.resikojatuhdewasa_skor').each(function(){
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

    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'resikojatuh_skor') ?>').val(totalSkorDewasa);
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'resikojatuh_keterangan') ?>').val(ketResikoDewasa);

    $('.formObgyn').find('#tblResikojatuhAnak').find('.resikojatuhanak_skor').each(function(){
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

    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'jumlah_skor_anak') ?>').val(totalSkorAnak);
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'keterangan_resiko_jatuh_anak') ?>').val(ketResikoAnak);

    $('.formObgyn').find('#tblResikojatuhLansia').find('.resikojatuhlansia_skor').each(function(){
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
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'jumlah_skor_lansia') ?>').val(totalSkorLansia);
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'keterangan_skor_lansia') ?>').val(ketResikoLansia);

    // var objPanel = $('.formDewasa').find('#<?php //echo CHtml::activeId($model,'isresikojatuh') ?>');

    $('.formObgyn').find('.pilih_resikoJatuh').each(function(){
      if($('.formObgyn').find(this).val() == 0 && $('.formObgyn').find(this).prop('checked')==true){
          $('.formObgyn').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoDewasa);
      }else if($('.formObgyn').find(this).val() == 0 && $('.formObgyn').find(this).prop('checked')==true){
         <?php if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR){ ?>
             $('.formObgyn').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val("Resiko Tinggi");
         <?php }else{ ?>
             $('.formObgyn').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoAnak);
          <?php } ?>
      }else if($('.formObgyn').find(this).val() == 0 && $('.formObgyn').find(this).prop('checked')==true){
          $('.formObgyn').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoLansia);
      }
    });
}

function setAdaresikojatuh_obgyn(obj){
    if($('.formObgyn').find(obj).val() == 0 && $('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').attr('readonly',true);
    }else if($('.formObgyn').find(obj).val() == 1 && $('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').attr('readonly',false);
    }
}

function changeInformasiResikoJatuh_obgyn(obj){
   var html = "Lakukan intervensi pencegahan resiko jatuh: Beritahu pendamping untuk tidak meninggalkan pasien";
    if($('.formObgyn').find(obj).val() === 'Kursi Roda' && $('.formObgyn').find(obj).prop('checked')===true && $('.formObgyn').find(obj).hasClass('jenisalatbantu')){
        html = "Lakukan intervensi pencegahan resiko jatuh: Beritahu pendamping untuk tidak meninggalkan pasien dan pastikan kursi roda terkunci";
    }

    if($('.formObgyn').find(obj).val() === 'Lainnya' && $('.formObgyn').find(obj).prop('checked')===true && $('.formObgyn').find(obj).hasClass('jenisalatbantu')){
        $('.formObgyn').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',false);
    }else if($('.formObgyn').find(obj).val() !== 'Lainnya' && $('.formObgyn').find(obj).prop('checked')===true && $('.formObgyn').find(obj).hasClass('jenisalatbantu')){
        $('.formObgyn').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',true);
    }

    if($('.formObgyn').find(obj).val() === '1' && $('.formObgyn').find(obj).prop('checked')===true && $('.formObgyn').find(obj).hasClass('riwayatjatuh_alatbantu')){
        $('.formObgyn').find('.jenisalatbantu').attr('disabled',false);
    }else{
        if($('.formObgyn').find(obj).val() === '0' && $('.formObgyn').find(obj).prop('checked')===true  && $('.formObgyn').find(obj).hasClass('riwayatjatuh_alatbantu')){
            $('.formObgyn').find('.jenisalatbantu').attr('disabled',true);
            $('.formObgyn').find('.jenisalatbantu').attr('checked',false);
            $('.formObgyn').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',true);
        }
    }
    if($('.formObgyn').find('.riwayatjatuh_alatbantu').prop('checked')===true && $('.formObgyn').find('.riwayatjatuh_3bln_terakhir').prop('checked')===false){
        $('.formObgyn').find('#informasiResikoJatuh').hide();
        $('.formObgyn').find('#informasiResikoJatuh').html("");
    }else{
        $('.formObgyn').find('#informasiResikoJatuh').show();
        $('.formObgyn').find('#informasiResikoJatuh').html(html);
    }

    if($('.formObgyn').find('.riwayatjatuh_alatbantu').prop('checked')===false && $('.formObgyn').find('.riwayatjatuh_3bln_terakhir').prop('checked')===false){
        $('.formObgyn').find('#informasiResikoJatuh').hide();
        $('.formObgyn').find('#informasiResikoJatuh').html("");
    }
}

function setRiwayatJatuh_obgyn(obj){
    if($('.formObgyn').find('.resiko_jatuh_lansia').val() != '' && $('.formObgyn').find('.resiko_jatuh_lansia').val() == 1){
        $('.formObgyn').find('#riwayatJatuhRSLansia_0').attr('checked',true);
        $('.formObgyn').find('#riwayatJatuhBulanLansia_0').attr('checked',true);
    }
    if($('.formObgyn').find('#riwayatJatuhRSLansia_0').prop('checked')==true || $('.formObgyn').find('#riwayatJatuhBulanLansia_0').prop('checked')==true){
        $('.formObgyn').find('.resiko_jatuh_lansia').val(true);
        $('.formObgyn').find('.skor_resiko_jatuh_lansia').val(6);
    }else if($('.formObgyn').find('#riwayatJatuhRSLansia_0').prop('checked')==false || $('.formObgyn').find('#riwayatJatuhBulanLansia_0').prop('checked')==false){
        $('.formObgyn').find('.resiko_jatuh_lansia').val(false);
        $('.formObgyn').find('.skor_resiko_jatuh_lansia').val(0);
    }
    skorresikojatuh_obgyn();
}

function setStatusMental_obgyn(obj){
    if($('.formObgyn').find('.status_mental_lansia').val() != '' && $('.formObgyn').find('.status_mental_lansia').val() == 1){
        $('.formObgyn').find('#statusMentalDeliriumLansia_0').attr('checked',true);
        $('.formObgyn').find('#statusMentalDisorientasiLansia_0').attr('checked',true);
        $('.formObgyn').find('#statusMentalAgitasiLansia_0').attr('checked',true);
    }
     if($('.formObgyn').find('#statusMentalDeliriumLansia_0').prop('checked')==true ||
           $('.formObgyn').find('#statusMentalDisorientasiLansia_0').prop('checked')==true ||
           $('.formObgyn').find('#statusMentalAgitasiLansia_0').prop('checked')==true){
            $('.formObgyn').find('.status_mental_lansia').val(true);
            $('.formObgyn').find('.skor_status_mental_lansia').val(14);
        }else if($('.formObgyn').find('#statusMentalDeliriumLansia_0').prop('checked')==false ||
           $('.formObgyn').find('#statusMentalDisorientasiLansia_0').prop('checked')==false ||
           $('.formObgyn').find('#statusMentalAgitasiLansia_0').prop('checked')==false){
            $('.formObgyn').find('.status_mental_lansia').val(false);
            $('.formObgyn').find('.skor_status_mental_lansia').val(0);
        }
    skorresikojatuh_obgyn();
}

function setPengelihatan_obgyn(obj){
    if($('.formObgyn').find('.penglihatan_lansia').val() != '' && $('.formObgyn').find('.penglihatan_lansia').val() == 1){
        $('.formObgyn').find('#penglihatanKacamataLansia_0').attr('checked',true);
        $('.formObgyn').find('#penglihatanBuramLansia_0').attr('checked',true);
        $('.formObgyn').find('#penglihatanKatarakLansia_0').attr('checked',true);
    }

     if($('.formObgyn').find('#penglihatanKacamataLansia_0').prop('checked')==true ||
           $('.formObgyn').find('#penglihatanBuramLansia_0').prop('checked')==true ||
           $('.formObgyn').find('#penglihatanKatarakLansia_0').prop('checked')==true){
            $('.formObgyn').find('.penglihatan_lansia').val(true);
            $('.formObgyn').find('.skor_penglihatan_lansia').val(1);
        }else{
            $('.formObgyn').find('.penglihatan_lansia').val(false);
            $('.formObgyn').find('.skor_penglihatan_lansia').val(0);
        }
    skorresikojatuh_obgyn();
}

function setKebiasaanBerkemih_obgyn(obj){
     if ($('.formObgyn').find(obj).val()=='1' && $('.formObgyn').find(obj).prop('checked')==true){
            $('.formObgyn').find('.skor_berkemih_lansia').val(2);
        }else if ($('.formObgyn').find(obj).val()=='0' && $('.formObgyn').find(obj).prop('checked')==true){
            $('.formObgyn').find('.skor_berkemih_lansia').val(0);
        }
    skorresikojatuh_obgyn();
}

function getTransferLansia_obgyn(){
    if($('.formObgyn').find('.transfer_mobilitas_lansia').val() != ''){
        var trs = '';
         $('.formObgyn').find('#transferLansia').find('option').each(function(){
            if($(this).text() == $('.formObgyn').find('.transfer_mobilitas_lansia').val()){
                trs = $(this).val();
            }
        });
        $('.formObgyn').find('#transferLansia').val(trs);
    }

    if($('.formObgyn').find('#transferLansia').val() != ""){
        $('.formObgyn').find('.transfer_mobilitas_lansia').val($('.formObgyn').find('#transferLansia').find('option:selected').text());
        $('.formObgyn').find('#transferLansiaHidden').val($('.formObgyn').find('#transferLansia').val());
    }else{
         $('.formObgyn').find('.transfer_mobilitas_lansia').val("");
        $('.formObgyn').find('#transferLansiaHidden').val(0);
    }

    totalTransferMobilitas_obgyn();
}

function getMobilitasLansia_obgyn(){
    if($('.formObgyn').find('.mobilitas_lansia').val() != ''){
        var mob = '';
         $('.formObgyn').find('#mobilitasLansia').find('option').each(function(){
            if($(this).text() == $('.formObgyn').find('.mobilitas_lansia').val()){
                mob = $(this).val();
            }
        });
        $('.formObgyn').find('#mobilitasLansia').val(mob);
    }

    if($('.formObgyn').find('#mobilitasLansia').val() != ""){
        $('.formObgyn').find('.mobilitas_lansia').val($('.formObgyn').find('#mobilitasLansia').find('option:selected').text());
         $('.formObgyn').find('#mobilitasLansiaHidden').val($('.formObgyn').find('#mobilitasLansia').val());
    }else{
        $('.formObgyn').find('.mobilitas_lansia').val("");
      $('.formObgyn').find('#mobilitasLansiaHidden').val(0);
    }

    totalTransferMobilitas_obgyn();
}

function totalTransferMobilitas_obgyn(){
   var trf = $('.formObgyn').find('#transferLansiaHidden').val();
   var mobil = $('.formObgyn').find('#mobilitasLansiaHidden').val();
   var jumlah = parseInt(trf) + parseInt(mobil);
   var totalJml = 0;
   if (!isNaN(jumlah)) {
       if(jumlah >=0 && jumlah <= 3){
           totalJml = 0;
       }else{
           totalJml = 7;
       }
   }
   $('.formObgyn').find('.skor_transfer_mobilitas_lansia').val(totalJml);
   skorresikojatuh_obgyn();
}

function setStatusAnteCare_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.obgyn_antenatalcare_status').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('.obgyn_antenatalcare_tempat').each(function(){
        $(this).attr('disabled',false);
      });
      $('.formObgyn').find('.obgyn_antenatalcare_frekuensi').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('.obgyn_antenatalcare_tempat').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
    $('.formObgyn').find('.obgyn_antenatalcare_frekuensi').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
  }
  setTempatAnteCare_obgyn();
}

function setTempatAnteCare_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.obgyn_antenatalcare_tempat').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_antenatalcare_tempatlainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 4 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_antenatalcare_tempatlainnya'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_antenatalcare_tempatlainnya'); ?>').attr('readonly',true);
  }
}

function setImunisasiStatus_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.obgyn_imunisasittstatus').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_imunisasittket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 4 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_imunisasittket'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_imunisasittket'); ?>').attr('readonly',true);
  }
}

function setKeluhanSaatHamil_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.keluhanhamil').each(function(){
    if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_keluhansaathamillainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 5 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_keluhansaathamillainnya'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_keluhansaathamillainnya'); ?>').attr('readonly',true);
  }
}

function tambahKehamilan(){
  var hamilke = parseInt(unformatNumber($('.formObgyn').find('#hamilke').val()));
  var umurkehamilan = parseInt(unformatNumber($('.formObgyn').find('#umurkehamilan').val()));
  var beratbadan = parseFloat(unformatNumber($('.formObgyn').find('#beratbadan').val()));
  var beratbadan_status = $('.formObgyn').find('#beratbadan_status').val();
  var jeniskelamin = '';

  $('.formObgyn').find('.jeniskelamin').each(function(){
    if($(this).prop('checked')==true){
        jeniskelamin = $(this).val();
    }
  });

  var carapersalinan = $('.formObgyn').find('#carapersalinan').val();
  var penolongpersalinan = $('.formObgyn').find('#penolongpersalinan').val();
  var tempatpersalinan = $('.formObgyn').find('#tempatpersalinan').val();
  var abortus = '';
  $('.formObgyn').find('.abortus').each(function(){
    if($(this).prop('checked')==true){
        abortus = $(this).val();
    }
  });
  var keterangan = $('.formObgyn').find('#keterangan').val();

  var checkJkLaki = "";
  var checkJKPerempuan = "";
  var checkAbortusYa = "";
  var checkAbortustidak = "";

  if(jeniskelamin != ""){
    if(jeniskelamin == 'Laki-laki'){
      checkJkLaki = "icon-form-check";
    }else{
      checkJKPerempuan = "icon-form-check";
    }
  }

  if(abortus != ""){
    if(abortus == 'Ya'){
      checkAbortusYa = "icon-form-check";
    }else{
      checkAbortustidak = "icon-form-check";
    }
  }

  if(hamilke != ''){
    var html = "<tr>" +
      "<td style='text-align: center'>"+
        "<input type='hidden' class='hamilke' value='"+hamilke+"' />"+
        "<input type='hidden' class='umurkehamilan' value='"+umurkehamilan+"' />"+
        "<input type='hidden' class='beratbadan' value='"+beratbadan+"' />"+
        "<input type='hidden' class='beratbadan_status' value='"+beratbadan_status+"' />"+
        "<input type='hidden' class='jeniskelamin' value='"+jeniskelamin+"' />"+
        "<input type='hidden' class='carapersalinan' value='"+carapersalinan+"' />"+
        "<input type='hidden' class='penolongpersalinan' value='"+penolongpersalinan+"' />"+
        "<input type='hidden' class='tempatpersalinan' value='"+tempatpersalinan+"' />"+
        "<input type='hidden' class='abortus' value='"+abortus+"' />"+
        "<input type='hidden' class='keterangan' value='"+keterangan+"' />"+

        "<span>"+ hamilke +"</span>"+
      "</td>"+
      "<td style='text-align: center'>"+
      "<span>"+ umurkehamilan +"</span>"+
      "</td>"+
      "<td style='text-align: center'>"+
        "<span class='"+checkJkLaki+"'></span>"+
      "</td>"+
      "<td style='text-align: center'>"+
        "<span class='"+checkJKPerempuan+"'></span>"+
      "</td>"+
      "<td>"+
        "<span>"+ carapersalinan +"</span>"+
      "</td>"+
      "<td>"+
        "<span>"+ penolongpersalinan +"</span>"+
      "</td>"+
      "<td>"+
        "<span>"+ tempatpersalinan +"</span>"+
      "</td>"+
      "<td style='text-align: center'>"+
        "<span class='"+checkAbortusYa+"'></span>"+
      "</td>"+
      "<td style='text-align: center'>"+
        "<span class='"+checkAbortustidak+"'></span>"+
      "</td>"+
      "<td>"+
        "<span>"+ keterangan +"</span>"+
      "</td>"+
      "<td>"+
        "<a onclick='batalKehamilan(this);return false;'' rel='tooltip' href='javascript:void(0);'' title='Klik untuk membatalkan Riwayat Kehamilan'><i class='icon-remove'></i></a>"+
      "</td>"+
    "</tr>";

    $('.formObgyn').find('#tblRiwayatKehamilan').find('tbody').append(html);
    generateRowKehamilan($('.formObgyn').find('#tblRiwayatKehamilan').find('tbody'));

    $('.formObgyn').find('#hamilke').val('0');
    $('.formObgyn').find('#umurkehamilan').val('0');
    $('.formObgyn').find('#beratbadan').val('');
    $('.formObgyn').find('#beratbadan_status').val('Kg');
    $('.formObgyn').find('.jeniskelamin').each(function(){
      $(this).attr('checked',false);
    });
    $('.formObgyn').find('#carapersalinan').val('');
    $('.formObgyn').find('#penolongpersalinan').val('');
    $('.formObgyn').find('#tempatpersalinan').val('');
    $('.formObgyn').find('.abortus').each(function(){
      $(this).attr('checked',false);
    });
    $('.formObgyn').find('#keterangan').val('');
  }else{
    myAlert('Riwayat Kehamilan Belum Diisi !!')
  }
}

function generateRowKehamilan(obj){
  for(var i=0; i< $('.formObgyn').find(obj).find('.hamilke').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.hamilke').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_hamilke');
      trRow.attr('name','RiwayatKehamilan['+i+'][hamilke]');
  }

  for(var i=0; i< $('.formObgyn').find(obj).find('.umurkehamilan').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.umurkehamilan').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_umurkehamilan');
      trRow.attr('name','RiwayatKehamilan['+i+'][umurkehamilan]');
  }
  for(var i=0; i< $('.formObgyn').find(obj).find('.beratbadan').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.beratbadan').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_beratbadan');
      trRow.attr('name','RiwayatKehamilan['+i+'][beratbadan]');
  }
  for(var i=0; i< $('.formObgyn').find(obj).find('.beratbadan_status').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.beratbadan_status').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_beratbadan_status');
      trRow.attr('name','RiwayatKehamilan['+i+'][beratbadan_status]');
  }
  for(var i=0; i< $('.formObgyn').find(obj).find('.jeniskelamin').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.jeniskelamin').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_jeniskelamin');
      trRow.attr('name','RiwayatKehamilan['+i+'][jeniskelamin]');
  }
  for(var i=0; i< $('.formObgyn').find(obj).find('.carapersalinan').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.carapersalinan').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_carapersalinan');
      trRow.attr('name','RiwayatKehamilan['+i+'][carapersalinan]');
  }
  for(var i=0; i< $('.formObgyn').find(obj).find('.penolongpersalinan').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.penolongpersalinan').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_penolongpersalinan');
      trRow.attr('name','RiwayatKehamilan['+i+'][penolongpersalinan]');
  }
  for(var i=0; i< $('.formObgyn').find(obj).find('.tempatpersalinan').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.tempatpersalinan').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_tempatpersalinan');
      trRow.attr('name','RiwayatKehamilan['+i+'][tempatpersalinan]');
  }
  for(var i=0; i< $('.formObgyn').find(obj).find('.abortus').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.abortus').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_abortus');
      trRow.attr('name','RiwayatKehamilan['+i+'][abortus]');
  }
  for(var i=0; i< $('.formObgyn').find(obj).find('.keterangan').length; i++){
      var trRow = $('.formObgyn').find(obj).find('.keterangan').eq(i);
      trRow.attr('id','RiwayatKehamilan_'+i+'_keterangan');
      trRow.attr('name','RiwayatKehamilan['+i+'][keterangan]');
  }
}

function batalKehamilan(obj){
    $('.formObgyn').find(obj).parents('tr').remove();
    generateRowKehamilan($('.formObgyn').find('#tblRiwayatKehamilan').find('tbody'));
}

function setChangeDetEdukasiLain_obgyn(obj){
    var index = $('.formObgyn').find(obj).attr('text_id');

    if($('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('readonly',false);
    }else{
        $('.formObgyn').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('readonly',true);
        $('.formObgyn').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').val('');
    }
}

function setEdukasiBicara_obgyn(obj){
    if($('.formObgyn').find(obj).val()==='Serangan Awal Bicara' && $('.formObgyn').find(obj).prop('checked')===true){
         $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal') ?>').attr('readonly',false);
    }else if($('.formObgyn').find(obj).val()==='Normal' && $('.formObgyn').find(obj).prop('checked')===true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal') ?>').attr('readonly',true);
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal') ?>').val('');
    }
}

function setNilaiKepercayaanKhusus_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.nilaikepercayaankhusus_dewasa').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket'); ?>').attr('readonly',true);
  }
}

function setEdukasiPenerima_obgyn(obj){
    if($('.formObgyn').find(obj).val()==='1' && $('.formObgyn').find(obj).prop('checked')===true){
         $('.formObgyn').find('.edukasipenerima').attr('disabled',false);
         $('.formObgyn').find('.edukasipenerima').attr('checked',false);
         $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak') ?>').attr('readonly',true);
         $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak') ?>').val('');
    }else if($('.formObgyn').find(obj).val()==='0' && $('.formObgyn').find(obj).prop('checked')===true){
        $('.formObgyn').find('.edukasipenerima').attr('disabled',true);
        $('.formObgyn').find('.edukasipenerima').attr('checked',false);
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak') ?>').attr('readonly',false);
    }
    setEdukasiPenerimaLainnya_obgyn($('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_lainnya') ?>'));
    setEdukasiPenerimaKeluarga_obgyn($('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_keluargapasien') ?>'));
}

function setEdukasiPenerimaLainnya_obgyn(obj){
    if($('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama') ?>').attr('readonly',false);
    }else{
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama') ?>').attr('readonly',true);
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama') ?>').val('');
    }
}

function setEdukasiPenerimaKeluarga_obgyn(obj){
    if($('.formObgyn').find(obj).prop('checked')==true){
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien') ?>').attr('readonly',false);
    }else{
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien') ?>').attr('readonly',true);
        $('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien') ?>').val('');
    }
}

function pilihNyeri_obgyn(obj){
  if($('.formObgyn').find(obj).val() == 0 && $('.formObgyn').find(obj).prop('checked')==true){

        inputAllDisabled($('.formObgyn').find('#nyeri_dewasa').find('.panel-body'));
        $('.formObgyn').find('#nyeri_dewasa').find('.panel-body').hide();

    } else if($('.formObgyn').find(obj).val() == 1 && $('.formObgyn').find(obj).prop('checked')==true){
        inputAllEnabled($('.formObgyn').find('#nyeri_dewasa').find('.panel-body'));
        $('.formObgyn').find('#nyeri_dewasa').find('.panel-body').show();
    }
}

function setJenisPernapasan_obgyn(obj){
  if($('.formObgyn').find(obj).prop('checked')==true){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'b1jenispernapasan_lainnya') ?>').attr('disabled',false);
  }else{
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'b1jenispernapasan_lainnya') ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model,'b1jenispernapasan_lainnya') ?>').attr('disabled',true);
  }
}

function setKesulitanbernafas_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.b1_kesulitanbernafas').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b1_jmloksigenperliter'); ?>').attr('disabled',false);
      $('.formObgyn').find('.b1_jenisterapioksigen').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b1_jmloksigenperliter'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b1_jmloksigenperliter'); ?>').attr('disabled',true);
    $('.formObgyn').find('.b1_jenisterapioksigen').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
}

function setB2isoedem_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.b2_isoedem').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b2_lokasioedem'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b2_lokasioedem'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b2_lokasioedem'); ?>').attr('disabled',true);
  }
}

function setB5Nyeritekan_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.b5_abdomen_isnyeritekan').each(function(){
    if($(this).val()==1 && $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b5_abdomen_nyeritekanlokasi'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b5_abdomen_nyeritekanlokasi'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b5_abdomen_nyeritekanlokasi'); ?>').attr('disabled',true);
  }
}

function setB6Fraktur_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.b6_isfraktur').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b6_lokasifraktur'); ?>').attr('disabled',false);
      $('.formObgyn').find('.b6_jenisfraktur').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b6_lokasifraktur'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b6_lokasifraktur'); ?>').attr('disabled',true);
    $('.formObgyn').find('.b6_jenisfraktur').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
}

function setB6ResikoDekubitus_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.b6_isresikodekubitus').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b6_skorbraden'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b6_skorbraden'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b6_skorbraden'); ?>').attr('disabled',true);
  }
}

function setB6Luka_obgyn(){
  var index = 0;
  var indexLainnya = 0;
  $('.formObgyn').find('.b6_isluka').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b6_lokasiluka'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b6_lokasiluka'); ?>').val('');
    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'b6_lokasiluka'); ?>').attr('disabled',true);
  }
}

$(document).ready(function(){
   $('.formObgyn').find('.groupUkurans').find('input').keyup(function(){
        gantiHidden_obgyn();
        getBeratBadanIdeal_obgyn();
        getBMI_obgyn();
    });
    getBeratBadanIdeal_obgyn();
    getBMI_obgyn();
    getText_obgyn();
    setAdaNyeri_obgyn();
    setStatusRiwayattransfusi_obgyn();
    setSumberData_obgyn();
    setStatusKontrolRisiko_obgyn();
    setAnak_obgyn();
    setMasalahDlmBerbicara_obgyn();
    setKualitasNyeri_obgyn();
    setFrekuensiNyeri_obgyn();
    setKesadaranNyeri_obgyn();

    $('.formObgyn').find(".riwayatpembedahan_status").each(function(){
         setStatusPembedahanAnastesi_obgyn($(this));
     });

     $('.formObgyn').find(".statusalergipasien").each(function(){
        setStatusAlergi_obgyn($(this));
     });

     $('.formObgyn').find('.bahasaseharihari_jenis').each(function(){
         setEduBahasaSehari_obgyn($(this));
     });

     $('.formObgyn').find('.statusrokok').each(function(){
         setJumlahRokok_obgyn($(this));
     });

     $('.formObgyn').find('.kebutuhanpenerjemah_status').each(function(){
         setEdukasiPenerjemah_obgyn($(this));
     });

     var indexSknFungsional = 0;
     $('.formObgyn').find('.pilih_fungsional').each(function(){
         pilihFungsional_obgyn($(this));

         if(($('.formObgyn').find(this).val() == 1 || $('.formObgyn').find(this).val() == 2) && $('.formObgyn').find(this).prop('checked')==false){
           indexSknFungsional++;
         }
     });

     if(indexSknFungsional==2){
         unpilihFungsional_obgyn();
     }

     $('.formObgyn').find('#informasiResikoJatuh').hide();
     $('.formObgyn').find('#informasiResikoJatuh').html("");

     $('.formObgyn').find('.pilih_nyeri').each(function(){
         pilihNyeri_obgyn($(this));
     });

    var skor = $('.formObgyn').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val();
    if (skor != "") {
        $('.formObgyn').find(".nyeri-nomor").css("border-radius", "5px");
        $('.formObgyn').find("#nyerinomor_" + skor).css("border", "1px solid black");
    }

    $('.formObgyn').find(".pilih_resikoJatuh").each(function(){
         choiseResikoJatuh_obgyn($(this));
     });

     $('.formObgyn').find('.riwayatJatuh').each(function(){
         setRiwayatJatuh_obgyn($(this));
     });

     $('.formObgyn').find('.statusMentalLansia').each(function(){
         setStatusMental_obgyn($(this));
     });

     $('.formObgyn').find('.penglihatanLansia').each(function(){
         setPengelihatan_obgyn($(this));
     });
     $('.formObgyn').find('.kebiasaanBerkemihLansia').each(function(){
         setKebiasaanBerkemih_obgyn($(this));
     });

     $('.formObgyn').find(".riwayatjatuh_3bln_terakhir").each(function(){
         changeInformasiResikoJatuh_obgyn($(this));
     });
    $('.formObgyn').find(".riwayatjatuh_alatbantu").each(function(){
      changeInformasiResikoJatuh_obgyn($(this));
     });
     $('.formObgyn').find(".jenisalatbantu").each(function(){
      changeInformasiResikoJatuh_obgyn($(this));
     });
     $('.formObgyn').find('.bicara_status').each(function(){
         setEdukasiBicara_obgyn($(this));
     });
     $('.formObgyn').find('.kesediaanmenerimaedukasi_status').each(function(){
         setEdukasiPenerima_obgyn($(this));
     });

    setEdukasiPenerimaLainnya_obgyn($('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_lainnya') ?>'));
    setEdukasiPenerimaKeluarga_obgyn($('.formObgyn').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_keluargapasien') ?>'));

     getTransferLansia_obgyn();
     getMobilitasLansia_obgyn();
     setNilaiKepercayaanKhusus_obgyn();
     setKesulitanbernafas_obgyn();
     setB2isoedem_obgyn();
     setB5Nyeritekan_obgyn();
     setB6Fraktur_obgyn();
     setB6ResikoDekubitus_obgyn();
     setB6Luka_obgyn();


    $('#checkSimpanData').val('');
    $('.formObgyn').find('#rootwizardAskepObgyn').bootstrapWizard({
      tabClass: "",
        onTabShow: function($tab, $navigation, index)
        {
          setCurrentProgressTab($(this), $navigation, $tab, $(this).find(".steps-progress div"), index);
        },
        onPrevious: function(tab, navigation, index){
        },
        onNext: function(tab, navigation, index){
          var postdata = $('.formObgyn').find('#askepobgynri-t-form');
          var indexStepObgyn = 11;
          
          var cekObgyn = simpanDataForm_obgyn(postdata, index);
          
          if(index == indexStepObgyn && cekObgyn==true){
              $('.formObgyn').find('.next').hide();
          }else{
            $('.formObgyn').find('.next').show();
          }

          return cekObgyn;
          // return true;
        },
        onTabClick: function(tab, navigation, index){
        }
      });
});


var date_label = {
    "Mei": "May",
    "Agus": "Aug",
    "Okt": "Oct",
    "Nop": "Nov",
    "Des": "Dec"
};

function hitungSiklusHaid() {

    var siklus = parseFloat($('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_siklushaid') ?>').val());
    var tgl = $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_mensterakhir') ?>').val();
    var arr_tgl = tgl.split(" ");

    if (date_label[arr_tgl[1]] != null) {
        arr_tgl[1] = date_label[arr_tgl[1]];
    }
    tgl = arr_tgl.join(" ");
    var tgl_full = new Date(tgl);
    var tgl_o = new Date(tgl);
    var month = tgl_full.getMonth();
    if (!isNaN(siklus) && !isNaN(tgl_full.getTime())) {
        if (siklus === 28) {
            if (month >= 4) {
                tgl_full.setDate(tgl_full.getDate() + 7);
                tgl_full.setMonth(tgl_full.getMonth() - 3);
                tgl_full.setFullYear(tgl_full.getFullYear() + 1);
            } else {
                tgl_full.setDate(tgl_full.getDate() + 7);
                tgl_full.setMonth(tgl_full.getMonth() + 9);
            }
        } else {
            tgl_full.setMonth(tgl_full.getMonth() + 9);
            tgl_full.setDate(tgl_full.getDate() + (siklus - 21));
        }
    }

    var tgl_sekarang = new Date();
    if (!isNaN(tgl_full.getTime())) {
        var selisih = tgl_sekarang.getTime() - tgl_o.getTime();
        var selisih_hari = Math.floor(selisih / (1000 * 3600 * 24));
        var selisih_minggu = Math.floor(selisih_hari / 7);
        $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_usiakehamilanhpht') ?>').val(selisih_minggu);
    }

    $('.formObgyn').find('#<?php echo CHtml::activeId($model, 'obgyn_taksiranpersalinan') ?>').val(tgl_full.toLocaleDateString("id-ID", {day:"numeric", month: "short", year:"numeric"}));

}

</script>
