<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'oppecaring-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#nama_perawat',
        ));
?>
<style>
    .integer2, .angkadot-only {
        text-align: right;
    }
</style>
<?php echo $form->errorSummary($model); ?>
<div class="panel-group joined" id="accordion-khp"> 
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #a6db9c"> 
                <a data-toggle="collapse"  data-parent="#accordion-khp" href="#riwayat" aria-expanded="true" class="">
                    Riwayat <b> Caring dalam 1 Semester </b>
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse in" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff">
                <table class="table table-bordered table-condensed table-striped" width="100%" id="riwayatCaring">
                    <thead>
                        <tr>
                            <th style="text-align: center; vertical-align: middle"> No </th>
                            <th style="text-align: center; vertical-align: middle"> Bulan Caring </th>
                            <th style="text-align: center; vertical-align: middle"> Nama Perawat </th>
                            <th style="text-align: center; vertical-align: middle"> Tanggal <br> Quesioner </th>
                            <th style="text-align: center; vertical-align: middle"> Nilai <br> Pasien </th>
                            <th style="text-align: center; vertical-align: middle"> Nilai <br> Keluarga </th>
                            <th style="text-align: center; vertical-align: middle"> Rata-rata </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('_form', array('model' => $model, 'form' => $form)) ?>

<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Pencatatan Kuisioner Caring </b> </div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>
        <table id="tabelCaring" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle"> Bulan <br>  Pencatatan </th>
                    <th style="text-align: center; vertical-align: middle"> Nama Perawat </th>
                    <th style="text-align: center; vertical-align: middle"> NIP Perawat </th>
                    <th style="text-align: center; vertical-align: middle"> Unit Kerja </th>
                    <th style="text-align: center; vertical-align: middle"> Tanggal <br> Kuisioner </th>
                    <th style="text-align: center; vertical-align: middle"> Pasien </th>
                    <th style="text-align: center; vertical-align: middle"> Keluarga <br>  Pasien </th>
                    <th style="text-align: center; vertical-align: middle"> Rata-rata </th>
                    <th style="text-align: center; vertical-align: middle"> Aksi </th>
                </tr>
            </thead>
            <tbody>
                <?php
                /*
                  $modDetail = ASOppecaringT::model()->findAllByAttributes(array('unitkerja_id' => Yii::app()->user->getState('unitkerja_id')));
                  if (!empty($modDetail)) {
                  $i = 1;
                  foreach($modDetail as $i => $mod){
                  $mod->bulan_caring = MyFormatter::getMonthId(date('M',strtotime($mod['bulan_caring'])))." ".date('Y', strtotime($mod['bulan_caring']));
                  $mod->namaunitkerja = $mod->unitkerja->namaunitkerja;
                  $mod->tgl_kuisioner = MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($mod['tgl_kuisioner'])));
                  $this->renderPartial('_rowCaring', array('model' => $mod, 'i' => $i));
                  }
                  }
                 */
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) : Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger submit', 'type' => 'button', 'onclick' => 'cekForm();', 'id' => 'btn_submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/bahanMenuDietM/admin'), array('class' => 'btn btn-danger', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial('_jsFunction', array('model' => $model)) ?>
