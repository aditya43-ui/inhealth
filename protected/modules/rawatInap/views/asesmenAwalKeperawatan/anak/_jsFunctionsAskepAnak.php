<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
    function setStatusAlergi(obj){
      var parentForm = $(obj).parents().find('.formAnak');
        var value = $(parentForm).find(obj).val();

        if(value === '3' && $(parentForm).find(obj).prop('checked')==true){
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('readonly',false);
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('readonly',false);
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('readonly',false);
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'ispasangtandaalergi') ?>').attr('readonly',false).attr('disabled',false);
        }else{
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('readonly',true);
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('readonly',true);
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('readonly',true);
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'ispasangtandaalergi') ?>').attr('readonly',true).attr('disabled',true);
        }
    }

    function setStatusPembedahanAnastesi(obj){
      var parentForm = $(obj).parents().find('.formAnak');
        var value = $(parentForm).find(obj).val();

        if($('.formAnak').find('.riwayatpembedahan_status').length > 0){
            for(var i=0; i<$('.formAnak').find('.riwayatpembedahan_status').length; i++){
                if($('.formAnak').find('.riwayatpembedahan_status').eq(i).prop('checked') === true && $('.formAnak').find('.riwayatpembedahan_status').eq(i).val()=='Pernah'){
                    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('readonly',false);
                }else if($('.formAnak').find('.riwayatpembedahan_status').eq(i).prop('checked') === true && $('.formAnak').find('.riwayatpembedahan_status').eq(i).val()=='Tidak Pernah'){
                    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('readonly',true);
                    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').val('');
                }
            }
        }
    }

     function setJumlahRokok(obj){
        var value = $('.formAnak').find(obj).val();

        if(value === '1' && $('.formAnak').find(obj).prop('checked')==true){
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'jmlrokok_btg_hr') ?>').attr('readonly',false);
        }else if(value === '0' && $('.formAnak').find(obj).prop('checked')==true){
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'jmlrokok_btg_hr') ?>').attr('readonly',true);
        }
    }

function returnValue(obj){
    var value = $('.formAnak').find(obj).val();
    var attrID = $('.formAnak').find(obj).attr('id');
    var td = $('.formAnak').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val();
    var splitTD = td.split(' / ');

    if (attrID == $('.formAnak').find('#<?php echo CHtml::activeId($model, 'td_diastolic') ?>').attr('id')){
        splitTD[0] = splitTD[0].replace(/_/gi, "0");
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val(splitTD[0]+' / '+value);
    }
    else if (attrID == $('.formAnak').find('#<?php echo CHtml::activeId($model, 'td_systolic') ?>').attr('id')){
        splitTD[1] = splitTD[1].replace(/_/gi, "0");
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val(value+' / '+splitTD[1]);
    }
}



function gantiJumlah(obj){
    var value = parseFloat($('.formAnak').find(obj).val());
    var teman = $('.formAnak').find(obj).parent('.groupUkurans').find('input[type="text"]');
    var valueTeman = parseFloat(teman.val());
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}

function gantiHidden(){
    var defaultBB = parseFloat(0.001);
    var defaultTB = parseFloat(100);
    var valueBB = parseFloat($('.formAnak').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
    var valueTB = parseFloat($('.formAnak').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').val());

    if ($('.formAnak').find('#gram').val() != defaultBB){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB*defaultBB);
    }
    else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB);
    }

    if ($('.formAnak').find('#meter').val() != defaultTB){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB*defaultTB);
    }
    else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB);
    }
}

function getBeratBadanIdeal(){
    var beratBadan = parseFloat($('.formAnak').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
    var tinggiBadan = parseFloat($('.formAnak').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var jenisKelamin = $('.formAnak').find('#<?php echo CHtml::activeId($modPasien, 'jenis_kelamin') ?>').val();
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
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
    }
    else{
        //hasil = (tinggiBadan - 100) - ((10/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
    }
}

function getBMI(){
    var beratBadan = parseFloat($('.formAnak').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var tinggiBadan = parseFloat($('.formAnak').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var hasil;

    hasil = (beratBadan/((tinggiBadan*tinggiBadan)/10000));
    if (jQuery.isNumeric(hasil)){
        $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText'); ?>', {bmi:hasil}, function(data){
            $('.formAnak').find('#imt').val(data.text);
            $('.formAnak').find('#imtValue').val(Math.floor(hasil));
        },'json');
    }
}

function getText(){
    var dias = parseFloat($('.formAnak').find('#<?php echo CHtml::activeId($model, 'td_diastolic') ?>').val());
    var sys = parseFloat($('.formAnak').find('#<?php echo CHtml::activeId($model, 'td_systolic') ?>').val());
    var arteri = ((sys+(2*dias))/3);

    if (jQuery.isNumeric(dias)){
        if (jQuery.isNumeric(sys)){
            $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/GetTextTekananDarah'); ?>', {diastolic:dias, systolic:sys}, function(data){
                if (data.text == null){
                    $('.formAnak').find('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
                } else {
                    $('.formAnak').find('#tekananDarah').val(data.text);
                }
            },'json');
            $('.formAnak').find('#<?php echo CHtml::activeId($model, 'meanarteripressure') ?>').val(arteri.toFixed(2));
        }
    }
}

function setStatusKebutuhanKhusus(obj){
    var value = $('.formAnak').find(obj).val();

    if(value === 'Ada'  && $('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isgigipalsu') ?>').attr('disabled',false);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isalatbantudengar') ?>').attr('disabled',false);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_ispakaikacamata') ?>').attr('disabled',false);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_istongkat') ?>').attr('disabled',false);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_islainnya') ?>').attr('disabled',false);
    }else if(value === 'Tidak Ada'  && $('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isgigipalsu') ?>').attr('disabled',true).attr('checked',false);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isalatbantudengar') ?>').attr('disabled',true).attr('checked',false);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_ispakaikacamata') ?>').attr('disabled',true).attr('checked',false);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_istongkat') ?>').attr('disabled',true).attr('checked',false);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_islainnya') ?>').attr('disabled',true).attr('checked',false);
    }
    changeIsLainnya($('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_islainnya') ?>'));
}

function changeIsLainnya(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_jenislainnya') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_jenislainnya') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_jenislainnya') ?>').val('');
    }
}

function setCheckDbn(){
    if( $('.formAnak').find('#<?php echo CHtml::activeId($model,'is_dbn') ?>').prop('checked')==true){
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'kepala_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'mata_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'leher_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'hidung_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'telinga_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'mulut_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'jantung_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'paru_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'abdomen_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'genitalia_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'extremitasatas_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'extremitasbawah_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'kulit_hasilperiksa') ?>"][value="1"]').prop('checked', true);
    }else{
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'kepala_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'kepala_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'mata_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'leher_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'hidung_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'telinga_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'mulut_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'jantung_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'paru_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'abdomen_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'genitalia_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'extremitasatas_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'extremitasbawah_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formAnak').find('input[name="<?php echo CHtml::activeName($model, 'kulit_hasilperiksa') ?>"][value="0"]').prop('checked', true);
    }

    $('.formAnak').find('.kepala_hasilperiksa').each(function(){
        setHasilKepala($(this));
    });

    $('.formAnak').find('.mata_hasilperiksa').each(function(){
        setHasilMata($(this));
    });

    $('.formAnak').find('.leher_hasilperiksa').each(function(){
        setHasilLeher($(this));
    });

    $('.formAnak').find('.hidung_hasilperiksa').each(function(){
        setHasilHidung($(this));
    });

    $('.formAnak').find('.telinga_hasilperiksa').each(function(){
        setHasilTelinga($(this));
    });

    $('.formAnak').find('.mulut_hasilperiksa').each(function(){
        setHasilMulut($(this));
    });
    $('.formAnak').find('.jantung_hasilperiksa').each(function(){
        setHasilJantung($(this));
    });
    $('.formAnak').find('.paru_hasilperiksa').each(function(){
        setHasilParu($(this));
    });
    $('.formAnak').find('.abdomen_hasilperiksa').each(function(){
        setHasilAbdomen($(this));
    });
    $('.formAnak').find('.genitalia_hasilperiksa').each(function(){
        setHasilGenitalia($(this));
    });
    $('.formAnak').find('.extremitasatas_hasilperiksa').each(function(){
        setHasilExtremAtas($(this));
    });

    $('.formAnak').find('.extremitasbawah_hasilperiksa').each(function(){
        setHasilExtremBawah($(this));
    });
    $('.formAnak').find('.kulit_hasilperiksa').each(function(){
        setHasilKulit($(this));
    });

}

