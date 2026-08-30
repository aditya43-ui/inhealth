<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
    
function usia_anak(obj){
    
    if($('.formanak').find(obj).val() != ''){
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[0]skor') ?>').val($(obj).val());
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[0]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[0]skor') ?>').val(0);
    }
    hitungskor_anak();
}

function jeniskelamin_skrining_anak(obj){
    
    if($('.formanak').find(obj).val() != ''){
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[1]skor') ?>').val($(obj).val());
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[1]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[1]skor') ?>').val(0);
    }
    hitungskor_anak();
}

function diagnose_anak(obj){
    
    if($('.formanak').find(obj).val() != ''){
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[2]skor') ?>').val($(obj).val());
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[2]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[2]skor') ?>').val(0);
    }
    hitungskor_anak();
}

function kognitif_anak(obj){
    
    if($('.formanak').find(obj).val() != ''){
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[3]skor') ?>').val($(obj).val());
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[3]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[3]skor') ?>').val(0);
    }
    hitungskor_anak();
}

function faktor_lingkungan_anak(obj){
    
    if($('.formanak').find(obj).val() != ''){
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[4]skor') ?>').val($(obj).val());
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[4]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[4]skor') ?>').val(0);
    }
    hitungskor_anak();
}

function respon_terhadap_anak(obj){
    
    if($('.formanak').find(obj).val() != ''){
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[5]skor') ?>').val($(obj).val());
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[5]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[5]skor') ?>').val(0);
    }
    hitungskor_anak();
}

function pembedahan_medikamentosa_anak(obj){
    
    if($('.formanak').find(obj).val() != ''){
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[6]skor') ?>').val($(obj).val());
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[6]penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    }else{
        $('.formanak').find('#<?php echo CHtml::activeId($modHasil,'[6]skor') ?>').val(0);
    }
    hitungskor_anak();
}


function hitungskor_anak(){
    var totalSkorAnak = 0;

    $('.formanak').find('#tblInputResikoAnak').find('.skoringanak').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorAnak += parseInt(skor);
    });

    if (totalSkorAnak >= 7 && totalSkorAnak <=11){
        $('.formanak').find('#<?php echo CHtml::activeId($model,'keteranganskor_resikojatuh') ?>').val('RESIKO RENDAH');    
    }else if (totalSkorAnak >= 12){
        $('.formanak').find('#<?php echo CHtml::activeId($model,'keteranganskor_resikojatuh') ?>').val('RESIKO TINGGI');
    }
    
    $('.formanak').find('#<?php echo CHtml::activeId($model,'totalskor') ?>').val(totalSkorAnak);
}


function simpanData_anak(){
    var indexNext = $('.formanak').find('#rootwizardResikoJatuhAnak').data('bootstrapWizard').nextIndex();
    var indexstep = $('.formanak').find('#rootwizardResikoJatuhAnak').data('bootstrapWizard').currentIndex();
    var suksesData = false;
    if(requiredCheck($('.formanak').find('#formanak-t-form'))){
      var indexNext = $('.formanak').find('#rootwizardResikoJatuhAnak').data('bootstrapWizard').nextIndex();
      $(".formanak").addClass("animation-loading");
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
        var dataSerialized = $('.formanak').find('#formanak-t-form').serializeArray();
        //   var dataSerialized = $('.formanak').find(simpanDt).serializeArray();
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
                    $('.formanak').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                    $.fn.yiiGridView.update('riwayatrisikojatuh-grid', {
                            data: $('#searchRiwayat').serialize()
                        });
                    
                }else{
                    $('.formanak').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                }

                if(suksesData==true){
                    setTimeout(function(){
                        $('.formanak').find('.divAlert').html('');
                    }, 5000);
                }


                }else{
                    $('.formanak').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
                }
                $(".formanak").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formanak").removeClass("animation-loading");}
      });
    }
    return suksesData;
    
}



function simpanDataForm_anak(simpanDt, indexstep, handeland){
    var suksesData = false;
    if(requiredCheck($('.formanak').find(simpanDt))){
      var indexNext = $('.formanak').find('#rootwizardResikoJatuhAnak').data('bootstrapWizard').nextIndex();
      $(".formanak").addClass("animation-loading");
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

      var dataSerialized = $('.formanak').find(simpanDt).serializeArray();
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
                        $('.formanak').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                        $('#PengkajianresikojatuhT_pengkajianresikojatuh_id').val(data.pengkajianresikojatuh_id);
                        if (data.resiko ==  'RESIKO RENDAH'){
                            $('#IntervensicegahjatuhpasienT_resikojatuh_tingkat_0').prop('checked',true);	
                        }else{
                            $('#IntervensicegahjatuhpasienT_resikojatuh_tingkat_1').prop('checked',true);	
                        }
                        $('.cekreq').attr('required',true);
                        
                    }else{
                        $('.formanak').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                    }

                    if(suksesData==true){
                        setTimeout(function(){
                            $('.formanak').find('.divAlert').html('');
                        }, 5000);
                    }


                }else{
                    $('.formanak').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
                }
                $(".formanak").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formanak").removeClass("animation-loading");}
      });
    }
    return suksesData;
    
}


