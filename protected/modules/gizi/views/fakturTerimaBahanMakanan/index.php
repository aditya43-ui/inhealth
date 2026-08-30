<?php
$this->breadcrumbs = array(
    'Faktur Pembelian Bahan Makanan',
); ?>
<?php
if (empty($modDetail)) {
    $modDetail =  null;
}
echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modDetail' => $modDetail, 'modUangmuka' => $modUangmuka, 'linkHalaman' => $linkHalaman));
?>
<script type="text/javascript">
    $(document).ready(function() {
        // Notifikasi supplier 1
        <?php
        if (isset($_GET['smscp1'])) {
            if ($_GET['smscp1'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS SUPPLIER',
                    isinotifikasi: '<?php echo $model->supplier->supplier_nama; ?> tidak memiliki nomor mobile'
                }; // 16 
                //insert_notifikasi(params);
        <?php
            }
        }
        ?>
        // Notifikasi supplier 2
        <?php
        if (isset($_GET['smscp2'])) {
            if ($_GET['smscp2'] == 0) {
        ?>
                var params2 = [];
                params2 = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS SUPPLIER 2',
                    isinotifikasi: '<?php echo $model->supplier->supplier_nama; ?> tidak memiliki nomor mobile'
                }; // 16 
                //insert_notifikasi(params2);
        <?php
            }
        }
        ?>
        <?php
        if (isset($model->terimabahanmakan_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_AKUNTANSI ?>,
                judulnotifikasi: 'Penerimaan Bahan Makanan',
                isinotifikasi: 'elah diterima bahan makanan dengan <?php echo $model->nopenerimaanbahan ?> pada <?php echo $model->tglterimabahan ?>'
            }; // 16 
            //insert_notifikasi(params);
        <?php
        }
        ?>
    })
</script>