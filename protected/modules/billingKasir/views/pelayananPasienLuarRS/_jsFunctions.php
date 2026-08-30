<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); 

$konfig = KonfigsystemK::model()->find();
$daftar = DaftartindakanM::model()->findByPk($konfig->tindakanluarrs);
$dfId = !empty($daftar)?$daftar->daftartindakan_id:null;
$dfNama = !empty($daftar)?$daftar->daftartindakan_nama:null;
?>

<script type="text/javascript">

const setNo = (obj) => {                        
    $("#no_row").val($(obj).parents(".trparent").attr("row-data"));
}

const setCeklisDarah = (obj) => {
    const cek = $(obj).prop("checked");
    const formtr = $(obj).parents("tr");
    
    formtr.find("#tindakanluar_nama").val("");
    formtr.find(".daftartindakan_id").val("");
    formtr.find(".daftartindakan_nama").val("");    
    formtr.find(".form-tindakan-luar").addClass('hide');
    formtr.find(".form-tindakan-luar").find("textarea").addClass('required');
    formtr.find(".form-tindakan").addClass('hide').find(".add-on").hide();
    formtr.find(".form-tindakan").addClass('hide').find("input[name*='[daftartindakan_nama]']").removeClass('required').attr("readonly", true);
    $("#kelompoktindakan_id").val("");
    if (cek){
        formtr.find(".form-tindakan").removeClass('hide');
        formtr.find(".form-tindakan-luar").find("textarea").removeClass('required');
        formtr.find(".daftartindakan_id").val("<?= $dfId ?>");
        formtr.find(".daftartindakan_nama").addClass('required').val("<?= $dfNama ?>");    
    }else{        
        formtr.find(".form-tindakan-luar").removeClass('hide');
    }
}

const seTindakanRS = (obj) => {
    const cek = $(obj).prop("checked");
    const formtr = $(obj).parents("tr");
    const daftarLuarId = '<?= $konfig->tindakanluarrs ?>';    
    
    formtr.find(".form-tindakan").find(".add-on").hide();
    formtr.find(".form-tindakan").find("input[name*='[daftartindakan_nama]']").addClass('required').attr("readonly", true);
    $("#kelompoktindakan_id").val("");
    if (cek){
        formtr.find(".form-tindakan").find(".add-on").show();
        formtr.find(".form-tindakan").find("input[name*='[daftartindakan_nama]']").removeAttr("readonly");
        formtr.find(".daftartindakan_id").val("");
        formtr.find(".daftartindakan_nama").val("");    
        $("#kelompoktindakan_id").val("<?= ParamsConst::KELOMPOKTINDAKAN_ID_PEL_BANK_DARAH ?>");
    }else{
        formtr.find(".daftartindakan_id").val("<?= $dfId ?>");
        formtr.find(".daftartindakan_nama").val("<?= $dfNama ?>");    
    }
}

function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id ){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
            $("#cari_pendaftaran_id").val(data.pendaftaran_id);
            // $("#instalasi_id").val(data.instalasi_id);
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasien_id").val(data.pasien_id);
            $("#pasienadmisi_id").val(data.pasienadmisi_id);
            $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            $("#penanggungjawab_id").val(data.penanggungjawab_id);
            $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
            if(data.ruangan_id)
                $("#ruangan_id").val(data.ruangan_id);
            else
                $("#ruangan_id").val(data.ruanganakhir_id);
            $("#no_pendaftaran").val(data.no_pendaftaran);
            $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
            $("#ruangan_nama").val(data.ruangan_nama);
            $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
            $("#carabayar_nama").val(data.carabayar_nama);
            $("#penjamin_nama").val(data.penjamin_nama);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.namadepan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#nama_bin").val(data.nama_bin);
            $("#tanggal_lahir").val(data.tanggal_lahir);
            $("#umur").val(data.umur);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#nama_pj").val(data.nama_pj);
            $("#pengantar").val(data.pengantar);
            $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
            $("#alamat_pasien").val(data.alamat_pasien);
            $("#kelastanggungan_nama").val(data.kelastanggungan_nama);
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan!"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#cari_pendaftaran_id").focus();
        }
    });

}
/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#cari_pendaftaran_id").val("");
    $("#pendaftaran_id").val("");
    $("#pasien_id").val("");
    $("#pasienadmisi_id").val("");
    $("#jeniskasuspenyakit_id").val("");
    $("#carabayar_id").val("");
    $("#penjamin_id").val("");
    $("#penanggungjawab_id").val("");
    $("#kelaspelayanan_id").val("");
    $("#ruangan_id").val("");
    $("#no_pendaftaran").val("");
    $("#tgl_pendaftaran").val("");
    $("#ruangan_nama").val("");
    $("#jeniskasuspenyakit_nama").val("");
    $("#carabayar_nama").val("");
    $("#penjamin_nama").val("");
    $("#no_rekam_medik").val("");
    $("#namadepan").val("");
    $("#nama_pasien").val("");
    $("#nama_bin").val("");
    $("#tanggal_lahir").val("");
    $("#umur").val("");
    $("#jeniskelamin").val("");
    $("#nama_pj").val("");
    $("#pengantar").val("");
    $("#kelaspelayanan_nama").val("");
    $("#kelastanggungan_nama").val("");
    $("#alamat_pasien").val("");
}

