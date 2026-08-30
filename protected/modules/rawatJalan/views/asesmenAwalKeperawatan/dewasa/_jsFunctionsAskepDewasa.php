<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
    function setStatusAlergi_dws(obj){
        var parentForm = $(obj).parents().find('.formDewasa');
        var value = $(parentForm).find(obj).val();

        if(value === '3' && $(parentForm).find(obj).prop('checked')==true){
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('readonly',false);
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('readonly',false);
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('readonly',false);
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'ispasangtandaalergi') ?>').attr('readonly',false).attr('disabled',false);
        }else{
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'riwayatalergiobat') ?>').attr('readonly',true);
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'riwayatalergimakanan') ?>').attr('readonly',true);
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'riwayatalergilainnya') ?>').attr('readonly',true);
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'ispasangtandaalergi') ?>').attr('readonly',true).attr('disabled',true);
        }
    }

    function setStatusPembedahanAnastesi_dws(obj){
      var parentForm = $(obj).parents().find('.formDewasa');
        var value = $(parentForm).find(obj).val();

        if($('.formDewasa').find('.riwayatpembedahan_status').length > 0){
            for(var i=0; i<$('.formDewasa').find('.riwayatpembedahan_status').length; i++){
                if($('.formDewasa').find('.riwayatpembedahan_status').eq(i).prop('checked') === true && $('.formDewasa').find('.riwayatpembedahan_status').eq(i).val()=='Pernah'){
                    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('readonly',false);
                }else if($('.formDewasa').find('.riwayatpembedahan_status').eq(i).prop('checked') === true && $('.formDewasa').find('.riwayatpembedahan_status').eq(i).val()=='Tidak Pernah'){
                    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').attr('readonly',true);
                    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'riwayatpembedahan_keterangan') ?>').val('');
                }
            }
        }
    }

     function setJumlahRokok_dws(obj){
        var value = $('.formDewasa').find(obj).val();

        if(value === '1' && $('.formDewasa').find(obj).prop('checked')==true){
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'jmlrokok_btg_hr') ?>').attr('readonly',false);
        }else if(value === '0' && $('.formDewasa').find(obj).prop('checked')==true){
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'jmlrokok_btg_hr') ?>').attr('readonly',true);
        }
    }

function returnValue_dws(obj){
    var value = $('.formDewasa').find(obj).val();
    var attrID = $('.formDewasa').find(obj).attr('id');
    var td = $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val();
    var splitTD = td.split(' / ');

    if (attrID == $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'td_diastolic') ?>').attr('id')){
        splitTD[0] = splitTD[0].replace(/_/gi, "0");
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val(splitTD[0]+' / '+value);
    }
    else if (attrID == $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'td_systolic') ?>').attr('id')){
        splitTD[1] = splitTD[1].replace(/_/gi, "0");
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'tekanandarah') ?>').val(value+' / '+splitTD[1]);
    }
}



function gantiJumlah_dws(obj){
    var value = parseFloat($('.formDewasa').find(obj).val());
    var teman = $('.formDewasa').find(obj).parent('.groupUkurans').find('input[type="text"]');
    var valueTeman = parseFloat(teman.val());
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}

function gantiHidden_dws(){
    var defaultBB = parseFloat(0.001);
    var defaultTB = parseFloat(100);
    var valueBB = parseFloat($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
    var valueTB = parseFloat($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').val());

    if ($('.formDewasa').find('#gram').val() != defaultBB){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB*defaultBB);
    }
    else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB);
    }

    if ($('.formDewasa').find('#meter').val() != defaultTB){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB*defaultTB);
    }
    else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB);
    }
}

function getBeratBadanIdeal_dws(){
    var beratBadan = parseFloat($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').val());
    var tinggiBadan = parseFloat($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var jenisKelamin = $('.formDewasa').find('#<?php echo CHtml::activeId($modPasien, 'jenis_kelamin') ?>').val();
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
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
    }
    else{
        //hasil = (tinggiBadan - 100) - ((10/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'bb_ideal') ?>').val(hasil);
    }
}

function getBMI_dws(){
    var beratBadan = parseFloat($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var tinggiBadan = parseFloat($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var hasil;

    hasil = (beratBadan/((tinggiBadan*tinggiBadan)/10000));
    if (jQuery.isNumeric(hasil)){
        $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText'); ?>', {bmi:hasil}, function(data){
            $('.formDewasa').find('#imt').val(data.text);
            $('.formDewasa').find('#imtValue').val(Math.floor(hasil));
        },'json');
    }
}

function getText_dws(){
    var dias = parseFloat($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'td_diastolic') ?>').val());
    var sys = parseFloat($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'td_systolic') ?>').val());
    var arteri = ((sys+(2*dias))/3);

    if (jQuery.isNumeric(dias)){
        if (jQuery.isNumeric(sys)){
            $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/GetTextTekananDarah'); ?>', {diastolic:dias, systolic:sys}, function(data){
                if (data.text == null){
                    $('.formDewasa').find('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
                } else {
                    $('.formDewasa').find('#tekananDarah').val(data.text);
                }
            },'json');
            $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'meanarteripressure') ?>').val(arteri.toFixed(2));
        }
    }
}

function setStatusKebutuhanKhusus_dws(obj){
    var value = $('.formDewasa').find(obj).val();

    if(value === 'Ada'  && $('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isgigipalsu') ?>').attr('disabled',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isalatbantudengar') ?>').attr('disabled',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_ispakaikacamata') ?>').attr('disabled',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_istongkat') ?>').attr('disabled',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_islainnya') ?>').attr('disabled',false);
    }else if(value === 'Tidak Ada'  && $('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isgigipalsu') ?>').attr('disabled',true).attr('checked',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isalatbantudengar') ?>').attr('disabled',true).attr('checked',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_ispakaikacamata') ?>').attr('disabled',true).attr('checked',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_istongkat') ?>').attr('disabled',true).attr('checked',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_islainnya') ?>').attr('disabled',true).attr('checked',false);
    }
    else if((value === 'Tidak Ada'  && $('.formDewasa').find(obj).prop('checked')==false) && (value === 'Ada'  && $('.formDewasa').find(obj).prop('checked')==false)){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isgigipalsu') ?>').attr('disabled',true).attr('checked',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_isalatbantudengar') ?>').attr('disabled',true).attr('checked',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_ispakaikacamata') ?>').attr('disabled',true).attr('checked',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_istongkat') ?>').attr('disabled',true).attr('checked',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_islainnya') ?>').attr('disabled',true).attr('checked',false);
    }
    changeIsLainnya_dws($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_islainnya') ?>'));
}

function changeIsLainnya_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_jenislainnya') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_jenislainnya') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kebutuhankhusus_jenislainnya') ?>').val('');
    }
}

