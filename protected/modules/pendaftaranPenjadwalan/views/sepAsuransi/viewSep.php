<?php
$this->breadcrumbs = array(
    'Assep Ts' => array('index'),
    $model->sep_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat Surat Eligibilitas Peserta <b>(SEP)</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span4">
            <table class="table table-striped table-condensed detail-view">
                <tbody>
                    <tr>
                        <th>Nomor Kartu Peserta</th>
                        <td id="noKartu"></td>
                    </tr>
                    <tr>
                        <th>Nama Peserta</th>
                        <td id="nama"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td id="tglLahir"></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td id="nik"></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td id="sex"></td>
                    </tr>
                    <tr>
                        <th>Kode Provider</th>
                        <td id="kdProvider"></td>
                    </tr>
                    <tr>
                        <th>Provider</th>
                        <td id="nmProvider"></td>
                    </tr>
                    <tr>
                        <th>Kode Cabang</th>
                        <td id="kdCabang"></td>
                    </tr>
                    <tr>
                        <th>Nama Cabang</th>
                        <td id="nmCabang"></td>
                    </tr>
                    <tr>
                        <th>Kode Kelas Tanggungan</th>
                        <td id="kdKelas"></td>
                    </tr>
                    <tr>
                        <th>Kelas Tanggungan</th>
                        <td id="nmKelas"></td>
                    </tr>
                    <tr>
                        <th>Kode Jenis Peserta</th>
                        <td id="kdJenisPeserta"></td>
                    </tr>
                    <tr>
                        <th>Jenis Peserta</th>
                        <td id="nmJenisPeserta"></td>
                    </tr>
                    <tr>
                        <th>Status Peserta</th>
                        <td id="statusPeserta"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="span4">
            <table class="table table-striped table-condensed detail-view">
                <tbody>
                    <tr>
                        <th>Tanggal Cetak Kartu</th>
                        <td id="tglCetakKartu"></td>
                    </tr>
                    <tr>
                        <th>Tanggal TAT</th>
                        <td id="tglTAT"></td>
                    </tr>
                    <tr>
                        <th>Tanggal TMT</th>
                        <td id="tglTMT"></td>
                    </tr>
                    <tr>
                        <th>Nomor Rekam Medik</th>
                        <td id="noMr"></td>
                    </tr>
                    <tr>
                        <th>Umur Sekarang</th>
                        <td id="umur"></td>
                    </tr>
                    <tr>
                        <th>Umur Saat Pelayanan</th>
                        <td id="umurSaatPelayanan"></td>
                    </tr>
                    <tr>
                        <th>No. SEP</th>
                        <td id="noSep"></td>
                    </tr>
                    <tr>
                        <th>Diagnosa Awal</th>
                        <td id="nmDiag"></td>
                    </tr>
                    <tr>
                        <th>Jenis Pelayanan</th>
                        <td id="jnsPelayanan"></td>
                    </tr>
                    <tr>
                        <th>Kelas Pelayanan</th>
                        <td id="nmKelas"></td>
                    </tr>
                    <tr>
                        <th>No. Rujukan</th>
                        <td id="noRujukan"></td>
                    </tr>
                    <tr>
                        <th>Pisa</th>
                        <td id="pisa"></td>
                    </tr>
                    <tr>
                        <th>Status SEP</th>
                        <td id="nmStatSep"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="span4">
            <table class="table table-striped table-condensed detail-view">
                <tbody>
                    <tr>
                        <th>Status COB</th>
                        <td id="namaCOB"></td>
                    </tr>
                    <tr>
                        <th>Keterangan Laka Lantas</th>
                        <td id="keterangan"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pulang</th>
                        <td id="tglPulang"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Rujukan</th>
                        <td id="tglRujukan"></td>
                    </tr>
                    <tr>
                        <th>Tanggal SEP</th>
                        <td id="tglSep"></td>
                    </tr>
                    <tr>
                        <th>Kode Cabang Pelayanan</th>
                        <td id="kdCabangPel"></td>
                    </tr>
                    <tr>
                        <th>Kode Provider Pelayanan</th>
                        <td id="kdProviderPel"></td>
                    </tr>
                    <tr>
                        <th>Nama Cabang Pelayanan</th>
                        <td id="nmCabangPel"></td>
                    </tr>
                    <tr>
                        <th>Nama Provider Pelayanan</th>
                        <td id="nmProviderPel"></td>
                    </tr>
                    <tr>
                        <th>Kode Cabang Rujukan</th>
                        <td id="kdCabangRujuk"></td>
                    </tr>
                    <tr>
                        <th>Kode Provider Rujukan</th>
                        <td id="kdProviderRujuk"></td>
                    </tr>
                    <tr>
                        <th>Nama Cabang Rujukan</th>
                        <td id="nmCabangRujuk"></td>
                    </tr>
                    <tr>
                        <th>Nama Provider Rujukan</th>
                        <td id="nmProviderRujuk"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan SEP', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    /**
     * fungsi menampilkan data Peserta BPJS berdasarkan No. SEP
     */
    function tampilDetailSEP() {
        var nosep = '<?php echo isset($model->nosep) ? $model->nosep : null; ?>';
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        var isi = nosep;
        var aksi = 11; // 11 untuk menampilkan detail SEP
        if (isi == "") {
            myAlert('Isi data Nomor Kartu Peserta terlebih dahulu!');
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&nosep=' + isi,
            beforeSend: function() {
                $("#data-peserta").addClass("animation-loading");
            },
            success: function(data) {
                $("#data-peserta").removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var peserta = obj.response;
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
                    $("#statusPeserta").text(peserta.statusPeserta);
                    $("#tglCetakKartu").text(peserta.tglCetakKartu);
                    $("#tglTAT").text(peserta.tglTAT);
                    $("#tglTMT").text(peserta.tglTMT);
                    $("#noMr").text(peserta.noMr);
                    $("#umur").text(peserta.umur);
                    //				RND-9239 $("#umurSaatPelayanan").text(peserta.umur.umurSaatPelayanan);
                    //				Data SEP
                    $("#noSep").text(peserta.noSep);
                    $("#nmDiag").text(peserta.diagAwal.kdDiag + ' - ' + peserta.diagAwal.nmDiag);
                    $("#jnsPelayanan").text(peserta.jnsPelayanan);
                    $("#nmKelas").text(peserta.klsRawat.kdKelas + ' - ' + peserta.klsRawat.nmKelas);
                    $("#noRujukan").text(peserta.noRujukan);
                    $("#pisa").text(peserta.pisa);
                    $("#nmStatSep").text(peserta.statSep.kdStatSep + ' - ' + peserta.statSep.nmStatSep);
                    $("#namaCOB").text(peserta.statusCOB.kodeCOB + ' - ' + peserta.statusCOB.namaCOB);
                    $("#tglPulang").text(peserta.tglPulang);
                    $("#tglRujukan").text(peserta.tglRujukan);
                    $("#tglSep").text(peserta.tglSep);
                    $("#keterangan").text(peserta.lakaLantas.keterangan);
                    $("#kdProviderPel").text(peserta.provPelayanan.kdProvider);
                    $("#nmProviderPel").text(peserta.provPelayanan.nmProvider);
                    $("#kdCabangPel").text(peserta.provPelayanan.kdCabang);
                    $("#nmCabangPel").text(peserta.provPelayanan.nmCabang);
                    $("#kdProviderRujuk").text(peserta.provRujukan.kdProvider);
                    $("#nmProviderRujuk").text(peserta.provRujukan.nmProvider);
                    $("#kdCabangRujuk").text(peserta.provRujukan.kdCabang);
                    $("#nmCabangRujuk").text(peserta.provRujukan.nmCabang);
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
    tampilDetailSEP();
</script>