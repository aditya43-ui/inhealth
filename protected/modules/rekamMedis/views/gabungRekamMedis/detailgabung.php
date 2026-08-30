<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/fileinput.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/datetime.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#',
)); ?>

<fieldset class="" id="tablePegawaicuti">
    <div class="panel panel-gradient panel-shadow">
        <div class="panel-heading">
            <div class="panel-title">Detail</div>
        </div>
        <div class="panel-body">
            <?php echo $form->errorSummary($model); ?>
            <?php
            //if($sukses > 0) {
            // Yii::app()->user->setFlash('success',"Data Cuti berhasil disimpan !");
            $this->widget('bootstrap.widgets.BootAlert');
            //   }
            ?>
            <p class="help-block"></p>

            <div class="form-actions">


            </div>
        </div>

    </div>

</fieldset>
<?php
$this->endWidget();
?>