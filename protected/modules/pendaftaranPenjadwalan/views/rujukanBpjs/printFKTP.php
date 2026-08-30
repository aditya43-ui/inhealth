<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judul_print . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])) {
    echo $this->renderPartial($this->path_view . '_headerPrint');
}
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valign="middle" colspan="3">
            <b><?php echo $judul_print ?></b>
        </td>
    </tr>
</table><br />
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="data-peserta">
    <tr>
        <td style="font-weight: bold;">Nomor Kartu Peserta</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="noKartu"></td>

        <td style="font-weight: bold;">Keluhan</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="keluhan"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Nama Peserta</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="nama"></td>

        <td style="font-weight: bold;">Diagnosa</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="nmDiag"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Tanggal Lahir</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="tglLahir"></td>

        <td style="font-weight: bold;">Pemeriksaan Fisik</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="pemFisikLain"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Tanggal Kunjungan</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="tglKunjungan"></td>

        <td style="font-weight: bold;">Catatan</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="catatan"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">No. Kunjungan</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="noKunjungan"></td>

        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Kode Poli</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="kdPoli"></td>

        <td style="font-weight: bold;">Nama Poli</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="nmPOli"></td>
    </tr>
</table>
<script type="text/javascript">
    /**
     * fungsi pencarian Rujukan BPJS FKTP
     */
    function cariDataRujukanBpjsFktp() {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var norujukan = '<?php echo $_GET['nomorrujukan']; ?>';
        var nokartu = '<?php echo $_GET['nomorkartu']; ?>';
        var tglrujukan = '<?php echo $_GET['tglrujukan']; ?>';


        if (norujukan != '') {
            var isi = norujukan;
            var aksi = 1; // 1 untuk mencari data rujukan berdasarkan Nomor Rujukan
            var alert = 'Isi data Nomor Rujukan terlebih dahulu!';
        } else if (nokartu != '') {
            var isi = nokartu;
            var aksi = 2; // 2 untuk mencari data rujukan berdasarkan Nomor Kartu Peserta
            var alert = 'Isi data Nomor Kartu Peserta terlebih dahulu!';
        } else {
            var isi = tglrujukan;
            var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Tanggal Rujukan
            var alert = 'Isi data Tanggal Rujukan terlebih dahulu!';
        }

        if (isi == "") {
            myAlert(alert);
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#data-peserta").addClass("animation-loading");
                $('#data-fktp').addClass("animation-loading");
            },
            success: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktp').removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var peserta = obj.response.peserta;
                    //Data Rujukan
                    $("#tglKunjungan").text(peserta.tglKunjungan);
                    $("#noKunjungan").text(peserta.noKunjungan);
                    $("#kdPoli").text(peserta.poliRujukan.kdPoli);
                    $("#nmPoli").text(peserta.poliRujukan.nmPoli);
                    $("#keluhan").text(peserta.keluhan);
                    $("#nmDiag").text(peserta.diagnosa.kdDiag + '-' + peserta.diagnosa.nmDiag);
                    $("#pemFisikLain").text(peserta.pemFisikLain);
                    $("#catatan").text(peserta.catatan);
                    //End Data Rujukan
                    //Data Peserta
                    $("#noKartu").text(peserta.noKartu);
                    $("#nama").text(peserta.nama);
                    $("#tglLahir").text(peserta.tglLahir);
                    $("#nik").text(peserta.nik);
                    $("#sex").text(peserta.sex);
                    $("#kdProvider").text(peserta.provUmum.kdProvider);
                    $("#nmProvider").text(peserta.provUmum.nmProvider);
                    $("#kdCabang").text(peserta.provUmum.kdCabang);
                    $("#nmCabang").text(peserta.provUmum.nmCabang);
                    $("#kdKelas").text(peserta.kelasTanggungan.kdKelas);
                    $("#nmKelas").text(peserta.kelasTanggungan.nmKelas);
                    $("#kdJenisPeserta").text(peserta.jenisPeserta.kdJenisPeserta);
                    $("#nmJenisPeserta").text(peserta.jenisPeserta.nmJenisPeserta);
                    //RND-9239 $("#keterangan").text(peserta.statusPeserta.keterangan);
                    $("#tglCetakKartu").text(peserta.tglCetakKartu);
                    $("#tglTAT").text(peserta.tglTAT);
                    $("#tglTMT").text(peserta.tglTMT);
                    $("#noMr").text(peserta.noMr);
                    //RND-9239 $("#umurSekarang").text(peserta.umur.umurSekarang);
                    //RND-9239 $("#umurSaatPelayanan").text(peserta.umur.umurSaatPelayanan);
                    //End Data Peserta
                    // OVERWRITES old selecor
                    jQuery.expr[':'].contains = function(a, i, m) {
                        return jQuery(a).text().toUpperCase()
                            .indexOf(m[3].toUpperCase()) >= 0;
                    };
                } else {
                    if (obj.metaData.message == null) {
                        myAlert('Data Not Found');
                    } else {
                        myAlert(obj.metaData.message);
                    }
                }
            },
            error: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktp').removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    $(document).ready(function() {
        cariDataRujukanBpjsFktp();
    });
</script>