function setHasilKepala(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.kepala_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.kepala_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilMata(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.mata_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.mata_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilLeher(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.leher_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.leher_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilHidung(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.hidung_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.hidung_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilTelinga(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.telinga_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.telinga_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilMulut(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.mulut_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.mulut_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilJantung(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.jantung_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.jantung_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilParu(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.paru_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.paru_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilAbdomen(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.abdomen_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.abdomen_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilGenitalia(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.genitalia_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.genitalia_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilExtremAtas(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.extremitasatas_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.extremitasatas_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilExtremBawah(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.extremitasbawah_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.extremitasbawah_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilKulit(obj){
    if($('.formAnak').find(obj).val() == 1  && $('.formAnak').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formAnak').find('.kulit_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formAnak').find(obj).val()==0 && $('.formAnak').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formAnak').find('.kulit_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function changePsikologiLainnya(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'statuspsikologis_lainnya') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'statuspsikologis_lainnya') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'statuspsikologis_lainnya') ?>').val('');
    }
}

function setHambatSosial(obj){
    if($('.formAnak').find(obj).val()==='Ada'){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'hambatansosial_keteranganada') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'hambatansosial_keteranganada') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'hambatansosial_keteranganada') ?>').val('');
    }
}

function setHambatEkonomi(obj){
    if($('.formAnak').find(obj).val()==='Ada'){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'hambatanekonomi_keteranganada') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'hambatanekonomi_keteranganada') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'hambatanekonomi_keteranganada') ?>').val('');
    }
}

function setHambatSpiritual(obj){
    if($('.formAnak').find(obj).val()==='Ada'){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'hambatanspiritual_keteranganada') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'hambatanspiritual_keteranganada') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'hambatanspiritual_keteranganada') ?>').val('');
    }
}

function setNilaiKepercayaan(obj){
    if($('.formAnak').find(obj).val()==='Ada'){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'nilaikepercayaan_keteranganada') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'nilaikepercayaan_keteranganada') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'nilaikepercayaan_keteranganada') ?>').val('');
    }
}

function klikBtnMakan(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_makan') ?>').val(nilai);
skorskrinningfungsional();
}

function klikBtnToilet(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_aktifitastoilet') ?>').val(nilai);
skorskrinningfungsional();
}

function klikBtnRodaTidur(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpindahkursi') ?>').val(nilai);
skorskrinningfungsional();
}

function klikBtnGosokGigi(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_kebersihanmandiri') ?>').val(nilai);
skorskrinningfungsional();
}

function klikBtnMandi(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mandi') ?>').val(nilai);
skorskrinningfungsional();
}

function klikBtnBerjalanDasar(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berjalanpermukaankasar') ?>').val(nilai);
skorskrinningfungsional();
}

function klikBtnNaikTangga(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_naikturuntangga') ?>').val(nilai);
skorskrinningfungsional();
}

function klikBtnBerpakaian(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpakaian') ?>').val(nilai);
skorskrinningfungsional();
}

function klikBtnDefekasi(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontroldefekasi') ?>').val(nilai);
    skorskrinningfungsional();
}

function klikBtnBerkemih(nilai){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontrolberkemih') ?>').val(nilai);
    skorskrinningfungsional();
}

function skorskrinningfungsional(){
    var totalSkor = 0;

    $('.formAnak').find('#tblInputFungsional').find('.skinningfungsional_skor').each(function(){
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

    $('.formAnak').find('#tblInputFungsional').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_jumlah_skor') ?>').val(totalSkor);
    $('.formAnak').find('#tblInputFungsional').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_keterangan') ?>').val(keterangan);
    $('.formAnak').find('#tblInputFungsional').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_kategori') ?>').val(kategori);
}

function skrinninggizidewasa_penurunbb(obj){
  if($('.formAnak').find(obj).val() != ''){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penurunanbb_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val(0);
  }
  skorskrinninggizi();
}

function skrinninggizidewasa_asupan(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_asupanmakanan_dewasa') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_asupanmakanan_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi();
}

function skrininggizianak_tampakkurus(obj){
  if($('.formAnak').find(obj).val() == 'Ya'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_tampakkurus') ?>').val(1);
  }else if($('.formAnak').find(obj).val() == 'Tidak'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_tampakkurus') ?>').val(0);
  }

    $('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_tampakkurus') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi();
}

function skrininggizianak_bb(obj){
  if($('.formAnak').find(obj).val() == 'Ya'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb') ?>').val(1);
  }else if($('.formAnak').find(obj).val() == 'Tidak'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb') ?>').val(0);
  }

    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penurunanbb') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi();
}

function skrininggizianak_kondisi(obj){
  if($('.formAnak').find(obj).val() == 'Ya'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_kondisi') ?>').val(1);
  }else if($('.formAnak').find(obj).val() == 'Tidak'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_kondisi') ?>').val(0);
  }
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_kondisi') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi();
}

function skrininggizianak_penyakit(obj){
  if($('.formAnak').find(obj).val() == 'Ya'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penyakit') ?>').val(2);
  }else if($('.formAnak').find(obj).val() == 'Tidak'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penyakit') ?>').val(0);
  }
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penyakit') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi();
}

function skorskrinninggizi(){
    var totalSkorDewasa = 0;
    var totalSkorAnak = 0;

    $('.formAnak').find('#tblInputSkrinningGiziDewasa').find('.skrinninggizidewasa_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorDewasa += parseInt(skor);
    });

    $('.formAnak').find('#tblInputSkrinningGiziAnak').find('.skrinninggizianak_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorAnak += parseInt(skor);
    });
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_totaldewasa') ?>').val(totalSkorDewasa);
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_totalanak') ?>').val(totalSkorAnak);

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

    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrininggizidewasa_resiko') ?>').val(ris);
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skrininggizidewasa_tindakanygdilakukan') ?>').val(ket);
}

function choiseSkrinningGizi(obj){
    if($('.formAnak').find(obj).val() == 1 && $('.formAnak').find(obj).prop('checked')==true){
        inputAllEnabled($('.formAnak').find('#skrinninggizi_dewasa_panel'));
        $('.formAnak').find('#skrinninggizi_dewasa_panel').show();

        inputAllDisabled($('.formAnak').find('#skrinninggizi_anak_panel'));
        $('.formAnak').find('#skrinninggizi_anak_panel').hide();
    } else if($('.formAnak').find(obj).val() == 0 && $('.formAnak').find(obj).prop('checked')==true){
        inputAllEnabled($('.formAnak').find('#skrinninggizi_anak_panel'));
        $('.formAnak').find('#skrinninggizi_anak_panel').show();

        inputAllDisabled($('.formAnak').find('#skrinninggizi_dewasa_panel'));
        $('.formAnak').find('#skrinninggizi_dewasa_panel').hide();
    }
}

function inputAllDisabled(obj){
    $('.formAnak').find(obj).find('input,select,textarea').each(function(){
        $(this).attr('disabled',true);
    });
}

function inputAllEnabled(obj){
    $('.formAnak').find(obj).find('input,select,textarea').each(function(){
        $(this).attr('disabled',false);
    });
}

