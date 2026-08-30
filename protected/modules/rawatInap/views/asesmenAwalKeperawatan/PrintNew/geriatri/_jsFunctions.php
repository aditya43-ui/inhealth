<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function simpanAllData_geriatri(){
  if(requiredCheck($('.formGeriatri').find("#askepgeriatri-t-form"))){
    var indexNext = $('.formGeriatri').find('#rootwizardAskepGeriatri').data('bootstrapWizard').nextIndex();
    var indexstep = $('.formGeriatri').find('#rootwizardAskepGeriatri').data('bootstrapWizard').currentIndex();
    $(".formGeriatri").addClass("animation-loading");
    $('.formGeriatri').find(".integer-decimal, .integer2, .float2").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
    var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
    var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
    var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
    var jenisasesmen = $('#choise_geriatri').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
    var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

    // var dataSerialized = $('.formGeriatri').find('#askepgeriatri-t-form').serializeArray();
    // dataSerialized.push({name: 'indexcurrent',value:indexstep});
    // dataSerialized.push({name: 'indexNext',value:indexNext});
    // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pendaftaran_id]',value:pendaftaran_id});
    // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pasienadmisi_id]',value:pasienadmisi_id});
    // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pasien_id]',value:pasien_id});
    // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[jenisasesmen]',value:jenisasesmen});
    // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[asesmenawalkeperawatan_id]',value:asesmenawalkeperawatan_id});
    // dataSerialized.push({name: 'RIAsesmenkebutuhanEdukasiT[pendaftaran_id]',value:pendaftaran_id});
    // dataSerialized.push({name: 'RIAsesmenkebutuhanEdukasiT[pasienadmisi_id]',value:pasienadmisi_id});

    var dataSerialized = new FormData($('.formGeriatri').find("#askepgeriatri-t-form")[0]);
    dataSerialized.append('indexcurrent',indexstep);
    dataSerialized.append('indexNext',indexNext);
    dataSerialized.append('RIAsesmenawalkeperawatanT[pendaftaran_id]',pendaftaran_id);
    dataSerialized.append('RIAsesmenawalkeperawatanT[pasienadmisi_id]',pasienadmisi_id);
    dataSerialized.append('RIAsesmenawalkeperawatanT[pasien_id]',pasien_id);
    dataSerialized.append('RIAsesmenawalkeperawatanT[jenisasesmen]',jenisasesmen);
    dataSerialized.append('RIAsesmenawalkeperawatanT[asesmenawalkeperawatan_id]',asesmenawalkeperawatan_id);
    dataSerialized.append('RIAsesmenkebutuhanEdukasiT[pendaftaran_id]',pendaftaran_id);
    dataSerialized.append('RIAsesmenkebutuhanEdukasiT[pasienadmisi_id]',pasienadmisi_id);

    if(indexstep > 1){
      $('#checkSimpanData').val('simpan');
    }else if (indexstep == 1){
      $('#checkSimpanData').val('');
    }
    var checksimpan = $('#checkSimpanData').val();
    dataSerialized.append('checksimpan',checksimpan);

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SimpanOrLoad'); ?>',
        data: dataSerialized,
        dataType: "json",
        'async': false,
        cache:false,
              contentType: false,
              processData: false,
        success:function(data){
          suksesData = false;
          if(data != ""){
            if(data.sukses > 0){
              suksesData = true;
              $('.formGeriatri').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              $.fn.yiiGridView.update('riwayataskep-grid', {
                  data: $(this).serialize()
              });
            }else{
              $('.formGeriatri').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
            }
            if(suksesData==true){
              setTimeout(function(){
                  $('.formGeriatri').find('.divAlert').html('');
              }, 5000);
            }
          }else{
              $('.formGeriatri').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');

          }
          $(".formGeriatri").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formGeriatri").removeClass("animation-loading");}
    });
  }
}

