<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php 
    
    // var_dump($mBuktBayar->attributes); die;
	$mBuktBayar->tgl_awal = MyFormatter::formatDateTimeForDb($mBuktBayar->tgl_awal);
	$mBuktBayar->tgl_akhir = MyFormatter::formatDateTimeForDb($mBuktBayar->tgl_akhir);

	$mBuktiKeluar->tgl_awal = MyFormatter::formatDateTimeForDb($mBuktiKeluar->tgl_awal);
	$mBuktiKeluar->tgl_akhir = MyFormatter::formatDateTimeForDb($mBuktiKeluar->tgl_akhir);

    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = false;
    $dataProvider = $mBuktBayar->searchTable();
    $dataProvider->sort->defaultOrder = 't.tglbuktibayar';

    $dataProviderKeluar = $mBuktiKeluar->searchTableUntukClosing();
    $dataProviderKeluar->sort->defaultOrder = 't.tglkaskeluar';

    $template = "{summary}\n{items}\n{pager}";
?>
<table id="tblBayarTind" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Pilih<br>
                <?php 
                    echo CHtml::checkBox('checkPembayaran',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                    'class'=>'checkbox-column','onclick'=>'checkAllPembayaran(this)','checked'=>'checked'))
                ?>
            </th>
            <th>No.</th>
            <th>Loket</th>
            <th>Tanggal Pembayaran</th>
            <th>No. Pembayaran</th>
            <th>Jenis Pembayaran</th>
            <th>Dari Nama</th>
            <th>Penjamin</th>
            <th hidden>Cara Pembayaran</th>
            <th hidden>Sebagai Pembayaran</th>
            <th>Piutang<br>(Rp)</th>
            <th>Pemakaian<br>Uang Muka<br>(Rp)</th>
            <th>Tunai<br>(Rp)</th>
            <th>Non-Tunai<br>(Rp)</th>
            <th>Retur Obat<br>(Rp)</th>
            <th>Retur Tindakan<br/>(Rp)</th>
            <th>Jumlah<br>Pembayaran<br>(Rp)</th>
            <!--th>Biaya Administrasi</th>
            <th>Biaya Meterai</th-->            
        </tr>
    </thead>
    <tbody>
    <?php

    $row_data = array();

    $i=0;
    
    if (count((array)$dataProvider->getData()) > 0)
    {
        
        
        $cr_retur = new CDbCriteria();
        $cr_retur->select = "sum(t.totaloaretur) as totaloaretur, sum(t.totaltindakanretur) as totaltindakanretur";
        $cr_retur->addCondition("t.tandabuktibayar_id = :id");
        
        foreach($dataProvider->getData() as $data)
        {
            // var_dump($data);die;
            $retur = 0;
            $no_bayar = null;
            $tgl_bayar = null;
            $total_bayar = 0;
            $total_nontunai = 0;
            $total_biaya = 0;
            $penjamin_bayar = 0;
            $bayar = PembayaranpelayananT::model()->findByPk($data->pembayaranpelayanan_id);
            $batal = PembatalanuangmukaT::model()->findByPk($data->pembatalanuangmuka_id);
            // var_dump($batal);die;
            $uangmuka = null;
            $bulat = $data->jmlpembulatan;
            $modJenispembayaran = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$data->tandabuktibayar_id));

            $jnspembayar = "";
            $total_debit = 0;
            $total_kredit = 0;

            if(!empty($modJenispembayaran)){
               foreach($modJenispembayaran as $idx => $jns){
                if($idx > 0){
                    $jnspembayar .= ", ";  
                }

                $jnspembayar .= (!empty($jns->jnspembayar)? $jns->jnspembayar->jnspembayar_nama :"");

                if($jns->jnspembayar_id == 1){
                    $total_kredit += $jns->jumlahpembayaran;
                }
                if($jns->jnspembayar_id == 2){
                    $total_debit += $jns->jumlahpembayaran;
                }
               } 
            }


            // var_dump(empty($bayar)); die;
            $retur = 0;
            $retur_tindakan = 0;
            if (!empty($bayar)) {
                
                //if ($data->uangditerima == 0) {
                //    continue;
                //}
                
                $no_bayar = $bayar->nopembayaran;
                $tgl_bayar = $bayar->tglpembayaran;
                $total_bayar = $data->uangditerima - $data->uangkembalian;// - $bulat;
                $total_nontunai = $data->bank_nominal;
                $total_biaya = $bayar->totalbiayapelayanan;
                $penjamin_bayar = $bayar->penjamin_id;
                
                $cr_retur->params = array(
                    ":id"=>$data->tandabuktibayar_id
                );
                
                $data_retur = ReturbayarpelayananT::model()->findAll($cr_retur);

                $retur = 0;
                $retur_tindakan = 0;

                /*
                foreach ($data_retur as $item_retur) {
                    // var_dump($item_retur->attributes);
                    $retur += $item_retur->totaloaretur;
                    $retur_tindakan += $item_retur->totaltindakanretur;
                }*/

                // var_dump($retur, $retur_tindakan);

                
                /*
                $pakai = PemakaianuangmukaT::model()->findAllByAttributes(array(
                    'pembayaranpelayanan_id'=>$bayar->pembayaranpelayanan_id,
                ));
                
                foreach ($pakai as $item) {
                    // $total_bayar -= $item->pemakaianuangmuka;
                }
                 * 
                 */
            } else { 
                $uangmuka = BayaruangmukaT::model()->findByAttributes(array(
                    'tandabuktibayar_id'=>$data->tandabuktibayar_id
                ));
                if (empty($uangmuka)) continue;
                
                $pemakaian = PemakaianuangmukaT::model()->findAllByAttributes(array(
                    'bayaruangmuka_id'=>$uangmuka->bayaruangmuka_id
                ));
                
//                foreach ($pemakaian as $items) {
//                    $uangmuka->jumlahuangmuka -= $items->pemakaianuangmuka;
//                }
//                
//                if ($uangmuka->jumlahuangmuka <= 0) continue;
                
                
                if (!empty($uangmuka->pasienadmisi_id))
                    $moddat = PasienadmisiT::model()->findByPk($uangmuka->pasienadmisi_id);
                else
                    $moddat = PendaftaranT::model()->findByPk($uangmuka->pendaftaran_id);
                
                // var_dump($uangmuka->attributes);
                
                if (!empty($uangmuka)) {
                    $no_bayar = $uangmuka->nouangmuka;
                }
                $total_biaya = $uangmuka->tgluangmuka;
                $total_bayar =$uangmuka->jumlahuangmuka - $data->bank_nominal;// - $bulat;
                $total_nontunai = $data->bank_nominal;
                $penjamin_bayar = $moddat->penjamin_id;
            }

            $tgl_bayar = empty($tgl_bayar) ? $data->tglbuktibayar : $tgl_bayar;

            $row_data[$i] = $this->renderPartial("_rowBayar", array(
                'data'=>$data, 'i' => $i, 'total_bayar'=>$total_bayar, 'jnspembayar'=>$jnspembayar,
                'total_nontunai'=>$total_nontunai, 'retur'=>0, 'retur_tindakan'=>0, 'total_kredit'=>$total_kredit,
                'total_debit'=>$total_debit, 'tgl_bayar'=>$tgl_bayar, 'no_bayar'=>$no_bayar, 'bayar'=>$bayar,
                'penjamin_bayar'=>$penjamin_bayar,
            ), true);

    ?>
        
    <?php
            $i++;
        }
    }

    // bukti keluar
    $data_keluar = $dataProviderKeluar->getData();
    foreach ($data_keluar as $data) {

        $retur = ReturbayarpelayananT::model()->findByPk($data->returbayarpelayanan_id);

        if (!empty($retur)) {
            $tgl_bayar = $retur->tglreturpelayanan;
            $no_bayar = $retur->noreturbayar;
        } else {
            continue;
        }

        
        $row_data[strtotime($data->tglkaskeluar)] = $this->renderPartial("_rowKeluar", array(
            'data'=>$data, 'i' => $i, 'retur'=>$retur->totaloaretur, 'retur_tindakan'=>$retur->totaltindakanretur,
            'tgl_bayar'=>$tgl_bayar, 'no_bayar'=>$no_bayar
        ), true);
        $i++;
        
    }

    // ksort($row_data);

    foreach ($row_data as $item) {
        echo $item;
    } 



    // else{
    //    echo('<tr><td align="center" colspan="14">Data tidak ditemukan.</td></tr>');
    // }
    ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('.currency_tbl').each(
            function(){
                $(this).text(formatThousandDecimal(parseFloat($(this).text())));
                $(this).attr('style', 'text-align:right');
            }
        );

        hitungTotalSetoran();
    });
    
        
    // setTimeout(
    //     function(){
    //         hitungTransaksi();
    //     }, 1000
    // );

    function cekInputTindakan(){
        $('.currency').each(function(){this.value = parseFloat(unformatNumber(this.value))});
        $('.currency').each(function(){this.value = parseFloat(unformatNumber(this.value))});
        $('.integer').each(function(){this.value = parseFloat(unformatNumber(this.value))});
        
        var closingsaldoawal = parseFloat(unformatNumber($('#BKClosingkasirT_closingsaldoawal').val()));
        if(parseInt(closingsaldoawal) > 0)
        {
            var totalsetoran = parseFloat(unformatNumber($('#BKClosingkasirT_totalsetoran').val()));
            if(parseInt(totalsetoran) > 0)
            {
                var total_recehan = parseFloat(unformatNumber($('#total_recehan').val()));
                if(total_recehan != totalsetoran)
                {
                    myAlert("Total setoran dengan total recehan berbeda, silakan cek kembali!");
                    $('#BKClosingkasirT_totalsetoran').focus();
                    return false;
                }else{
                    //requiredCheck($("#formClosing"));
                }
            }else{
                myAlert("Total setoran tidak boleh kosong!");
                $('#BKClosingkasirT_totalsetoran').focus();
                return false;                
            }
        }else{
            $('#BKClosingkasirT_closingsaldoawal').focus();
            myAlert("Saldo awal tidak boleh kosong!");
            return false;
        }
    }
    
    function hitungTransaksi() {
    unformatNumberSemua();
        var jumTrans = 0, totPembayaran=0, jumPelayanan=0, totPembayaranTunai=0, jumDeposit=0, totAdministrasi = 0, jumTunai = 0;
        var jmlPiutang = 0;
        var totaliurbiaya = 0;
        var total_nontunai = 0;
        var totRetur = 0;
        var totReturTindakan = 0;
        var totPakaiUangMuka = 0;
        var totKeluarUmum = $("#BKClosingkasirT_totalpengeluaran").val();

        var totKredit = 0;
        var totDebit = 0;
        
        $('#tblBayarTind tbody').find('tr').each(
            function(){
                if($(this).find('input[type="checkbox"]').is(':checked')){
                    jumTrans++;
                    var jmlpiutang = parseFloat(unformatNumber($(this).find(".piutang").text()));
                    var jmlpembayaran = parseFloat(unformatNumber($(this).find('.jmlpembayaran').text()));
                    var jmlAdministrasi = 0; //unformatNumber($(this).find('.jmlAdministrasi').text());
                    var jmlNonTunai = parseFloat(unformatNumber($(this).find('.jml_nontunai').text()));
                    var jmlRetur = parseFloat(unformatNumber($(this).find(".jml_retur").text()));
                    var jmlReturTindakan = parseFloat(unformatNumber($(this).find(".jml_retur_tindakan").text()));
                    var jmlTunaiRow = parseFloat(unformatNumber($(this).find(".jml_tunai").text()));
                    var jmlPakaiUangMuka = parseFloat(unformatNumber($(this).find(".jml_uangmuka").text()));

                    var jmlKredit = parseFloat(unformatNumber($(this).find(".jml_kredit").text()));
                    var jmlDebit = parseFloat(unformatNumber($(this).find(".jml_debit").text()));
                    
                    totPakaiUangMuka += jmlPakaiUangMuka;
                    totRetur += jmlRetur;
                    totReturTindakan += jmlReturTindakan;
                    
                    jumTunai += jmlTunaiRow;
                    total_nontunai += parseFloat(jmlNonTunai);
                    totAdministrasi += parseFloat(jmlAdministrasi);
                    totPembayaran += parseFloat(jmlpembayaran);
                    jmlPiutang += parseFloat(jmlpiutang);
                    totKredit += jmlKredit;
                    totDebit += jmlDebit;

                    var nobuktibayar = $(this).find('.nobuktibayar').text();
                    $(this).find('input[name*="nobuktibayar"]').val(nobuktibayar);
                    
                    var is_pelayanan = $(this).find('input[name*="is_pelayanan"]').val();
                    if(is_pelayanan != 'xxx'){
                        jumPelayanan += parseFloat(jmlpembayaran);
                    }
                    
                    var is_deposit = $(this).find('input[name*="is_deposit"]').val();
                    if(is_deposit != 'xxx'){
                        console.log(jmlpembayaran);
                        jumDeposit += parseFloat(jmlpembayaran);
                    }
                    
                    var is_tunai = $(this).find('input[name*="is_tunai"]').val();
                    if(is_tunai == 'TUNAI' || is_tunai == 'CICILAN' || is_tunai == 'HUTANG')
                    {
//                        jumTunai += parseFloat(jmlpembayaran - jmlpiutang);
//                        jmlPiutang += parseFloat(jmlpiutang);
                    } else if (is_tunai == 'PIUTANG') {
                        
                        totaliurbiaya = $(this).find('input[name*="totaliurbiaya"]').val();
//                        jumTunai += parseFloat(totaliurbiaya);
//                        jmlPiutang += parseFloat(jmlpembayaran - totaliurbiaya);
                    }
                    
                    
                    var carapembayaran = $(this).find('.carapembayaran').text();
                    if(carapembayaran == 'TUNAI' || carapembayaran == 'CICILAN' || is_tunai == 'HUTANG')
                    {
                        totPembayaranTunai += parseFloat(jmlpembayaran);
                    }
                }else{
                    $(this).find('input[name*="nobuktibayar"]').removeAttr("value");
                }
            }
        );

        // console.log(jumPelayanan, jumDeposit);
            
        console.log("TUNAI", jumTunai, jumPelayanan, jumDeposit);    
            
        $("#BKClosingkasirT_jmltransaksi").val(jumTrans);
        $("#BKClosingkasirT_terimauangpelayanan").val(jumPelayanan + jumDeposit + totRetur);
        $("#BKClosingkasirT_terimauangmuka").val(jumDeposit);
        $("#BKClosingkasirT_piutang").val(jmlPiutang);
        $("#BKClosingkasirT_jumlahnontunai").val(total_nontunai);
        $("#BKClosingkasirT_jumlahreturoa").val(totRetur);
        $("#BKClosingkasirT_jumlah_returtagihan").val(totReturTindakan);
        $("#BKClosingkasirT_pemakaianuangmuka").val(totPakaiUangMuka);
        $("#BKClosingkasirT_jumlahkredit").val(totKredit);
        $("#BKClosingkasirT_jumlahdebit").val(totDebit);
        
        //console.log(jmlPiutang);
        
        var terimauangmuka = jumDeposit;
        var jum_penerimaan_umum = $("#jum_penerimaan_umum").val();
        var jum_pengeluaran_umum = $("#jum_pengeluaran_umum").val();
        var jum_penerimaan_tunai = parseFloat(jumPelayanan) + parseFloat(terimauangmuka);// + parseInt(jum_penerimaan_umum);
        var jum_tutup_kasir = parseFloat(jumTunai) + parseFloat(total_nontunai) - (parseFloat(totRetur) + parseFloat(totReturTindakan) + parseFloat(totPakaiUangMuka) + parseFloat(totKeluarUmum));
        
//        if(parseInt(jum_pengeluaran_umum) > 0)
//        {
//            jum_tutup_kasir = parseInt(jumTunai) + parseInt(totAdministrasi) - parseInt(jum_pengeluaran_umum);
//        }
        
        
//        $("#jum_penerimaan_tunai").val(parseInt(jumTunai - total_nontunai + totRetur));
        
        $("#BKClosingkasirT_jumlahtunai").val(jumTunai);
        
        $("#BKClosingkasirT_nilaiclosingtrans").val(jum_tutup_kasir);
        $("#BKClosingkasirT_totalsetoran").val(0);
        // $("#BKClosingkasirT_piutang").val(0);
        $("#BKSetorbankT_jumlahsetoran").val(jum_tutup_kasir);
        
        $('.currency').each(
            function(){
                this.value = formatInteger(this.value)
            }
        );

        formatNumberSemua();    
        
        hitungTotalSetoran();
    }
    

    function checkAllPembayaran()
    {
        //hasan arofi. melakukan improvemnt pada proses checklist all
        if ($("#checkPembayaran").is(":checked")) {
            $('.cekcheckbox').prop('checked', true);
            // $('.cekcheckbox').attr('checked','checked');
            // $('#tblBayarTind input[name*="pilih"]').each(function(){
            //    $(this).attr('checked',true);
            // });
        } else {
            $('.cekcheckbox').prop('checked', false);
        //    $('#tblBayarTind input[name*="pilih"]').each(function(){
        //        $(this).removeAttr('checked');
        //     });
        }
        hitungTransaksi();
    }
    
    function hitungPiutang(param)
    {
        var terimauangpelayanan = unformatNumber($("#BKClosingkasirT_terimauangpelayanan").val());
        var terimauangmuka = unformatNumber($("#BKClosingkasirT_terimauangmuka").val());
        var jum_penerimaan_umum = unformatNumber($("#jum_penerimaan_umum").val());
        var jum_pengeluaran_umum = unformatNumber($("#jum_pengeluaran_umum").val());
        var total = parseInt(terimauangpelayanan) + parseInt(terimauangmuka);
        if(parseInt(jum_pengeluaran_umum) > 0)
        {
            total = total - jum_pengeluaran_umum;
        }
//        $("#jum_penerimaan_tunai").val(formatInteger(total));
        $("#BKClosingkasirT_jumlahtunai").val(formatInteger(total));
        
        
        /* SEMENTARA DI NON AKTIFKAN DULU SEBELUM ADA KONFIRMASI ALUR YG BENAR DARI RS
         * 
         * 
        var totalClosing = unformatNumber($("#BKClosingkasirT_nilaiclosingtrans").val());
        var uangMuka = unformatNumber($(param).val());
        var totPiutang = 0;
        if(uangMuka > 0)
        {
            if(totalClosing > 0)
            {
                totPiutang = totalClosing - uangMuka;
            }else{
                myAlert('Biaya masing kosong, silakan cek kembali!');
                $(param).val(0);
            }            
            totPiutang = totalClosing - uangMuka;
        }
        $("#BKClosingkasirT_piutang").val(formatInteger(totPiutang));
        */
    }

    // tambah fungsi Total Setoran = Total Tutup Kasir + Saldo Awal
    function hitungTotalSetoran(){
    unformatNumberSemua();
        var clossaldoawal = parseFloat($('#BKClosingkasirT_closingsaldoawal').val());
        var totClosing = parseFloat($("#BKClosingkasirT_nilaiclosingtrans").val());
        if (parseFloat(totClosing) > 0){
        var totsetoran = parseFloat(clossaldoawal) + parseFloat(totClosing);
        $("#BKClosingkasirT_totalsetoran").val(totsetoran);
        }
    formatNumberSemua();
    }
    
    function hitungRecehan()
    {
       var total = 0, tot_receh=0,tot_lembar=0;
       $('#div_recehan input[name*="jum_recehan"]').each(function(){
           var xxx = $(this).attr('recehan_val');
           var xx = unformatNumber($(this).val());
           total += (xxx * xx);
           
           var is_receh = $(this).attr('is_receh');
           if(is_receh == 1 && xx != 0){
               tot_receh += xx;
           }else if(is_receh == 0 && xx != 0){
               tot_lembar += xx;
           }
        })
        $('#BKClosingkasirT_jmluanglogam').val(tot_receh);
        $('#BKClosingkasirT_jmluangkertas').val(tot_lembar);
        $('#total_recehan').val(formatInteger(total));
    }
    
    function setorBankEnable(params)
    {
        if ($(params).is(":checked")){
            $('#setor_bank').slideDown();
        } else {
            $('#setor_bank').slideUp();
        }
        
    }
     
    $(document).ready(function(){
                hitungTransaksi();
    })
/**
 * menampilkan form verifikasi
 * @returns {undefined}
 */
/*
function setVerifikasi(){
    if(requiredCheck($("form"))){
        var jum_penerimaan_umum=$("#jum_penerimaan_umum").val();
        if(jum_penerimaan_umum === ""){
            myAlert("Silakan cari data informasi pembayaran terlabih dahulu!");
        }else{
            $('#dialog-verifikasi').dialog("open");
            $.ajax({
               type:'POST',
               url:'<?php echo $this->createUrl('verifikasi'); ?>',
               data: $("form").serialize(),
               dataType: "json",
               success:function(data){
                    $('#dialog-verifikasi > .dialog-content').html(data.content);
               },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
            });
            //untuk verifikasi hilangkan srbac loading
        
            $(".animation-loading").removeClass("animation-loading");
            $("form").find('.float').each(function(){
                $(this).val(formatFloat($(this).val()));
            });
            $("form").find('.integer').each(function(){
                $(this).val(formatInteger($(this).val()));
            });
        }
    }
    return false;
}
*/
</script>