function choiseResikoJatuh(obj){
    if($('.formAnak').find(obj).val() == 0 && $('.formAnak').find(obj).prop('checked')==true){
        inputAllEnabled($('.formAnak').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formAnak').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').show();

        inputAllDisabled($('.formAnak').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formAnak').find('#panelresikojatuh_anak').find('#resikojatuhanak').hide();
        inputAllDisabled($('.formAnak').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formAnak').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').hide();
    } else if($('.formAnak').find(obj).val() == 1 && $('.formAnak').find(obj).prop('checked')==true){
        inputAllEnabled($('.formAnak').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formAnak').find('#panelresikojatuh_anak').find('#resikojatuhanak').show();


        inputAllDisabled($('.formAnak').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formAnak').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
        inputAllDisabled($('.formAnak').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formAnak').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').hide();
    }
    else if($('.formAnak').find(obj).val() == 2 && $('.formAnak').find(obj).prop('checked')==true){
        inputAllEnabled($('.formAnak').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formAnak').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').show();

        inputAllDisabled($('.formAnak').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formAnak').find('#panelresikojatuh_anak').find('#resikojatuhanak').hide();
        inputAllDisabled($('.formAnak').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formAnak').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
    }
}

function resikojatuhdewasa_penilaian(obj){
  if($('.formAnak').find(obj).val() =='Ya'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_skor') ?>').val(25);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_skor') ?>').val(0);
  }

    $('.formAnak').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhdewasa_diagnosa(obj){
  if($('.formAnak').find(obj).val() =='Ya'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'diagnosismedis_skor') ?>').val(15);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'diagnosismedis_skor') ?>').val(0);
  }
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'diagnosismedis_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhdewasa_alatbantu(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'alatbantujalan_skor') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'alatbantujalan_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhdewasa_terapi(obj){
  if($('.formAnak').find(obj).val() =='Ya'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_skor') ?>').val(20);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_skor') ?>').val(0);
  }
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhdewasa_berjalan(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'caraberjalan_skor') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'caraberjalan_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhdewasa_mental(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'statusmental_skor') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'statusmental_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhanak_usia(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skor_usia_anak') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'usia_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhanak_jeniskelamin(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skor_jeniskelamin_anak') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'jeniskelamin_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhanak_diagnosa(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skor_diagnosa_anak') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'diagnosa_asessment_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhanak_gangguan(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skor_gangguan_kognitif_anak') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'gangguan_kognitif_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}


function resikojatuhanak_faktor(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skor_faktor_lingkungan_anak') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'faktor_lingkungan_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}


function resikojatuhanak_respon(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skor_responterhadap_pembedahan_anak') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'responterhadap_pembedahan_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhanak_bedah(obj){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skor_medikamentosa_anak') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'penggunaan_medikamentosa') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function skorresikojatuh(){
    var totalSkorDewasa = 0;
    var totalSkorAnak = 0;
    var totalSkorLansia = 0;

    $('.formAnak').find('#tblResikojatuhDewasa').find('.resikojatuhdewasa_skor').each(function(){
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

    $('.formAnak').find('#<?php echo CHtml::activeId($model,'resikojatuh_skor') ?>').val(totalSkorDewasa);
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'resikojatuh_keterangan') ?>').val(ketResikoDewasa);

    $('.formAnak').find('#tblResikojatuhAnak').find('.resikojatuhanak_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorAnak += parseInt(skor);
    });
    var ketResikoAnak = "";
    if (totalSkorAnak >= 0  && totalSkorAnak <=6)  {
       ketResikoAnak = "Risiko Rendah";
    }
    else if(totalSkorAnak >= 7  && totalSkorAnak <=11) {
       ketResikoAnak = "Risiko Sedang";
    }
    else if(totalSkorAnak >= 12) {
        ketResikoAnak = "Risiko Tinggi";
    }

    $('.formAnak').find('#<?php echo CHtml::activeId($model,'jumlah_skor_anak') ?>').val(totalSkorAnak);
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'keterangan_resiko_jatuh_anak') ?>').val(ketResikoAnak);

    $('.formAnak').find('#tblResikojatuhLansia').find('.resikojatuhlansia_skor').each(function(){
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
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'jumlah_skor_lansia') ?>').val(totalSkorLansia);
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'keterangan_skor_lansia') ?>').val(ketResikoLansia);

    // var objPanel = $('.formAnak').find('#<?php //echo CHtml::activeId($model,'isresikojatuh') ?>');

    $('.formAnak').find('.pilih_resikoJatuh').each(function(){
      if($('.formAnak').find(this).val() == 0 && $('.formAnak').find(this).prop('checked')==true){
          $('.formAnak').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoDewasa);
      }else if($('.formAnak').find(this).val() == 0 && $('.formAnak').find(this).prop('checked')==true){
         <?php if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR){ ?>
             $('.formAnak').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val("Resiko Tinggi");
         <?php }else{ ?>
             $('.formAnak').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoAnak);
          <?php } ?>
      }else if($('.formAnak').find(this).val() == 0 && $('.formAnak').find(this).prop('checked')==true){
          $('.formAnak').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoLansia);
      }
    });


}

function setAdaresikojatuh(obj){
    if($('.formAnak').find(obj).val() == 0 && $('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').attr('readonly',true);
    }else if($('.formAnak').find(obj).val() == 1 && $('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').attr('readonly',false);
    }
}

function changeInformasiResikoJatuh(obj){
   var html = "Lakukan intervensi pencegahan resiko jatuh: Beritahu pendamping untuk tidak meninggalkan pasien";
    if($('.formAnak').find(obj).val() === 'Kursi Roda' && $('.formAnak').find(obj).prop('checked')===true && $('.formAnak').find(obj).hasClass('jenisalatbantu')){
        html = "Lakukan intervensi pencegahan resiko jatuh: Beritahu pendamping untuk tidak meninggalkan pasien dan pastikan kursi roda terkunci";
    }

    if($('.formAnak').find(obj).val() === 'Lainnya' && $('.formAnak').find(obj).prop('checked')===true && $('.formAnak').find(obj).hasClass('jenisalatbantu')){
        $('.formAnak').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',false);
    }else if($('.formAnak').find(obj).val() !== 'Lainnya' && $('.formAnak').find(obj).prop('checked')===true && $('.formAnak').find(obj).hasClass('jenisalatbantu')){
        $('.formAnak').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',true);
    }

    if($('.formAnak').find(obj).val() === '1' && $('.formAnak').find(obj).prop('checked')===true && $('.formAnak').find(obj).hasClass('riwayatjatuh_alatbantu')){
        $('.formAnak').find('.jenisalatbantu').attr('disabled',false);
    }else{
        if($('.formAnak').find(obj).val() === '0' && $('.formAnak').find(obj).prop('checked')===true  && $('.formAnak').find(obj).hasClass('riwayatjatuh_alatbantu')){
            $('.formAnak').find('.jenisalatbantu').attr('disabled',true);
            $('.formAnak').find('.jenisalatbantu').attr('checked',false);
            $('.formAnak').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',true);
        }
    }
    if($('.formAnak').find('.riwayatjatuh_alatbantu').prop('checked')===true && $('.formAnak').find('.riwayatjatuh_3bln_terakhir').prop('checked')===false){
        $('.formAnak').find('#informasiResikoJatuh').hide();
        $('.formAnak').find('#informasiResikoJatuh').html("");
    }else{
        $('.formAnak').find('#informasiResikoJatuh').show();
        $('.formAnak').find('#informasiResikoJatuh').html(html);
    }

    if($('.formAnak').find('.riwayatjatuh_alatbantu').prop('checked')===false && $('.formAnak').find('.riwayatjatuh_3bln_terakhir').prop('checked')===false){
        $('.formAnak').find('#informasiResikoJatuh').hide();
        $('.formAnak').find('#informasiResikoJatuh').html("");
    }

}


function resetFormFlasCCs(){
    $('.formAnak').find("#master_falsccs > tbody > tr").each(function(){

        $(this).find('.borderflaccs').each(function(){
            $(this).attr('style','');
        });

        $(this).find('.field').each(function(){
            $(this).val('');
        });


        $(this).find('.labelname').each(function(){
            $(this).html('');
        });
    });

    $('.formAnak').find("#master_falsccs > tfoot > tr").each(function(){
        $(this).find('.field').each(function(){
            $(this).val('');
        });
    });

    $('.formAnak').find("#totalskor").html('');
}


function pilihNyeri(obj){
if($('.formAnak').find(obj).val() == 0 && $('.formAnak').find(obj).prop('checked')==true){
        inputAllEnabled($('.formAnak').find('#nyeri_anak').find('.panel-body'));
        $('.formAnak').find('#nyeri_anak').find('.panel-body').show();

        inputAllDisabled($('.formAnak').find('#nyeri_dewasa').find('.panel-body'));
        $('.formAnak').find('#nyeri_dewasa').find('.panel-body').hide();

        // // $('.formAnak').find("#<?php //echo CHtml::activeId($model, 'score_skalanyeri') ?>").addClass('required');
        // $('.formAnak').find("#<?php //echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").addClass('required');
    } else if($('.formAnak').find(obj).val() == 1 && $('.formAnak').find(obj).prop('checked')==true){
        inputAllEnabled($('.formAnak').find('#nyeri_dewasa').find('.panel-body'));
        $('.formAnak').find('#nyeri_dewasa').find('.panel-body').show();

        inputAllDisabled($('.formAnak').find('#nyeri_anak').find('.panel-body'));
        $('.formAnak').find('#nyeri_anak').find('.panel-body').hide();

        resetFormFlasCCs();

        // $('.formAnak').find("#<?php //echo CHtml::activeId($model, 'score_skalanyeri') ?>").removeClass('required');
        // $('.formAnak').find("#<?php //echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").removeClass('required');
    }
}

function pilihScala(skor){
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
        $('.formAnak').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val(skor);
        $('.formAnak').find("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").val(keterangan);
    //}

    $('.formAnak').find(".nyeri-nomor").css("border", "none");
    $('.formAnak').find(".nyeri-nomor").css("border-radius", "5px");
    $('.formAnak').find("#nyerinomor_" + skor).css("border", "1px solid black");
}

function getSkorFla(id,skor,obj){
    $('.formAnak').find("#skor_"+id).html(skor);
    $('.formAnak').find(obj).parents("tr").find('.params').val(skor);
    $('.formAnak').find(obj).parents("tr").find('.nilai').val(skor);
    $('.formAnak').find(obj).parents("tr").find('.kategoriid').val(id);

    totalSkorFla();
}

function totalSkorFla(){
    var total = 0;

    $('.formAnak').find("#master_falsccs > tbody > tr").each(function(){
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

    $('.formAnak').find("#totalskor").html(total);

    if (total == 0){
        var keterangan = 'tidak nyeri';
    }else if(total >= 1 && total <= 3){
        var keterangan = 'nyeri ringan';
    }else if(total >= 4 && total <= 6){
        var keterangan = 'nyeri sedang';
    }else if(total >= 7 && total <= 10){
        var keterangan = 'nyeri berat sekali';
    }

    $('.formAnak').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri_anak') ?>").val(total);
    $('.formAnak').find("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri_anak') ?>").val(keterangan);
}



function changeDeskripsinyeri_ismenjalar(obj){
    if($('.formAnak').find(obj).val()==='1'){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').val('');
    }
}

function changeNyeriHilangLain(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').val('');
    }
}

function setDeformitas(obj){
    if($('.formAnak').find(obj).val()==='1'){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'deformitas_regio') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'deformitas_regio') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'deformitas_regio') ?>').val('');
    }
}

