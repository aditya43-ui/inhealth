<?php $linkHalaman = CustomFunction::getUrlByMenuID(352); ?>
<?php
$this->breadcrumbs = array(
    'Transaksi Permintaan Pembelian Bahan Makanan',
);
//$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GZPengajuanbahanmkn ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
////                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GZPengajuanbahanmkn', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GZPengajuanbahanmkn', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
//
//$this->menu=$arrMenu;
?>
<?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modDetails' => $modDetails, 'modDetailPengajuan' => $modDetailPengajuan, 'linkHalaman' => $linkHalaman)); ?>
<script type="text/javascript">
    $(document).ready(function() {
        // Notifikasi supplier 1
        <?php
        if (Yii::app()->user->getState('issmsgateway')) {
            if (isset($_GET['smscp1'])) {
                if ($_GET['smscp1'] == 0) {
        ?>
        var params = [];
        params = {
            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
            modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
            judulnotifikasi: 'GAGAL KIRIM SMS SUPPLIER',
            isinotifikasi: '<?php echo $modSupplier->supplier_nama; ?> tidak memiliki nomor mobile'
        }; // 16 
        insert_notifikasi(params);
        <?php
                }
            }
        }
        ?>
        // Notifikasi supplier 2
        <?php
        if (Yii::app()->user->getState('issmsgateway')) {
            if (isset($_GET['smscp2'])) {
                if ($_GET['smscp2'] == 0) {
        ?>
                    var params = [];
                    params = {
                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                        modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                        judulnotifikasi: 'GAGAL KIRIM SMS SUPPLIER 2',
                        isinotifikasi: '<?php echo $modSupplier->supplier_nama; ?> tidak memiliki nomor mobile'
                    }; // 16 
                    insert_notifikasi(params);
        <?php
                }
            }
        }
        ?>
        <?php
        if (isset($model->pengajuanbahanmkn_id)) {
        ?>
            renameInputRowObatAlkes($('#tableBahanMakanan'));
            hitungSemua();
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_AKUNTANSI ?>,
                judulnotifikasi: 'Permintaan Pembelian Bahan Makanan',
                isinotifikasi: 'Telah dilakukan pengajuan bahan makanan dengan <?php echo $model->nopengajuan ?> pada <?php echo $model->tglpengajuanbahan ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });
</script>