function simpanDataForm_geriatri(simpanDt, indexstep, handeland){
  var suksesData = false;
    if(requiredCheck($('.formGeriatri').find(simpanDt))){
      var indexNext = $('.formGeriatri').find('#rootwizardAskepGeriatri').data('bootstrapWizard').nextIndex();
      $(".formGeriatri").addClass("animation-loading");
      $('.formGeriatri').find(".integer-decimal, .integer2, .float2").each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
      var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
      var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
      var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
      var jenisasesmen = $('#choise_geriatri').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
      var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

      if(indexstep > 1){
        $('#checkSimpanData').val('simpan');
      }else if (indexstep == 1){
        $('#checkSimpanData').val('');
      }

      var checksimpan = $('#checkSimpanData').val();
      //tidak memakai files
      // var dataSerialized = $('.formGeriatri').find(simpanDt).serializeArray();
      // dataSerialized.push({name: 'indexcurrent',value:indexstep});
      // dataSerialized.push({name: 'indexNext',value:indexNext});
      // dataSerialized.push({name: 'checksimpan',value:checksimpan});
      // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pendaftaran_id]',value:pendaftaran_id});
      // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pasienadmisi_id]',value:pasienadmisi_id});
      // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[pasien_id]',value:pasien_id});
      // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[jenisasesmen]',value:jenisasesmen});
      // dataSerialized.push({name: 'RIAsesmenawalkeperawatanT[asesmenawalkeperawatan_id]',value:asesmenawalkeperawatan_id});
      // dataSerialized.push({name: 'RIAsesmenkebutuhanEdukasiT[pendaftaran_id]',value:pendaftaran_id});
      // dataSerialized.push({name: 'RIAsesmenkebutuhanEdukasiT[pasienadmisi_id]',value:pasienadmisi_id});

      //memakai files
      var dataSerialized = new FormData($('.formGeriatri').find(simpanDt)[0]);
      dataSerialized.append('indexcurrent',indexstep);
      dataSerialized.append('indexNext',indexNext);
      dataSerialized.append('checksimpan',checksimpan);
      dataSerialized.append('RIAsesmenawalkeperawatanT[pendaftaran_id]',pendaftaran_id);
      dataSerialized.append('RIAsesmenawalkeperawatanT[pasienadmisi_id]',pasienadmisi_id);
      dataSerialized.append('RIAsesmenawalkeperawatanT[pasien_id]',pasien_id);
      dataSerialized.append('RIAsesmenawalkeperawatanT[jenisasesmen]',jenisasesmen);
      dataSerialized.append('RIAsesmenawalkeperawatanT[asesmenawalkeperawatan_id]',asesmenawalkeperawatan_id);
      dataSerialized.append('RIAsesmenkebutuhanEdukasiT[pendaftaran_id]',pendaftaran_id);
      dataSerialized.append('RIAsesmenkebutuhanEdukasiT[pasienadmisi_id]',pasienadmisi_id);

      $.ajax({
          type:'POST',
          url:'<?php echo $this->createUrl('SimpanOrLoad'); ?>',
          data: dataSerialized,
          cache:false,
                contentType: false,
                processData: false,
          dataType: "json",
          'async': false,
          success:function(data){
            suksesData = false;
            if(data != ""){
              if(data.sukses > 0){
                suksesData = true;
                $('.formGeriatri').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                $.fn.yiiGridView.update('riwayataskep-grid', {
                    data: $(this).serialize()
                });
              }else{
                $('.formGeriatri').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              }

              if(suksesData==true){
                setTimeout(function(){
                    $('.formGeriatri').find('.divAlert').html('');
                }, 5000);
              }
            }else{
                $('.formGeriatri').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
            }
            $(".formGeriatri").removeClass("animation-loading");
          },
          error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formGeriatri").removeClass("animation-loading");}
      });
    }
    return suksesData;
}

function setSumberData(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.sumberdata').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').val('');
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('disabled',true);
  }
}

function setStatusAlergi_geriatri(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.statusalergipasien').each(function(){
    if($(this).val()==3 &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('disabled',false);
      $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('disabled',false);
      $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('disabled',false);
      $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'ispasangtandaalergi') ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('disabled',true);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('disabled',true);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('disabled',true);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'ispasangtandaalergi') ?>').attr('disabled',true);
  }
}

function setStatusPembedahanAnastesi_geriatri(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.riwayatpembedahan_status').each(function(){
    if($(this).val()=='Pernah' &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('disabled',true);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').val('');
  }
}

function setStatusRiwayattransfusi_geriatri(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.riwayattransfusi_status').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',false);
      $('.formGeriatri').find('.riwayattransfusi_isreaksi').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').val('');
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',true);
    $('.formGeriatri').find('.riwayattransfusi_isreaksi').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
  setReaksiRiwayattransfusi_geriatri();
}