function setCheckDbn_dws(){
    if( $('.formDewasa').find('#<?php echo CHtml::activeId($model,'is_dbn') ?>').prop('checked')==true){
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'kepala_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'mata_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'leher_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'hidung_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'telinga_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'mulut_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'jantung_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'paru_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'abdomen_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'genitalia_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'extremitasatas_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'extremitasbawah_hasilperiksa') ?>"][value="1"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'kulit_hasilperiksa') ?>"][value="1"]').prop('checked', true);
    }else{
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'kepala_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'kepala_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'mata_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'leher_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'hidung_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'telinga_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'mulut_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'jantung_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'paru_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'abdomen_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'genitalia_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'extremitasatas_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'extremitasbawah_hasilperiksa') ?>"][value="0"]').prop('checked', true);
        $('.formDewasa').find('input[name="<?php echo CHtml::activeName($model, 'kulit_hasilperiksa') ?>"][value="0"]').prop('checked', true);
    }

    $('.formDewasa').find('.kepala_hasilperiksa').each(function(){
        setHasilKepala_dws($(this));
    });

    $('.formDewasa').find('.mata_hasilperiksa').each(function(){
        setHasilMata_dws($(this));
    });

    $('.formDewasa').find('.leher_hasilperiksa').each(function(){
        setHasilLeher_dws($(this));
    });

    $('.formDewasa').find('.hidung_hasilperiksa').each(function(){
        setHasilHidung_dws($(this));
    });

    $('.formDewasa').find('.telinga_hasilperiksa').each(function(){
        setHasilTelinga_dws($(this));
    });

    $('.formDewasa').find('.mulut_hasilperiksa').each(function(){
        setHasilMulut_dws($(this));
    });
    $('.formDewasa').find('.jantung_hasilperiksa').each(function(){
        setHasilJantung_dws($(this));
    });
    $('.formDewasa').find('.paru_hasilperiksa').each(function(){
        setHasilParu_dws($(this));
    });
    $('.formDewasa').find('.abdomen_hasilperiksa').each(function(){
        setHasilAbdomen_dws($(this));
    });
    $('.formDewasa').find('.genitalia_hasilperiksa').each(function(){
        setHasilGenitalia_dws($(this));
    });
    $('.formDewasa').find('.extremitasatas_hasilperiksa').each(function(){
        setHasilExtremAtas_dws($(this));
    });

    $('.formDewasa').find('.extremitasbawah_hasilperiksa').each(function(){
        setHasilExtremBawah_dws($(this));
    });
    $('.formDewasa').find('.kulit_hasilperiksa').each(function(){
        setHasilKulit_dws($(this));
    });

}

function setHasilKepala_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.kepala_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.kepala_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilMata_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.mata_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.mata_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilLeher_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.leher_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.leher_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilHidung_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.hidung_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.hidung_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilTelinga_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.telinga_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.telinga_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilMulut_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.mulut_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.mulut_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilJantung_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.jantung_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.jantung_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilParu_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.paru_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.paru_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilAbdomen_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.abdomen_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.abdomen_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilGenitalia_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.genitalia_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.genitalia_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilExtremAtas_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.extremitasatas_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.extremitasatas_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilExtremBawah_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.extremitasbawah_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.extremitasbawah_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function setHasilKulit_dws(obj){
    if($('.formDewasa').find(obj).val() == 1  && $('.formDewasa').find(obj).prop('checked')==true){
      setTimeout(function(){
  			$('.formDewasa').find('.kulit_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", false);
  		}, 500);
    }else if($('.formDewasa').find(obj).val()==0 && $('.formDewasa').find(obj).prop('checked')===true){
      setTimeout(function(){
        $('.formDewasa').find('.kulit_abnormalketerangan > .redactor_box > .redactor_frame').contents().find('html > body > #page').attr("contenteditable", true);
      }, 500);
    }
}

function changePsikologiLainnya_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'statuspsikologis_lainnya') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'statuspsikologis_lainnya') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'statuspsikologis_lainnya') ?>').val('');
    }
}

function setHambatSosial_dws(obj){
    if($('.formDewasa').find(obj).val()==='Ada'){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'hambatansosial_keteranganada') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'hambatansosial_keteranganada') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'hambatansosial_keteranganada') ?>').val('');
    }
}

function setHambatEkonomi_dws(obj){
    if($('.formDewasa').find(obj).val()==='Ada'){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'hambatanekonomi_keteranganada') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'hambatanekonomi_keteranganada') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'hambatanekonomi_keteranganada') ?>').val('');
    }
}

function setHambatSpiritual_dws(obj){
    if($('.formDewasa').find(obj).val()==='Ada'){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'hambatanspiritual_keteranganada') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'hambatanspiritual_keteranganada') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'hambatanspiritual_keteranganada') ?>').val('');
    }
}

function setNilaiKepercayaan_dws(obj){
    if($('.formDewasa').find(obj).val()==='Ada'){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'nilaikepercayaan_keteranganada') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'nilaikepercayaan_keteranganada') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'nilaikepercayaan_keteranganada') ?>').val('');
    }
}

function klikBtnMakan_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_makan') ?>').val(nilai);
skorskrinningfungsional_dws();
}

function klikBtnToilet_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_aktifitastoilet') ?>').val(nilai);
skorskrinningfungsional_dws();
}

function klikBtnRodaTidur_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpindahkursi') ?>').val(nilai);
skorskrinningfungsional_dws();
}

function klikBtnGosokGigi_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_kebersihanmandiri') ?>').val(nilai);
skorskrinningfungsional_dws();
}

function klikBtnMandi_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mandi') ?>').val(nilai);
skorskrinningfungsional_dws();
}

function klikBtnBerjalanDasar_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berjalanpermukaankasar') ?>').val(nilai);
skorskrinningfungsional_dws();
}

function klikBtnNaikTangga_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_naikturuntangga') ?>').val(nilai);
skorskrinningfungsional_dws();
}

function klikBtnBerpakaian_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_berpakaian') ?>').val(nilai);
skorskrinningfungsional_dws();
}

function klikBtnDefekasi_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontroldefekasi') ?>').val(nilai);
    skorskrinningfungsional_dws();
}

function klikBtnBerkemih_dws(nilai){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'skrinningfungsional_skor_mengontrolberkemih') ?>').val(nilai);
    skorskrinningfungsional_dws();
}

function skorskrinningfungsional_dws(){
    var totalSkor = 0;

    $('.formDewasa').find('#tblInputFungsional').find('.skinningfungsional_skor').each(function(){
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

    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_jumlah_skor') ?>').val(totalSkor);
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_keterangan') ?>').val(keterangan);
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinningfungsional_kategori') ?>').val(kategori);
}

function skrinninggizidewasa_penurunbb_dws(obj){
  if($('.formDewasa').find(obj).val() != ''){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val($(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penurunanbb_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
  }else{
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb_dewasa') ?>').val(0);
  }
  skorskrinninggizi_dws();
}

function skrinninggizidewasa_asupan_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_asupanmakanan_dewasa') ?>').val($(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_asupanmakanan_dewasa') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_dws();
}

function skrininggizianak_tampakkurus_dws(obj){
  if($('.formDewasa').find(obj).val() == 'Ya'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_tampakkurus') ?>').val(1);
  }else if($(obj).val() == 'Tidak'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_tampakkurus') ?>').val(0);
  }

    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_tampakkurus') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_dws();
}

function skrininggizianak_bb_dws(obj){
  if($('.formDewasa').find(obj).val() == 'Ya'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb') ?>').val(1);
  }else if($(obj).val() == 'Tidak'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penurunanbb') ?>').val(0);
  }

    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penurunanbb') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_dws();
}