/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogKunjungan(){
    var instalasi_id = $("#instalasi_id").val();
    var instalasi_nama = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
            "BKInformasikasirrawatjalanV[instalasi_id]":instalasi_id,
            "BKInformasikasirrawatjalanV[instalasi_nama]":instalasi_nama,
        }
    });
}

function resetPencarianRuangan() {
    $("#dialog_pasien_ruangan_id").val("");
}

function tambahkantindakan(){
    var html = new String(<?php echo CJSON::encode($this->renderPartial('_rowTindakan', array(), true)); ?>);
    $('#tbl_tindakan').append(html.replace());

    generateRowTindakan($('#tbl_tindakan'));
    hitungTotal();

}

function hapusTindakan(obj){
    if($(obj).parents('.tblchild').length > 0){
        var trparent = $(obj).parents('.trparent');
        var index_child = $(obj).parents('.trcld').attr('idx');
        
        $(obj).parents('.trcld').detach();
        $(trparent).find('.tblchild_tarif').find('#trcld_tarif'+index_child).detach();
        $(trparent).find('.tblchild_diskon').find('#trcld_diskon'+index_child).detach();
        $(trparent).find('.tblchild_total').find('#trcld_total'+index_child).detach();
        
        if($(trparent).find('.tblchild').find('tr').length == 0){
            $(trparent).next('tr').detach();
            $(trparent).detach();

            if($('#tbl_tindakan').find('.trparent').length == 0){
                tambahkantindakan();
            }else{
                generateRowTindakan($('#tbl_tindakan'));
                hitungTotal();
            }
        }else{
            generateRowTindakan($('#tbl_tindakan'));
            hitungTotal();
        }
    }else{
        $(obj).parents('.trparent').next('tr').detach();
        $(obj).parents('.trparent').detach();
        if($('#tbl_tindakan').find('.trparent').length == 0){
            tambahkantindakan();
        }else{
            generateRowTindakan($('#tbl_tindakan'));
            hitungTotal();
        }
    }
}