function setReaksiRiwayattransfusi_geriatri(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.riwayattransfusi_isreaksi').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').val('');
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',true);
  }
}

function returnValue_geriatri(obj){
    var value = $('.formGeriatri').find(obj).val();
    var attrID = $('.formGeriatri').find(obj).attr('id');
    var td = $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val();
    var splitTD = td.split(' / ');

    if (attrID == $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'td_diastolic') ?>').attr('id')){
        splitTD[0] = splitTD[0].replace(/_/gi, "0");
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val(splitTD[0]+' / '+value);
    }
    else if (attrID == $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'td_systolic') ?>').attr('id')){
        splitTD[1] = splitTD[1].replace(/_/gi, "0");
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val(value+' / '+splitTD[1]);
    }
}

function getText_geriatri(){
    var dias = parseFloat($('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'td_diastolic') ?>').val());
    var sys = parseFloat($('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'td_systolic') ?>').val());
    var arteri = ((sys+(2*dias))/3);

    if (jQuery.isNumeric(dias)){
        if (jQuery.isNumeric(sys)){
            $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/GetTextTekananDarah'); ?>', {diastolic:dias, systolic:sys}, function(data){
                if (data.text == null){
                    $('.formGeriatri').find('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
                } else {
                    $('.formGeriatri').find('#tekananDarah').val(data.text);
                }
            },'json');
            $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'meanarteripressure') ?>').val(arteri.toFixed(2));
        }
    }
}

function pilihFungsional_geriatri(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.pilih_fungsional').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      inputAllEnabled($('.formGeriatri').find('#pilih_fungsional').find('.panel-body'));
      $('.formGeriatri').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').show();

      inputAllDisabled($('.formGeriatri').find('#pilih_fungsionaladl').find('.panel-body'));
     $('.formGeriatri').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').hide();
      indexLainnya = 1;
    }else if($(this).val()==2 &&  $(this).prop('checked')==true){
      inputAllEnabled($('.formGeriatri').find('#pilih_fungsionaladl').find('.panel-body'));
      $('.formGeriatri').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').show();

      inputAllDisabled($('.formGeriatri').find('#pilih_fungsional').find('.panel-body'));
      $('.formGeriatri').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').hide();
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    inputAllDisabled($('.formGeriatri').find('#pilih_fungsionaladl').find('.panel-body'));
   $('.formGeriatri').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').hide();

   inputAllDisabled($('.formGeriatri').find('#pilih_fungsional').find('.panel-body'));
   $('.formGeriatri').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').hide();
  }
}

function klikBtnMakan_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_makan') ?>').val(nilai);
skorskrinningfungsional_geriatri();
}

function klikBtnToilet_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_aktifitastoilet') ?>').val(nilai);
skorskrinningfungsional_geriatri();
}

function klikBtnRodaTidur_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpindahkursi') ?>').val(nilai);
skorskrinningfungsional_geriatri();
}

function klikBtnGosokGigi_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_kebersihanmandiri') ?>').val(nilai);
skorskrinningfungsional_geriatri();
}

function klikBtnMandi_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mandi') ?>').val(nilai);
skorskrinningfungsional_geriatri();
}

function klikBtnBerjalanDasar_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berjalanpermukaankasar') ?>').val(nilai);
skorskrinningfungsional_geriatri();
}

function klikBtnNaikTangga_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_naikturuntangga') ?>').val(nilai);
skorskrinningfungsional_geriatri();
}

function klikBtnBerpakaian_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpakaian') ?>').val(nilai);
skorskrinningfungsional_geriatri();
}

function klikBtnDefekasi_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontroldefekasi') ?>').val(nilai);
    skorskrinningfungsional_geriatri();
}

function klikBtnBerkemih_geriatri(nilai){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontrolberkemih') ?>').val(nilai);
    skorskrinningfungsional_geriatri();
}

function skorskrinningfungsional_geriatri(){
    var totalSkor = 0;

    $('.formGeriatri').find('#tblInputFungsional').find('.skinningfungsional_skor').each(function(){
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

    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_jumlah_skor') ?>').val(totalSkor);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_keterangan') ?>').val(keterangan);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_kategori') ?>').val(kategori);
}