function setGangguanTidur(obj){
    if($('.formAnak').find(obj).val()==='1'){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'gangguantidur_keterangan') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'gangguantidur_keterangan') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'gangguantidur_keterangan') ?>').val('');
    }
}

function setKebNutrisiStatus(obj){
 if($('.formAnak').find(obj).val()==='1' && $('.formAnak').find(obj).prop('checked')===true){
        $('.formAnak').find('.kebnutricairankeluhan').attr('disabled',false);
    }else if($('.formAnak').find(obj).val()==='0' && $('.formAnak').find(obj).prop('checked')===true){
        $('.formAnak').find('.kebnutricairankeluhan').attr('disabled',true);
        $('.formAnak').find('.kebnutricairankeluhan').attr('checked',false);
    }
}

function setKebNutrisiEdema(obj){
    if($('.formAnak').find(obj).val()==='1' && $('.formAnak').find(obj).prop('checked')===true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_nutricairan_edemalokasi') ?>').attr('readonly',false);
    }else if($('.formAnak').find(obj).val()==='0' && $('.formAnak').find(obj).prop('checked')===true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_nutricairan_edemalokasi') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_nutricairan_edemalokasi') ?>').val('');
    }
}

function setKebEliminasiBab(obj){
    if($('.formAnak').find(obj).val()==='1' && $('.formAnak').find(obj).prop('checked')===true){
         $('.formAnak').find('.kebEliminasiBab').attr('disabled',false);
    }else if($('.formAnak').find(obj).val()==='0' && $('.formAnak').find(obj).prop('checked')===true){
        $('.formAnak').find('.kebEliminasiBab').attr('disabled',true);
        $('.formAnak').find('.kebEliminasiBab').attr('checked',false);
    }
    setKebEliminasiKeluhanLainBab($('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_iskeluhanlainnya') ?>'));
}

function setKebEliminasiKeluhanLainBab(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_jeniskeluhanlainnya') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_jeniskeluhanlainnya') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_jeniskeluhanlainnya') ?>').val('');
    }
}

function setKebEliminasiBak(obj){
    if($('.formAnak').find(obj).val()==='1' && $('.formAnak').find(obj).prop('checked')===true){
         $('.formAnak').find('.kebEliminasiBak').attr('disabled',false);
    }else if($(obj).val()==='0' && $(obj).prop('checked')===true){
        $('.formAnak').find('.kebEliminasiBak').attr('disabled',true);
        $('.formAnak').find('.kebEliminasiBak').attr('checked',false);
    }
    setKebEliminasiKeluhanLainBak($('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_iskeluhanlainnya') ?>'));
}

function setKebEliminasiKeluhanLainBak(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_jeniskeluhanlainnya') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_jeniskeluhanlainnya') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_jeniskeluhanlainnya') ?>').val('');
    }
}

function changeIndetifikasiPenyakitMenular(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_menularketerangan') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_menularketerangan') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_menularketerangan') ?>').val('');
    }
}

function changeIndetifikasiPenyakitJiwa(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('.idenpenyakitjiwa').attr('disabled',false);
    }else{
        $('.formAnak').find('.idenpenyakitjiwa').attr('disabled',true);
        $('.formAnak').find('.idenpenyakitjiwa').attr('checked',false);
    }
    setIdenPenyakitJiwaLainnya($('.formAnak').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakitjiwa_islainnya') ?>'));
}

function setIdenPenyakitJiwaLainnya(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakitjiwa_keteranganlainnya') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakitjiwa_keteranganlainnya') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakitjiwa_keteranganlainnya') ?>').val('');
    }
}

function setChangeDetEdukasiLain(obj){
    var index = $('.formAnak').find(obj).attr('text_id');

    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('readonly',false);
    }else{
        $('.formAnak').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('readonly',true);
        $('.formAnak').find('#RIAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').val('');
    }
}

function setEdukasiPenerima(obj){
    if($('.formAnak').find(obj).val()==='1' && $('.formAnak').find(obj).prop('checked')===true){
         $('.formAnak').find('.edukasipenerima').attr('disabled',false);
         $('.formAnak').find('.edukasipenerima').attr('checked',false);
         $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak') ?>').attr('readonly',true);
         $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak') ?>').val('');
    }else if($('.formAnak').find(obj).val()==='0' && $('.formAnak').find(obj).prop('checked')===true){
        $('.formAnak').find('.edukasipenerima').attr('disabled',true);
        $('.formAnak').find('.edukasipenerima').attr('checked',false);
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak') ?>').attr('readonly',false);
    }
    setEdukasiPenerimaLainnya($('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_lainnya') ?>'));
    setEdukasiPenerimaKeluarga($('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_keluargapasien') ?>'));
}

function setEdukasiPenerimaLainnya(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama') ?>').attr('readonly',false);
    }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama') ?>').val('');
    }
}