function generateRowTindakan(obj){

    for(var i=0; i<$(obj).find('.tgl_tindakan').length; i++){
        var tr = $(obj).find('.tgl_tindakan').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_tgl_tindakan');
        tr.attr('name','TindakanpelayananT['+i+'][tgl_tindakan]');
        tr.datetimepicker(
                            jQuery.extend(
                                {
                                    showMonthAfterYear:false
                                }, 
                                jQuery.datepicker.regional['id'],
                                {
                                   'dateFormat':'dd M yy',
                                    'minDate':'d',
                                    'timeText':'Waktu',
                                    'hourText':'Jam',
                                    'minuteText':'Menit',
                                    'secondText':'Detik',
                                    'showSecond':true,
                                    'timeOnlyTitle':'Pilih Waktu',
                                    'timeFormat':'hh:mm:ss',
                                    'changeYear':true,
                                    'changeMonth':true,
                                    'showAnim':'fold',
                                    'yearRange':'-80y:+20y'
                                }
                            )
                        );
        
        tr.each(function() {
            var obj = $(this);
            $(this).parent().find(".add-on").click(function() {
                $(obj).focus();
            });
        });
    }

    for(var i=0; i<$(obj).find('.tindakanluar_nama').length; i++){
        var tr = $(obj).find('.tindakanluar_nama').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_tindakanluar_nama');
        tr.attr('name','TindakanpelayananT['+i+'][tindakanluar_nama]');
    }

    for(var i=0; i<$(obj).find('.qty_tindakan').length; i++){
        var tr = $(obj).find('.qty_tindakan').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_qty_tindakan');
        tr.attr('name','TindakanpelayananT['+i+'][qty_tindakan]');
    }

    for(var i=0; i<$(obj).find('.dokterpemeriksa1_id').length; i++){
        var tr = $(obj).find('.dokterpemeriksa1_id').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_dokterpemeriksa1_id');
        tr.attr('name','TindakanpelayananT['+i+'][dokterpemeriksa1_id]');
    }

    for(var i=0; i<$(obj).find('.dokterpemeriksa1_nama').length; i++){
        var tr = $(obj).find('.dokterpemeriksa1_nama').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_dokterpemeriksa1_nama');
        tr.attr('name','TindakanpelayananT['+i+'][dokterpemeriksa1_nama]');
    }

    for(var i=0; i<$(obj).find('.dokterpemeriksa2_id').length; i++){
        var tr = $(obj).find('.dokterpemeriksa2_id').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_dokterpemeriksa2_id');
        tr.attr('name','TindakanpelayananT['+i+'][dokterpemeriksa2_id]');
    }

    for(var i=0; i<$(obj).find('.dokterpemeriksa2_nama').length; i++){
        var tr = $(obj).find('.dokterpemeriksa2_nama').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_dokterpemeriksa2_nama');
        tr.attr('name','TindakanpelayananT['+i+'][dokterpemeriksa2_nama]');
    }

    for(var i=0; i<$(obj).find('.discount_tindakan').length; i++){
        var tr = $(obj).find('.discount_tindakan').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_discount_tindakan');
        tr.attr('name','TindakanpelayananT['+i+'][discount_tindakan]');
    }

    for(var i=0; i<$(obj).find('.tarif_satuan').length; i++){
        var tr = $(obj).find('.tarif_satuan').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_tarif_satuan');
        tr.attr('name','TindakanpelayananT['+i+'][tarif_satuan]');
    }
    
    for(var i=0; i<$(obj).find('.tariftindakan').length; i++){
        var tr = $(obj).find('.tariftindakan').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_tariftindakan');
        tr.attr('name','TindakanpelayananT['+i+'][tariftindakan]');
    }
    
    for(var i=0; i<$(obj).find('.daftartindakan_nama').length; i++){
        var tr = $(obj).find('.daftartindakan_nama').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_daftartindakan_nama');
        tr.attr('name','TindakanpelayananT['+i+'][daftartindakan_nama]');
    }
    
    for(var i=0; i<$(obj).find('.daftartindakan_id').length; i++){
        var tr = $(obj).find('.daftartindakan_id').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_daftartindakan_id');
        tr.attr('name','TindakanpelayananT['+i+'][daftartindakan_id]');
    }
    
    for(var i=0; i<$(obj).find('.tariftindakan').length; i++){
        var tr = $(obj).find('.tariftindakan').eq(i);
        tr.attr('id','TindakanpelayananT_'+i+'_tariftindakan');
        tr.attr('name','TindakanpelayananT['+i+'][tariftindakan]');
    }
    
    
    
    for(var i=0; i<$(obj).find('.trparent').length; i++){
        var tr = $(obj).find('.trparent').eq(i);
        tr.attr('id','trparent'+i);
        tr.attr('idxparent',i);
        
        for(var j=0; j<tr.find('.tblchild').find('.trcld').length; j++){
            var trc = tr.find('.tblchild').find('.trcld').eq(j);
            trc.attr('id','trcld'+i+'_'+j);
            trc.attr('idx',i+'_'+j);
            trc.attr('idxchild',j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_komp = tr.find('.tblchild').find('.komponen_id').eq(j);
            trc_komp.attr('id','TindakankomponenT_'+i+'_'+j+'_komponen_id');
            trc_komp.attr('name','TindakankomponenT['+i+']['+j+'][komponen_id]');
        }

        for(var j=0; j<tr.find('.tblchild_tarif').find('.trcld_tarif').length; j++){
            var trc = tr.find('.tblchild_tarif').find('.trcld_tarif').eq(j);
            trc.attr('id','trcld_tarif'+i+'_'+j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }

            var tr_tarif = tr.find('.tblchild_tarif').find('.tarif_kompsatuan').eq(j);
            tr_tarif.attr('id','TindakankomponenT_'+i+'_'+j+'_tarif_kompsatuan');
            tr_tarif.attr('name','TindakankomponenT['+i+']['+j+'][tarif_kompsatuan]');
        }

        for(var j=0; j<tr.find('.tblchild_diskon').find('.trcld_diskon').length; j++){
            var trc = tr.find('.tblchild_diskon').find('.trcld_diskon').eq(j);
            trc.attr('id','trcld_diskon'+i+'_'+j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_diskon = tr.find('.tblchild_diskon').find('.discountkomptindakan').eq(j);
            trc_diskon.attr('id','TindakankomponenT_'+i+'_'+j+'_discountkomptindakan');
            trc_diskon.attr('name','TindakankomponenT['+i+']['+j+'][discountkomptindakan]');
        }

        for(var j=0; j<tr.find('.tblchild_total').find('.trcld_total').length; j++){
            var trc = tr.find('.tblchild_total').find('.trcld_total').eq(j);
            trc.attr('id','trcld_total'+i+'_'+j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_total = tr.find('.tblchild_total').find('.tarif_tindakankomp').eq(j);
            trc_total.attr('id','TindakankomponenT_'+i+'_'+j+'_tarif_tindakankomp');
            trc_total.attr('name','TindakankomponenT['+i+']['+j+'][tarif_tindakankomp]');
        }
        
    }
    
    var row = 0;
    $("#tbl_tindakan > tr.trparent").each(function(){
       $(this).attr('row-data',row);
       
       row++;
    });
    
    $("#tbl_tindakan > tr.trparent").find("input[name*='[daftartindakan_nama]']").autocomplete({                                           
        'showAnim': 'fold',
        'minLength': 3,
        'focus': function (event, ui)
        {
            $(this).val(ui.item.label);
            return false;
        },
        'select': function (event, ui)
        {

            setTindakan(ui.item, this);
            return false;
        },
        'source': function (request, response)
        {
            $.ajax({
                url: "<?= $this->createUrl('/actionAutoComplete/daftarTindakan') ?>",
                dataType: "json",
                data: {
                    term: request.term,    
                    kelompoktindakan_id: $("#kelompoktindakan_id").val()
                },
                success: function (data) {
                    response(data);
                }
            });
        }
    });

}

function tambahkomp(obj){
    var html = new String(<?php echo CJSON::encode($this->renderPartial('_rowKomponen', array('typeinput'=>'namakomponen'), true)); ?>);
    var html_tarif = new String(<?php echo CJSON::encode($this->renderPartial('_rowKomponen', array('typeinput'=>'tarifkomponen'), true)); ?>);
    var html_diskon = new String(<?php echo CJSON::encode($this->renderPartial('_rowKomponen', array('typeinput'=>'diskonkomponen'), true)); ?>);
    var html_total = new String(<?php echo CJSON::encode($this->renderPartial('_rowKomponen', array('typeinput'=>'totalkomponen'), true)); ?>);

    if($(obj).parents('.tblchild').length == 0){
        $(obj).find('.tblchild').append(html.replace());
        $(obj).find('.tblchild_tarif').append(html_tarif.replace());
        $(obj).find('.tblchild_diskon').append(html_diskon.replace());
        $(obj).find('.tblchild_total').append(html_total.replace());
    }else{
        $(obj).parents('.trparent').find('.tblchild').append(html.replace());
        $(obj).parents('.trparent').find('.tblchild_tarif').append(html_tarif.replace());
        $(obj).parents('.trparent').find('.tblchild_diskon').append(html_diskon.replace());
        $(obj).parents('.trparent').find('.tblchild_total').append(html_total.replace());
    }
    
    generateRowTindakan($('#tbl_tindakan'));
    hitungTotal();
}


function setDialogDokter1(obj){
    var parent = $(obj).parents(".input-append").find("input").attr("id");
    var dialog = "#dialogDokter1";
    
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");
}

function setDokter1Auto(pegawai_id, pegawai_nama){
    var is_ada_pegawai = false;
    var dialog_pegawai = "#dialogDokter1";
    var parent_pegawai = $(dialog_pegawai).attr("parent-dialog");
    var obj_pegawai = $("#"+parent_pegawai);

    if($(obj_pegawai).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa2_id]"]').val() != ''){
        if($(obj_pegawai).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa2_id]"]').val() == pegawai_id){
            is_ada_pegawai = true;
        }
    }
    
    if (is_ada_pegawai) {
        myAlert("Dokter Pemeriksaan 1 Sudah ada di Dokter Pemeriksaan 2 silahkan pilih yang lain.");
        return false;
    }
    
    $(obj_pegawai).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa1_id]"]').val(pegawai_id);
    $(obj_pegawai).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa1_nama]"]').val(pegawai_nama);
    $(dialog_pegawai).dialog("close");
}