function klikBtnAdl_geriatri(skor, type){
  if(type == 'bab'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_bab'); ?>').val(skor);
  }else if(type == 'bak'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_bak'); ?>').val(skor);
  }else if(type == 'kebersihan'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_kebersihanmandiri'); ?>').val(skor);
  }else if(type == 'penggunaanjamban'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_pengunaanjamban'); ?>').val(skor);
  }else if(type == 'makan'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_makan'); ?>').val(skor);
  }else if(type == 'sikap'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_sikap'); ?>').val(skor);
  }else if(type == 'pindah'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_berpindah'); ?>').val(skor);
  }else if(type == 'baju'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_baju'); ?>').val(skor);
  }else if(type == 'tangga'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_naikturuntangga'); ?>').val(skor);
  }else if(type == 'mandi'){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_mandi'); ?>').val(skor);
  }

  var skor = 0;
  var keterangan = "";

  $('.formGeriatri').find('#tblInputFungsionalAdl').find('.skinningfungsionaladl_skor').each(function(){
    var skorAdl = $('.formGeriatri').find(this).val();

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

  $('.formGeriatri').find('#tblInputFungsionalAdl').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_jumlah_skor'); ?>').val(skor);
  $('.formGeriatri').find('#tblInputFungsionalAdl').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_keterangan'); ?>').val(keterangan);
}

function choiseSkrinningGizi_geriatri(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.pilih_fungsional').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      inputAllEnabled($('.formGeriatri').find('#skrinninggizi_dewasa_panel'));
      $('.formGeriatri').find('#skrinninggizi_dewasa_panel').show();

      // inputAllDisabled($('.formGeriatri').find('#skrinninggizi_anak_panel'));
      // $('.formGeriatri').find('#skrinninggizi_anak_panel').hide();
      indexLainnya = 1;
    }
    // else if($(this).val()==0 &&  $(this).prop('checked')==true){
    //   inputAllEnabled($('.formGeriatri').find('#skrinninggizi_anak_panel'));
    //   $('.formGeriatri').find('#skrinninggizi_anak_panel').show();
    //
    //   inputAllDisabled($('.formGeriatri').find('#skrinninggizi_dewasa_panel'));
    //   $('.formGeriatri').find('#skrinninggizi_dewasa_panel').hide();
    //   indexLainnya = 1;
    // }
    else{
      index++;
    }
  });

  if(index <= 1 && indexLainnya == 0){
    // inputAllDisabled($('.formGeriatri').find('#skrinninggizi_anak_panel'));
    // $('.formGeriatri').find('#skrinninggizi_anak_panel').hide();

    inputAllDisabled($('.formGeriatri').find('#skrinninggizi_dewasa_panel'));
    $('.formGeriatri').find('#skrinninggizi_dewasa_panel').hide();
  }
}

function skrinninggizidewasa_penurunbb_geriatri(obj){
  if($('.formGeriatri').find(obj).val() != ''){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val($(obj).val());
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penurunanbb_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val(0);
  }
  skorskrinninggizi_geriatri();
}

function skrinninggizidewasa_asupan_geriatri(obj){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_asupanmakanan_dewasa') ?>').val($(obj).val());
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_asupanmakanan_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_geriatri();
}

function skorskrinninggizi_geriatri(){
    var totalSkorDewasa = 0;

    $('.formGeriatri').find('#tblInputSkrinningGiziDewasa').find('.skrinninggizidewasa_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorDewasa += parseInt(skor);
    });


    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_totaldewasa') ?>').val(totalSkorDewasa);

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

    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrininggizidewasa_resiko') ?>').val(risDewasa);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skrininggizidewasa_tindakanygdilakukan') ?>').val(ketdewasa);
}

function gantiHidden_geriatri(){
    var defaultBB = parseFloat(0.001);
    var defaultTB = parseFloat(100);
    var valueBB = parseFloat($('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
    var valueTB = parseFloat($('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').val());

    if ($('.formGeriatri').find('#gram').val() != defaultBB){
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB*defaultBB);
    }
    else{
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB);
    }

    if ($('.formGeriatri').find('#meter').val() != defaultTB){
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB*defaultTB);
    }
    else{
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB);
    }
}

