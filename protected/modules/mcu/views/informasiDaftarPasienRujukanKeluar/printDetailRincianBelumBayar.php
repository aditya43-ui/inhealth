<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'updatetagihan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
)); ?>
<style>
    .table-rincian td,
    th {
        border: solid #000 1px;
    }
</style>
<?php
//if(!$modRincians){
//    echo "Data tidak ditemukan."; exit;
//}
$format = new MyFormatter;
if (!isset($_GET['frame'])) {
    echo $this->renderPartial($this->path_view . '_headerPrint');
}
?>
<div style='width:100%; text-align: center; font-weight: bold;'> DETAIL RINCIAN TAGIHAN PASIEN </div>
<table style="width: 100%; border: none;">
    <tr>
        <td>No. Urut</td>
        <td>: <?php echo "-" ?></td>
        <td>No. Rekam Medik</td>
        <td>: <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
        <td>Tanggal Masuk RS</td>
        <td>: <?php echo date("d-m-Y", strtotime($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td>Nama/Umur</td>
        <td>: <?php echo $modPendaftaran->pasien->namadepan . " " . $modPendaftaran->pasien->nama_pasien . "/" . $modPendaftaran->umur; ?></td>
        <td>Tanggal Keluar</td>
        <td>: <?php
                if (count((array)$modRincians) > 0) {
                    echo date("d-m-Y", strtotime($modRincians[count((array)$modRincians) - 1]->tgl_tindakan));
                }
                ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
        <td></td>
        <td></td>
    </tr>
</table>
<table width='100%' cellpadding='2px' class='table-rincian' id="table-rincian">
    <thead>
        <th>Tanggal</th>
        <th>Uraian</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Subtotal</th>
    </thead>
    <tbody>
        <?php
        $totalbiaya = 0;
        if (count((array)$modRincians) > 0) {
            foreach ($modRincians as $i => $rincian) {
                $totalbiaya += ($rincian->qty_tindakan * $rincian->tarif_satuan);
                $rincian->iurbiaya_tindakan = ($rincian->qty_tindakan * $rincian->tarif_satuan);
                $tampilruangan = true;
                if ($i > 0) {
                    if ($modRincians[$i]->ruangantindakan_id == $modRincians[$i - 1]->ruangantindakan_id) {
                        $tampilruangan = false;
                    } else {
                        $tampilruangan = true;
                    }
                }
                //				if($tampilruangan){
        ?>
                <!--					<tr>
						<td></td>
						<td colspan='4'><b><?php // echo $rincian->ruangantindakan_nama; 
                                            ?></b></td>
					</tr>-->
                <?php
                //				}
                ?>
                <tr>
                    <td align='right'><?php echo date("d-m-Y", strtotime($rincian->tgl_tindakan)); ?></td>
                    <td><?php echo $rincian->daftartindakan_nama; ?>
                        <?php echo CHtml::activeHiddenField($rincian, '[' . $i . ']tindakanpelayanan_id', array('readonly' => false, 'class' => 'span1 integer')); ?></td>
                    <?php echo CHtml::activeHiddenField($rincian, '[' . $i . ']discount_tindakan', array('readonly' => false, 'class' => 'span1 integer')); ?></td>
                    <td align='right'><?php echo CHtml::activeTextField($rincian, '[' . $i . ']qty_tindakan', array('readonly' => false, 'class' => 'span1', 'onblur' => 'hitungSubTotal(this);')); ?></td>
                    <td align='right'><?php echo CHtml::activeTextField($rincian, '[' . $i . ']tarif_satuan', array('readonly' => false, 'class' => 'span1 integer', 'onblur' => 'hitungSubTotal(this);')); ?></td>
                    <td align='right'><?php echo CHtml::activeTextField($rincian, '[' . $i . ']iurbiaya_tindakan', array('readonly' => true, 'class' => 'span1 integer')); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='4' align='right' style="font-weight:bold;">Jumlah Biaya</td>
            <td align='right' style="font-weight:bold;">
                <?php echo CHtml::textField('total_tagihan', $totalbiaya, array('readonly' => true, 'class' => 'span1 integer', 'onblur' => 'hitungProporsi(this);')); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='center' style="font-style:italic;">(<?php echo $format->formatNumberTerbilang($totalbiaya); ?> rupiah)</td>
        </tr>
    </tfoot>
</table>
<div class="row">
    <div class="col-sm-4">
        <div class="control-group">
            <div class="control-label">Total Tagihan</div>
            <div class="controls">
                <?php echo CHtml::textField('totaltagihan', '', array('class' => 'span3 integer', 'onblur' => 'hitungProporsi(this);')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">

    </div>
    <div class="col-sm-4">

    </div>
</div>

<div class="form-actions">
    <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); 
    ?>
    <?php
    if (!isset($_GET['sukses'])) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);')
        ); //formSubmit(this,event)
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();return false", 'disabled' => FALSE));
    }
    ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onClick' => 'closeDialog();')
    );
    ?>
