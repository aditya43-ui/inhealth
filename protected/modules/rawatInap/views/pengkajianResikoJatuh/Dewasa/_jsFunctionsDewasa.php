<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
    
function usia_dewasa(obj){
    
    if($('.formdewasa').find(obj).val() != ''){
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[0]skor') ?>').val($(obj).val());
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[0]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[0]skor') ?>').val(0);
    }
    hitungskor_dewasa();
}

function defisit(obj){
    
    if($('.formdewasa').find(obj).val() != ''){
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[1]skor') ?>').val($(obj).val());
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[1]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[1]skor') ?>').val(0);
    }
    hitungskor_dewasa();
}

function akktivitas(obj){
    
    if($('.formdewasa').find(obj).val() != ''){
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[2]skor') ?>').val($(obj).val());
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[2]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[2]skor') ?>').val(0);
    }
    hitungskor_dewasa();
}

function riwayatjatuh(obj){
    
    if($('.formdewasa').find(obj).val() != ''){
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[3]skor') ?>').val($(obj).val());
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[3]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[3]skor') ?>').val(0);
    }
    hitungskor_dewasa();
}

function kognisi(obj){
    
    if($('.formdewasa').find(obj).val() != ''){
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[4]skor') ?>').val($(obj).val());
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[4]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[4]skor') ?>').val(0);
    }
    hitungskor_dewasa();
}

function pengobatan(obj){
    
    if($('.formdewasa').find(obj).val() != ''){
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[5]skor') ?>').val($(obj).val());
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[5]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[5]skor') ?>').val(0);
    }
    hitungskor_dewasa();
}

function mobilitas(obj){
    
    if($('.formdewasa').find(obj).val() != ''){
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[6]skor') ?>').val($(obj).val());
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[6]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[6]skor') ?>').val(0);
    }
    hitungskor_dewasa();
}

function polaeliminasi(obj){
    
    if($('.formdewasa').find(obj).val() != ''){
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[7]skor') ?>').val($(obj).val());
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[7]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[7]skor') ?>').val(0);
    }
    hitungskor_dewasa();
}

function komorbiditas(obj){
    
    if($('.formdewasa').find(obj).val() != ''){
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[8]skor') ?>').val($(obj).val());
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[8]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formdewasa').find('#<?php echo CHtml::activeId($modHasil,'[8]skor') ?>').val(0);
    }
    hitungskor_dewasa();
}


function hitungskor_dewasa(){
    var totalSkordewasa = 0;
    var keterangan = "";
    var resiko = "";

    $('.formdewasa').find('#tblInputResikodewasa').find('.skoringdewasa').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkordewasa += parseInt(skor);
    });

    if (totalSkordewasa >= 7 && totalSkordewasa <=11){
        keterangan = 'RESIKO RENDAH';
        resiko = "Resiko Rendah";
    }else if (totalSkordewasa >= 12){
        keterangan = 'RESIKO TINGGI';
        resiko = "Resiko Tinggi";
    }
    $('.formdewasa').find('#<?php echo CHtml::activeId($model,'keteranganskor_resikojatuh') ?>').val(keterangan);    
    $('.formdewasa').find('#<?php echo CHtml::activeId($model,'totalskor') ?>').val(totalSkordewasa);

    if(keterangan != ''){
        $('.formdewasa').find('.risikojatuh').each(function(){
            if($(this).val() == resiko){
                $(this).attr('checked',true);
            }
        });
        
        $('.formdewasa').find('#<?php echo CHtml::activeId($modIntervensi,'resikojatuh_tingkat') ?>').val(resiko).prop('checked',true);;

        setRisikoJatuh($('.formdewasa').find('#<?php echo CHtml::activeId($modIntervensi,'resikojatuh_tingkat') ?>'));
    }
    
}