function skrininggizianak_kondisi_dws(obj){
  if($('.formDewasa').find(obj).val() == 'Ya'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_kondisi') ?>').val(1);
  }else if($(obj).val() == 'Tidak'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_kondisi') ?>').val(0);
  }
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_kondisi') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_dws();
}

function skrininggizianak_penyakit_dws(obj){
  if($('.formDewasa').find(obj).val() == 'Ya'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penyakit') ?>').val(2);
  }else if($(obj).val() == 'Tidak'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_penyakit') ?>').val(0);
  }
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_jwb_penyakit') ?>').val(obj.options[obj.selectedIndex].text);
    skorskrinninggizi_dws();
}

function skorskrinninggizi_dws(){
    var totalSkorDewasa = 0;
    var totalSkorAnak = 0;

    $('.formDewasa').find('#tblInputSkrinningGiziDewasa').find('.skrinninggizidewasa_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorDewasa += parseInt(skor);
    });

    $('.formDewasa').find('#tblInputSkrinningGiziAnak').find('.skrinninggizianak_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorAnak += parseInt(skor);
    });
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_totaldewasa') ?>').val(totalSkorDewasa);
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skrinninggizi_skor_totalanak') ?>').val(totalSkorAnak);
}

function choiseSkrinningGizi_dws(obj){
    if($('.formDewasa').find(obj).val() == 1 && $('.formDewasa').find(obj).prop('checked')==true){
        inputAllEnabled_dws($('.formDewasa').find('#skrinninggizi_dewasa_panel'));
        $('.formDewasa').find('#skrinninggizi_dewasa_panel').show();

        inputAllDisabled_dws($('.formDewasa').find('#skrinninggizi_anak_panel'));
        $('.formDewasa').find('#skrinninggizi_anak_panel').hide();
    } else if($('.formDewasa').find(obj).val() == 0 && $('.formDewasa').find(obj).prop('checked')==true){
        inputAllEnabled_dws($('.formDewasa').find('#skrinninggizi_anak_panel'));
        $('.formDewasa').find('#skrinninggizi_anak_panel').show();

        inputAllDisabled_dws($('.formDewasa').find('#skrinninggizi_dewasa_panel'));
        $('.formDewasa').find('#skrinninggizi_dewasa_panel').hide();
    }
}

function inputAllDisabled_dws(obj){
    $('.formDewasa').find(obj).find('input,select,textarea').each(function(){
        $(this).attr('disabled',true);
    });
}

function inputAllEnabled_dws(obj){
    $('.formDewasa').find(obj).find('input,select,textarea').each(function(){
        $(this).attr('disabled',false);
    });
}

function choiseResikoJatuh_dws(obj){
    if($('.formDewasa').find(obj).val() == 0 && $('.formDewasa').find(obj).prop('checked')==true){
        inputAllEnabled_dws($('.formDewasa').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formDewasa').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').show();

        inputAllDisabled_dws($('.formDewasa').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formDewasa').find('#panelresikojatuh_anak').find('#resikojatuhanak').hide();
        inputAllDisabled_dws($('.formDewasa').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formDewasa').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').hide();
    } else if($('.formDewasa').find(obj).val() == 1 && $('.formDewasa').find(obj).prop('checked')==true){
        inputAllEnabled_dws($('.formDewasa').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formDewasa').find('#panelresikojatuh_anak').find('#resikojatuhanak').show();

        inputAllDisabled_dws($('.formDewasa').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formDewasa').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
        inputAllDisabled_dws($('.formDewasa').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formDewasa').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').hide();
    }
    else if($('.formDewasa').find(obj).val() == 2 && $('.formDewasa').find(obj).prop('checked')==true){
        inputAllEnabled_dws($('.formDewasa').find('#panelresikojatuh_lansia').find('.panel-body'));
        $('.formDewasa').find('#panelresikojatuh_lansia').find('#resikojatuhlansia').show();

        inputAllDisabled_dws($('.formDewasa').find('#panelresikojatuh_anak').find('.panel-body'));
        $('.formDewasa').find('#panelresikojatuh_anak').find('#resikojatuhanak').hide();
        inputAllDisabled_dws($('.formDewasa').find('#panelresikojatuh_dewasa').find('.panel-body'));
        $('.formDewasa').find('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
    }
}

function resikojatuhdewasa_penilaian_dws(obj){
  if($('.formDewasa').find(obj).val() =='Ya'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_skor') ?>').val(25);
  }else{
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_skor') ?>').val(0);
  }

    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhdewasa_diagnosa_dws(obj){
  if($('.formDewasa').find(obj).val() =='Ya'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'diagnosismedis_skor') ?>').val(15);
  }else{
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'diagnosismedis_skor') ?>').val(0);
  }
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'diagnosismedis_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhdewasa_alatbantu_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'alatbantujalan_skor') ?>').val($(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'alatbantujalan_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhdewasa_terapi_dws(obj){
  if($('.formDewasa').find(obj).val() =='Ya'){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_skor') ?>').val(20);
  }else{
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_skor') ?>').val(0);
  }
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'memakaiterapiheparin_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhdewasa_berjalan_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'caraberjalan_skor') ?>').val($('.formDewasa').find(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'caraberjalan_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhdewasa_mental_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'statusmental_skor') ?>').val($('.formDewasa').find(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'statusmental_penilaian') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhanak_usia_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skor_usia_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'usia_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhanak_jeniskelamin_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skor_jeniskelamin_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'jeniskelamin_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhanak_diagnosa_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skor_diagnosa_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'diagnosa_asessment_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhanak_gangguan_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skor_gangguan_kognitif_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'gangguan_kognitif_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}


function resikojatuhanak_faktor_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skor_faktor_lingkungan_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'faktor_lingkungan_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}


function resikojatuhanak_respon_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skor_responterhadap_pembedahan_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'responterhadap_pembedahan_anak') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function resikojatuhanak_bedah_dws(obj){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'skor_medikamentosa_anak') ?>').val($('.formDewasa').find(obj).val());
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'penggunaan_medikamentosa') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh_dws();
}

function skorresikojatuh_dws(){
    var totalSkorDewasa = 0;
    var totalSkorAnak = 0;
    var totalSkorLansia = 0;

    $('.formDewasa').find('#tblResikojatuhDewasa').find('.resikojatuhdewasa_skor').each(function(){
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

    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'resikojatuh_skor') ?>').val(totalSkorDewasa);
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'resikojatuh_keterangan') ?>').val(ketResikoDewasa);

    $('.formDewasa').find('#tblResikojatuhAnak').find('.resikojatuhanak_skor').each(function(){
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

    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'jumlah_skor_anak') ?>').val(totalSkorAnak);
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'keterangan_resiko_jatuh_anak') ?>').val(ketResikoAnak);

    $('.formDewasa').find('#tblResikojatuhLansia').find('.resikojatuhlansia_skor').each(function(){
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
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'jumlah_skor_lansia') ?>').val(totalSkorLansia);
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'keterangan_skor_lansia') ?>').val(ketResikoLansia);

    // var objPanel = $('.formDewasa').find('#<?php //echo CHtml::activeId($model,'isresikojatuh') ?>');

      $('.formDewasa').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoDewasa);

    // $('.formDewasa').find('.pilih_resikoJatuh').each(function(){
    //   if($('.formDewasa').find(this).val() == 0 && $('.formDewasa').find(this).prop('checked')==true){
    //       $('.formDewasa').find('#<?php //echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoDewasa);
    //   }else if($('.formDewasa').find(this).val() == 0 && $('.formDewasa').find(this).prop('checked')==true){
    //      <?php //if($modPasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR){ ?>
    //          $('.formDewasa').find('#<?php //echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val("Resiko Tinggi");
    //      <?php //}else{ ?>
    //          $('.formDewasa').find('#<?php //echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoAnak);
    //       <?php //} ?>
    //   }else if($('.formDewasa').find(this).val() == 0 && $('.formDewasa').find(this).prop('checked')==true){
    //       $('.formDewasa').find('#<?php //echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(ketResikoLansia);
    //   }
    // });
}

