<?php

$modul_login = Yii::app()->user->getState('modul_id');
$modul_hide = [6, 7, 72];

$hide_edit = in_array($modul_login, $modul_hide) ? "hidden" : "";


?>

<table class="items table table-striped table-condensed" id="tblInputAnamnesa">
    <thead>
        <tr>
            <th>Tanggal Anamnesis</th>
            <th>Dokter</th>
            <th>Paramedis</th>
            <th>PPDS</th>
            <th>Lihat Detail</th>
            <th <?=$hide_edit?>>Ubah</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <?php foreach ($tabelAnamnesa as $i => $Anamnesa) { ?>
        <?php
            $ruangan_login = Yii::app()->user->getState('ruangan_id');
            $pegawai_login = Yii::app()->user->getState('loginpemakai_id');
            
            $ruangan_create = $Anamnesa->create_ruangan;
            $pegawai_create = $Anamnesa->create_loginpemakai_id;
            
            $modul_pel = [6, 7, 72];
            
            $bisa_hapus = (($ruangan_login == $ruangan_create) && ($pegawai_login == $pegawai_create) && in_array($modul_login, $modul_pel)) ? 1 : 0;    
        ?>
        <tr>
            <td><?php echo $format->formatDateTimeForUser($Anamnesa->tglanamnesis); ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Anamnesa->pegawai_id) ?>
            <td><?php echo  $pegawai->nama_pegawai; ?></td>
            <td><?php echo $Anamnesa->paramedis_nama; ?></td>
            <td><?php echo !empty($Anamnesa->ppds->ppds_nama) ? ($Anamnesa->ppds->ppds_nama) : ''; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick' => 'viewDetailAnamnesa("' . $Anamnesa->anamesa_id . '","' . $_GET["pendaftaran_id"] . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail anamnesa')); ?></td>
            <td <?=$hide_edit?>>
                <?php
                echo CHtml::link(
                    "<i class='icon-form-ubah'></i>",
                    array('AnamnesaTPI/index', 'pendaftaran_id' => $Anamnesa->pendaftaran_id, 'pasienadmisi_id' => $Anamnesa->pasienadmisi_id, 'tglanamnesis' => $Anamnesa->tglanamnesis)
                );
                ?>
            </td>
            <td>
                <?php
                $tglAnamnesis = (isset($_GET['tglanamnesis']) ? $_GET['tglanamnesis'] : null);
                if ($tglAnamnesis !== $Anamnesa->tglanamnesis) { ?>
                    <a onclick="hapusAnamnesis('<?php echo $Anamnesa->anamesa_id; ?>',this, <?=$bisa_hapus?>);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Anamnesa"><i class="icon-form-sampah"></i></a>
                <?php }
                ?>
            </td>
        </tr>
    <?php } ?>
</table>

<script type="text/javascript">
    function hapusAnamnesis(anamesa_id, obj, is_bisa = true) {
        tabel = obj;

        if(is_bisa) {
        myConfirm('Apakah Anda akan menghapus Anamnesa ini?', 'Perhatian!', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRiwayatAnamnesa'); ?>',
                    data: {
                        anamesa_id: anamesa_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses) {
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                        }
                        myAlert(data.pesan);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
        }else {
            myAlert("Anda tidak memiliki akses");
        }
    }

    function viewDetailAnamnesa(idAnamnesis, pendaftaran_id) {

        $.post('<?php echo $this->createUrl('ajaxDetailAnamnesa') ?>', {
            idAnamnesis: idAnamnesis,
            pendaftaran_id: pendaftaran_id
        }, function(data) {
            $('#contentDetailAnamnesa').html(data.result);
        }, 'json');
        $('#dialogDetailAnamnesa').dialog('open');
    }
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailAnamnesa',
    'options' => array(
        'title' => 'Detail Anamnesa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
        'position' => 'top',
    ),
));

echo '<div id="contentDetailAnamnesa">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>