function setEdukasiPenerimaKeluarga(obj){
    if($('.formAnak').find(obj).prop('checked')==true){
        $('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien') ?>').attr('readonly',false);
    }else{
        $('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien') ?>').attr('readonly',true);
        $('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien') ?>').val('');
    }
}

function setEdukasiBicara(obj){
    if($('.formAnak').find(obj).val()==='Serangan Awal Bicara' && $('.formAnak').find(obj).prop('checked')===true){
         $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal') ?>').attr('readonly',false);
    }else if($('.formAnak').find(obj).val()==='Normal' && $('.formAnak').find(obj).prop('checked')===true){
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal') ?>').val('');
    }
}

function setEduBahasaSehari(obj){
    if($('.formAnak').find(obj).val()==='Daerah' && $('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama') ?>').attr('readonly',false);
    }else if($('.formAnak').find(obj).val()==='Indonesia' && $('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama') ?>').val('');
    }
}

function setEdukasiPenerjemah(obj){
    if($('.formAnak').find(obj).val()==='Ya' && $('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').attr('readonly',false);
    }else if($('.formAnak').find(obj).val()==='Tidak' && $('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').attr('readonly',true);
        $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').val('');
    }
}

function setRiwayatJatuh(obj){
    if($('.formAnak').find('.resiko_jatuh_lansia').val() != '' && $('.formAnak').find('.resiko_jatuh_lansia').val() == 1){
        $('.formAnak').find('#riwayatJatuhRSLansia_0').attr('checked',true);
        $('.formAnak').find('#riwayatJatuhBulanLansia_0').attr('checked',true);
    }
    if($('.formAnak').find('#riwayatJatuhRSLansia_0').prop('checked')==true || $('.formAnak').find('#riwayatJatuhBulanLansia_0').prop('checked')==true){
        $('.formAnak').find('.resiko_jatuh_lansia').val(true);
        $('.formAnak').find('.skor_resiko_jatuh_lansia').val(6);
    }else if($('.formAnak').find('#riwayatJatuhRSLansia_0').prop('checked')==false || $('.formAnak').find('#riwayatJatuhBulanLansia_0').prop('checked')==false){
        $('.formAnak').find('.resiko_jatuh_lansia').val(false);
        $('.formAnak').find('.skor_resiko_jatuh_lansia').val(0);
    }
    skorresikojatuh();
}

function setStatusMental(obj){
    if($('.formAnak').find('.status_mental_lansia').val() != '' && $('.formAnak').find('.status_mental_lansia').val() == 1){
        $('.formAnak').find('#statusMentalDeliriumLansia_0').attr('checked',true);
        $('.formAnak').find('#statusMentalDisorientasiLansia_0').attr('checked',true);
        $('.formAnak').find('#statusMentalAgitasiLansia_0').attr('checked',true);
    }
     if($('.formAnak').find('#statusMentalDeliriumLansia_0').prop('checked')==true ||
           $('.formAnak').find('#statusMentalDisorientasiLansia_0').prop('checked')==true ||
           $('.formAnak').find('#statusMentalAgitasiLansia_0').prop('checked')==true){
            $('.formAnak').find('.status_mental_lansia').val(true);
            $('.formAnak').find('.skor_status_mental_lansia').val(14);
        }else if($('.formAnak').find('#statusMentalDeliriumLansia_0').prop('checked')==false ||
           $('.formAnak').find('#statusMentalDisorientasiLansia_0').prop('checked')==false ||
           $('.formAnak').find('#statusMentalAgitasiLansia_0').prop('checked')==false){
            $('.formAnak').find('.status_mental_lansia').val(false);
            $('.formAnak').find('.skor_status_mental_lansia').val(0);
        }
    skorresikojatuh();
}

function setPengelihatan(obj){
    if($('.formAnak').find('.penglihatan_lansia').val() != '' && $('.formAnak').find('.penglihatan_lansia').val() == 1){
        $('.formAnak').find('#penglihatanKacamataLansia_0').attr('checked',true);
        $('.formAnak').find('#penglihatanBuramLansia_0').attr('checked',true);
        $('.formAnak').find('#penglihatanKatarakLansia_0').attr('checked',true);
    }

     if($('.formAnak').find('#penglihatanKacamataLansia_0').prop('checked')==true ||
           $('.formAnak').find('#penglihatanBuramLansia_0').prop('checked')==true ||
           $('.formAnak').find('#penglihatanKatarakLansia_0').prop('checked')==true){
            $('.formAnak').find('.penglihatan_lansia').val(true);
            $('.formAnak').find('.skor_penglihatan_lansia').val(1);
        }else{
            $('.formAnak').find('.penglihatan_lansia').val(false);
            $('.formAnak').find('.skor_penglihatan_lansia').val(0);
        }
    skorresikojatuh();
}

function setKebiasaanBerkemih(obj){
     if ($('.formAnak').find(obj).val()=='1' && $('.formAnak').find(obj).prop('checked')==true){
            $('.formAnak').find('.skor_berkemih_lansia').val(2);
        }else if ($('.formAnak').find(obj).val()=='0' && $('.formAnak').find(obj).prop('checked')==true){
            $('.formAnak').find('.skor_berkemih_lansia').val(0);
        }
    skorresikojatuh();
}

function getTransferLansia(){
    if($('.formAnak').find('.transfer_mobilitas_lansia').val() != ''){
        var trs = '';
         $('.formAnak').find('#transferLansia').find('option').each(function(){
            if($(this).text() == $('.formAnak').find('.transfer_mobilitas_lansia').val()){
                trs = $(this).val();
            }
        });
        $('.formAnak').find('#transferLansia').val(trs);
    }

    if($('.formAnak').find('#transferLansia').val() != ""){
        $('.formAnak').find('.transfer_mobilitas_lansia').val($('.formAnak').find('#transferLansia').find('option:selected').text());
        $('.formAnak').find('#transferLansiaHidden').val($('.formAnak').find('#transferLansia').val());
    }else{
         $('.formAnak').find('.transfer_mobilitas_lansia').val("");
        $('.formAnak').find('#transferLansiaHidden').val(0);
    }

    totalTransferMobilitas();
}

function getMobilitasLansia(){
    if($('.formAnak').find('.mobilitas_lansia').val() != ''){
        var mob = '';
         $('.formAnak').find('#mobilitasLansia').find('option').each(function(){
            if($(this).text() == $('.formAnak').find('.mobilitas_lansia').val()){
                mob = $(this).val();
            }
        });
        $('.formAnak').find('#mobilitasLansia').val(mob);
    }

    if($('.formAnak').find('#mobilitasLansia').val() != ""){
        $('.formAnak').find('.mobilitas_lansia').val($('.formAnak').find('#mobilitasLansia').find('option:selected').text());
         $('.formAnak').find('#mobilitasLansiaHidden').val($('.formAnak').find('#mobilitasLansia').val());
    }else{
        $('.formAnak').find('.mobilitas_lansia').val("");
      $('.formAnak').find('#mobilitasLansiaHidden').val(0);
    }

    totalTransferMobilitas();
}

function totalTransferMobilitas(){
   var trf = $('.formAnak').find('#transferLansiaHidden').val();
   var mobil = $('.formAnak').find('#mobilitasLansiaHidden').val();
   var jumlah = parseInt(trf) + parseInt(mobil);
   var totalJml = 0;
   if (!isNaN(jumlah)) {
       if(jumlah >=0 && jumlah <= 3){
           totalJml = 0;
       }else{
           totalJml = 7;
       }
   }
   $('.formAnak').find('.skor_transfer_mobilitas_lansia').val(totalJml);
   skorresikojatuh();
}

