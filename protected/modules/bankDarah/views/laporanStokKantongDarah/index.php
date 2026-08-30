<?php
$this->breadcrumbs = array(
    'Laporan Stok Kantong Darah',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
/**
 * Halaman ini digunakan untuk menampilkan informasi stok kantong darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('#laporanstokkantongdarah-v-search').submit(function(){
        $.fn.yiiGridView.update('laporanstokkantongdarah-v-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Laporan <b>Stok Kantong Darah</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>

            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stok Kantong Darah</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_table', array(
                    'model' => $model,
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            ?>
        </div>
    </div>
</div>

<?php
$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#laporanstokkantongdarah-v-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporanstokkantongdarah-v-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php
// ===========================Dialog Details =========================================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//                    'id'=>'dialogStokKantongDarah',
//                        // additional javascript options for the dialog plugin
//                        'options'=>array(
//                        'title'=>'Detail Stok Kantong Darah',
//                        'autoOpen'=>false,
//                        'width'=>1000,
//                        'height'=>500,
//                        'resizable'=>true,
//                        'scroll'=>false    
//                         ),
//                    ));
?>
<!--<iframe src="" name="frameDetailStokKantongDarah" style="width:100%; height: 98%;"></iframe>';-->

<?php
//$this->endWidget('zii.widgets.jui.CJuiDialog');

//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//                    'id'=>'dialogStokDarahSiap',
//                        // additional javascript options for the dialog plugin
//                        'options'=>array(
//                        'title'=>'Detail Stok Darah Siap',
//                        'autoOpen'=>false,
//                        'width'=>1000,
//                        'height'=>500,
//                        'resizable'=>true,
//                        'scroll'=>false    
//                         ),
//                    ));
?>
<!--<iframe src="" name="frameDetailStokDarahSiap" style="width:100%; height: 98%;"></iframe>';-->

<?php
//$this->endWidget('zii.widgets.jui.CJuiDialog');

//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//                    'id'=>'dialogStokDarahKeluar',
//                        // additional javascript options for the dialog plugin
//                        'options'=>array(
//                        'title'=>'Detail Stok Darah Keluar',
//                        'autoOpen'=>false,
//                        'width'=>1000,
//                        'height'=>500,
//                        'resizable'=>true,
//                        'scroll'=>false    
//                         ),
//                    ));
?>
<!--<iframe src="" name="frameDetailStokDarahKeluar" style="width:100%; height: 98%;"></iframe>';-->

<?php
//$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>