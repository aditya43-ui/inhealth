<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
    function setKematian() {
        var keadaan_lahir = $('#PSPersalinanT_keadaanlahir').val();
        if (keadaan_lahir == 'Lahir Hidup') {
            $('#PSPersalinanT_jmlkelahiranmati').attr('disabled', 'true');
            $('#PSPersalinanT_sebabkematian').attr('disabled', 'true');
            $('#PSPersalinanT_tglabortus').attr('disabled', 'true');
            $('#PSPersalinanT_tglabortus_date').hide();
            $('#PSPersalinanT_jmlabortus').attr('disabled', 'true');

            $('#PSPersalinanT_sebabkematian').hide();
            $("label[for=PSPersalinanT_sebabkematian]").hide()

        } else {
            $('#PSPersalinanT_jmlkelahiranmati').removeAttr('disabled');
            $('#PSPersalinanT_sebabkematian').removeAttr('disabled');
            $('#PSPersalinanT_tglabortus').removeAttr('disabled');
            $('#PSPersalinanT_tglabortus_date').show();
            $('#PSPersalinanT_jmlabortus').removeAttr('disabled');
            $('#PSPersalinanT_sebabkematian').show();
            $("label[for=PSPersalinanT_sebabkematian]").show()
        }
    }

    function setTab(obj, v) {
        $("#tabber li").removeClass("active");
        $(obj).addClass("active");
        if (v == 1) {
            $("#panel-ginekologi").hide();
            $("#panel-obs").hide();
            $("#panel-persalinan").show();
            $("#panel-partograf").hide();
        } else if (v == 2) {
            $("#panel-ginekologi").hide();
            $("#panel-obs").show();
            $("#panel-persalinan").hide();
            $("#panel-partograf").hide();
        } else if (v == 3) {
            $("#panel-ginekologi").show();
            $("#panel-obs").hide();
            $("#panel-persalinan").hide();
            $("#panel-partograf").hide();
        } else if (v == 4) {
            $("#panel-ginekologi").hide();
            $("#panel-obs").hide();
            $("#panel-persalinan").hide();
            $("#panel-partograf").show();
        }
    }

    function setTekanan(obj) {
        var sis = parseFloat($(".systolic").val());
        var dia = parseFloat($(".diastolic").val());
        var art = 0;

        if (isNaN(sis)) sis = 0;
        if (isNaN(dia)) dia = 0;

        art = ((sis + (2 * dia)) / 3);

        $.post('<?php echo Yii::app()->createUrl('persalinan/pemeriksaanFisikTPS/GetTextTekananDarah'); ?>', {
            diastolic: dia,
            systolic: sis
        }, function(data) {
            if (data.text == null) {
                $('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
            } else {
                $('#tekananDarah').val(data.text);
            }
        }, 'json');
        $('#PemeriksaanfisikT_kala4_meanarteripressure').val(Math.floor(art));

        $(".td").val(sis + " / " + dia);

    }

    function cekInputPersalinan() {
        var jeniskegiatan_persalinan = $('#PSPersalinanT_jeniskegiatanpersalinan').val();
        var paritaske = $('#PSPersalinanT_paritaske').val();
        if (jeniskegiatan_persalinan.trim() == '' || paritaske.trim() == '') {
            myAlert("Anda belum melakukan pengisian data Persalinan Jenis Kegiatan dan Paristas Ke.");
            return false;
        }
        return true;
    }

    function cekGinekologi(obj) {
        var jeniskegiatan_persalinan = $('#PSPersalinanT_jeniskegiatanpersalinan').val();
        var paritaske = $('#PSPersalinanT_paritaske').val();

        if ((jeniskegiatan_persalinan.trim() != '') && (paritaske.trim() != '')) {
            $("#form-partografkontrol").html('');
            $("#form-partograflainlain").html('');

            obj.submit();
            //return false;
        } 
    }

    function changePenyulitKehamilan(obj){
        if($(obj).attr('look_value')=='Lainnya' && $(obj).prop('checked') == true){
            $('.keterangan_persalinan').attr('readonly',false);
        }else{
            $('.ischeck').each(function(){
                if(($(this).attr('look_value')=='Lainnya' && $(this).prop('checked') == false)){
                    $('.keterangan_persalinan').attr('readonly',true);
                    $('.keterangan_persalinan').val('');
                }  
            });
            
        }
    }

    function panelToggleObs(obj, panelform){
        if($(obj).prop('checked') == true){
            $('#panel-obs').find('.'+panelform).show();
        }else if($(obj).prop('checked') == false){
            $('#panel-obs').find('.'+panelform).hide();
        }
    }

    function tambahJaninObs(){
        var html =new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'obsteri/_rowJanin',array(),true));?>);
        $('#tbljanin_obs').find('tbody').append(html.replace());
        generateRowJaninObs($('#tbljanin_obs').find('tbody'));
    }

    function generateRowJaninObs(obj){
        for(var i=0; i<$(obj).find('.frek_auskultasi').length; i++){
            var trRow = $(obj).find('.frek_auskultasi').eq(i);
            trRow.attr('id','JaninObs_'+i+'_frek_auskultasi');
            trRow.attr('name','JaninObs['+i+'][frek_auskultasi]');
        }

        for(var i=0; i<$(obj).find('.denyutjantung_janin').length; i++){
            var trRow = $(obj).find('.denyutjantung_janin').eq(i);
            trRow.attr('id','JaninObs_'+i+'_denyutjantung_janin');
            trRow.attr('name','JaninObs['+i+'][denyutjantung_janin]');
        }

        for(var i=0; i<$(obj).find('.posisijanin').length; i++){
            var trRow = $(obj).find('.posisijanin').eq(i);
            trRow.attr('id','JaninObs_'+i+'_posisijanin');
            trRow.attr('name','JaninObs['+i+'][posisijanin]');
        }
    }

    function hapusJaninObs(obj){
        $(obj).parents('tr').remove();
        generateRowJaninObs($('#tbljanin_obs').find('tbody'));
    }

    function setPeriksadjj_kala2(obj){
        if($(obj).prop('checked') == true){
            $('#<?php echo CHtml::activeId($modKala,'kala_ii_hasilpemantauandjj') ?>').attr('readonly',false);
        }else{
            $('#<?php echo CHtml::activeId($modKala,'kala_ii_hasilpemantauandjj') ?>').val('');
            $('#<?php echo CHtml::activeId($modKala,'kala_ii_hasilpemantauandjj') ?>').attr('readonly',true);
        }
    }

    function changeismenyusuidini_kala3(){
        var index = 0;
        var indexLainnya = 0;
        $('.kala_iii_isimd').each(function(){
            if($(this).val()=='Tidak' &&  $(this).prop('checked')==true){
            $('#<?php echo CHtml::activeId($modKala, 'kala_iii_alasantidak_imd'); ?>').attr('readonly',false);
            indexLainnya = 1;
            }else{
            index++;
            }
        });

        if(index <= 2 && indexLainnya == 0){
            $('#<?php echo CHtml::activeId($modKala, 'kala_iii_alasantidak_imd'); ?>').val('');
            $('#<?php echo CHtml::activeId($modKala, 'kala_iii_alasantidak_imd'); ?>').attr('readonly',true);
        }
    }

    function changeispmtct_kala3(){
        var index = 0;
        var indexLainnya = 0;
        $('.kala_iii_pmtct').each(function(){
            if($(this).val()=='Tidak' &&  $(this).prop('checked')==true){
            $('#<?php echo CHtml::activeId($modKala, 'kala_iii_isalasantindakpmtct'); ?>').attr('readonly',false);
            indexLainnya = 1;
            }else{
            index++;
            }
        });

        if(index <= 2 && indexLainnya == 0){
            $('#<?php echo CHtml::activeId($modKala, 'kala_iii_isalasantindakpmtct'); ?>').val('');
            $('#<?php echo CHtml::activeId($modKala, 'kala_iii_isalasantindakpmtct'); ?>').attr('readonly',true);
        }
    }

    function changeDikirimOleh_ginekologi(){
        var index = 0;
        var indexLainnya = 0;
        $('.asal_pasien').each(function(){
            if($(this).val()=='Poliklinik Rumah Sakit' &&  $(this).prop('checked')==true){
            $('#<?php echo CHtml::activeId($modGinekologi, 'ruanganpoli_asalpasien'); ?>').attr('disabled',false);
            indexLainnya = 1;
            }else{
            index++;
            }
        });

        if(index <= 5 && indexLainnya == 0){
            $('#<?php echo CHtml::activeId($modGinekologi, 'ruanganpoli_asalpasien'); ?>').val('');
            $('#<?php echo CHtml::activeId($modGinekologi, 'ruanganpoli_asalpasien'); ?>').attr('disabled',true);
        }
    }
    function changemenopause_ginekologi(){
        var index = 0;
        var indexLainnya = 0;
        $('.ismenopause').each(function(){
            if($(this).val()=='Sudah' &&  $(this).prop('checked')==true){
            $('#<?php echo CHtml::activeId($modGinekologi, 'usia_menopause'); ?>').attr('readonly',false);
            indexLainnya = 1;
            }else{
            index++;
            }
        });

        if(index <= 2 && indexLainnya == 0){
            $('#<?php echo CHtml::activeId($modGinekologi, 'usia_menopause'); ?>').val('');
            $('#<?php echo CHtml::activeId($modGinekologi, 'usia_menopause'); ?>').attr('readonly',true);
        }
    }

    function tambahKehamilan_ginekologi(){
        var hamilke = parseInt(unformatNumber($('#hamilke').val()));
        var suamike = parseInt(unformatNumber($('#suamike').val()));
        var umurkehamilan = parseInt(unformatNumber($('#umurkehamilan').val()));
        var penyulit_kehamilan = $('#penyulit_kehamilan').val();
        var persalinan_penolong = $('#persalinan_penolong').val();
        var persalinan_jenis = $('#persalinan_jenis').val();
        var persalinan_penyulit = $('#persalinan_penyulit').val();
        var nifas = $('#nifas').val();
        var anak_ke = parseInt(unformatNumber($('#anak_ke').val()));
        var jeniskelamin = '';

        $('.jeniskelamin').each(function(){
            if($(this).prop('checked')==true){
                jeniskelamin = $(this).val();
            }
        });
        var beratbadan = parseFloat(unformatNumber($('#beratbadan').val()));
        var beratbadan_status = $('#beratbadan_status').val();
        var anak_keadaanlahir = $('#anak_keadaanlahir').val();
        var anak_lamapersalinanmenit = $('#anak_lamapersalinanmenit').val();
        var kb_cara = $('#kb_cara').val();
        var keterangan = $('#keterangan').val();


        if(hamilke != ''){
            var html = "<tr>" +
            "<td style='text-align: center'>"+
                "<input type='hidden' class='hamil_ke' value='"+hamilke+"' />"+
                "<input type='hidden' class='suami_ke' value='"+suamike+"' />"+
                "<input type='hidden' class='umurkehamilan_minggu' value='"+umurkehamilan+"' />"+
                "<input type='hidden' class='penyulit_kehamilan' value='"+penyulit_kehamilan+"' />"+
                "<input type='hidden' class='persalinan_penolong' value='"+persalinan_penolong+"' />"+
                "<input type='hidden' class='persalinan_jenis' value='"+persalinan_jenis+"' />"+
                "<input type='hidden' class='persalinan_penyulit' value='"+persalinan_penyulit+"' />"+
                "<input type='hidden' class='nifas' value='"+nifas+"' />"+
                "<input type='hidden' class='anak_ke' value='"+anak_ke+"' />"+
                "<input type='hidden' class='anak_jeniskelamin' value='"+jeniskelamin+"' />"+
                "<input type='hidden' class='anak_beratbadanlahir' value='"+beratbadan+"' />"+
                "<input type='hidden' class='anak_beratbadanlahirsatuan' value='"+beratbadan_status+"' />"+
                "<input type='hidden' class='anak_keadaanlahir' value='"+anak_keadaanlahir+"' />"+
                "<input type='hidden' class='anak_lamapersalinanmenit' value='"+anak_lamapersalinanmenit+"' />"+
                "<input type='hidden' class='kb_cara' value='"+kb_cara+"' />"+
                "<input type='hidden' class='keterangan' value='"+keterangan+"' />"+

                "<span>"+ hamilke +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ suamike +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ umurkehamilan +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ penyulit_kehamilan +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ persalinan_penolong +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ persalinan_jenis +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ persalinan_penyulit +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ nifas +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ anak_ke +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ jeniskelamin +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ beratbadan +"</span><br/>"+
                "<span>"+ beratbadan_status +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ anak_keadaanlahir +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ anak_lamapersalinanmenit +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ kb_cara +"</span>"+
            "</td>"+
            "<td>"+
                "<span>"+ keterangan +"</span>"+
            "</td>"+
            "<td>"+
                "<a onclick='batalKehamilan_ginekologi(this);return false;' rel='tooltip' href='javascript:void(0);' title='Klik untuk membatalkan Riwayat Kehamilan'><i class='icon-remove'></i></a>"+
            "</td>"+
            "</tr>";

            $('#tblRiwayatKehamilan').find('tbody').append(html);
            generateRowKehamilan_ginekologi($('#tblRiwayatKehamilan').find('tbody'));

            $('#hamilke').val('0');
            $('#suamike').val('0');
            $('#umurkehamilan').val('0');
            $('#penyulit_kehamilan').val('');
            $('#persalinan_penolong').val('');
            $('#persalinan_jenis').val('');
            $('#persalinan_penyulit').val('');
            $('#nifas').val('');
            $('#anak_ke').val('0');
            $('.jeniskelamin').each(function(){
                $(this).attr('checked',false);
            });
            $('#beratbadan').val('');
            $('#anak_keadaanlahir').val('');
            $('#beratbadan_status').val('Kg');
            $('#anak_lamapersalinanmenit').val('');
            $('#kb_cara').val('');
            $('#keterangan').val('');
        }else{
            myAlert('Riwayat Kehamilan & Kelahiran Belum Diisi !!')
        }
        }

        function generateRowKehamilan_ginekologi(obj){
            for(var i=0; i< $(obj).find('.hamil_ke').length; i++){
                var trRow = $(obj).find('.hamil_ke').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_hamil_ke');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][hamil_ke]');
            }

            for(var i=0; i< $(obj).find('.suami_ke').length; i++){
                var trRow = $(obj).find('.suami_ke').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_suami_ke');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][suami_ke]');
            }

            for(var i=0; i< $(obj).find('.umurkehamilan_minggu').length; i++){
                var trRow = $(obj).find('.umurkehamilan_minggu').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_umurkehamilan_minggu');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][umurkehamilan_minggu]');
            }

            for(var i=0; i< $(obj).find('.penyulit_kehamilan').length; i++){
                var trRow = $(obj).find('.penyulit_kehamilan').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_penyulit_kehamilan');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][penyulit_kehamilan]');
            }

            for(var i=0; i< $(obj).find('.persalinan_penolong').length; i++){
                var trRow = $(obj).find('.persalinan_penolong').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_persalinan_penolong');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][persalinan_penolong]');
            }

            for(var i=0; i< $(obj).find('.persalinan_jenis').length; i++){
                var trRow = $(obj).find('.persalinan_jenis').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_persalinan_jenis');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][persalinan_jenis]');
            }

            for(var i=0; i< $(obj).find('.persalinan_penyulit').length; i++){
                var trRow = $(obj).find('.persalinan_penyulit').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_persalinan_penyulit');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][persalinan_penyulit]');
            }
            for(var i=0; i< $(obj).find('.nifas').length; i++){
                var trRow = $(obj).find('.nifas').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_nifas');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][nifas]');
            }

            for(var i=0; i< $(obj).find('.anak_ke').length; i++){
                var trRow = $(obj).find('.anak_ke').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_anak_ke');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][anak_ke]');
            }

            for(var i=0; i< $(obj).find('.anak_jeniskelamin').length; i++){
                var trRow = $(obj).find('.anak_jeniskelamin').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_anak_jeniskelamin');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][anak_jeniskelamin]');
            }

            for(var i=0; i< $(obj).find('.anak_beratbadanlahir').length; i++){
                var trRow = $(obj).find('.anak_beratbadanlahir').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_anak_beratbadanlahir');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][anak_beratbadanlahir]');
            }

            for(var i=0; i< $(obj).find('.anak_beratbadanlahirsatuan').length; i++){
                var trRow = $(obj).find('.anak_beratbadanlahirsatuan').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_anak_beratbadanlahirsatuan');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][anak_beratbadanlahirsatuan]');
            }

            for(var i=0; i< $(obj).find('.anak_keadaanlahir').length; i++){
                var trRow = $(obj).find('.anak_keadaanlahir').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_anak_keadaanlahir');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][anak_keadaanlahir]');
            }

            for(var i=0; i< $(obj).find('.anak_lamapersalinanmenit').length; i++){
                var trRow = $(obj).find('.anak_lamapersalinanmenit').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_anak_lamapersalinanmenit');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][anak_lamapersalinanmenit]');
            }

            for(var i=0; i< $(obj).find('.kb_cara').length; i++){
                var trRow = $(obj).find('.kb_cara').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_kb_cara');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][kb_cara]');
            }

            for(var i=0; i< $(obj).find('.keterangan').length; i++){
                var trRow = $(obj).find('.keterangan').eq(i);
                trRow.attr('id','PSRiwayatkehamilanT_'+i+'_keterangan');
                trRow.attr('name','PSRiwayatkehamilanT['+i+'][keterangan]');
            }

        }

        function batalKehamilan_ginekologi(obj){
            $(obj).parents('tr').remove();
            generateRowKehamilan_ginekologi($('#tblRiwayatKehamilan').find('tbody'));
        }

        function setTekanan_ginekologi(obj) {
            var sis = parseFloat($('#<?php echo CHtml::activeId($modGinekologi, 'td_systolic'); ?>').val());
            var dia = parseFloat($('#<?php echo CHtml::activeId($modGinekologi, 'td_diastolic'); ?>').val());
            var art = 0;

            if (isNaN(sis)) sis = 0;
            if (isNaN(dia)) dia = 0;

            art = ((sis + (2 * dia)) / 3);

            $.post('<?php echo Yii::app()->createUrl('persalinan/pemeriksaanFisikTPS/GetTextTekananDarah'); ?>', {
                diastolic: dia,
                systolic: sis
            }, function(data) {
                if (data.text == null) {
                    $('#tekananDarah_genikologi').val('Tekanan Darah Tidak Ditemukan');
                } else {
                    $('#tekananDarah_genikologi').val(data.text);
                }
            }, 'json');
            $('#<?php echo CHtml::activeId($modGinekologi, 'map'); ?>').val(Math.floor(art));

            $("#tekananDarah_ori_genikologi").val(sis + " / " + dia);

        }
    
    function changeedema_ginekologi(){
        var index = 0;
        var indexLainnya = 0;
        $('.isedema').each(function(){
            if($(this).val()=='Ya' &&  $(this).prop('checked')==true){
            $('#<?php echo CHtml::activeId($modGinekologi, 'edema_lokasi'); ?>').attr('readonly',false);
            indexLainnya = 1;
            }else{
            index++;
            }
        });

        if(index <= 2 && indexLainnya == 0){
            $('#<?php echo CHtml::activeId($modGinekologi, 'edema_lokasi'); ?>').val('');
            $('#<?php echo CHtml::activeId($modGinekologi, 'edema_lokasi'); ?>').attr('readonly',true);
        }
    }
    $(document).ready(function() {
        changeismenyusuidini_kala3();
        changeispmtct_kala3();
        changeDikirimOleh_ginekologi();
        changemenopause_ginekologi();
        changeedema_ginekologi();

        <?php if(!empty($modPemeriksaan->frek_auskultasi)){ ?>
            generateRowJaninObs($('#tbljanin_obs').find('tbody'));
        <?php } ?>    
        

        $('.numbersOnly').keyup(function() {
            var d = $(this).attr('numeric');
            var value = $(this).val();
            var orignalValue = value;
            value = value.replace(/[0-9.]*/g, "");
            var msg = "Only Integer Values allowed.";

            if (d == 'decimal') {
                value = value.replace(/\./, "");
                msg = "Only Numeric Values allowed.";
            }

            if (value != '') {
                orignalValue = orignalValue.replace(/([^0-9.].*)/g, "")
                $(this).val(orignalValue);
            }

        });

        setTimeout(function() {
            setTekanan($("#PemeriksaanfisikT_kala4_systolic"));
        }, 500);

        $(".pilih-cb").find('input:checkbox').click(function() {
            $(this).parents(".pilih-cb").find('.txtlain').each(function() {
                if ($(this).parents(".control-group").find('.adatext').prop("checked") == false) {
                    $(this).attr('readonly', true);
                }
            });
            if ($(this).prop("checked") == true) {
                if ($(this).hasClass('adatext')) {
                    $(this).parents(".control-group").find('.txtlain').removeAttr('readonly');
                    $(this).parents(".control-group").find('.txtlain').val('');
                }
            } else {
                $(this).parents(".control-group").find('.txtlain').val('');
            }
        });

        $(".pilih-cb").find('input:radio').click(function() {
            $(this).parents(".pilih-cb").find('.txtlain').each(function() {

                if ($(this).parents(".control-group").find('.adatext').prop("checked") == false) {
                    $(this).attr('readonly', true);
                    $(this).val('');
                }
            });
            if ($(this).prop("checked") == true) {
                if ($(this).hasClass('adatext')) {
                    $(this).parents(".control-group").find('.txtlain').removeAttr('readonly');
                    $(this).parents(".control-group").find('.txtlain').val('');
                }
            } else {
                $(this).parents(".control-group").find('.txtlain').val('');
            }
        });

        $(".pilih-cb").find('input:radio.adatext, input:checkbox.adatext').each(function() {
            if ($(this).prop("checked") == true) {
                $(this).parents('.control-group').find('.txtlain').removeAttr('readonly');
            }
        });

        setKematian();

        $('#PSPersalinanT_sebabkematian').hide();
        $("label[for=PSPersalinanT_sebabkematian]").hide()
    });
</script>