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
    echo $this->renderPartial('application.views.headerReport.headerDefault');
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
     * fungsi pencarian Rujukan RS BPJS FKTL
     */
    function cariDataRujukanBpjsFktl() {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var norujukan = '<?php echo $_GET['norujukan']; ?>';
        var nokartu = '<?php echo $_GET['nokartu']; ?>';
        var tglrujukan = '<?php echo $_GET['tglrujukan']; ?>';

        if (norujukan != '') {
            var isi = norujukan;
            var aksi = 4; // 1 untuk mencari data rujukan rs berdasarkan Nomor Rujukan
            var alert = 'Isi data Nomor Rujukan terlebih dahulu!';
        } else if (nokartu != '') {
            var isi = nokartu;
            var aksi = 5; // 2 untuk mencari data rujukan rs berdasarkan Nomor Kartu Peserta
            var alert = 'Isi data Nomor Kartu Peserta terlebih dahulu!';
        } else {
            var isi = tglrujukan;
            var aksi = 6; // 3 untuk mencari data rujukan rs berdasarkan Tanggal Rujukan
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
                $('#data-fktl').addClass("animation-loading");
            },
            success: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktl').removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var rujukan = obj.response.rujukan;
                    if (obj.metaData.code == '201') {
                        myAlert(obj.metaData.message);
                    } else {
                        //Data Rujukan
                        $("#tglKunjungan").text(rujukan.tglKunjungan);
                        $("#noKunjungan").text(rujukan.noKunjungan);
                        $("#kdPoli").text(rujukan.poliRujukan.kode);
                        $("#nmPoli").text(rujukan.poliRujukan.nama);
                        $("#keluhan").text(rujukan.peserta.keluhan);
                        $("#nmDiag").text(rujukan.diagnosa.kode + '-' + rujukan.diagnosa.nama);
                        //					$("#pemFisikLain").text(peserta.pemFisikLain);
                        $("#catatan").text(rujukan.keluhan);
                        //End Data Rujukan
                        //Data Peserta
                        $("#noKartu").text(rujukan.peserta.noKartu);
                        $("#nama").text(rujukan.peserta.nama);
                        $("#tglLahir").text(rujukan.peserta.tglLahir);
                        $("#nik").text(rujukan.peserta.nik);
                        if (rujukan.peserta.sex == "P") {
                            $("#sex").text("Perempuan");
                        } else {
                            $("#sex").text("Laki-laki");
                        }
                        $("#kdProvider").text(rujukan.peserta.provUmum.kdProvider);
                        $("#nmProvider").text(rujukan.peserta.provUmum.nmProvider);
                        $("#kdCabang").text(rujukan.peserta.provUmum.kdProvider);
                        $("#nmCabang").text(rujukan.peserta.provUmum.nmProvider);
                        $("#kdKelas").text(rujukan.peserta.hakKelas.kode);
                        $("#nmKelas").text(rujukan.peserta.hakKelas.keterangan);
                        $("#kdJenisPeserta").text(rujukan.peserta.jenisPeserta.kode);
                        $("#nmJenisPeserta").text(rujukan.peserta.jenisPeserta.keterangan);
                        $("#keterangan").text(rujukan.peserta.statusPeserta.keterangan);
                        $("#tglCetakKartu").text(rujukan.peserta.tglCetakKartu);
                        $("#tglTAT").text(rujukan.peserta.tglTAT);
                        $("#tglTMT").text(rujukan.peserta.tglTMT);
                        $("#noMr").text(rujukan.peserta.noMr);
                        $("#umurSekarang").text(rujukan.peserta.umur.umurSekarang);
                        $("#umurSaatPelayanan").text(rujukan.peserta.umur.umurSaatPelayanan);
                        //End Data Peserta
                        // OVERWRITES old selecor
                        jQuery.expr[':'].contains = function(a, i, m) {
                            return jQuery(a).text().toUpperCase()
                                .indexOf(m[3].toUpperCase()) >= 0;
                        };
                        //			}else{
                        //				if(obj.metaData.message == null){
                        //					myAlert('Data Not Found');
                        //				}else{
                        //					myAlert(obj.metaData.message);
                        //				}
                    }
                }
            },
            error: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                $('#data-fktl').removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }


    $(document).ready(function() {
        cariDataRujukanBpjsFktl();
    });
</script>