function resikojatuhrj_penilaian(){
    var hasilpengkajian = "";
    var tindakan = "";
    var nilai_a = $('.formAnak').find('#<?php echo CHtml::activeId($model, 'resikojatuhkhususrj_hasilpenilaian_a') ?>').val();
    var nilai_b = $('.formAnak').find('#<?php echo CHtml::activeId($model, 'resikojatuhkhususrj_hasilpenilaian_b') ?>').val();

    if(nilai_a==='1' && nilai_b==='1'){
        hasilpengkajian = "Resiko Tinggi";
    }else if((nilai_a==='1' && nilai_b==='0') || (nilai_a==='0' && nilai_b==='1')){
        hasilpengkajian = "Resiko Rendah";
    }else if(nilai_a==='0' && nilai_b==='0'){
        hasilpengkajian = "Tidak Beresiko";
    }

    if(hasilpengkajian === 'Resiko Tinggi'){
       tindakan = "Edukasi dan Pemasangan Pin Resiko Jatuh";
    }else if(hasilpengkajian === 'Resiko Rendah'){
       tindakan = "Edukasi";
    }else if(hasilpengkajian === 'Tidak Beresiko'){
       tindakan = "Tidak Ada Tindakan";
    }

    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'resikojatuhkhususrj_hasilpengkajian') ?>').val(hasilpengkajian);
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'resikojatuhkhususrj_tindakanygdiperlukan') ?>').val(tindakan);
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(hasilpengkajian);
}

function simpanAllDataAnak(){
  if(requiredCheck($('.formAnak').find("#askepanakri-t-form"))){
    var indexNext = $('.formAnak').find('#rootwizardAskepAnak').data('bootstrapWizard').nextIndex();
    var indexstep = $('.formAnak').find('#rootwizardAskepAnak').data('bootstrapWizard').currentIndex();
    $(".formAnak").addClass("animation-loading");
    $('.formAnak').find(".integer-decimal, .integer2, .float2").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
    var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
    var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
    var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
    var jenisasesmen = $('#choise_anak').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
    var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

    var dataSerialized = $('.formAnak').find('#askepanakri-t-form').serializeArray();
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
              $('.formAnak').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              suksesData=true;
              $.fn.yiiGridView.update('riwayataskep-grid', {
                  data: $(this).serialize()
              });
            }else{
              $('.formAnak').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
            }
            if(suksesData==true){
              setTimeout(function(){
                  $('.formAnak').find('.divAlert').html('');
              }, 5000);
            }
          }else{
              $('.formAnak').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');

          }
          $(".formAnak").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formAnak").removeClass("animation-loading");}
    });
  }
}

function simpanDataFormAnak(simpanDt, indexstep, handeland){
  var suksesData = false;

    if(requiredCheck($('.formAnak').find(simpanDt))){
      var indexNext = $('.formAnak').find('#rootwizardAskepAnak').data('bootstrapWizard').nextIndex();
      $(".formAnak").addClass("animation-loading");
      $('.formAnak').find(".integer-decimal, .integer2, .float2").each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
      var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
      var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
      var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
      var jenisasesmen = $('#choise_anak').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
      var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

      if(indexstep > 1){
        $('#checkSimpanData').val('simpan');
      }else if (indexstep == 1){
        $('#checkSimpanData').val('');
      }

      var checksimpan = $('#checkSimpanData').val();

      var dataSerialized = $('.formAnak').find(simpanDt).serializeArray();
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
                $('.formAnak').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                $.fn.yiiGridView.update('riwayataskep-grid', {
                    data: $(this).serialize()
                });
              }else{
                $('.formAnak').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              }
              if(suksesData == true){
                setTimeout(function(){
                    $('.formAnak').find('.divAlert').html('');
                }, 5000);
              }
            }else{
                $('.formAnak').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
            }
            $(".formAnak").removeClass("animation-loading");
          },
          error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formAnak").removeClass("animation-loading");}
      });
    }
    return suksesData;
}

function setChangeDetTumbuhKembang(obj){
    var index = $('.formAnak').find(obj).attr('text_id');

    if($('.formAnak').find(obj).prop('checked')==true){
        $('.formAnak').find('#AsesmentumbuhkembanganakT_'+index+'_tumbuhkembanganak_usia').attr('readonly',false);
    }else{
        $('.formAnak').find('#AsesmentumbuhkembanganakT_'+index+'_tumbuhkembanganak_usia').attr('readonly',true);
        $('.formAnak').find('#AsesmentumbuhkembanganakT_'+index+'_tumbuhkembanganak_usia').val('');
    }
}

function setSumberData_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.sumberdata').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',true);
  }
}

function setStatusKontrolRisiko_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.kontrolrisikoinfeksi_status').each(function(){
    if($(this).val()=='Diketahui' &&  $(this).prop('checked')==true){
      indexLainnya = 1;
      $('.formAnak').find('.jenisrisiko').each(function(){
        $(this).attr('disabled',false);
      });
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formAnak').find('.jenisrisiko').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
  }
  $('.formAnak').find('.jenisrisiko').each(function(){
    setJenisRisikoLainnya_anak($(this));
  });
}

function setJenisRisikoLainnya_anak(obj){
  if($('.formAnak').find(obj).attr('datavalue')== 'Lainnya' && $('.formAnak').find(obj).prop('checked') == true){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'jenisrisikoinfeksi_lainnya'); ?>').attr('readonly',false);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'jenisrisikoinfeksi_lainnya'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'jenisrisikoinfeksi_lainnya'); ?>').attr('readonly',true);
  }
}

function setAnak_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.isada_anak').each(function(){
    if($(this).val()=='Ada' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'jml_anak'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'jml_anak'); ?>').val('0');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'jml_anak'); ?>').attr('readonly',true);
  }
}

function changeTinggalBersama_anak(obj){
    var value = $('.formAnak').find(obj).val();

    if(value === 'Lainnya'){
      $('.formAnak').find('.tinggalbersama').attr('disabled',false);
    }else{
      $('.formAnak').find('.tinggalbersama').val('');
      $('.formAnak').find('.tinggalbersama').attr('disabled',true);
    }
}

function setMasalahDlmBerbicara_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.masalahdlm_berbicara').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'masalahbicara_ket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'masalahbicara_ket'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'masalahbicara_ket'); ?>').attr('readonly',true);
  }
}

function setNutrisiPerubahanBB_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.nutrisi_perubahanbb6blnterakhir').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'nutrisi_perubahanbb6blnterakhirket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'nutrisi_perubahanbb6blnterakhirket'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'nutrisi_perubahanbb6blnterakhirket'); ?>').attr('readonly',true);
  }
}

function setAdaNyeri_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.isadakeluhannyeri').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formAnak').find('.jenisnyeri').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('.jenisnyeri').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
  }
}

function setKualitasNyeri_anak(){
  $('.formAnak').find('.kualitasnyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',false);
      }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').val('');
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',true);
      }
  });
}

function setFrekuensiNyeri_anak(){
  $('.formAnak').find('.frekuensinyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',false);
      }else{
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').val('');
        $('.formAnak').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',true);
      }
  });
}

function setNilaiKepercayaanKhusus_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.nilaikepercayaankhusus_dewasa').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket'); ?>').attr('readonly',true);
  }
}

function selectSumberData_anak(){
  if($('.formAnak').find('#<?php echo CHtml::activeId($model, 'sumberdata'); ?>').val() == 'Lainnya'){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',false);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',true);
  }
}

function changeMasalahPerkawinan_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.neonatus_masalahperkawinanortu').each(function(){
    if($(this).val()=='Ada' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'neonatus_masalahperkawinanortuket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'neonatus_masalahperkawinanortuket'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'neonatus_masalahperkawinanortuket'); ?>').attr('readonly',true);
  }
}