function simpanData_dewasa(){
    var indexNext = $('.formdewasa').find('#rootwizardResikoJatuhdewasa').data('bootstrapWizard').nextIndex();
    var indexstep = $('.formdewasa').find('#rootwizardResikoJatuhdewasa').data('bootstrapWizard').currentIndex();
    var suksesData = false;
    if(requiredCheck($('.formdewasa').find('#formdewasa-t-form'))){
      var indexNext = $('.formdewasa').find('#rootwizardResikoJatuhdewasa').data('bootstrapWizard').nextIndex();
      $(".formdewasa").addClass("animation-loading");
      var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
      var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
      var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
      var pengkajianresikojatuh_id = $('#<?php echo Chtml::activeId($model, 'pengkajianresikojatuh_id') ?>').val();

      if(indexstep > 0){
        $('#checkSimpanData').val('simpan');
      }else if (indexstep == 1){
        $('#checkSimpanData').val('');
      }

         var checksimpan = $('#checkSimpanData').val();
        var dataSerialized = $('.formdewasa').find('#formdewasa-t-form').serializeArray();
        //   var dataSerialized = $('.formdewasa').find(simpanDt).serializeArray();
        dataSerialized.push({name: 'indexcurrent',value:indexstep});
        dataSerialized.push({name: 'indexNext',value:indexNext});
        dataSerialized.push({name: 'checksimpan',value:checksimpan});
        dataSerialized.push({name: 'PengkajianresikojatuhT[pendaftaran_id]',value:pendaftaran_id});
        dataSerialized.push({name: 'PengkajianresikojatuhT[pasien_id]',value:pasien_id});
        dataSerialized.push({name: 'PengkajianresikojatuhT[pengkajianresikojatuh_id]',value:pengkajianresikojatuh_id});


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
                    $('.formdewasa').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                    $.fn.yiiGridView.update('riwayatdewasa-t-grid', {
                        data: {
                            "PengkajianresikojatuhT[pendaftaran_id]":pendaftaran_id,
                            "PengkajianresikojatuhT[skalajatuh_jenis]":'dewasa_morsefallscale'
                        }
                    });
                }else{
                    $('.formdewasa').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                }

                if(suksesData==true){
                    setTimeout(function(){
                        $('.formdewasa').find('.divAlert').html('');
                    }, 5000);
                }


                }else{
                    $('.formdewasa').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
                }
                $(".formdewasa").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formdewasa").removeClass("animation-loading");}
      });
    }
    return suksesData;
    
}



function simpanDataForm_dewasa(simpanDt, indexstep, handeland){
    var suksesData = false;
    if(requiredCheck($('.formdewasa').find(simpanDt))){
      var indexNext = $('.formdewasa').find('#rootwizardResikoJatuhdewasa').data('bootstrapWizard').nextIndex();
      $(".formdewasa").addClass("animation-loading");
      var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
      var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
      var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
      var pengkajianresikojatuh_id = $('#<?php echo Chtml::activeId($model, 'pengkajianresikojatuh_id') ?>').val();

      if(indexstep > 1){
        $('#checkSimpanData').val('simpan');
      }else if (indexstep == 1){
        $('#checkSimpanData').val('');
      }

      var checksimpan = $('#checkSimpanData').val();

      var dataSerialized = $('.formdewasa').find(simpanDt).serializeArray();
      dataSerialized.push({name: 'indexcurrent',value:indexstep});
      dataSerialized.push({name: 'indexNext',value:indexNext});
      dataSerialized.push({name: 'checksimpan',value:checksimpan});
      dataSerialized.push({name: 'PengkajianresikojatuhT[pendaftaran_id]',value:pendaftaran_id});
        dataSerialized.push({name: 'PengkajianresikojatuhT[pasien_id]',value:pasien_id});
        dataSerialized.push({name: 'PengkajianresikojatuhT[pengkajianresikojatuh_id]',value:pengkajianresikojatuh_id});


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
                        $('.formdewasa').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                        $('#PengkajianresikojatuhT_pengkajianresikojatuh_id').val(data.pengkajianresikojatuh_id);
                        if (data.resiko ==  'RESIKO RENDAH'){
                            $('#IntervensicegahjatuhpasienT_resikojatuh_tingkat_0').prop('checked',true);	
                        }else{
                            $('#IntervensicegahjatuhpasienT_resikojatuh_tingkat_1').prop('checked',true);	
                        }
                        $('.cekreq').attr('required',true);
                        
                    }else{
                        $('.formdewasa').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                    }

                    if(suksesData==true){
                        setTimeout(function(){
                            $('.formdewasa').find('.divAlert').html('');
                        }, 5000);
                    }


                }else{
                    $('.formdewasa').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
                }
                $(".formdewasa").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formdewasa").removeClass("animation-loading");}
      });
    }
    return suksesData;
    
}