function setAdaresikojatuh_dws(obj){
    if($('.formDewasa').find(obj).val() == 0 && $('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').attr('readonly',true);
    }else if($('.formDewasa').find(obj).val() == 1 && $('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').attr('readonly',false);
    }
}

function changeInformasiResikoJatuh_dws(obj){
   var html = "Lakukan intervensi pencegahan resiko jatuh: Beritahu pendamping untuk tidak meninggalkan pasien";
    if($('.formDewasa').find(obj).val() === 'Kursi Roda' && $('.formDewasa').find(obj).prop('checked')===true && $('.formDewasa').find(obj).hasClass('jenisalatbantu')){
        html = "Lakukan intervensi pencegahan resiko jatuh: Beritahu pendamping untuk tidak meninggalkan pasien dan pastikan kursi roda terkunci";
    }

    if($('.formDewasa').find(obj).val() === 'Lainnya' && $('.formDewasa').find(obj).prop('checked')===true && $('.formDewasa').find(obj).hasClass('jenisalatbantu')){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',false);
    }else if($('.formDewasa').find(obj).val() !== 'Lainnya' && $('.formDewasa').find(obj).prop('checked')===true && $('.formDewasa').find(obj).hasClass('jenisalatbantu')){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',true);
    }

    if($('.formDewasa').find(obj).val() === '1' && $('.formDewasa').find(obj).prop('checked')===true && $('.formDewasa').find(obj).hasClass('riwayatjatuh_alatbantu')){
        $('.formDewasa').find('.jenisalatbantu').attr('disabled',false);
    }else{
        if($('.formDewasa').find(obj).val() === '0' && $('.formDewasa').find(obj).prop('checked')===true  && $('.formDewasa').find(obj).hasClass('riwayatjatuh_alatbantu')){
            $('.formDewasa').find('.jenisalatbantu').attr('disabled',true);
            $('.formDewasa').find('.jenisalatbantu').attr('checked',false);
            $('.formDewasa').find('#<?php echo CHtml::activeId($model,'riwayatjatuh_jenisalatbantulainnya') ?>').attr('readonly',true);
        }
    }
    if($('.formDewasa').find('.riwayatjatuh_alatbantu').prop('checked')===true && $('.formDewasa').find('.riwayatjatuh_3bln_terakhir').prop('checked')===false){
        $('.formDewasa').find('#informasiResikoJatuh').hide();
        $('.formDewasa').find('#informasiResikoJatuh').html("");
    }else{
        $('.formDewasa').find('#informasiResikoJatuh').show();
        $('.formDewasa').find('#informasiResikoJatuh').html(html);
    }

    if($('.formDewasa').find('.riwayatjatuh_alatbantu').prop('checked')===false && $('.formDewasa').find('.riwayatjatuh_3bln_terakhir').prop('checked')===false){
        $('.formDewasa').find('#informasiResikoJatuh').hide();
        $('.formDewasa').find('#informasiResikoJatuh').html("");
    }

}


function resetFormFlasCCs_dws(){
    $('.formDewasa').find("#master_falsccs > tbody > tr").each(function(){

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

    $('.formDewasa').find("#master_falsccs > tfoot > tr").each(function(){
        $(this).find('.field').each(function(){
            $(this).val('');
        });
    });

    $('.formDewasa').find("#totalskor").html('');
}


function pilihNyeri_dws(obj){
if($('.formDewasa').find(obj).val() == 0 && $('.formDewasa').find(obj).prop('checked')==true){
        // inputAllEnabled_dws($('.formDewasa').find('#nyeri_anak').find('.panel-body'));
        // $('.formDewasa').find('#nyeri_anak').find('.panel-body').show();

        inputAllDisabled_dws($('.formDewasa').find('#nyeri_dewasa').find('.panel-body'));
        $('.formDewasa').find('#nyeri_dewasa').find('.panel-body').hide();

        // $('.formDewasa').find("#<?php //echo CHtml::activeId($model, 'score_skalanyeri') ?>").addClass('required');
        // $('.formDewasa').find("#<?php //echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").addClass('required');
    } else if($('.formDewasa').find(obj).val() == 1 && $('.formDewasa').find(obj).prop('checked')==true){
        inputAllEnabled_dws($('.formDewasa').find('#nyeri_dewasa').find('.panel-body'));
        $('.formDewasa').find('#nyeri_dewasa').find('.panel-body').show();

        // inputAllDisabled_dws($('.formDewasa').find('#nyeri_anak').find('.panel-body'));
        // $('.formDewasa').find('#nyeri_anak').find('.panel-body').hide();

        // resetFormFlasCCs_dws();
        //
        // $('.formDewasa').find("#<?php //echo CHtml::activeId($model, 'score_skalanyeri') ?>").removeClass('required');
        // $('.formDewasa').find("#<?php //echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").removeClass('required');
    }
}

function pilihScala_dws(skor){
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
        $('.formDewasa').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val(skor);
        $('.formDewasa').find("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri') ?>").val(keterangan);
    //}

    $('.formDewasa').find(".nyeri-nomor").css("border", "none");
    $('.formDewasa').find(".nyeri-nomor").css("border-radius", "5px");
    $('.formDewasa').find("#nyerinomor_" + skor).css("border", "1px solid black");
}

function getSkorFla_dws(id,skor,obj){
    $("#skor_"+id).html(skor);
    $('.formDewasa').find(obj).parents("tr").find('.params').val(skor);
    $('.formDewasa').find(obj).parents("tr").find('.nilai').val(skor);
    $('.formDewasa').find(obj).parents("tr").find('.kategoriid').val(id);

    totalSkorFla_dws();
}

function totalSkorFla_dws(){
    var total = 0;

    $('.formDewasa').find("#master_falsccs > tbody > tr").each(function(){
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

    $('.formDewasa').find("#totalskor").html(total);

    if (total == 0){
        var keterangan = 'tidak nyeri';
    }else if(total >= 1 && total <= 3){
        var keterangan = 'nyeri ringan';
    }else if(total >= 4 && total <= 6){
        var keterangan = 'nyeri sedang';
    }else if(total >= 7 && total <= 10){
        var keterangan = 'nyeri berat sekali';
    }

    $('.formDewasa').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri_anak') ?>").val(total);
    $('.formDewasa').find("#<?php echo CHtml::activeId($model, 'keteranganskala_nyeri_anak') ?>").val(keterangan);
}



function changeDeskripsinyeri_ismenjalar_dws(obj){
    if($('.formDewasa').find(obj).val()==='1'){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_lokasipenjalaran') ?>').val('');
    }
}

function changeNyeriHilangLain_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'nyerihilangdgn_lainlainjenis') ?>').val('');
    }
}