function changeKekerasanFisik_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.neonatus_kekerasanfisikortu').each(function(){
    if($(this).val()=='Ada' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kekerasanfisiket'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kekerasanfisiket'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'kekerasanfisiket'); ?>').attr('disabled',true);
  }
}

function changeTraumaKehidupan_anak(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.neonatus_traumadlmhiduportu').each(function(){
    if($(this).val()=='Ada' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'neonatus_traumadlmhiduportuket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'neonatus_traumadlmhiduportuket'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'neonatus_traumadlmhiduportuket'); ?>').attr('readonly',true);
  }
}

function pilihFungsional(obj){
    if($('.formAnak').find(obj).val() == 1 && $('.formAnak').find(obj).prop('checked')==true){
        inputAllEnabled($('.formAnak').find('#pilih_fungsional').find('.panel-body'));
        $('.formAnak').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').show();

        inputAllDisabled($('.formAnak').find('#pilih_fungsionaladl').find('.panel-body'));
       $('.formAnak').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').hide();
    }else if($('.formAnak').find(obj).val() == 2 && $('.formAnak').find(obj).prop('checked')==true){
        inputAllEnabled($('.formAnak').find('#pilih_fungsionaladl').find('.panel-body'));
        $('.formAnak').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').show();

        inputAllDisabled($('.formAnak').find('#pilih_fungsional').find('.panel-body'));
        $('.formAnak').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').hide();
    }
}

function unpilihFungsional(){
  inputAllDisabled($('.formAnak').find('#pilih_fungsional').find('.panel-body'));
  $('.formAnak').find('#pilih_fungsional').find('.panel-body').find('.formFungsional').hide();

  inputAllDisabled($('.formAnak').find('#pilih_fungsionaladl').find('.panel-body'));
 $('.formAnak').find('#pilih_fungsionaladl').find('.panel-body').find('.formFungsionalAdl').hide();
}

function klikBtnAdl(skor, type){
  if(type == 'bab'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_bab'); ?>').val(skor);
  }else if(type == 'bak'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_bak'); ?>').val(skor);
  }else if(type == 'kebersihan'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_kebersihanmandiri'); ?>').val(skor);
  }else if(type == 'penggunaanjamban'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_pengunaanjamban'); ?>').val(skor);
  }else if(type == 'makan'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_makan'); ?>').val(skor);
  }else if(type == 'sikap'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_sikap'); ?>').val(skor);
  }else if(type == 'pindah'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_berpindah'); ?>').val(skor);
  }else if(type == 'baju'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_baju'); ?>').val(skor);
  }else if(type == 'tangga'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_naikturuntangga'); ?>').val(skor);
  }else if(type == 'mandi'){
    $('.formAnak').find('#<?php echo CHtml::activeId($modBarthelindex, 'skor_mandi'); ?>').val(skor);
  }

  var skor = 0;
  var keterangan = "";

  $('.formAnak').find('#tblInputFungsionalAdl').find('.skinningfungsionaladl_skor').each(function(){
    var skorAdl = $('.formAnak').find(this).val();

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

  $('.formAnak').find('#tblInputFungsionalAdl').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_jumlah_skor'); ?>').val(skor);
  $('.formAnak').find('#tblInputFungsionalAdl').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_keterangan'); ?>').val(keterangan);
}

function setStatusRiwayattransfusi(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.riwayattransfusi_status').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',false);
      $('.formAnak').find('.riwayattransfusi_isreaksi').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',true);
    $('.formAnak').find('.riwayattransfusi_isreaksi').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
  setReaksiRiwayattransfusi();
}

function setReaksiRiwayattransfusi(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.riwayattransfusi_isreaksi').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'riwayattransfusi_reaksiygtimbul'); ?>').attr('disabled',true);
  }
}

function setKesadaranNyeri(){
  var indexLainnya = 0;
  $('.formAnak').find('.kesadaranpasien_pengkajiannyeri').each(function(){
    if($(this).val()=='Sadar' &&  $(this).prop('checked')==true){
      inputAllEnabled($('.formAnak').find('.panelsadar'));
      $('.formAnak').find('.panelsadar').show();

      inputAllDisabled($('.formAnak').find('.paneltidaksadar'));
      $('.formAnak').find('.paneltidaksadar').hide();
      indexLainnya += 1;
    }else if($(this).val()=='Tidak Sadar' &&  $(this).prop('checked')==true){
      inputAllDisabled($('.formAnak').find('.panelsadar'));
      $('.formAnak').find('.panelsadar').hide();

      inputAllEnabled($('.formAnak').find('.paneltidaksadar'));
      $('.formAnak').find('.paneltidaksadar').show();
      indexLainnya += 1;
    }
  });



  if(indexLainnya == 0){
    inputAllDisabled($('.formAnak').find('.paneltidaksadar'));
    inputAllDisabled($('.formAnak').find('.panelsadar'));
    $('.formAnak').find('.panelsadar').hide();
    $('.formAnak').find('.paneltidaksadar').hide();
  }
}

function venekpresi(obj){
  if($('.formAnak').find(obj).val() != ''){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahskor') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahpenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekspresiwajahskor') ?>').val(0);
  }
    skorventilator();
}

function venekstremitas(obj){
  if($('.formAnak').find(obj).val() != ''){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasatasskor') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasataspenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_ekstremitasatasskor') ?>').val(0);
  }
    skorventilator();
}

function venpatuh(obj){
  if($('.formAnak').find(obj).val() != ''){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorskor') ?>').val($(obj).val());
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorpenilaian') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'skriningnyeribps_kepatuhanventilatorskor') ?>').val(0);
  }
    skorventilator();
}


function skorventilator(){
    var totalSkor = 0;

    $('.formAnak').find('#tbl_ventilator').find('.skor_ventilator').each(function(){
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

    $('.formAnak').find('.paneltidaksadar').find('#<?php echo CHtml::activeId($model,'score_skalanyeri_anak') ?>').val(totalSkor);
    $('.formAnak').find('.paneltidaksadar').find('#<?php echo CHtml::activeId($model,'keteranganskala_nyeri_anak') ?>').val(risDewasa);
}

function setJenisPernapasan(obj){
  if($('.formAnak').find(obj).prop('checked')==true){
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'b1jenispernapasan_lainnya') ?>').attr('disabled',false);
  }else{
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'b1jenispernapasan_lainnya') ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model,'b1jenispernapasan_lainnya') ?>').attr('disabled',true);
  }
}

function setKesulitanbernafas(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.b1_kesulitanbernafas').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b1_jmloksigenperliter'); ?>').attr('disabled',false);
      $('.formAnak').find('.b1_jenisterapioksigen').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b1_jmloksigenperliter'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b1_jmloksigenperliter'); ?>').attr('disabled',true);
    $('.formAnak').find('.b1_jenisterapioksigen').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
}

function setB2isoedem(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.b2_isoedem').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b2_lokasioedem'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b2_lokasioedem'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b2_lokasioedem'); ?>').attr('disabled',true);
  }
}

function setB5Nyeritekan(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.b5_abdomen_isnyeritekan').each(function(){
    if($(this).val()==1 && $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b5_abdomen_nyeritekanlokasi'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b5_abdomen_nyeritekanlokasi'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b5_abdomen_nyeritekanlokasi'); ?>').attr('disabled',true);
  }
}

function setB6Fraktur(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.b6_isfraktur').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b6_lokasifraktur'); ?>').attr('disabled',false);
      $('.formAnak').find('.b6_jenisfraktur').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b6_lokasifraktur'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b6_lokasifraktur'); ?>').attr('disabled',true);
    $('.formAnak').find('.b6_jenisfraktur').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
}

function setB6ResikoDekubitus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.b6_isresikodekubitus').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b6_skorbraden'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b6_skorbraden'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b6_skorbraden'); ?>').attr('disabled',true);
  }
}

function setB6Luka(){
  var index = 0;
  var indexLainnya = 0;
  $('.formAnak').find('.b6_isluka').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b6_lokasiluka'); ?>').attr('disabled',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b6_lokasiluka'); ?>').val('');
    $('.formAnak').find('#<?php echo CHtml::activeId($model, 'b6_lokasiluka'); ?>').attr('disabled',true);
  }
}