function setDokter1(obj,item)
{
    $(obj).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa1_id]"]').val(item.pegawai_id);
    $(obj).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa1_id]"]').val(item.namaLengkap);
}

function setDialogDokter2(obj){
    var parent = $(obj).parents(".input-append").find("input").attr("id");
    var dialog = "#dialogDokter2";
    
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");
}

function setDokter2Auto(pegawai_id, pegawai_nama){
    var is_ada_pegawai = false;
    var dialog_pegawai = "#dialogDokter2";
    var parent_pegawai = $(dialog_pegawai).attr("parent-dialog");
    var obj_pegawai = $("#"+parent_pegawai);
    
    if($(obj_pegawai).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa1_id]"]').val() != ''){
        if($(obj_pegawai).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa1_id]"]').val() == pegawai_id){
            is_ada_pegawai = true;
        }
    }
    
    if (is_ada_pegawai) {
        myAlert("Dokter Pemeriksaan 2 Sudah ada di Dokter Pemeriksaan 1 silahkan pilih yang lain.");
        return false;
    }

    $(obj_pegawai).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa2_id]"]').val(pegawai_id);
    $(obj_pegawai).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa2_nama]"]').val(pegawai_nama);
    $(dialog_pegawai).dialog("close");
}

function setDokter2(obj,item)
{
    $(obj).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa2_id]"]').val(item.pegawai_id);
    $(obj).parents('.trpemeriksaan').find('input[name$="[dokterpemeriksa2_id]"]').val(item.namaLengkap);
}