function setDeformitas_dws(obj){
    if($('.formDewasa').find(obj).val()==='1'){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'deformitas_regio') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'deformitas_regio') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'deformitas_regio') ?>').val('');
    }
}

function setGangguanTidur_dws(obj){
    if($('.formDewasa').find(obj).val()==='1'){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'gangguantidur_keterangan') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'gangguantidur_keterangan') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'gangguantidur_keterangan') ?>').val('');
    }
}

function setKebNutrisiStatus_dws(obj){
 if($('.formDewasa').find(obj).val()==='1' && $('.formDewasa').find(obj).prop('checked')===true){
        $('.formDewasa').find('.kebnutricairankeluhan').attr('disabled',false);
    }else if($('.formDewasa').find(obj).val()==='0' && $('.formDewasa').find(obj).prop('checked')===true){
        $('.formDewasa').find('.kebnutricairankeluhan').attr('disabled',true);
        $('.formDewasa').find('.kebnutricairankeluhan').attr('checked',false);
    }
}

function setKebNutrisiEdema_dws(obj){
    if($('.formDewasa').find(obj).val()==='1' && $('.formDewasa').find(obj).prop('checked')===true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_nutricairan_edemalokasi') ?>').attr('readonly',false);
    }else if($('.formDewasa').find(obj).val()==='0' && $('.formDewasa').find(obj).prop('checked')===true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_nutricairan_edemalokasi') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_nutricairan_edemalokasi') ?>').val('');
    }
}

function setKebEliminasiBab_dws(obj){
    if($('.formDewasa').find(obj).val()==='1' && $('.formDewasa').find(obj).prop('checked')===true){
         $('.formDewasa').find('.kebEliminasiBab').attr('disabled',false);
    }else if($('.formDewasa').find(obj).val()==='0' && $('.formDewasa').find(obj).prop('checked')===true){
        $('.formDewasa').find('.kebEliminasiBab').attr('disabled',true);
        $('.formDewasa').find('.kebEliminasiBab').attr('checked',false);
    }
    setKebEliminasiKeluhanLainBab_dws($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_iskeluhanlainnya') ?>'));
}

function setKebEliminasiKeluhanLainBab_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_jeniskeluhanlainnya') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_jeniskeluhanlainnya') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bab_jeniskeluhanlainnya') ?>').val('');
    }
}

function setKebEliminasiBak_dws(obj){
    if($('.formDewasa').find(obj).val()==='1' && $('.formDewasa').find(obj).prop('checked')===true){
         $('.formDewasa').find('.kebEliminasiBak').attr('disabled',false);
    }else if($('.formDewasa').find(obj).val()==='0' && $('.formDewasa').find(obj).prop('checked')===true){
        $('.formDewasa').find('.kebEliminasiBak').attr('disabled',true);
        $('.formDewasa').find('.kebEliminasiBak').attr('checked',false);
    }
    setKebEliminasiKeluhanLainBak_dws($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_iskeluhanlainnya') ?>'));
}

function setKebEliminasiKeluhanLainBak_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_jeniskeluhanlainnya') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_jeniskeluhanlainnya') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'keb_eliminasi_bak_jeniskeluhanlainnya') ?>').val('');
    }
}

function changeIndetifikasiPenyakitMenular_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_menularketerangan') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_menularketerangan') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_menularketerangan') ?>').val('');
    }
}

function changeIndetifikasiPenyakitJiwa_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('.idenpenyakitjiwa').attr('disabled',false);
    }else{
        $('.formDewasa').find('.idenpenyakitjiwa').attr('disabled',true);
        $('.formDewasa').find('.idenpenyakitjiwa').attr('checked',false);
    }
    setIdenPenyakitJiwaLainnya_dws($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakitjiwa_islainnya') ?>'));
}

function setIdenPenyakitJiwaLainnya_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakitjiwa_keteranganlainnya') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakitjiwa_keteranganlainnya') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakitjiwa_keteranganlainnya') ?>').val('');
    }
}

function setChangeDetEdukasiLain_dws(obj){
    var index = $('.formDewasa').find(obj).attr('text_id');

    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#RJAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('readonly',false);
    }else{
        $('.formDewasa').find('#RJAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').attr('readonly',true);
        $('.formDewasa').find('#RJAsesmenkebutuhanEdukasidetT_'+index+'_edukasipasien_lainnya').val('');
    }
}

function setEdukasiPenerima_dws(obj){
    if($('.formDewasa').find(obj).val()==='1' && $('.formDewasa').find(obj).prop('checked')===true){
         $('.formDewasa').find('.edukasipenerima').attr('disabled',false);
         $('.formDewasa').find('.edukasipenerima').attr('checked',false);
         $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak') ?>').attr('readonly',true);
         $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak') ?>').val('');
    }else if($('.formDewasa').find(obj).val()==='0' && $('.formDewasa').find(obj).prop('checked')===true){
        $('.formDewasa').find('.edukasipenerima').attr('disabled',true);
        $('.formDewasa').find('.edukasipenerima').attr('checked',false);
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak') ?>').attr('readonly',false);
    }
    setEdukasiPenerimaLainnya_dws($('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_lainnya') ?>'));
    setEdukasiPenerimaKeluarga_dws($('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_keluargapasien') ?>'));
}

function setEdukasiPenerimaLainnya_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama') ?>').val('');
    }
}

function setEdukasiPenerimaKeluarga_dws(obj){
    if($('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien') ?>').attr('readonly',false);
    }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien') ?>').val('');
    }
}

function setEdukasiBicara_dws(obj){
    if($('.formDewasa').find(obj).val()==='Serangan Awal Bicara' && $('.formDewasa').find(obj).prop('checked')===true){
         $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal') ?>').attr('readonly',false);
    }else if($('.formDewasa').find(obj).val()==='Normal' && $('.formDewasa').find(obj).prop('checked')===true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal') ?>').val('');
    }
}

function setEduBahasaSehari_dws(obj){
    if($('.formDewasa').find(obj).val()==='Daerah' && $('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama') ?>').attr('readonly',false);
    }else if($('.formDewasa').find(obj).val()==='Indonesia' && $('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama') ?>').val('');
    }
}

function setEdukasiPenerjemah_dws(obj){
    if($('.formDewasa').find(obj).val()==='Ya' && $('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').attr('readonly',false);
    }else if($('.formDewasa').find(obj).val()==='Tidak' && $('.formDewasa').find(obj).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').attr('readonly',true);
        $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa') ?>').val('');
    }
}

