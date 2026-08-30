<link rel="stylesheet" href="themes/neon18/assets/css/sidebar/custom-sidebar-green.css">
<link rel="stylesheet" href="themes/neon18/assets/css/sidebar/neon-forms-green.css">
<link rel="stylesheet" href="themes/neon18/assets/css/sidebar/inovastyle.css">

<?php
echo $this->renderPartial('application.views.headerReport.headerAnggaran', array('judulLaporan' => $judulLaporan, 'deskripsi' => $deskripsi, 'colspan' => 10));
?>
<div class="col-sm-12">
    <table class="table" style="width: 100%">
        <tr>
            <td>No. Pemesanan</td>
            <td>:</td>
            <td><?php echo isset($model->pesanperlinensteril_no) ? $model->pesanperlinensteril_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pemesanan</td>
            <td>:</td>
            <td><?php echo isset($model->pesanperlinensteril_tgl) ? MyFormatter::formatDateTimeForUser($model->pesanperlinensteril_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Pemesanan</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaiMemesan->NamaLengkap) ? $model->pegawaiMemesan->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->pesanperlinensteril_ket) ? $model->pesanperlinensteril_ket : "-"; ?></td>
        </tr>
    </table><br>
    <table class="table" id="table-detailpemesanan" style="width: 100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Nama Peralatan dan Linen</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count((array)$modDetail) > 0) {
                $disabled = false;
                foreach ($modDetail as $i => $detail) { ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo (!empty($detail->pesan->ruangan_id) ? $detail->pesan->ruangan->ruangan_nama : ""); ?></td>
                        <td><?php echo (!empty($detail->barang->barang_id) ? $detail->barang->barang_id : ""); ?></td>
                        <td><?php echo (!empty($detail->pesanperlinensterildet_jml) ? $detail->pesanperlinensterildet_jml : ""); ?></td>
                        <td><?php echo (!empty($detail->pesanperlinensterildet_ket) ? $detail->pesanperlinensterildet_ket : ""); ?></td>
                    </tr>
                <?php    }
            } else {
                $disabled = false;
                ?>
                <tr>
                    <td colspan="5">Data tidak ditemukan.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disabled, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'disabled' => $disabled, 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'disabled' => $disabled, 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
?>
<script type="text/javascript">
    function print(caraPrint) {
        var pesanperlinensteril_id = '<?php echo isset($_GET['pesanperlinensteril_id']) ? $_GET['pesanperlinensteril_id'] : null; ?>';
        window.open('<?php echo $this->createUrl('printDetail'); ?>&pesanperlinensteril_id=' + pesanperlinensteril_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>