</div>

<?php
$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
if (isset($_GET['frame']) && $sukses > 0) {
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();"));
?>

<?php
} else if (!isset($_GET['frame'])) {
?>
    <table width='100%'>
        <tr>
            <td></td>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td align='center'>Dicetak oleh</td>
        </tr>
        <tr height='100px'>
            <td></td>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
        </tr>
    </table>
<?php
}
?>
<?php $this->endWidget(); ?>
<script type='text/javascript'>
    /**
     * print
     */
    function print() {
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintDetailRincianBelumBayar", array("instalasi_id" => $_GET['instalasi_id'], "pendaftaran_id" => $_GET['pendaftaran_id'], "pasienadmisi_id" => (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) ?>", "", 'location=_new, width=1024px');
    }

    function hitungSubTotal(obj) {
        unformatNumberSemua();
        harga = parseInt($(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val());
        qty = parseInt($(obj).parents('tr').find('input[name$="[qty_tindakan]"]').val());
        diskon = parseInt($(obj).parents('tr').find('input[name$="[discount_tindakan]"]').val());

        iurbiaya = $(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]');
        totaliurbiaya = ((harga * qty) - ((harga * qty) * (diskon / 100)));

        if (totaliurbiaya <= 0) {
            totaliurbiaya = 0;
        }

        iurbiaya.val(totaliurbiaya);

        hitungTotal();
        formatNumberSemua();
    }

    function hitungTotal() {
        unformatNumberSemua();
        obj_totaltagihan = $('#totaltagihan');
        obj_totaltindakan = $('#total_tagihan');
        totaltagihan = 0;
        iurbiayatindakan = 0;
        $('#table-rincian tbody').find('tr').each(function() {
            harga = parseFloat($(this).find('input[name*="[tarif_satuan]"]').val());
            qty = parseFloat($(this).find('input[name*="[qty_tindakan]"]').val());
            totaltagihan = totaltagihan + (harga * qty);
            iurbiayatindakan = (harga * qty);

            $(this).find('input[name*="[iurbiaya_tindakan]"]').val(iurbiayatindakan);
        });

        obj_totaltagihan.val(totaltagihan);
        obj_totaltindakan.val(totaltagihan);

        formatNumberSemua();
    }

    function hitungProporsi(obj) {
        unformatNumberSemua();
        var total = 0;
        var totaltagihan = parseFloat($('#totaltagihan').val());
        var jumlah_record = $('#table-rincian tbody tr').length;

        if (jumlah_record > 0 && totaltagihan > 0) {
            total = totaltagihan / jumlah_record;
            if (total <= 0) {
                total = 0;
            }
            $('#table-rincian tbody').find('tr').each(function() {
                harga = total;
                qty = parseFloat($(this).find('input[name*="[qty_tindakan]"]').val());
                $(this).find('input[name*="[tarif_satuan]"]').val(total);
            });
            hitungTotal();
        }
    }

    function closeDialog() {
        window.parent.$('#dialogRincian').dialog('close');
    }
</script>