function getBeratBadanIdeal_geriatri(){
    var beratBadan = parseFloat($('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
    var tinggiBadan = parseFloat($('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var jenisKelamin = $('.formGeriatri').find('#<?php echo CHtml::activeId($modPasien, 'jenis_kelamin') ?>').val();
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
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
    }
    else{
        //hasil = (tinggiBadan - 100) - ((10/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
    }
}

function getBMI_geriatri(){
    var beratBadan = parseFloat($('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var tinggiBadan = parseFloat($('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var hasil;

    hasil = (beratBadan/((tinggiBadan*tinggiBadan)/10000));
    if (jQuery.isNumeric(hasil)){
        $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText'); ?>', {bmi:hasil}, function(data){
            $('.formGeriatri').find('#imt').val(data.text);
            $('.formGeriatri').find('#imtValue').val(Math.floor(hasil));
        },'json');
    }
}

function gantiJumlah_geriatri(obj){
    var value = parseFloat($('.formGeriatri').find(obj).val());
    var teman = $('.formGeriatri').find(obj).parent('.groupUkurans').find('input[type="text"]');
    var valueTeman = parseFloat(teman.val());
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}

function setRiwayatJatuh_geriatri(obj){
    if($('.formGeriatri').find('.resiko_jatuh_lansia').val() != '' && $('.formGeriatri').find('.resiko_jatuh_lansia').val() == 1){
        $('.formGeriatri').find('#riwayatJatuhRSLansia_0').attr('checked',true);
        $('.formGeriatri').find('#riwayatJatuhBulanLansia_0').attr('checked',true);
    }
    if($('.formGeriatri').find('#riwayatJatuhRSLansia_0').prop('checked')==true || $('.formGeriatri').find('#riwayatJatuhBulanLansia_0').prop('checked')==true){
        $('.formGeriatri').find('.resiko_jatuh_lansia').val(true);
        $('.formGeriatri').find('.skor_resiko_jatuh_lansia').val(6);
    }else if($('.formGeriatri').find('#riwayatJatuhRSLansia_0').prop('checked')==false || $('.formGeriatri').find('#riwayatJatuhBulanLansia_0').prop('checked')==false){
        $('.formGeriatri').find('.resiko_jatuh_lansia').val(false);
        $('.formGeriatri').find('.skor_resiko_jatuh_lansia').val(0);
    }
    skorresikojatuh_geriatri();
}

function setStatusMental_geriatri(obj){
    if($('.formGeriatri').find('.status_mental_lansia').val() != '' && $('.formGeriatri').find('.status_mental_lansia').val() == 1){
        $('.formGeriatri').find('#statusMentalDeliriumLansia_0').attr('checked',true);
        $('.formGeriatri').find('#statusMentalDisorientasiLansia_0').attr('checked',true);
        $('.formGeriatri').find('#statusMentalAgitasiLansia_0').attr('checked',true);
    }
     if($('.formGeriatri').find('#statusMentalDeliriumLansia_0').prop('checked')==true ||
           $('.formGeriatri').find('#statusMentalDisorientasiLansia_0').prop('checked')==true ||
           $('.formGeriatri').find('#statusMentalAgitasiLansia_0').prop('checked')==true){
            $('.formGeriatri').find('.status_mental_lansia').val(true);
            $('.formGeriatri').find('.skor_status_mental_lansia').val(14);
        }else if($('.formGeriatri').find('#statusMentalDeliriumLansia_0').prop('checked')==false ||
           $('.formGeriatri').find('#statusMentalDisorientasiLansia_0').prop('checked')==false ||
           $('.formGeriatri').find('#statusMentalAgitasiLansia_0').prop('checked')==false){
            $('.formGeriatri').find('.status_mental_lansia').val(false);
            $('.formGeriatri').find('.skor_status_mental_lansia').val(0);
        }
    skorresikojatuh_geriatri();
}

function setPengelihatan_geriatri(obj){
    if($('.formGeriatri').find('.penglihatan_lansia').val() != '' && $('.formGeriatri').find('.penglihatan_lansia').val() == 1){
        $('.formGeriatri').find('#penglihatanKacamataLansia_0').attr('checked',true);
        $('.formGeriatri').find('#penglihatanBuramLansia_0').attr('checked',true);
        $('.formGeriatri').find('#penglihatanKatarakLansia_0').attr('checked',true);
    }

     if($('.formGeriatri').find('#penglihatanKacamataLansia_0').prop('checked')==true ||
           $('.formGeriatri').find('#penglihatanBuramLansia_0').prop('checked')==true ||
           $('.formGeriatri').find('#penglihatanKatarakLansia_0').prop('checked')==true){
            $('.formGeriatri').find('.penglihatan_lansia').val(true);
            $('.formGeriatri').find('.skor_penglihatan_lansia').val(1);
        }else{
            $('.formGeriatri').find('.penglihatan_lansia').val(false);
            $('.formGeriatri').find('.skor_penglihatan_lansia').val(0);
        }
    skorresikojatuh_geriatri();
}

function setKebiasaanBerkemih_geriatri(obj){
     if ($('.formGeriatri').find(obj).val()=='1' && $('.formGeriatri').find(obj).prop('checked')==true){
            $('.formGeriatri').find('.skor_berkemih_lansia').val(2);
        }else if ($('.formGeriatri').find(obj).val()=='0' && $('.formGeriatri').find(obj).prop('checked')==true){
            $('.formGeriatri').find('.skor_berkemih_lansia').val(0);
        }
    skorresikojatuh_geriatri();
}

function getTransferLansia_geriatri(){
    if($('.formGeriatri').find('.transfer_mobilitas_lansia').val() != ''){
        var trs = '';
         $('.formGeriatri').find('#transferLansia').find('option').each(function(){
            if($(this).text() == $('.formGeriatri').find('.transfer_mobilitas_lansia').val()){
                trs = $(this).val();
            }
        });
        $('.formGeriatri').find('#transferLansia').val(trs);
    }

    if($('.formGeriatri').find('#transferLansia').val() != ""){
        $('.formGeriatri').find('.transfer_mobilitas_lansia').val($('.formGeriatri').find('#transferLansia').find('option:selected').text());
        $('.formGeriatri').find('#transferLansiaHidden').val($('.formGeriatri').find('#transferLansia').val());
    }else{
         $('.formGeriatri').find('.transfer_mobilitas_lansia').val("");
        $('.formGeriatri').find('#transferLansiaHidden').val(0);
    }

    totalTransferMobilitas_geriatri();
}

function getMobilitasLansia_geriatri(){
    if($('.formGeriatri').find('.mobilitas_lansia').val() != ''){
        var mob = '';
         $('.formGeriatri').find('#mobilitasLansia').find('option').each(function(){
            if($(this).text() == $('.formGeriatri').find('.mobilitas_lansia').val()){
                mob = $(this).val();
            }
        });
        $('.formGeriatri').find('#mobilitasLansia').val(mob);
    }

    if($('.formGeriatri').find('#mobilitasLansia').val() != ""){
        $('.formGeriatri').find('.mobilitas_lansia').val($('.formGeriatri').find('#mobilitasLansia').find('option:selected').text());
         $('.formGeriatri').find('#mobilitasLansiaHidden').val($('.formGeriatri').find('#mobilitasLansia').val());
    }else{
        $('.formGeriatri').find('.mobilitas_lansia').val("");
      $('.formGeriatri').find('#mobilitasLansiaHidden').val(0);
    }

    totalTransferMobilitas_geriatri();
}

function totalTransferMobilitas_geriatri(){
   var trf = $('.formGeriatri').find('#transferLansiaHidden').val();
   var mobil = $('.formGeriatri').find('#mobilitasLansiaHidden').val();
   var jumlah = parseInt(trf) + parseInt(mobil);
   var totalJml = 0;
   if (!isNaN(jumlah)) {
       if(jumlah >=0 && jumlah <= 3){
           totalJml = 0;
       }else{
           totalJml = 7;
       }
   }
   $('.formGeriatri').find('.skor_transfer_mobilitas_lansia').val(totalJml);
   skorresikojatuh_geriatri();
}

function skorresikojatuh_geriatri(){
    var totalSkorLansia = 0;

    $('.formGeriatri').find('#tblResikojatuhLansia').find('.resikojatuhlansia_skor').each(function(){
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
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'jumlah_skor_lansia') ?>').val(totalSkorLansia);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'keterangan_skor_lansia') ?>').val(ketResikoLansia);


    $('.formGeriatri').find('.isadaresikojatuh').each(function(){
      if($('.formGeriatri').find(this).val() == 1 && $('.formGeriatri').find(this).prop('checked')==true){
          $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoLansia);
      }
    });
}

function setKesadaranNyeri_geriatri(){
  var indexLainnya = 0;
  $('.formGeriatri').find('.kesadaranpasien_pengkajiannyeri').each(function(){
    if($(this).val()=='Sadar' &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('.panelsadar').show();
      $('.formGeriatri').find('.paneltidaksadar').hide();
      indexLainnya += 1;
    }else if($(this).val()=='Tidak Sadar' &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('.panelsadar').hide();
      $('.formGeriatri').find('.paneltidaksadar').show();
      indexLainnya += 1;
    }
  });

  if(indexLainnya == 0){
    $('.formGeriatri').find('.panelsadar').hide();
    $('.formGeriatri').find('.paneltidaksadar').hide();
  }
}

function pilihNyeri_geriatri(obj){
  if($('.formGeriatri').find(obj).val() == 0 && $('.formGeriatri').find(obj).prop('checked')==true){
        inputAllDisabled_dws($('.formGeriatri').find('#nyeri_dewasa').find('.panel-body'));
        $('.formGeriatri').find('#nyeri_dewasa').find('.panel-body').hide();

    } else if($('.formGeriatri').find(obj).val() == 1 && $('.formGeriatri').find(obj).prop('checked')==true){
        inputAllEnabled_dws($('.formGeriatri').find('#nyeri_dewasa').find('.panel-body'));
        $('.formGeriatri').find('#nyeri_dewasa').find('.panel-body').show();
    }
}

function pilihScala_geriatri(skor){
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
        $('.formGeriatri').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val(skor);
        $('.formGeriatri').find("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").val(keterangan);
    //}

    $('.formGeriatri').find(".nyeri-nomor").css("border", "none");
    $('.formGeriatri').find(".nyeri-nomor").css("border-radius", "5px");
    $('.formGeriatri').find("#nyerinomor_" + skor).css("border", "1px solid black");
}

function setAdaNyeri_geriatri(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.isadakeluhannyeri').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('.jenisnyeri').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formGeriatri').find('.jenisnyeri').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
  }
}

function setKualitasNyeri_geriatri(){
  $('.formGeriatri').find('.kualitasnyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',false);
      }else{
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').val('');
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',true);
      }
  });
}

