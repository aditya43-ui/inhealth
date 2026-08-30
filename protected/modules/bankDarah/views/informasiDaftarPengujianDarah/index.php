<?php
$this->breadcrumbs = array(
    'Informasi Permintaan Darah Pasien',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#permintaandarah-r-search').submit(function(){
            $.fn.yiiGridView.update('permintaandarah-r-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$module  = $this->module->name;
$controller = $this->id;
$format = new MyFormatter();
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Daftar Pengujian Darah </b>
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
                <?php $this->renderPartial('_search', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Table Daftar Pengujian Darah
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_table', array('model' => $model)); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
<?php $this->renderPartial('_dialogTagihan', array()); ?>