function setRiwayatJatuh_dws(obj){
    if($('.formDewasa').find('.resiko_jatuh_lansia').val() != '' && $('.formDewasa').find('.resiko_jatuh_lansia').val() == 1){
        $('.formDewasa').find('#riwayatJatuhRSLansia_0').attr('checked',true);
        $('.formDewasa').find('#riwayatJatuhBulanLansia_0').attr('checked',true);
    }
    if($('.formDewasa').find('#riwayatJatuhRSLansia_0').prop('checked')==true || $('.formDewasa').find('#riwayatJatuhBulanLansia_0').prop('checked')==true){
        $('.formDewasa').find('.resiko_jatuh_lansia').val(true);
        $('.formDewasa').find('.skor_resiko_jatuh_lansia').val(6);
    }else if($('.formDewasa').find('#riwayatJatuhRSLansia_0').prop('checked')==false || $('.formDewasa').find('#riwayatJatuhBulanLansia_0').prop('checked')==false){
        $('.formDewasa').find('.resiko_jatuh_lansia').val(false);
        $('.formDewasa').find('.skor_resiko_jatuh_lansia').val(0);
    }
    skorresikojatuh_dws();
}

function setStatusMental_dws(obj){
    if($('.formDewasa').find('.status_mental_lansia').val() != '' && $('.formDewasa').find('.status_mental_lansia').val() == 1){
        $('.formDewasa').find('#statusMentalDeliriumLansia_0').attr('checked',true);
        $('.formDewasa').find('#statusMentalDisorientasiLansia_0').attr('checked',true);
        $('.formDewasa').find('#statusMentalAgitasiLansia_0').attr('checked',true);
    }
     if($('.formDewasa').find('#statusMentalDeliriumLansia_0').prop('checked')==true ||
           $('.formDewasa').find('#statusMentalDisorientasiLansia_0').prop('checked')==true ||
           $('.formDewasa').find('#statusMentalAgitasiLansia_0').prop('checked')==true){
            $('.formDewasa').find('.status_mental_lansia').val(true);
            $('.formDewasa').find('.skor_status_mental_lansia').val(14);
        }else if($('.formDewasa').find('#statusMentalDeliriumLansia_0').prop('checked')==false ||
           $('.formDewasa').find('#statusMentalDisorientasiLansia_0').prop('checked')==false ||
           $('.formDewasa').find('#statusMentalAgitasiLansia_0').prop('checked')==false){
            $('.formDewasa').find('.status_mental_lansia').val(false);
            $('.formDewasa').find('.skor_status_mental_lansia').val(0);
        }
    skorresikojatuh_dws();
}

function setPengelihatan_dws(obj){
    if($('.formDewasa').find('.penglihatan_lansia').val() != '' && $('.formDewasa').find('.penglihatan_lansia').val() == 1){
        $('.formDewasa').find('#penglihatanKacamataLansia_0').attr('checked',true);
        $('.formDewasa').find('#penglihatanBuramLansia_0').attr('checked',true);
        $('.formDewasa').find('#penglihatanKatarakLansia_0').attr('checked',true);
    }

     if($('.formDewasa').find('#penglihatanKacamataLansia_0').prop('checked')==true ||
           $('.formDewasa').find('#penglihatanBuramLansia_0').prop('checked')==true ||
           $('.formDewasa').find('#penglihatanKatarakLansia_0').prop('checked')==true){
            $('.formDewasa').find('.penglihatan_lansia').val(true);
            $('.formDewasa').find('.skor_penglihatan_lansia').val(1);
        }else{
            $('.formDewasa').find('.penglihatan_lansia').val(false);
            $('.formDewasa').find('.skor_penglihatan_lansia').val(0);
        }
    skorresikojatuh_dws();
}

function setKebiasaanBerkemih_dws(obj){
     if ($('.formDewasa').find(obj).val()=='1' && $('.formDewasa').find(obj).prop('checked')==true){
            $('.formDewasa').find('.skor_berkemih_lansia').val(2);
        }else if ($('.formDewasa').find(obj).val()=='0' && $('.formDewasa').find(obj).prop('checked')==true){
            $('.formDewasa').find('.skor_berkemih_lansia').val(0);
        }
    skorresikojatuh_dws();
}

function getTransferLansia_dws(){
    if($('.formDewasa').find('.transfer_mobilitas_lansia').val() != ''){
        var trs = '';
         $('.formDewasa').find('#transferLansia').find('option').each(function(){
            if($(this).text() == $('.formDewasa').find('.transfer_mobilitas_lansia').val()){
                trs = $(this).val();
            }
        });
        $('.formDewasa').find('#transferLansia').val(trs);
    }

    if($('.formDewasa').find('#transferLansia').val() != ""){
        $('.formDewasa').find('.transfer_mobilitas_lansia').val($('.formDewasa').find('#transferLansia').find('option:selected').text());
        $('.formDewasa').find('#transferLansiaHidden').val($('.formDewasa').find('#transferLansia').val());
    }else{
         $('.formDewasa').find('.transfer_mobilitas_lansia').val("");
        $('.formDewasa').find('#transferLansiaHidden').val(0);
    }

    totalTransferMobilitas_dws();
}

function getMobilitasLansia_dws(){
    if($('.formDewasa').find('.mobilitas_lansia').val() != ''){
        var mob = '';
         $('.formDewasa').find('#mobilitasLansia').find('option').each(function(){
            if($(this).text() == $('.formDewasa').find('.mobilitas_lansia').val()){
                mob = $(this).val();
            }
        });
        $('.formDewasa').find('#mobilitasLansia').val(mob);
    }

    if($('.formDewasa').find('#mobilitasLansia').val() != ""){
        $('.formDewasa').find('.mobilitas_lansia').val($('.formDewasa').find('#mobilitasLansia').find('option:selected').text());
         $('.formDewasa').find('#mobilitasLansiaHidden').val($('.formDewasa').find('#mobilitasLansia').val());
    }else{
        $('.formDewasa').find('.mobilitas_lansia').val("");
      $('.formDewasa').find('#mobilitasLansiaHidden').val(0);
    }

    totalTransferMobilitas_dws();
}

function totalTransferMobilitas_dws(){
   var trf = $('.formDewasa').find('#transferLansiaHidden').val();
   var mobil = $('.formDewasa').find('#mobilitasLansiaHidden').val();
   var jumlah = parseInt(trf) + parseInt(mobil);
   var totalJml = 0;
   if (!isNaN(jumlah)) {
       if(jumlah >=0 && jumlah <= 3){
           totalJml = 0;
       }else{
           totalJml = 7;
       }
   }
   $('.formDewasa').find('.skor_transfer_mobilitas_lansia').val(totalJml);
   skorresikojatuh_dws();
}

function resikojatuhrj_penilaian_dws(){
    var hasilpengkajian = "";
    var tindakan = "";
    var nilai_a = $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'resikojatuhkhususrj_hasilpenilaian_a') ?>').val();
    var nilai_b = $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'resikojatuhkhususrj_hasilpenilaian_b') ?>').val();

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

    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'resikojatuhkhususrj_hasilpengkajian') ?>').val(hasilpengkajian);
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'resikojatuhkhususrj_tindakanygdiperlukan') ?>').val(tindakan);
    $('.formDewasa').find('#<?php echo CHtml::activeId($model,'resikojatuh_tingkat') ?>').val(hasilpengkajian);
}

