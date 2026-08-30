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

        <td style="font-weight: bold;">Status Peserta</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="keterangan"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Nama Peserta</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="nama"></td>

        <td style="font-weight: bold;">Tanggal Cetak Kartu</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="tglCetakKartu"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Tanggal Lahir</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="tglLahir"></td>

        <td style="font-weight: bold;">Tanggal TAT</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="tglTAT"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">NIK</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="nik"></td>

        <td style="font-weight: bold;">Tanggal TMT</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="tglTMT"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Jenis Kelamin</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="sex"></td>

        <td style="font-weight: bold;">Nomor Rekam Medik</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="noMr"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Kode Provider</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="kdProvider"></td>

        <td style="font-weight: bold;">Umur Sekarang</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="umurSekarang"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Provider</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="nmProvider"></td>

        <td style="font-weight: bold;">Umur Saat Pelayanan</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="umurSaatPelayanan"></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Kode Cabang</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="kdCabang"></td>

        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Nama Cabang</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="nmCabang"></td>

        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Kode Kelas Tanggungan</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="kdKelas"></td>

        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Kelas Tanggungan</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="nmKelas"></td>

        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Kode Jenis Peserta</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="kdJenisPeserta"></td>

        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Jenis Peserta</td>
        <td style="font-weight: bold;text-align:center;">:</td>
        <td id="nmJenisPeserta"></td>

        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