function hitungTotal(){
    unformatNumberSemua();
    var totalAll = 0;
    
    $('#tbl_tindakan').find('.trparent').each(function(){
        var idxParent = $(this).attr('idxparent');
        var totaltarif = 0;
        var totalsatuan = 0;
        var totaldiskon = 0;
        var qty  = parseInt($(this).find('input[name$="['+idxParent+'][qty_tindakan]"]').val());
        
        $('#tbl_tindakan').find('.trparent').eq(idxParent).find('.tblchild').find('.trcld').each(function(){
            var idxchild = $(this).attr('idxchild');
            var tarifkomp = parseFloat($('#tbl_tindakan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][tarif_kompsatuan]"]').val());
            var discountkomp = parseFloat($('#tbl_tindakan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][discountkomptindakan]"]').val());


            var jmltarif = ((qty * tarifkomp) - discountkomp);
            if (jmltarif > 0){
                jmltarif = parseFloat(jmltarif.toFixed(2));
            }

            $('#tbl_tindakan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][tarif_tindakankomp]"]').val(jmltarif);
            totaltarif += jmltarif;
            totalsatuan += tarifkomp;
            totaldiskon += discountkomp;

        });
        $('#tbl_tindakan').find('.trpemeriksaan').eq(idxParent).find('input[name$="['+idxParent+'][tarif_satuan]"]').val(totalsatuan);
        $('#tbl_tindakan').find('.trpemeriksaan').eq(idxParent).find('input[name$="['+idxParent+'][tariftindakan]"]').val(totaltarif);
        $('#tbl_tindakan').find('.trpemeriksaan').eq(idxParent).find('input[name$="['+idxParent+'][discount_tindakan]"]').val(totaldiskon);
        totalAll += totaltarif;
    });
    $('#totaltarifkeseluruhan').val(totalAll);    
    formatNumberSemua();
}

function simpanTindakan(){
    if(requiredCheck($("form"))){
        var cekkosong = 0;
        for(var i=0; i<$('#tbl_tindakan').find('.trparent').length; i++){
            var tr = $('#tbl_tindakan').find('.trparent').eq(i);
            var chekchild = 0;

            for(var j=0; j<tr.find('.tblchild_total').find('.trcld_total').length; j++){
                var trc = tr.find('.tblchild_total').find('.trcld_total').eq(j);
                unformatNumberSemua();
                var total  = parseFloat(trc.find('input[name$="['+i+']['+j+'][tarif_tindakankomp]"]').val());
                
                trc.find('input[name$="['+i+']['+j+'][tarif_tindakankomp]"]').removeClass('redError');
                if(total == 0){
                    chekchild += 1;
                    trc.find('input[name$="['+i+']['+j+'][tarif_tindakankomp]"]').addClass('redError');
                }else{
                    if(chekchild > 1){
                        chekchild -= 1;
                    }
                }
                formatNumberSemua();
            }

            if(chekchild > 0){
                cekkosong += 1;
            }else{
                if(cekkosong > 1){
                    cekkosong -= 1;
                }
            }
        }
        
        if(cekkosong > 0){
            myAlert("Total Tarif Komponen tidak boleh kurang dari sama dengan 0");
            return false;
        }
        $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
        });
        $('#pelayananpasienluarrs-form').submit();
        
    }
    return false;
}

