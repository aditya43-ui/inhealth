<script type='text/javascript'>
    
    function ewsNilai(obj){
        var value = $(obj).val();
        $(obj).parents('tr').find('input[name$="[skorpenilaian]"]').val(value);
        $(obj).parents('tr').find('input[name$="[hasipenilaian_text]"]').val(obj.options[obj.selectedIndex].text);
        totalEws();
    }
    
    function totalEws(){
        var total = 0;
        var countParam = 0;
        $('#choise_ews').find('#tblchoise_ews').find('.trSkorEws').each(function(){
            var nilai = $(this).find('.skorpenilaian').val();
            var value = $(this).find('select[name$="[hasipenilaian]"]').val();
            
            if(value !== ''){
                countParam += 1;
            }
            
            if(nilai === '' || isNaN(nilai)){
                nilai = 0;
            }
            
            total += parseInt(nilai);
        });
        
        // var klarifikasi = "Sangat Rendah";
        // var respon = "Lanjutkan Observasi minimal 12 jam";
        // var tindakan = "Observasi/ monitoring secara rutin";
        
        if(total >= 0 && total <=2){
            klarifikasi = "Sangat Rendah";
            respon = "“Pasien dalam kondisi Stabil, Pemantauan tanda vital setiap 6 jam”";
            tindakan = "Pemantauan tanda vital setiap 6 jam";
        }
        if(total >= 2 && total <=3){
            klarifikasi = "Rendah";
            respon = "“Pemantauan tanda vital setiap 2 jam”";
            tindakan = "(1) Perawat ketua tim segera memberikan informasi tentang kondisi pasien kepada dokter jaga; (2) Dokter jaga melakukan asesmen sesuai kompetensinya dan menentukan kondisi pasien apakah dalam penyakit akut; (3) Siapkan fasilitas monitoring yang lebih tinggi";
        }
        if((total >=4 && total <=5)){
            klarifikasi = "Sedang";
            respon = "Pantau TTV setiap 1 jam";
            tindakan = "(1) Perawat ketua tim segera memberikan informasi tentang kondisi pasien kepada dokter jaga/ DPJP; (2) Dokter jaga segera memberikan informasi tentang kondisi pasien kepada  DPJP; (3) DPJP melakukan asesmen sesuai kompetensinya dan menentukan kondisi pasien apakah dalam penyakit akut  (4)Siapkan fasilitas monitoring yang lebih tinggi";
        }
        if (total >= 6){
            klarifikasi = "Tinggi";
            respon = "Pemantauan TTV setiap 1/2 jam";
            tindakan = "(1) Perawat ketua tim segera memberikan informasi tentang kondisi pasien kepada dokter jaga/ DPJP; (2) Dokter jaga segera memberikan informasi tentang kondisi pasien kepada  DPJP; (3) Dokter Jaga atau DPJP  konsultasi intensivist";
        }
        
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'total_skor') ?>').val(total);
       
       if(klarifikasi == 'Tinggi'){
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').val(klarifikasi);
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').css({ 'background-color': 'red'});
       } else if(klarifikasi == 'Sedang'){
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').val(klarifikasi);
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').css({ 'background-color': 'orange'}); 
       } else if(klarifikasi == 'Rendah'){
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').val(klarifikasi);
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').css({ 'background-color': 'yellow'}); 
        } else if(klarifikasi == 'Sangat Rendah'){
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').val(klarifikasi);
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').css({ 'background-color': 'darkgreen'}); 
       }else{
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').val(klarifikasi);
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').css({ 'background-color': 'darkgreen'}); 
           
       }

        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'monitoring_frekuensi') ?>').val(respon);
        $('#choise_ews').find('#tblchoise_ews').find('#<?php echo CHtml::activeId($model, 'tindakan') ?>').val(tindakan);
    }
    
    function moewsNilai(obj){
        var value = $(obj).val();
        $(obj).parents('tr').find('input[name$="[skorpenilaian]"]').val(value);
        $(obj).parents('tr').find('input[name$="[hasipenilaian_text]"]').val(obj.options[obj.selectedIndex].text);
        totalMoews();
    }
    
    function totalMoews(){
        var total = 0;
        var countParam = 0;
        $('#choise_moews').find('#tblchoise_moews').find('.trSkorMoews').each(function(){
            var nilai = $(this).find('.skorpenilaian').val();
            var value = $(this).find('select[name$="[hasipenilaian]"]').val();
            
            if(value !== ''){
                countParam += 1;
            }
            
            if(nilai === '' || isNaN(nilai)){
                nilai = 0;
            }
            
            total += parseInt(nilai);
        });
        
        var klarifikasi = "Rendah (Hijau)";
        var monitoring = "4 Jam";
        var petugas = "Perawat/ Bidan jaga, Dokter jaga";
        var tindakan = "(1) Meningkatkan frekuensi monitoring jika ada perubahan kondisi pasien; (2) Jika perlu menghubungi dokter jaga; (3) Jika pasien mengalami preeklampsia (sakit kepala, pandangan kabur, nyeri perut), tingkatkan pengawasan";
        
        if(total > 0 && total <=4){
            klarifikasi = "Rendah (Hijau)";
            monitoring = "4 Jam";
            petugas = "Perawat/ Bidan jaga, Dokter jaga";
            tindakan = "(1) Meningkatkan frekuensi monitoring jika ada perubahan kondisi pasien; (2) Jika perlu menghubungi dokter jaga; (3) Jika pasien mengalami preeklampsia (sakit kepala, pandangan kabur, nyeri perut), tingkatkan pengawasan";
        }
        if((total >= 5 && total <=6)){
            klarifikasi = "Sedang (Kuning)";
            monitoring = "1 jam";
            petugas = "Bidan/ Perawat jaga, Dokter Sp.OG";
            tindakan = "(1) Lapor bidan/perawat jaga (2) Bidan/ perawat segera monitoring ulang pasien; (3) Menguhubungi dokter spesialis kandungan dan segera konsultasikan; (4) Meningkatkan frekuensi monitoring; (5) Jika pasien mengalami preeklampsia (sakit kepala, pandangan kabur, nyeri perut), tingkatkan pengawasan";
        }
        if (total >= 7){
            klarifikasi = "Tinggi (Merah)";
            monitoring = "Berkelanjutan";
            petugas = "Panggilan Darurat";
            tindakan = "(1) Menghubungi dokter Sp.OG; (2) Mengubungi tim emergency; (3) Melanjutkan TTV secara berkelanjutan; (4) Mempertimbangkan pemindahan ke ruang ICU";
        }
        
        $('#choise_moews').find('#tblchoise_moews').find('#<?php echo CHtml::activeId($model, 'total_skor') ?>').val(total);
        $('#choise_moews').find('#tblchoise_moews').find('#<?php echo CHtml::activeId($model, 'klasifikasi') ?>').val(klarifikasi);
        $('#choise_moews').find('#tblchoise_moews').find('#<?php echo CHtml::activeId($model, 'monitoring_frekuensi') ?>').val(monitoring);
        $('#choise_moews').find('#tblchoise_moews').find('#<?php echo CHtml::activeId($model, 'monitoring_petugas') ?>').val(petugas);
        $('#choise_moews').find('#tblchoise_moews').find('#<?php echo CHtml::activeId($model, 'tindakan') ?>').val(tindakan);
    }
    
    function pewsNilai(obj){
        var value = $(obj).val();
        $(obj).parents('tr').find('input[name$="[skorpenilaian]"]').val(value);
        $(obj).parents('tr').find('input[name$="[hasipenilaian_text]"]').val(obj.options[obj.selectedIndex].text);
        totalPews();
    }
    
    function totalPews(){
        var total = 0;
        var countParam = 0;
        $('#choise_pews').find('#tblchoise_pews').find('.trSkorPews').each(function(){
            var nilai = $(this).find('.skorpenilaian').val();
            var value = $(this).find('select[name$="[hasipenilaian]"]').val();
            
            if(value !== ''){
                countParam += 1;
            }
            
            if(nilai === '' || isNaN(nilai)){
                nilai = 0;
            }
            
            total += parseInt(nilai);
        });
        
        var monitoring = "4 Jam";
        var petugas = "Perawat";
        var tindakan = "Tidak ada intervensi tambahan";
        
        if(total > 0 && total <=3){
            if(total > 2){
                 monitoring = "2 - 4 jam";
                tindakan = "Mengkaji/ menilai ulang pasien";
            }else{
                monitoring = "4 Jam";
                tindakan = "Tidak ada intervensi tambahan";
            }
            petugas = "Perawat";
        }
        if((total >= 4 && total <=5)){
            if(total == 4){
                monitoring = "Minimal 1 jam";
                tindakan = "Perawat melapor kepada dokter tentang pasien";
            }
            if(total == 5){
                monitoring = "30 menit";
                tindakan = "Perawat maupun dokter menilai ulang pasien";
            }
            
            petugas = "Perawat/ Dokter Jaga";
        }
        if (total == 6){
            monitoring = "30 menit";
            petugas = "Perawat/ Dokter Jaga dan DPJP";
            tindakan = "Melapor ke DPJP untuk tindakan klinis selanjutnya";
        }
        if((total >= 7)){
            monitoring = "Berkelanjutan";
            petugas = "Panggilan Darurat";
            tindakan = "Menghubungi tim emergensi";
        }
        
        $('#choise_pews').find('#tblchoise_pews').find('#<?php echo CHtml::activeId($model, 'total_skor') ?>').val(total);
        $('#choise_pews').find('#tblchoise_pews').find('#<?php echo CHtml::activeId($model, 'monitoring_frekuensi') ?>').val(monitoring);
        $('#choise_pews').find('#tblchoise_pews').find('#<?php echo CHtml::activeId($model, 'monitoring_petugas') ?>').val(petugas);
        $('#choise_pews').find('#tblchoise_pews').find('#<?php echo CHtml::activeId($model, 'tindakan') ?>').val(tindakan);
    }
    
    function choiseEws(obj){
        if($(obj).val() == 1 && $(obj).prop('checked')==true){
            inputAllEnabled($('#choise_ews').find('.panel-body'));
            $('#choise_ews').find('.panel-body').find('.formEws').show();
            $('#choise_ews').find('.panel-body').find('#tblchoise_ews').find('input[name*="hasipenilaian_text"],input[type="text"],textarea, select').val('');
            $('#choise_ews').find('.panel-body').find('#tblchoise_ews').find('.integer').val('0');
            
            inputAllDisabled($('#choise_pews').find('.panel-body'));
            $('#choise_pews').find('.panel-body').find('.formPews').hide();
            inputAllDisabled($('#choise_news').find('.panel-body'));
            $('#choise_news').find('.panel-body').find('.formNews').hide();
            inputAllDisabled($('#choise_moews').find('.panel-body'));
            $('#choise_moews').find('.panel-body').find('.formMoews').hide();
        }else if($(obj).val() == 2 && $(obj).prop('checked')==true){
            inputAllEnabled($('#choise_pews').find('.panel-body'));
            $('#choise_pews').find('.panel-body').find('.formPews').show();
            $('#choise_pews').find('.panel-body').find('#tblchoise_pews').find('input[name*="hasipenilaian_text"],input[type="text"],textarea, select').val('');
            $('#choise_pews').find('.panel-body').find('#tblchoise_pews').find('.integer').val('0');
            
            inputAllDisabled($('#choise_ews').find('.panel-body'));
            $('#choise_ews').find('.panel-body').find('.formEws').hide();
            inputAllDisabled($('#choise_news').find('.panel-body'));
            $('#choise_news').find('.panel-body').find('.formNews').hide();
            inputAllDisabled($('#choise_moews').find('.panel-body'));
            $('#choise_moews').find('.panel-body').find('.formMoews').hide();
        }else if($(obj).val() == 3 && $(obj).prop('checked')==true){
            inputAllEnabled($('#choise_news').find('.panel-body'));
            $('#choise_news').find('.panel-body').find('.formNews').show();
             $('#choise_news').find('.panel-body').find('#tblchoise_news').find('input[name*="hasipenilaian_text"],input[type="text"],textarea, select').val('');
            $('#choise_news').find('.panel-body').find('#tblchoise_news').find('.float2, .integer2').val('0');
            
            inputAllDisabled($('#choise_ews').find('.panel-body'));
            $('#choise_ews').find('.panel-body').find('.formEws').hide();
             inputAllDisabled($('#choise_pews').find('.panel-body'));
            $('#choise_pews').find('.panel-body').find('.formPews').hide();
            inputAllDisabled($('#choise_moews').find('.panel-body'));
            $('#choise_moews').find('.panel-body').find('.formMoews').hide();
        }else if($(obj).val() == 4 && $(obj).prop('checked')==true){
            inputAllEnabled($('#choise_moews').find('.panel-body'));
            $('#choise_moews').find('.panel-body').find('.formMoews').show();
             $('#choise_moews').find('.panel-body').find('#tblchoise_moews').find('input[name*="hasipenilaian_text"],input[type="text"],textarea, select').val('');
            $('#choise_moews').find('.panel-body').find('#tblchoise_moews').find('.integer').val('0');
            
            inputAllDisabled($('#choise_ews').find('.panel-body'));
            $('#choise_ews').find('.panel-body').find('.formEws').hide();
             inputAllDisabled($('#choise_pews').find('.panel-body'));
            $('#choise_pews').find('.panel-body').find('.formPews').hide();
            inputAllDisabled($('#choise_news').find('.panel-body'));
            $('#choise_news').find('.panel-body').find('.formNews').hide();
        }else{
            inputAllDisabled($('#choise_ews').find('.panel-body'));
            $('#choise_ews').find('.panel-body').find('.formEws').hide();
            
             inputAllDisabled($('#choise_pews').find('.panel-body'));
            $('#choise_pews').find('.panel-body').find('.formPews').hide();
            
            inputAllDisabled($('#choise_news').find('.panel-body'));
            $('#choise_news').find('.panel-body').find('.formNews').hide();
            
            inputAllDisabled($('#choise_moews').find('.panel-body'));
            $('#choise_moews').find('.panel-body').find('.formMoews').hide();
        }
    }
    
    function changeNilaiSuhu(){
        var value = $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($modDetail, '[0]hasipenilaian') ?>').val();
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($modDetail, '[0]hasipenilaian_text') ?>').val(value);
    
        if(value === '' || isNaN(value)){
            value = 0;
        }
        var warna = "Merah";
        
        if(parseFloat(value) <= 35){
            warna = "Merah";
        }
        if(parseFloat(value) >= 35.1 && parseFloat(value) <= 36){
            warna = "Kuning";
        }
        if(parseFloat(value) >= 36.1 && parseFloat(value) <= 37){
            warna = "Hijau";
        }
        if(parseFloat(value) >= 37.1){
            warna = "Merah";
        }
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($modDetail, '[0]skorpenilaian') ?>').val(warna);
        totalNews();
    }
    
    function changeNilaiPernapasan(){
        var value = $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($modDetail, '[1]hasipenilaian') ?>').val();
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($modDetail, '[1]hasipenilaian_text') ?>').val(value);
        
        if(value === '' || isNaN(value)){
            value = 0;
        }
        var warna = "Merah";
        
        if(parseFloat(value) <= 25){
            warna = "Merah";
        }
        if(parseFloat(value) >= 25.1 && parseFloat(value) <= 30){
            warna = "Kuning";
        }
        if(parseFloat(value) >= 30.1 && parseFloat(value) <= 55){
            warna = "Hijau";
        }
        if(parseFloat(value) >= 55.1 && parseFloat(value) <= 80){
            warna = "Kuning";
        }
        if(parseFloat(value) >= 80.1){
            warna = "Merah";
        }
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($modDetail, '[1]skorpenilaian') ?>').val(warna);
        totalNews();
    }
    
    function changeNilaiNadi(){
        var value = $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($modDetail, '[3]hasipenilaian') ?>').val();
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($modDetail, '[3]hasipenilaian_text') ?>').val(value);
        
        if(value === '' || isNaN(value)){
            value = 0;
        }
        var warna = "Merah";
        
        if(parseFloat(value) <= 70){
            warna = "Merah";
        }
        if(parseFloat(value) >= 80 && parseFloat(value) <= 90){
            warna = "Kuning";
        }
        if(parseFloat(value) >= 100 && parseFloat(value) <= 140){
            warna = "Hijau";
        }
        if(parseFloat(value) >= 150 && parseFloat(value) <= 180){
            warna = "Kuning";
        }
        if(parseFloat(value) >= 190){
            warna = "Merah";
        }
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($modDetail, '[3]skorpenilaian') ?>').val(warna);
        totalNews();
    }
    
    function newsNilai(obj){
        var value = $(obj).val();
        $(obj).parents('tr').find('input[name$="[skorpenilaian]"]').val(value);
        $(obj).parents('tr').find('input[name$="[hasipenilaian_text]"]').val(obj.options[obj.selectedIndex].text);
        totalNews();
    }
    
    function totalNews(){
        var totalhijau = 0;
        var totalmerah = 0;
        var totalkuning = 0;
        var totalskor = $('#choise_news').find('#tblchoise_news').find('select[name$="[total_skor]"]').val();
        $('#choise_news').find('#tblchoise_news').find('.trSkorNews').each(function(){
            var value = $(this).find('input[name$="[skorpenilaian]"]').val();
            
            if(value == 'Merah'){
                totalmerah += 1;
            }
            
            if(value == 'Kuning'){
                totalkuning += 1;
            }
            
            if(value == 'Hijau'){
                totalhijau += 1;
            }
        });
        
        var monitoring = "";
        var tindakan = "";
        
        if(totalskor === 'Hijau (0)'){
            monitoring = "4 Jam";
            tindakan = "Frekuensi observasi dilakukan setiap 4 jam oleh bidan atau perawat sesuai yang ditentukan dokter atau DPJP";
        }
        
        if(totalskor === 'Kuning (1)'){
            monitoring = "30 - 60 menit";
            tindakan = "(1) Menghubungi dokter atau DPJP untuk tindakan klinis yang akan dilakukan; (2) Memonitor pasien dalam 30-60 menit";
        }
        
        if(totalskor === 'Kuning (≥1)' || totalskor === 'Merah (≥1)'){
            monitoring = "Berkelanjutan";
            tindakan = "Menghubungi dokter dan atau tim medis emergensi untuk tindakan medis selanjutnya";
        }
        
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($model, 'total_skor_hijau') ?>').val(totalhijau);
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($model, 'total_skor_kuning') ?>').val(totalkuning);
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($model, 'total_skor_merah') ?>').val(totalmerah);
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($model, 'monitoring_frekuensi') ?>').val(monitoring);
        $('#choise_news').find('#tblchoise_news').find('#<?php echo CHtml::activeId($model, 'tindakan') ?>').val(tindakan);
    }
    
    function inputAllDisabled(obj){
        $(obj).find('input,select,textarea').each(function(){ //element <input>
            $(this).attr('disabled',true);
        });
    }
    
    function inputAllEnabled(obj){
        $(obj).find('input,select,textarea').each(function(){ //element <input>
            $(this).attr('disabled',false);
        });
    }
    
function hapusEws(id,daftarid) {
    myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusEws'); ?>', {id: id,pendaftaran_id:daftarid}, function(data) {
                if (data.sukses == 1) {
                    myAlert(data.msg);
                    window.location.replace('<?php echo $this->createUrl('index', array('pendaftaran_id'=>$model->pendaftaran_id)); ?>');
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}

function printEws(ewspasien_id, pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('print'); ?>&ewspasien_id='+ewspasien_id+'&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=1000,height=1122,scrollbars=yes');
}

    $(document).ready(function(){
        choiseEws();
        $('#choise_news').find('#tblchoise_news').find('input[class*="float2"]').maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":2}
        );
$('#choise_news').find('#tblchoise_news').find('input[class*="integer2"]').maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
        );
    });
</script>

