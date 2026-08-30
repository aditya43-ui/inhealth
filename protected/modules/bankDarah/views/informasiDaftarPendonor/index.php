<?php
/**
 * Digunakan sebagai Informasi Daftar Pendonor
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @author  Andyka Putra <andykaputra@.com>
 * @website	   <.com>
 * */
?>

<?php
$this->breadcrumbs = array(
    'Informasi Daftar Pendonor' => array('index'),
    'Informasi',
);

$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Data Pelamar ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) : '';
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PelamarT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PelamarT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

$this->menu = $arrMenu;

Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
$('#daftarpendonor-search').submit(function(){
    $.fn.yiiGridView.update('daftarpendonor-grid', {
            data: $(this).serialize()
    });
    return false;
});
");

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Daftar Donor</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Daftar Donor</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                        <?php
                            $this->renderPartial('_table', ['model' => $model]);
                        ?>                            
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php
                            $this->renderPartial('_search', array(
                                'model' => $model,
                            ));
                            ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>     
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
?>
<?php
// Dialog untuk Observasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObservasi',
    'options' => array(
        'title' => 'Detail Observasi Donor Darah',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'minHeight' => 450,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeObservasi" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
//========= end Observasi =============================
?>
<?php
// Dialog untuk Seleksi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogSeleksi',
    'options' => array(
        'title' => 'Detail Seleksi Donor Darah',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 970,
        'minHeight' => 450,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeSeleksi" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
//========= end Seleksi =============================
?>
<?php
// Dialog untuk Kantong Darah =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKantong',
    'options' => array(
        'title' => 'Detail Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1300,
        'minHeight' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeKantong" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
//========= end Kantong Darah=============================
?>

<script>
    function Bataldonordarah(id) {
        var id = id;
        var url = '<?php echo $url . '/bataldonordarah'; ?>';
        myConfirm('Apakah anda yakin membatalkan pendonor ini ?', 'Perhatian !', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'berhasil_form') {
                                myAlert('Data donor darah berhasil dibatalkan');
                                $.fn.yiiGridView.update('daftarpendonor-grid');
                            } else {
                                myAlert('Data donor darah gagal dibatalkan');
                            }
                        }, "json");
            }
        });
    }
</script>