function print()
{
    var pendaftaran_id = "<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>";
    var instalasi_id = "<?php echo isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null; ?>";
    var pasienadmisi_id = "<?php echo isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null; ?>";
    var kodetindakanluar = "<?php echo isset($_GET['kodetindakanluar']) ? $_GET['kodetindakanluar'] : null; ?>";

    window.open("<?php echo $this->createUrl('print') ?>&pendaftaran_id=" + pendaftaran_id+"&instalasi_id=" + instalasi_id+"&pasienadmisi_id=" + pasienadmisi_id+"&kodetindakanluar=" + kodetindakanluar + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
}

$(document).ready(function () {
    tambahkantindakan();
});

/**
 * set form info pasien
 * @returns {undefined}
 */
function setInfoPasien(no_rekam_medik, pasien_id){
    $("#form-infopasien > div").addClass("animation-loading");
    var instalasi_id = $("#instalasi_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataInfoPasien'); ?>',
        data: {no_rekam_medik:no_rekam_medik, pasien_id:pasien_id},
        dataType: "json",
        success:function(data){
            $("#<?php echo CHtml::activeId($modPasien,'pasien_id'); ?>").val(data.pasien_id);
            $("#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>").val(data.jenisidentitas);
            $("#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>").val(data.no_identitas_pasien);
            $("#<?php echo CHtml::activeId($modPasien,'namadepan'); ?>").val(data.nama_depan);
            $("#<?php echo CHtml::activeId($modPasien,'nama_pasien'); ?>").val(data.nama_pasien);
            $("#<?php echo CHtml::activeId($modPasien,'nama_bin'); ?>").val(data.nama_bin);
            $("#<?php echo CHtml::activeId($modPasien,'tempat_lahir'); ?>").val(data.tempat_lahir);
            $("#<?php echo CHtml::activeId($modPasien,'tanggal_lahir'); ?>").val(data.tanggal_lahir);
            $("#<?php echo CHtml::activeId($modPasien,'kelompokumur_id'); ?>").val(data.kelompokumur_id);
            $("#<?php echo CHtml::activeId($modPasien,'jeniskelamin'); ?>").val(data.jeniskelamin);
            $("#<?php echo CHtml::activeId($modPasien,'alamat_pasien'); ?>").val(data.alamat_pasien);

            $("#form-infopasien .tombol").attr('style','display:true;');

            $("#form-infopasien div").removeClass("animation-loading");
            setUmur(data.tanggal_lahir);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            myAlert("Data kunjungan tidak ditemukan !");
            console.log(errorThrown);
            setInfoPasienReset();
            $("#form-infopasien > div").removeClass("animation-loading");
            $("#instalasi_id").focus();
        }
    });
}
/*
 * reset form info pasien
 * @returns {undefined}
 */
function setInfoPasienReset(){
    $("#<?php echo CHtml::activeId($modPasien,'pasien_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'namadepan'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'nama_pasien'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'nama_bin'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'tempat_lahir'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'tanggal_lahir'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'kelompokumur_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'jeniskelamin'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'alamat_pasien'); ?>").val("");
    $("#noPasienApotek").val("");
    $("#umur").val("");

    $("#form-infopasien .tombol").attr('style','display:none;');
}

/**
 * set nilai umur dari tanggal_lahir
 * @param {type} tanggal_lahir
 * @returns {undefined} */
function setUmur(tanggal_lahir)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetUmur'); ?>',
       data: {tanggal_lahir : tanggal_lahir},//
       dataType: "json",
       success:function(data){
           $("#umur").val(data.umur);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * untuk set value jenis kelamin
 * @returns {undefined}
 */
function setJenisKelaminPasien(jeniskelamin)
{
    $('input[name="FAPasienM[jeniskelamin]"]').each(function(){
            if(this.value == jeniskelamin)
                $(this).attr('checked',true);
        }
    );
}

</script>