function simpanAllData_dws(){
  if(requiredCheck($('.formDewasa').find("#askepdewasari-t-form"))){
    var indexNext = $('.formDewasa').find('#rootwizardAskepDewasa').data('bootstrapWizard').nextIndex();
    var indexstep = $('.formDewasa').find('#rootwizardAskepDewasa').data('bootstrapWizard').currentIndex();
    $(".formDewasa").addClass("animation-loading");
    $('.formDewasa').find(".integer-decimal, .integer2, .float2").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
    var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
    var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
    var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
    var jenisasesmen = $('#choise_dewasa').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
    var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

    var dataSerialized = $('.formDewasa').find('#askepdewasari-t-form').serializeArray();
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
              suksesData = true;
              $('.formDewasa').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              $.fn.yiiGridView.update('riwayataskep-grid', {
                  data: $(this).serialize()
              });
            }else{
              $('.formDewasa').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
            }
            if(suksesData==true){
              setTimeout(function(){
                  $('.formDewasa').find('.divAlert').html('');
              }, 5000);
            }
          }else{
              $('.formDewasa').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');

          }
          $(".formDewasa").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formDewasa").removeClass("animation-loading");}
    });
  }
}

function simpanDataForm_dws(simpanDt, indexstep, handeland){
  var suksesData = false;
    if(requiredCheck($('.formDewasa').find(simpanDt))){
      var indexNext = $('.formDewasa').find('#rootwizardAskepDewasa').data('bootstrapWizard').nextIndex();
      $(".formDewasa").addClass("animation-loading");
      $('.formDewasa').find(".integer-decimal, .integer2, .float2").each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
      var pendaftaran_id = $('#<?php echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
      var pasienadmisi_id = $('#<?php echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
      var pasien_id = $('#<?php echo Chtml::activeId($model, 'pasien_id') ?>').val();
      var jenisasesmen = $('#choise_dewasa').find('#<?php echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
      var asesmenawalkeperawatan_id = $('#<?php echo Chtml::activeId($model, 'asesmenawalkeperawatan_id') ?>').val();

      if(indexstep > 1){
        $('#checkSimpanData').val('simpan');
      }else if (indexstep == 1){
        $('#checkSimpanData').val('');
      }

      var checksimpan = $('#checkSimpanData').val();

      var dataSerialized = $('.formDewasa').find(simpanDt).serializeArray();
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
                $('.formDewasa').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                $.fn.yiiGridView.update('riwayataskep-grid', {
                    data: $(this).serialize()
                });
              }else{
                $('.formDewasa').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
              }

              if(suksesData==true){
                setTimeout(function(){
                    $('.formDewasa').find('.divAlert').html('');
                }, 5000);
              }


            }else{
                $('.formDewasa').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
            }
            $(".formDewasa").removeClass("animation-loading");
          },
          error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formDewasa").removeClass("animation-loading");}
      });
    }
    return suksesData;
}

function setSumberData(){
  var index = 0;
  var indexLainnya = 0;
  $('.formDewasa').find('.sumberdata').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').val('');
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'sumberdata_lainnya'); ?>').attr('readonly',true);
  }
}

function setStatusKontrolRisiko(){
  var index = 0;
  var indexLainnya = 0;
  $('.formDewasa').find('.kontrolrisikoinfeksi_status').each(function(){
    if($(this).val()=='Diketahui' &&  $(this).prop('checked')==true){
      indexLainnya = 1;
      $('.formDewasa').find('.jenisrisiko').each(function(){
        $(this).attr('disabled',false);
      });
    }else{
      index++;
    }
  });

  if(index <= 3 && indexLainnya == 0){
    $('.formDewasa').find('.jenisrisiko').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
  }
  $('.formDewasa').find('.jenisrisiko').each(function(){
    setJenisRisikoLainnya($(this));
  });
}

function setJenisRisikoLainnya(obj){
  if($('.formDewasa').find(obj).attr('datavalue')== 'Lainnya' && $('.formDewasa').find(obj).prop('checked') == true){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'jenisrisikoinfeksi_lainnya'); ?>').attr('readonly',false);
  }else{
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'jenisrisikoinfeksi_lainnya'); ?>').val('');
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'jenisrisikoinfeksi_lainnya'); ?>').attr('readonly',true);
  }
}

function setAnak_dws(){
  var index = 0;
  var indexLainnya = 0;
  $('.formDewasa').find('.isada_anak').each(function(){
    if($(this).val()=='Ada' &&  $(this).prop('checked')==true){
      $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'jml_anak'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'jml_anak'); ?>').val('0');
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'jml_anak'); ?>').attr('readonly',true);
  }
}

function changeTinggalBersama_dws(obj){
    var value = $('.formDewasa').find(obj).val();

    if(value === 'Lainnya'){
      $('.formDewasa').find('.tinggalbersama').attr('disabled',false);
    }else{
      $('.formDewasa').find('.tinggalbersama').val('');
      $('.formDewasa').find('.tinggalbersama').attr('disabled',true);
    }
}

function setMasalahDlmBerbicara(){
  var index = 0;
  var indexLainnya = 0;
  $('.formDewasa').find('.masalahdlm_berbicara').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'masalahbicara_ket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'masalahbicara_ket'); ?>').val('');
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'masalahbicara_ket'); ?>').attr('readonly',true);
  }
}

function setNutrisiPerubahanBB(){
  var index = 0;
  var indexLainnya = 0;
  $('.formDewasa').find('.nutrisi_perubahanbb6blnterakhir').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'nutrisi_perubahanbb6blnterakhirket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'nutrisi_perubahanbb6blnterakhirket'); ?>').val('');
    $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'nutrisi_perubahanbb6blnterakhirket'); ?>').attr('readonly',true);
  }
}

function setAdaNyeri_dws(){
  var index = 0;
  var indexLainnya = 0;
  $('.formDewasa').find('.isadakeluhannyeri').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formDewasa').find('.jenisnyeri').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formDewasa').find('.jenisnyeri').each(function(){
      $(this).attr('checked',false);
      $(this).attr('disabled',true);
    });
  }
}

function setKualitasNyeri(){
  $('.formDewasa').find('.kualitasnyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',false);
      }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').val('');
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'kualitasnyeri_lainnya'); ?>').attr('readonly',true);
      }
  });
}

function setFrekuensiNyeri(){
  $('.formDewasa').find('.frekuensinyeri').each(function(){
      if($(this).attr('datavalue')=='Lainnya' &&  $(this).prop('checked')==true){
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',false);
      }else{
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').val('');
        $('.formDewasa').find('#<?php echo CHtml::activeId($model, 'deskripsinyeri_frekuensinyerilainnya'); ?>').attr('readonly',true);
      }
  });
}

function setNilaiKepercayaanKhusus(){
  var index = 0;
  var indexLainnya = 0;
  $('.formDewasa').find('.nilaikepercayaankhusus_dewasa').each(function(){
    if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
      $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket'); ?>').val('');
    $('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket'); ?>').attr('readonly',true);
  }
}



