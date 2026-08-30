<?php $linkHalaman = CustomFunction::getUrlByMenuID(461); ?>
<?php
$this->breadcrumbs = array(
    'Transaksi Penerimaan Bahan Makanan',
);
?>
<?php
//$this->breadcrumbs=array(
//	'Gzterimabahanmakans',
//);
//
//$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GZTerimabahanmakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GZTerimabahanmakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GZTerimabahanmakan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;
//
//$this->menu=$arrMenu;
?>
<?php
if (empty($modDetail)) {
    $modDetail =  null;
}
echo $this->renderPartial('_form', array('model' => $model, 'modDetail' => $modDetail, 'modDetailPengajuan' => $modDetailPengajuan, 'modPengajuan' => $modPengajuan, 'modUangMuka' => $modUangMuka, 'linkHalaman' => $linkHalaman));
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
                insert_notifikasi(params);
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
                insert_notifikasi(params2);
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
            insert_notifikasi(params);
        <?php
        }
        ?>
    })
</script>