function changeDeskripsinyeri_ismenjalar_geriatri(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.deskripsinyeri_ismenjalar').each(function(){
    if($(this).val()=='1' &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('disabled',true);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').val('');
  }
}

function setFrekuensiNyeri_geriatri(){
  $('.formGeriatri').find('.frekuensinyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',false);
      }else{
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').val('');
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',true);
      }
  });
}

function changeNyeriHilangLain_geriatri(obj){
    if($('.formGeriatri').find(obj).prop('checked')==true){
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',false);
    }else{
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',true);
        $('.formGeriatri').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').val('');
    }
}

function venekpresi_geriatri(obj){
  if($('.formGeriatri').find(obj).val() != ''){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahskor') ?>').val($(obj).val());
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahpenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahskor') ?>').val(0);
  }
    skorventilator_geriatri();
}

function venekstremitas_geriatri(obj){
  if($('.formGeriatri').find(obj).val() != ''){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasatasskor') ?>').val($(obj).val());
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasataspenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasatasskor') ?>').val(0);
  }
    skorventilator_geriatri();
}

function venpatuh_geriatri(obj){
  if($('.formGeriatri').find(obj).val() != ''){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorskor') ?>').val($(obj).val());
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorpenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorskor') ?>').val(0);
  }
    skorventilator_geriatri();
}