function setRisikoJatuh(obj){
    // var findParent = $(obj).parents().find('.panel_cegah').find('.formCegah:visible');
    var findParent = $(obj).parents().find('.panel_cegah').find('.formCegah');
    
        if($(findParent).find(obj).val() === 'Resiko Rendah' && $(findParent).find(obj).prop('checked') === true){
            $(findParent).find('#tblpencegahan').find('.intervensirendah').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensirendah').removeClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_r').attr('checked',true);
            checkedAllTindakan($(findParent).find('#tblpencegahan').find('.checkisdilakukan_r'), true);

            $(findParent).find('#tblpencegahan').find('.intervensitinggi').find('input').attr('disabled',true);
            $(findParent).find('#tblpencegahan').find('.textintervensitinggi').addClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_s').attr('checked',false);
            checkedAllTindakan($(findParent).find('#tblpencegahan').find('.checkisdilakukan_s'), false);

            $(findParent).find('#tblpencegahan').find('.intervensisangattinggi').find('input').attr('disabled',true);
            $(findParent).find('#tblpencegahan').find('.textintervensisangattinggi').addClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_t').attr('checked',false);
            checkedAllTindakan($(findParent).find('#tblpencegahan').find('.checkisdilakukan_t'), false);

        }else if($(findParent).find(obj).val() === 'Resiko Tinggi' && $(findParent).find(obj).prop('checked') === true){
            $(findParent).find('#tblpencegahan').find('.intervensirendah').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensirendah').removeClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_r').attr('checked',true);
            checkedAllTindakan($(findParent).find('#tblpencegahan').find('.textintervensirendah'), true);
            
            $(findParent).find('#tblpencegahan').find('.intervensitinggi').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensitinggi').removeClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_s').attr('checked',true);
            checkedAllTindakan($(findParent).find('#tblpencegahan').find('.checkisdilakukan_s'), true);
            
            $(findParent).find('#tblpencegahan').find('.intervensisangattinggi').find('input').attr('disabled',true);
            $(findParent).find('#tblpencegahan').find('.textintervensisangattinggi').addClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_t').attr('checked',false);
            checkedAllTindakan($(findParent).find('#tblpencegahan').find('.checkisdilakukan_t'), false);
        }else if($(findParent).find(obj).val() === 'Resiko Sangat Tinggi' && $(findParent).find(obj).prop('checked') === true){
            $(findParent).find('#tblpencegahan').find('.intervensirendah').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensirendah').removeClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_r').attr('checked',true);
            checkedAllTindakan($(findParent).find('#tblpencegahan').find('.textintervensirendah'), true);
            
            $(findParent).find('#tblpencegahan').find('.intervensitinggi').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensitinggi').removeClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_s').attr('checked',true);
            checkedAllTindakan($(findParent).find('#tblpencegahan').find('.checkisdilakukan_s'), true);

            $(findParent).find('#tblpencegahan').find('.intervensisangattinggi').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensisangattinggi').removeClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_t').attr('checked',true);
            checkedAllTindakan($(findParent).find('#tblpencegahan').find('.checkisdilakukan_t'), true);
        }
        // else if(($(findParent).find(obj).val() === 'Rendah' || $(findParent).find(obj).val() === 'Sedang' || $(findParent).find(obj).val() === 'Tinggi') && $(findParent).find(obj).prop('checked') === false){
        //     $(findParent).find('#tblpencegahan').find('.intervensirendah').find('input').attr('disabled',true);
        //     $(findParent).find('#tblpencegahan').find('.textintervensirendah').addClass('classlabeldisabled');
        //     $(findParent).find('#tblpencegahan').find('.checkisdilakukan_r').attr('checked',false);
        //
        //     $(findParent).find('#tblpencegahan').find('.intervensisedang').find('input').attr('disabled',true);
        //     $(findParent).find('#tblpencegahan').find('.textintervensisedang').addClass('classlabeldisabled');
        //     $(findParent).find('#tblpencegahan').find('.checkisdilakukan_s').attr('checked',false);
        //
        //     $(findParent).find('#tblpencegahan').find('.intervensitinggi').find('input').attr('disabled',true);
        //     $(findParent).find('#tblpencegahan').find('.textintervensitinggi').addClass('classlabeldisabled');
        //     $(findParent).find('#tblpencegahan').find('.checkisdilakukan_t').attr('checked',false);
        // }
    }

    function checkedAllTindakan(obj, ischeck){
        $(obj).each(function(){
            $(this).prop('checked',ischeck);
        });
    }

    function loadRisikoJatuh(){
        var cek = $('#IntervensicegahjatuhpasienT_resikojatuh_tingkat_0').prop('checked');
        var cek_1 = $('#IntervensicegahjatuhpasienT_resikojatuh_tingkat_1').prop('checked');
        var cek_2 = $('#IntervensicegahjatuhpasienT_resikojatuh_tingkat_2').prop('checked');
        
        if(cek === true){
            $('.intervensirendah').find('input').attr('disabled',false);
            $('.textintervensirendah').removeClass('classlabeldisabled');
            $('.checkisdilakukan_r').attr('checked',true);

            $('.intervensitinggi').find('input').attr('disabled',true);
            $('.textintervensitinggi').addClass('classlabeldisabled');
            $('.checkisdilakukan_s').attr('checked',false);

            $('.intervensisangattinggi').find('input').attr('disabled',true);
            $('.textintervensisangattinggi').addClass('classlabeldisabled');
            $('.checkisdilakukan_t').attr('checked',false);
        }else if(cek_1 === true){
            $('.intervensirendah').find('input').attr('disabled',false);
            $('.textintervensirendah').removeClass('classlabeldisabled');
            $('.checkisdilakukan_r').attr('checked',true);

            $('.intervensitinggi').find('input').attr('disabled',false);
            $('.textintervensitinggi').removeClass('classlabeldisabled');
            $('.checkisdilakukan_s').attr('checked',true);

            $('.intervensisangattinggi').find('input').attr('disabled',true);
            $('.textintervensisangattinggi').addClass('classlabeldisabled');
            $('.checkisdilakukan_t').attr('checked',false);
        }else if(cek_2 === true){
            $('.intervensirendah').find('input').attr('disabled',false);
            $('.textintervensirendah').removeClass('classlabeldisabled');
            $('.checkisdilakukan_r').attr('checked',true);

            $('.intervensitinggi').find('input').attr('disabled',false);
            $('.textintervensitinggi').removeClass('classlabeldisabled');
            $('.checkisdilakukan_s').attr('checked',true);

            $('.intervensisangattinggi').find('input').attr('disabled',false);
            $('.textintervensisangattinggi').removeClass('classlabeldisabled');
            $('.checkisdilakukan_t').attr('checked',true);
        }
    }


$(document).ready(function(){
    $('.cekreq').attr('required');
    $('#checkSimpanData').val('');
    $('.formdewasa').find('#rootwizardResikoJatuhdewasa').bootstrapWizard({
      tabClass: "",
        onTabShow: function($tab, $navigation, index)
        {
          setCurrentProgressTab($(this), $navigation, $tab, $(this).find(".steps-progress div"), index);
        },
        onPrevious: function(tab, navigation, index){
        },
        onNext: function(tab, navigation, index){
          var postdata = $('.formdewasa').find('#formdewasa-t-form');
          var indexStepDewasa = 1;
          var cekDewasa = simpanDataForm_dewasa(postdata, index);
          if(index == indexStepDewasa && cekDewasa==true){
                $('.formdewasa').find('.next').hide();
          }else{
                $('.formdewasa').find('.next').show();
          }
          loadRisikoJatuh();
          return cekDewasa;
          // return true;
        },
        onTabClick: function(tab, navigation, index){
        }
      });

});


</script>