$(document).ready(function(){
   $('.formAnak').find('.groupUkurans').find('input').keyup(function(){
        gantiHidden();
        getBeratBadanIdeal();
        getBMI();
    });
    getBeratBadanIdeal();
    getBMI();
    getText();
    $('.formAnak').find('#informasiResikoJatuh').hide();
    $('.formAnak').find('#informasiResikoJatuh').html("");
    setCheckDbn();

    $('.formAnak').find('.kepala_hasilperiksa').each(function(){
        setHasilKepala($(this));
    });

    $('.formAnak').find('.mata_hasilperiksa').each(function(){
        setHasilMata($(this));
    });

    $('.formAnak').find('.leher_hasilperiksa').each(function(){
        setHasilLeher($(this));
    });

    $('.formAnak').find('.hidung_hasilperiksa').each(function(){
        setHasilHidung($(this));
    });

    $('.formAnak').find('.telinga_hasilperiksa').each(function(){
        setHasilTelinga($(this));
    });

    $('.formAnak').find('.mulut_hasilperiksa').each(function(){
        setHasilMulut($(this));
    });
    $('.formAnak').find('.jantung_hasilperiksa').each(function(){
        setHasilJantung($(this));
    });
    $('.formAnak').find('.paru_hasilperiksa').each(function(){
        setHasilParu($(this));
    });
    $('.formAnak').find('.abdomen_hasilperiksa').each(function(){
        setHasilAbdomen($(this));
    });
    $('.formAnak').find('.genitalia_hasilperiksa').each(function(){
        setHasilGenitalia($(this));
    });
    $('.formAnak').find('.extremitasatas_hasilperiksa').each(function(){
        setHasilExtremAtas($(this));
    });

    $('.formAnak').find('.extremitasbawah_hasilperiksa').each(function(){
        setHasilExtremBawah($(this));
    });
    $('.formAnak').find('.kulit_hasilperiksa').each(function(){
        setHasilKulit($(this));
    });

     $('.formAnak').find(".pilih_SkrinningGizi").each(function(){
         choiseSkrinningGizi($(this));
     });


    $('.formAnak').find(".riwayatpembedahan_status").each(function(){
         setStatusPembedahanAnastesi($(this));
     });

     $('.formAnak').find(".statusalergipasien").each(function(){
        setStatusAlergi($(this));
     });



     $('.formAnak').find(".riwayatjatuh_3bln_terakhir").each(function(){
         changeInformasiResikoJatuh($(this));
     });
    $('.formAnak').find(".riwayatjatuh_alatbantu").each(function(){
         changeInformasiResikoJatuh($(this));
     });
     $('.formAnak').find(".jenisalatbantu").each(function(){
         changeInformasiResikoJatuh($(this));
     });

     $('.formAnak').find('.keb_nutricairan_edemastatus').each(function(){
         setKebNutrisiEdema($(this));
     });

     $('.formAnak').find('.keb_nutricairankeluhan_status').each(function(){
         setKebNutrisiStatus($(this));
     });

     $('.formAnak').find('.keb_eliminasi_bab_keluhanstatus').each(function(){
         setKebEliminasiBab($(this));
     });

     $('.formAnak').find('.keb_eliminasi_bak_keluhanstatus').each(function(){
         setKebEliminasiBak($(this));
     });

     $('.formAnak').find('.kesediaanmenerimaedukasi_status').each(function(){
         setEdukasiPenerima($(this));
     });

     $('.formAnak').find('.bicara_status').each(function(){
         setEdukasiBicara($(this));
     });

     $('.formAnak').find('.bahasaseharihari_jenis').each(function(){
         setEduBahasaSehari($(this));
     });

     $('.formAnak').find('.kebutuhanpenerjemah_status').each(function(){
         setEdukasiPenerjemah($(this));
     });

    setEdukasiPenerimaLainnya($('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_lainnya') ?>'));
    setEdukasiPenerimaKeluarga($('.formAnak').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_keluargapasien') ?>'));

     $('.formAnak').find('.riwayatJatuh').each(function(){
         setRiwayatJatuh($(this));
     });

     $('.formAnak').find('.statusMentalLansia').each(function(){
         setStatusMental($(this));
     });

     $('.formAnak').find('.penglihatanLansia').each(function(){
         setPengelihatan($(this));
     });
     $('.formAnak').find('.kebiasaanBerkemihLansia').each(function(){
         setKebiasaanBerkemih($(this));
     });

     $('.formAnak').find('.statusrokok').each(function(){
         setJumlahRokok($(this));
     });

     changeIndetifikasiPenyakitMenular($('.formAnak').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_ismenular') ?>'));
     changeIndetifikasiPenyakitJiwa($('.formAnak').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_ispenyakitjiwa') ?>'));

    getTransferLansia();
    getMobilitasLansia();

    $('.formAnak').find('.kebutuhankhusus_status').each(function(){
        setStatusKebutuhanKhusus($(this));
    });

    setTimeout(function(){
      $('.formAnak').find(".pilih_resikoJatuh").each(function(){
           choiseResikoJatuh($(this));
       });
      $('.formAnak').find('.pilih_nyeri').each(function(){
          pilihNyeri($(this));
      });
    }, 500);


    var skor = $('.formAnak').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val();
    if (skor != "") {
        $('.formAnak').find(".nyeri-nomor").css("border-radius", "5px");
        $('.formAnak').find("#nyerinomor_" + skor).css("border", "1px solid black");
    }

    setSumberData_anak();
    setStatusKontrolRisiko_anak();
    setAnak_anak();
    changeTinggalBersama_anak();
    setMasalahDlmBerbicara_anak();
    setNutrisiPerubahanBB_anak();
    setKualitasNyeri_anak();
    setFrekuensiNyeri_anak();
    setNilaiKepercayaanKhusus_anak();

    selectSumberData_anak();
    changeMasalahPerkawinan_anak();
    changeKekerasanFisik_anak();
    changeTraumaKehidupan_anak();

    setStatusRiwayattransfusi();
    setKesadaranNyeri();
    setKesulitanbernafas();
    setB2isoedem();
    setB5Nyeritekan();
    setB6Fraktur();
    setB6ResikoDekubitus();
    setB6Luka();

    var indexSknFungsional = 0;
    $('.formAnak').find('.pilih_fungsional').each(function(){
        pilihFungsional($(this));

        if(($('.formAnak').find(this).val() == 1 || $('.formAnak').find(this).val() == 2) && $('.formAnak').find(this).prop('checked')==false){
          indexSknFungsional++;
        }
    });

    if(indexSknFungsional==2){
        unpilihFungsional();
    }

    $('#checkSimpanData').val('');
    $('.formAnak').find('#rootwizardAskepAnak').bootstrapWizard({
      tabClass: "",
        onTabShow: function($tab, $navigation, index)
        {
          setCurrentProgressTab($(this), $navigation, $tab, $(this).find(".steps-progress div"), index);
        },
        onPrevious: function(tab, navigation, index){
          //alert('prev');
        },
        onNext: function(tab, navigation, index){
          var postdata = $('.formAnak').find('#askepanakri-t-form');
          var indexStepAnak = 9;

          var cekAnak = simpanDataFormAnak(postdata, index);
          if(index == indexStepAnak && cekAnak==true){
              $('.formAnak').find('.next').hide();
          }else{
            $('.formAnak').find('.next').show();
          }

          return cekAnak;
          // return true;
        },
        onTabClick: function(tab, navigation, index){
          // alert('assdssds');
          // var indexNext = $('.formAnak').find('#rootwizardAskepAnak').data('bootstrapWizard').nextIndex();
          // alert(indexNext);
          // if(index == 12){
          //     $('.next').hide();
          // }else{
          //   $('.next').show();
          // }
        }
      });
});

</script>