function skorventilator_geriatri(){
    var totalSkor = 0;

    $('.formGeriatri').find('#tbl_ventilator').find('.skor_ventilator').each(function(){
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

    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'score_skalanyeri_dws') ?>').val(totalSkor);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($model,'keteranganskala_nyeri_dws') ?>').val(risDewasa);
}

function setHambatanLainnya_geriatri(){
  if($('.formGeriatri').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_lainnya') ?>').prop('checked')==true){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'hambatanbelajar_lainnya') ?>').attr('readonly',false);
  }else{
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'hambatanbelajar_lainnya') ?>').attr('readonly',true);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'hambatanbelajar_lainnya') ?>').val('');
  }
}

function setEdukasiPenerjemah_geriatri(){
  var index = 0;
  var indexLainnya = 0;
  $('.formGeriatri').find('.kebutuhanpenerjemah_status').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formGeriatri').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').attr('disabled',true);
    $('.formGeriatri').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').val('');
  }
}

function setChangeDetEdukasiLain_geriatri(obj){
    var index = $('.formGeriatri').find(obj).attr('text_id');

    if($('.formGeriatri').find(obj).prop('checked')==true){
        $('.formGeriatri').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('readonly',false);
    }else{
        $('.formGeriatri').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('readonly',true);
        $('.formGeriatri').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').val('');
    }
}

