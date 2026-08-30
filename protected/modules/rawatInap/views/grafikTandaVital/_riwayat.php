<?php

$modul_login = Yii::app()->user->getState('modul_id');
$modul_hide = [6, 7, 72];

$hide_edit = in_array($modul_login, $modul_hide) ? "hidden" : "";
$visible = isset($_GET['lihat']) ? 'hidden' : '';
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Monitoring Kondisi Tubuh</div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Monitoring</th>
                    <th>Jam Monitoring</th>
                    <th>Pernapasan<br />(x/Menit)</th>
                    <th>Suhu Tubuh<br />(&deg;C)</th>
                    <th>Nadi<br />(x/Menit)</th>
                    <th>Tekanan Darah<br />(mm/Hg)</th>
                    <th>Petugas Pengisi</th>
                    <th>Lihat Detail</th>
                    <th <?=$hide_edit?> <?= $visible ?>>Ubah</th>
                    <th <?= $visible ?>>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riwayat as $idx => $item): ?>
                <tr class="data-row">
                    <td><?php echo $idx + 1; ?></td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($item->tgl_monitoring); ?></td>
                    <td><?php echo $item->jam_monitoring; ?></td>
                    <td><?php echo $item->pernapasan; ?></td>
                    <td><?php echo $item->suhu; ?></td>
                    <td><?php echo $item->nadi; ?></td>
                    <td><?php echo $item->td_systolic."/".$item->td_dyastolic; ?></td>
                    <td><?php echo empty($item->petugaspengisi) ? "-" : $item->petugaspengisi->namaLengkap; ?></td>
                    <td style="text-align: center;"><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick' => 'viewDetail("' . $item->grafiktandavital_id . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemeriksaan fisik')); ?>
                    </td>
                    <td style="text-align: center;" <?=$hide_edit?> <?= $visible ?>><?php echo CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('create', array(
                        'pendaftaran_id'=>$item->pendaftaran_id,
                        'id'=>$item->grafiktandavital_id,
                        // 'type'=> $_GET['type'],
                        // 'frame'=> $_GET['frame']
                    ))); ?></td>
                    <td style="text-align: center;" <?= $visible ?>><?php
                        $onclick = 'window.parent.myAlert("Tidak bisa dihapus karena hak akses tidak sesuai")';
                        
                        $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $item->create_ruangan, $item->create_loginpemakai_id);
                        
                        if($bisa_hapus) {
                            $onclick = "hapusItem(".$item->grafiktandavital_id.", this); return false;";
                        }

                        echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                            'onclick'=> $onclick,
                        ));
                    ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
        echo CHtml::link(Yii::t('mds', '{icon} Print',
                array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')),
            'javascript:void(0);', array('class' => 'btn btn-info',
            'onclick' => "print(" . $model->pendaftaran_id . ");return false")) . "&nbsp;";
        ?>

<script>
function viewDetail(id) {

    $.post('<?php echo $this->createUrl('ajaxDetail') ?>', {
        id: id,
    }, function(data) {
        $('#contentDetail').html(data.result);
        $('#contentDetail').trigger("load_detail_periksagambar");
    }, 'json');
    $('#dialogDetail').dialog('open');
}

function hapusItem(id, obj) {
    // untuk menentukan hanya data yang terbaru yang dapat dihapus
    // Temukan elemen <tr>  yang diklik
    var trElement = $(obj).closest("tr");
    // Dapatkan indeks elemen <tr> tersebut
    var trIndex = $(".data-row").index(trElement);
    // indeks <tr> yang diklik
    console.log("TR ke-" + trIndex + " di klik.");

    if(trIndex > 0) {
        window.parent.myAlert("Data tidak dapat dihapus karena sudah valid");
        return false;
    }

    window.parent.myConfirm("Anda yakin untuk menghapus monitoring ini ?", "Perhatian", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('delete'); ?>', {
                id: id
            }, function(data) {
                if (data.ok == 1) {
                    window.parent.myAlert(data.msg);
                    location.reload();
                } else {
                    window.parent.myAlert(data.msg);
                }
            }, 'json');
        }
    });
}

function print(pendaftaran_id) {
    window.open('<?php echo $this->createUrl('printGrafik'); ?>&id=' + pendaftaran_id, 'printwin',
        'left=100,top=100,width=1280,height=720');
}
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Monitoring Kondisi Tubuh',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
        // 'position' => 'top',
    ),
));

echo '<div id="contentDetail">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>