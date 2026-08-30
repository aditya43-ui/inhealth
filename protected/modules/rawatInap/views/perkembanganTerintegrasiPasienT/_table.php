<table class="items table table-bordered table-striped datatable" id="tblListKonsul">
    <thead>
        <tr>
            <th>No. Pendaftaran</th>
            <th>Tgl. Pemeriksaan</th>
            <th>Nama Pegawai</th>
            <th>Profesi</th>
            <th>Lihat</th>
            <th>Edit</th>
            <th>Hapus</th>
            <th>Salin</th>
            <th>Cetak</th>
        </tr>
    </thead>
    <tbody> 
        <?php $no = 1; ?>
        <?php
        $module = $this->module->id;

        $daftar_id = "";
        if (isset($_GET['pendaftaran_id'])) {
            $daftar_id = $_GET['pendaftaran_id'];
        } else if (isset($_GET['id'])) {
            $daftar_id = $_GET['id'];
        } else if (isset($_POST['id'])) {
            $daftar_id = $_POST['id'];
        }

//                echo '<pre>';        var_dump($_POST); die();
//        $daftar_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : $_GET['id'];
        $modIntegrasi = PerkembanganTerintegrasiPasienT::model()->findAll("pendaftaran_id = $daftar_id");

        if (!empty($modIntegrasi)) {

            foreach ($modIntegrasi as $i => $intg) {

                $daftar_id = $intg->pendaftaran_id;
//                $modTampilAsesmenDetail = AsesmenRencanaKeperawatanDetT::model()->findByAttributes(array('asesmen_rencana_keperawatan_id' => $modAsesmen->asesmen_rencana_keperawatan_id));
                ?>
                <tr>
                    <td><?php
                        $modDaftar = PendaftaranT::model()->findByPk($daftar_id);
                        echo $modDaftar->no_pendaftaran;
                        $modPenj = PasienmasukpenunjangT::model()->find("pendaftaran_id = $daftar_id");
                        ?></td>
                    <td><?php echo MyFormatter::formatDateTimeId($intg->tgltransaksi); ?></td>
                    <td><?php
                        $modPeg = PegawaiM::model()->findByPk($intg->pegawai_id);
                        echo!empty($modPeg) ? $modPeg->namaLengkap : "";
                        ?> </td>
                    <td><?php echo $intg->profesi; ?></td>
                    <td><?php echo CHtml::link("<i class='icon icon-eye-open'></i>", '#', array('onclick' => 'viewDetail("' . $intg->perkembangan_terintegrasi_pasien_id . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemantauan')); ?></td>
                    <td><?php echo CHtml::link("<i class='icon icon-pencil'></i>", '#', array('onclick' => 'ubahDetail("' . $intg->perkembangan_terintegrasi_pasien_id . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemantauan')); ?></td>

                    <td>
            <center><a onclick="hapusRiwayat('<?php echo $intg->perkembangan_terintegrasi_pasien_id; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Riwayat Asesmen Awal Dialisis"><i class="entypo-trash"></i></a></center>
        </td>
        <td>
        <center><?=
            CHtml::Link("<span style='font-size:17px'><i class='fa fa-clipboard'></i></span>", 'javascript:void(0)', array("onclick" => "salinRiwayat(" . $intg->perkembangan_terintegrasi_pasien_id . "); return false; ",
                "data-placement" => "left",
                "rel" => "tooltip",
                "title" => "Klik untuk salin data pasien",
            ));
            ?></center>
        </td>
        <td>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-print"></i>')), 'javascript:void(0);', array('class' => '',
                'onclick' => "print($intg->perkembangan_terintegrasi_pasien_id);return false")) . "&nbsp;";
            ?>
        </td>

        <script>


            function hapusRiwayat(id) {
                var url = '<?= Yii::app()->createUrl('paliatifBebasNyeri/perkembanganTerintegrasiPasienTPBN/hapusRiwayat') ?>';
                //        console.log(url);return false;
                myConfirm('Apakah anda yakin menghapus data ini ?', 'Perhatian!', function (r) {
                    if (r) {
                        $.ajax({
                            url: url,
                            dataType: 'json',
                            type: 'post',
                            data: {id: id},
                            success: function (data) {
                                if (data.sukses == 1) {
                                    toastr.success(data.pesan, "Perhatian!");
                                    //                            location.href = '<?php //echo $this->createUrl('index&pendaftaran_id=')               ?>'+pendaftaran_id;
                                    window.location.reload();
                                } else {
                                    toastr.error(data.pesan, "Perhatian!");
                                }
                            }
                        })
                    }
                })
            }


            function viewDetail(id) {

                $('#integrasi-pasien-t-form').addClass('animation-loading');

                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('ajaxDetailPerkembangan'); ?>',
                    data: {id: id},
                    dataType: "json",
                    success: function (data) {

                        $('#btn_simpan').attr('disabled', true);
                        $('#RIPerkembanganTerintegrasiPasienT_tgltransaksi').val(data.tgltransaksi);
                        $('#RIPerkembanganTerintegrasiPasienT_pegawai_id').val(data.pegawai_id);
                        $('#RIPerkembanganTerintegrasiPasienT_nama_pegawai').val(data.nama_pegawai);
                        $('#RIPerkembanganTerintegrasiPasienT_profesi').val(data.profesi);
                        $("#<?php echo CHtml::activeId($model, 'subyektif') ?>").val(data.subyektif);
                        $("#<?php echo CHtml::activeId($model, 'perkembangan_terintegrasi_pasien_id') ?>").val(data.perkembangan_terintegrasi_pasien_id);
                        $("#<?php echo CHtml::activeId($model, 'obyektif') ?>").val(data.obyektif);
                        $("#<?php echo CHtml::activeId($model, 'asesmen') ?>").val(data.asesmen);
                        $("#<?php echo CHtml::activeId($model, 'perencanaan') ?>").val(data.perencanaan);
                        $("#<?php echo CHtml::activeId($model, 'instruksi') ?>").val(data.instruksi);
                        $("#<?php echo CHtml::activeId($model, 'proses') ?>").val("lihat");
                        //                        $("#sub > .redactor_box > .redactor_frame").find("p").html("testset");
                        $("#integrasi-pasien-t-form").find('input,select,textarea').attr('readonly', true);
                        $("#btn_simpan").attr('disabled', true);

                        $('#integrasi-pasien-t-form').removeClass("animation-loading");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        myAlert("Data Perkembangan Terintegrasi Pasien Tidak Ditemukan!");
                        console.log(errorThrown);
                        $('#integrasi-pasien-t-form').removeClass("animation-loading");
                    }
                });

            }

            function ubahDetail(id) {

                $('#integrasi-pasien-t-form').addClass('animation-loading');

                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('ajaxUbahPerkembangan'); ?>',
                    data: {id: id},
                    dataType: "json",
                    success: function (data) {

                        $('#btn_simpan').attr('disabled', false);

                        $('#RIPerkembanganTerintegrasiPasienT_tgltransaksi').val(data.tgltransaksi);
                        $('#RIPerkembanganTerintegrasiPasienT_pegawai_id').val(data.pegawai_id);
                        $('#RIPerkembanganTerintegrasiPasienT_nama_pegawai').val(data.nama_pegawai);
                        $('#RIPerkembanganTerintegrasiPasienT_profesi').val(data.profesi);
                        $("#<?php echo CHtml::activeId($model, 'perkembangan_terintegrasi_pasien_id') ?>").val(data.perkembangan_terintegrasi_pasien_id);
                        $("#<?php echo CHtml::activeId($model, 'subyektif') ?>").val(data.subyektif);
                        $("#<?php echo CHtml::activeId($model, 'obyektif') ?>").val(data.obyektif);
                        $("#<?php echo CHtml::activeId($model, 'asesmen') ?>").val(data.asesmen);
                        $("#<?php echo CHtml::activeId($model, 'perencanaan') ?>").val(data.perencanaan);
                        $("#<?php echo CHtml::activeId($model, 'instruksi') ?>").val(data.instruksi);
                        $("#<?php echo CHtml::activeId($model, 'proses') ?>").val("ubah");

                        //                        $("#sub > .redactor_box > .redactor_frame").find("p").html("testset");
                        $("#integrasi-pasien-t-form").find('input,select,textarea').attr('readonly', false);
                        $("#btn_simpan").attr('disabled', false);

                        $('#integrasi-pasien-t-form').removeClass("animation-loading");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        myAlert("Data Perkembangan Terintegrasi Pasien Tidak Ditemukan!");
                        console.log(errorThrown);
                        $('#integrasi-pasien-t-form').removeClass("animation-loading");
                    }
                });

            }

            function salinRiwayat(id) {

                $('#integrasi-pasien-t-form').addClass('animation-loading');

                $.ajax({
                    url: '<?php echo $this->createUrl('GetDataFromRiwayat'); ?>',
                    data: {id: id},
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        $('#RIPerkembanganTerintegrasiPasienT_tgltransaksi').val(data.tgltransaksi);
                        $('#RIPerkembanganTerintegrasiPasienT_pegawai_id').val(data.pegawai_id);
                        $('#RIPerkembanganTerintegrasiPasienT_nama_pegawai').val(data.nama_pegawai);
                        $('#RIPerkembanganTerintegrasiPasienT_profesi').val(data.profesi);
                        $("#<?php echo CHtml::activeId($model, 'subyektif') ?>").val(data.subyektif);
                        $("#<?php echo CHtml::activeId($model, 'obyektif') ?>").val(data.obyektif);
                        $("#<?php echo CHtml::activeId($model, 'asesmen') ?>").val(data.asesmen);
                        $("#<?php echo CHtml::activeId($model, 'perencanaan') ?>").val(data.perencanaan);
                        $("#<?php echo CHtml::activeId($model, 'instruksi') ?>").val(data.instruksi);
                        $("#<?php echo CHtml::activeId($model, 'proses') ?>").val("salin");
                        $("#integrasi-pasien-t-form").find('input,select,textarea').attr('readonly', false);
                        $("#btn_simpan").attr('disabled', false);

                        $('#integrasi-pasien-t-form').removeClass('animation-loading');

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        myAlert("Data Perkembangan Terintegrasi Pasien Tidak Ditemukan!");
                        console.log(errorThrown);
                        $('#integrasi-pasien-t-form').removeClass('animation-loading');

                    },
                });
            }

            function setSOAPIDokter(id) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('GetSOAPIDokter'); ?>',
                    data: {id: id}, //
                    dataType: "json",
                    success: function (data) {
                        $('.redactor').html(data.form);
                        $('.redactor').find('textarea').redactor({
                            toolbar: 'smini'
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }

            function setSOAPIPerawat(id) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('GetSOAPIPerawat'); ?>',
                    data: {id: id}, //
                    dataType: "json",
                    success: function (data) {
                        $('.redactor').html(data.form);
                        $('.redactor').find('textarea').redactor({
                            toolbar: 'smini'
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }


            $(document).ready(function () {

                $("#<?php echo CHtml::activeId($model, 'proses') ?>").val("default");
                $("#<?php echo CHtml::activeId($model, 'tgltransaksi') ?>").val("<?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s")); ?>");

            });
        </script>
        </tr>
        <?php
    }
}
?>
</tbody>
</table>