function setKlikUploadMMSE(){
  var total_file=$('.formGeriatri').find('.uploadgambar_mmse').prop('files').length;
  $('.formGeriatri').find('#div_uploadmmse').html('');

  for(var i=0;i<total_file;i++){
    var eventData = $('.formGeriatri').find('.uploadgambar_mmse').prop('files')[i];
    var htmlupl = '';

    htmlupl = '<div class="div_upldmmse">' +
      eventData.name +
        ' <a onclick="batalUpload(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan upload"><i class="icon-remove"></i></a>'+
      '</div>';
      $('.formGeriatri').find('#div_uploadmmse').append(htmlupl);
  }
}

function batalUpload(obj){
  $('.formGeriatri').find(obj).parents('.div_upldmmse').remove();
}

function batalUploadServer(obj,id) {
  $.post('<?php echo $this->createUrl('hapusMMSEDetail'); ?>', {id: id}, function(data) {
      if (data.sukses === 1) {
          $('.formGeriatri').find(obj).parents('.div_serveruploadmmse').remove();
      } else {
          myAlert(data.msg);
      }
  }, 'json');
}

function setNiliaRespondenMMSE(){
  var total = 0;
  $('.formGeriatri').find('#tbl_mmse tbody tr').each(function(){
    var nilai = parseInt($(this).find('input[name$="[nilai_responden]"]').val());
    if(isNaN(nilai)){
      nilai = 0;
    }
    total += nilai;
  });

  var keterangan = "";
  if(total <= 16){
    keterangan = "Definite Gangguan Kognitif";
  }else if(total >= 17 && total <= 23){
    keterangan = "Probable Gangguan Kognitif";
  }else if(total >= 24){
    keterangan = "Normal";
  }
  $('.formGeriatri').find('#<?php echo CHtml::activeId($modAskepgeriatriT,'minimentalexam_skor') ?>').val(total);
  $('.formGeriatri').find('#<?php echo CHtml::activeId($modAskepgeriatriT,'minimentalexam_keterangan') ?>').val(keterangan);
}

$(document).ready(function(){
  $('.formGeriatri').find('.groupUkurans').find('input').keyup(function(){
       gantiHidden_geriatri();
       getBeratBadanIdeal_geriatri();
       getBMI_geriatri();
   });

  setSumberData();
  setStatusAlergi_geriatri();
  setStatusPembedahanAnastesi_geriatri();
  setStatusRiwayattransfusi_geriatri();
  getText_geriatri();
  pilihFungsional_geriatri();
  setKesadaranNyeri_geriatri();
  setAdaNyeri_geriatri();
  setKualitasNyeri_geriatri();
  changeDeskripsinyeri_ismenjalar_geriatri();
  setFrekuensiNyeri_geriatri();
  setHambatanLainnya_geriatri();
  setEdukasiPenerjemah_geriatri();
  setNiliaRespondenMMSE();

  $('.formGeriatri').find(".pilih_SkrinningGizi").each(function(){
      choiseSkrinningGizi_geriatri($(this));
  });

  $('.formGeriatri').find('.pilih_nyeri').each(function(){
      pilihNyeri_geriatri($(this));
  });
    $('#checkSimpanData').val('');
    $('.formGeriatri').find('#rootwizardAskepGeriatri').bootstrapWizard({
      tabClass: "",
        onTabShow: function($tab, $navigation, index)
        {
          setCurrentProgressTab($(this), $navigation, $tab, $(this).find(".steps-progress div"), index);
        },
        onPrevious: function(tab, navigation, index){
        },
        onNext: function(tab, navigation, index){
          var postdata = $('.formGeriatri').find('#askepgeriatri-t-form');
          var indexStepGeriatri = 10;

          var cekGeriatri = simpanDataForm_geriatri(postdata, index);
          if(index == indexStepGeriatri && cekGeriatri==true){
              $('.formGeriatri').find('.next').hide();
          }else{
            $('.formGeriatri').find('.next').show();
          }

          return cekGeriatri;
          // return true;
        },
        onTabClick: function(tab, navigation, index){
        }
      });
});

</script>