$(document).ready(function(){
   $('.formDewasa').find('.groupUkurans').find('input').keyup(function(){
        gantiHidden_dws();
        getBeratBadanIdeal_dws();
        getBMI_dws();
    });
    getBeratBadanIdeal_dws();
    getBMI_dws();
    getText_dws();
    $('.formDewasa').find('#informasiResikoJatuh').hide();
    $('.formDewasa').find('#informasiResikoJatuh').html("");
    setCheckDbn_dws();

    $('.formDewasa').find('.kepala_hasilperiksa').each(function(){
        setHasilKepala_dws($(this));
    });

    $('.formDewasa').find('.mata_hasilperiksa').each(function(){
        setHasilMata_dws($(this));
    });

    $('.formDewasa').find('.leher_hasilperiksa').each(function(){
        setHasilLeher_dws($(this));
    });

    $('.formDewasa').find('.hidung_hasilperiksa').each(function(){
        setHasilHidung_dws($(this));
    });

    $('.formDewasa').find('.telinga_hasilperiksa').each(function(){
        setHasilTelinga_dws($(this));
    });

    $('.formDewasa').find('.mulut_hasilperiksa').each(function(){
        setHasilMulut_dws($(this));
    });
    $('.formDewasa').find('.jantung_hasilperiksa').each(function(){
        setHasilJantung_dws($(this));
    });
    $('.formDewasa').find('.paru_hasilperiksa').each(function(){
        setHasilParu_dws($(this));
    });
    $('.formDewasa').find('.abdomen_hasilperiksa').each(function(){
        setHasilAbdomen_dws($(this));
    });
    $('.formDewasa').find('.genitalia_hasilperiksa').each(function(){
        setHasilGenitalia_dws($(this));
    });
    $('.formDewasa').find('.extremitasatas_hasilperiksa').each(function(){
        setHasilExtremAtas_dws($(this));
    });

    $('.formDewasa').find('.extremitasbawah_hasilperiksa').each(function(){
        setHasilExtremBawah_dws($(this));
    });
    $('.formDewasa').find('.kulit_hasilperiksa').each(function(){
        setHasilKulit_dws($(this));
    });

     $('.formDewasa').find(".pilih_SkrinningGizi").each(function(){
         choiseSkrinningGizi_dws($(this));
     });
    $('.formDewasa').find(".pilih_resikoJatuh").each(function(){
         choiseResikoJatuh_dws($(this));
     });

    $('.formDewasa').find(".riwayatpembedahan_status").each(function(){
         setStatusPembedahanAnastesi_dws($(this));
     });

     $('.formDewasa').find(".statusalergipasien").each(function(){
        setStatusAlergi_dws($(this));
     });



     $('.formDewasa').find(".riwayatjatuh_3bln_terakhir").each(function(){
         changeInformasiResikoJatuh_dws($(this));
     });
    $('.formDewasa').find(".riwayatjatuh_alatbantu").each(function(){
         changeInformasiResikoJatuh_dws($(this));
     });
     $('.formDewasa').find(".jenisalatbantu").each(function(){
         changeInformasiResikoJatuh_dws($(this));
     });

     $('.formDewasa').find('.keb_nutricairan_edemastatus').each(function(){
         setKebNutrisiEdema_dws($(this));
     });

     $('.formDewasa').find('.keb_nutricairankeluhan_status').each(function(){
         setKebNutrisiStatus_dws($(this));
     });

     $('.formDewasa').find('.keb_eliminasi_bab_keluhanstatus').each(function(){
         setKebEliminasiBab_dws($(this));
     });

     $('.formDewasa').find('.keb_eliminasi_bak_keluhanstatus').each(function(){
         setKebEliminasiBak_dws($(this));
     });

     $('.formDewasa').find('.kesediaanmenerimaedukasi_status').each(function(){
         setEdukasiPenerima_dws($(this));
     });

     $('.formDewasa').find('.bicara_status').each(function(){
         setEdukasiBicara_dws($(this));
     });

     $('.formDewasa').find('.bahasaseharihari_jenis').each(function(){
         setEduBahasaSehari_dws($(this));
     });

     $('.formDewasa').find('.kebutuhanpenerjemah_status').each(function(){
         setEdukasiPenerjemah_dws($(this));
     });

    setEdukasiPenerimaLainnya_dws($('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_lainnya') ?>'));
    setEdukasiPenerimaKeluarga_dws($('.formDewasa').find('#<?php echo CHtml::activeId($modAsesmenkebutuhanEdukasiT, 'ispenerimaedukasi_keluargapasien') ?>'));

     $('.formDewasa').find('.riwayatJatuh').each(function(){
         setRiwayatJatuh_dws($(this));
     });

     $('.formDewasa').find('.statusMentalLansia').each(function(){
         setStatusMental_dws($(this));
     });

     $('.formDewasa').find('.penglihatanLansia').each(function(){
         setPengelihatan_dws($(this));
     });
     $('.formDewasa').find('.kebiasaanBerkemihLansia').each(function(){
         setKebiasaanBerkemih_dws($(this));
     });

     $('.formDewasa').find('.statusrokok').each(function(){
         setJumlahRokok_dws($(this));
     });

     changeIndetifikasiPenyakitMenular_dws($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_ismenular') ?>'));
     changeIndetifikasiPenyakitJiwa_dws($('.formDewasa').find('#<?php echo CHtml::activeId($model, 'identifikasipenyakit_ispenyakitjiwa') ?>'));

    getTransferLansia_dws();
    getMobilitasLansia_dws();

    $('.formDewasa').find('.kebutuhankhusus_status').each(function(){
        setStatusKebutuhanKhusus_dws($(this));
    });

     $('.formDewasa').find('.pilih_nyeri').each(function(){
         pilihNyeri_dws($(this));
     });

    var skor = $('.formDewasa').find("#<?php echo CHtml::activeId($model, 'score_skalanyeri') ?>").val();
    if (skor != "") {
        $('.formDewasa').find(".nyeri-nomor").css("border-radius", "5px");
        $('.formDewasa').find("#nyerinomor_" + skor).css("border", "1px solid black");
    }

    setSumberData();
    setStatusKontrolRisiko();
    setAnak_dws();
    setMasalahDlmBerbicara();
    setNutrisiPerubahanBB();
    setKualitasNyeri();
    setAdaNyeri_dws();
    setFrekuensiNyeri();
    setNilaiKepercayaanKhusus();


    $('#checkSimpanData').val('');
    $('.formDewasa').find('#rootwizardAskepDewasa').bootstrapWizard({
      tabClass: "",
        onTabShow: function($tab, $navigation, index)
        {
          setCurrentProgressTab($(this), $navigation, $tab, $(this).find(".steps-progress div"), index);
        },
        onPrevious: function(tab, navigation, index){
        },
        onNext: function(tab, navigation, index){
          var postdata = $('.formDewasa').find('#askepdewasari-t-form');
          var indexStepDewasa = 8;
          var cekDewasa = simpanDataForm_dws(postdata, index);
          if(index == indexStepDewasa && cekDewasa==true){
              $('.formDewasa').find('.next').hide();
          }else{
            $('.formDewasa').find('.next').show();
          }

          return cekDewasa;
          // return true;
        },
        onTabClick: function(tab, navigation, index){
        }
      });
});

</script>