function setRisikoJatuh(obj){
    
      var findParent = $(obj).parents().find('.panel_cegah').find('.formCegah:visible');
        if($(findParent).find(obj).val() === 'Resiko Rendah' && $(findParent).find(obj).prop('checked') === true){
            
            $(findParent).find('#tblpencegahan').find('.intervensirendah').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensirendah').removeClass('classlabeldisabled');
            $(findParent).find('#tblpencegahan').find('.checkisdilakukan_r').attr('checked',true);

            $(findParent).find('#tblpencegahan').find('.intervensitinggi').find('input').attr('disabled',true);
            $(findParent).find('#tblpencegahan').find('.textintervensitinggi').addClass('classlabeldisabled');
            $(findParent).find('#tblpencegahan').find('.checkisdilakukan_s').attr('checked',false);

            // $(findParent).find('#tblpencegahan').find('.intervensisangattinggi').find('input').attr('disabled',true);
            // $(findParent).find('#tblpencegahan').find('.textintervensisangattinggi').addClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_t').attr('checked',false);
        }else if($(findParent).find(obj).val() === 'Resiko Tinggi' && $(findParent).find(obj).prop('checked') === true){
            $(findParent).find('#tblpencegahan').find('.intervensirendah').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensirendah').removeClass('classlabeldisabled');
            $(findParent).find('#tblpencegahan').find('.checkisdilakukan_r').attr('checked',true);

            $(findParent).find('#tblpencegahan').find('.intervensitinggi').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensitinggi').removeClass('classlabeldisabled');
            $(findParent).find('#tblpencegahan').find('.checkisdilakukan_s').attr('checked',true);

            // $(findParent).find('#tblpencegahan').find('.intervensisangattinggi').find('input').attr('disabled',true);
            // $(findParent).find('#tblpencegahan').find('.textintervensisangattinggi').addClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_t').attr('checked',false);
        }else if($(findParent).find(obj).val() === 'Resiko Sangat Tinggi' && $(findParent).find(obj).prop('checked') === true){
            $(findParent).find('#tblpencegahan').find('.intervensirendah').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensirendah').removeClass('classlabeldisabled');
            $(findParent).find('#tblpencegahan').find('.checkisdilakukan_r').attr('checked',true);

            $(findParent).find('#tblpencegahan').find('.intervensitinggi').find('input').attr('disabled',false);
            $(findParent).find('#tblpencegahan').find('.textintervensitinggi').removeClass('classlabeldisabled');
            $(findParent).find('#tblpencegahan').find('.checkisdilakukan_s').attr('checked',true);

            // $(findParent).find('#tblpencegahan').find('.intervensisangattinggi').find('input').attr('disabled',false);
            // $(findParent).find('#tblpencegahan').find('.textintervensisangattinggi').removeClass('classlabeldisabled');
            // $(findParent).find('#tblpencegahan').find('.checkisdilakukan_t').attr('checked',true);
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

    function dialogRiwayat(){
        $('#dialogDetail').dialog('open');
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

            // $('.intervensisangattinggi').find('input').attr('disabled',true);
            // $('.textintervensisangattinggi').addClass('classlabeldisabled');
            // $('.checkisdilakukan_t').attr('checked',false);
        }else if(cek_1 === true){
            $('.intervensirendah').find('input').attr('disabled',false);
            $('.textintervensirendah').removeClass('classlabeldisabled');
            $('.checkisdilakukan_r').attr('checked',true);

            $('.intervensitinggi').find('input').attr('disabled',false);
            $('.textintervensitinggi').removeClass('classlabeldisabled');
            $('.checkisdilakukan_s').attr('checked',true);

            // $('.intervensisangattinggi').find('input').attr('disabled',true);
            // $('.textintervensisangattinggi').addClass('classlabeldisabled');
            // $('.checkisdilakukan_t').attr('checked',false);
        }else if(cek_2 === true){
            $('.intervensirendah').find('input').attr('disabled',false);
            $('.textintervensirendah').removeClass('classlabeldisabled');
            $('.checkisdilakukan_r').attr('checked',true);

            $('.intervensitinggi').find('input').attr('disabled',false);
            $('.textintervensitinggi').removeClass('classlabeldisabled');
            $('.checkisdilakukan_s').attr('checked',true);

            // $('.intervensisangattinggi').find('input').attr('disabled',false);
            // $('.textintervensisangattinggi').removeClass('classlabeldisabled');
            // $('.checkisdilakukan_t').attr('checked',true);
        }
    }


$(document).ready(function(){
    $('.cekreq').attr('required');
    $('#checkSimpanData').val('');
    
    $('.formanak').find('#rootwizardResikoJatuhAnak').bootstrapWizard({
      tabClass: "",
        onTabShow: function($tab, $navigation, index)
        {
          setCurrentProgressTab($(this), $navigation, $tab, $(this).find(".steps-progress div"), index);
        },
        onPrevious: function(tab, navigation, index){
        },
        onNext: function(tab, navigation, index){
          var postdata = $('.formanak').find('#formanak-t-form');
          var indexStepDewasa = 1;
          var cekDewasa = simpanDataForm_anak(postdata, index);
          if(index == indexStepDewasa && cekDewasa==true){
                $('.formanak').find('.next').hide();
                
          }else{
                $('.formanak').find('.next').show();
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