<script type="text/javascript">
    /**
     * fungsi pencarian peserta BPJS berdasarkan No. Kartu
     */
    function cariPesertaBpjsNoKartu() {
        var nokartu = '<?php echo $_GET['nokartu']; ?>';
        var nonik = '<?php echo $_GET['nonik']; ?>';
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        if (nokartu != '') {
            var isi = nokartu;
            var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu Peserta
        } else {
            var isi = nonik;
            var aksi = 2; // 2 untuk mencari data peserta berdasarkan NIK
        }
        if (isi == "") {
            myAlert('Isi data Nomor Kartu Peserta / Nomor Induk Kependudukan terlebih dahulu!');
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#data-peserta").addClass("animation-loading");
            },
            success: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var peserta = obj.response.peserta;
                    $("#noKartu").text(peserta.noKartu);
                    $("#nama").text(peserta.nama);
                    $("#tglLahir").text(peserta.tglLahir);
                    $("#nik").text(peserta.nik);
                    if (peserta.sex == "P") {
                        $("#sex").text("Perempuan");
                    } else {
                        $("#sex").text("Laki-laki");
                    }
                    $("#kdProvider").text(peserta.provUmum.kdProvider);
                    $("#nmProvider").text(peserta.provUmum.nmProvider);
                    $("#kdCabang").text(peserta.provUmum.kdCabang);
                    $("#nmCabang").text(peserta.provUmum.nmCabang);
                    //				$("#kdKelas").text(peserta.kelasTanggungan.kdKelas);
                    //				$("#nmKelas").text(peserta.kelasTanggungan.nmKelas);
                    $("#kdKelas").text(peserta.hakKelas.kode);
                    $("#nmKelas").text(peserta.hakKelas.keterangan);
                    $("#kdJenisPeserta").text(peserta.jenisPeserta.kdJenisPeserta);
                    $("#nmJenisPeserta").text(peserta.jenisPeserta.nmJenisPeserta);
                    //				RND-9239 $("#keterangan").text(peserta.statusPeserta.keterangan);
                    $("#keterangan").text(peserta.statusPeserta.keterangan);
                    $("#tglCetakKartu").text(peserta.tglCetakKartu);
                    $("#tglTAT").text(peserta.tglTAT);
                    $("#tglTMT").text(peserta.tglTMT);
                    $("#noMr").text(peserta.noMr);
                    //				RND-9239 $("#umurSekarang").text(peserta.umur.umurSekarang);
                    //				RND-9239 $("#umurSaatPelayanan").text(peserta.umur.umurSaatPelayanan);
                    $("#umurSekarang").text(peserta.umur.umurSekarang);
                    $("#umurSaatPelayanan").text(peserta.umur.umurSaatPelayanan);
                    // OVERWRITES old selecor
                    jQuery.expr[':'].contains = function(a, i, m) {
                        return jQuery(a).text().toUpperCase()
                            .indexOf(m[3].toUpperCase()) >= 0;
                    };
                } else {
                    myAlert(obj.metaData.message);
                }
            },
            error: function(data) {
                $("#data-peserta").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }
    /**
     * fungsi pencarian peserta BPJS berdasarkan NIK
     */
    function cariPesertaBpjsNIK() {
        var nokartu = '<?php echo $_GET['nokartu']; ?>';
        var nonik = '<?php echo $_GET['nonik']; ?>';
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        if (nokartu != '') {
            var isi = nokartu;
            var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu Peserta
        } else {
            var isi = nonik;
            var aksi = 2; // 2 untuk mencari data peserta berdasarkan NIK
        }
        if (isi == "") {
            myAlert('Isi data Nomor Kartu Peserta terlebih dahulu!');
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#data-peserta").addClass("animation-loading");
            },
            success: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                var obj = JSON.parse(data);
                //			if(obj.response.list[0]!=null){ //RND-13321
                //				var list = obj.response.list[0]; //RND-13321
                if (obj.response != null) {
                    var peserta = obj.response.peserta;
                    $("#noKartu").text(peserta.noKartu);
                    $("#nama").text(peserta.nama);
                    $("#tglLahir").text(peserta.tglLahir);
                    $("#nik").text(peserta.nik);
                    if (peserta.sex == "P") {
                        $("#sex").text("Perempuan");
                    } else {
                        $("#sex").text("Laki-laki");
                    }
                    $("#kdProvider").text(peserta.provUmum.kdProvider);
                    $("#nmProvider").text(peserta.provUmum.nmProvider);
                    $("#kdCabang").text(peserta.provUmum.kdCabang);
                    $("#nmCabang").text(peserta.provUmum.nmCabang);
                    //				$("#kdKelas").text(peserta.kelasTanggungan.kdKelas);
                    //				$("#nmKelas").text(peserta.kelasTanggungan.nmKelas);
                    $("#kdKelas").text(peserta.hakKelas.kode);
                    $("#nmKelas").text(peserta.hakKelas.keterangan);
                    $("#kdJenisPeserta").text(peserta.jenisPeserta.kdJenisPeserta);
                    $("#nmJenisPeserta").text(peserta.jenisPeserta.nmJenisPeserta);
                    //RND-9239 $("#keterangan").text(peserta.statusPeserta.keterangan);
                    $("#keterangan").text(peserta.statusPeserta.keterangan);
                    $("#tglCetakKartu").text(peserta.tglCetakKartu);
                    $("#tglTAT").text(peserta.tglTAT);
                    $("#tglTMT").text(peserta.tglTMT);
                    $("#noMr").text(peserta.noMr);
                    //RND-9239 $("#umurSekarang").text(peserta.umur.umurSekarang);
                    //RND-9239 $("#umurSaatPelayanan").text(peserta.umur.umurSaatPelayanan);
                    $("#umurSekarang").text(peserta.umur.umurSekarang);
                    $("#umurSaatPelayanan").text(peserta.umur.umurSaatPelayanan);
                    // OVERWRITES old selecor
                    jQuery.expr[':'].contains = function(a, i, m) {
                        return jQuery(a).text().toUpperCase()
                            .indexOf(m[3].toUpperCase()) >= 0;
                    };
                } else {
                    //              myAlert(obj.metaData.message);
                    myAlert('Data Not Found');
                }
            },
            error: function(data) {
                $("#data-peserta").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }
    $(document).ready(function() {
        var nokartu = '<?php echo $_GET['nokartu']; ?>';
        var nonik = '<?php echo $_GET['nonik']; ?>';
        if (nokartu != '') {
            cariPesertaBpjsNoKartu();
        } else {
            cariPesertaBpjsNIK();
        }
    });
</script>