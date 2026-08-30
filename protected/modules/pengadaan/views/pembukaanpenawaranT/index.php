<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'persiapanpengadaan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onsubmit' => 'return requiredCheck(this);',
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
        //'focus' => '#'.CHtml::activeId($model, 'persiapanpengadaan_tanggal').'',
        ));
?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> Data <b> Pembukaan Penawaran</b></div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAll("konfigtemplatesurat_nama LIKE '%Pembukaan Penawaran%' AND konfigtemplatesurat_aktif = true order by konfigtemplatesurat_nama ASC"), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'), array('class' => 'span4 jenisform', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'pembukaanpenawaran_nomor', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
            <?php $this->renderPartial('_form', array('form' => $form, 'model' => $model)) ?>
        </div>
        <hr>
    </div>
</div>
<div class="row-fluid">
    <div class="panel panel-success">
        <div class="panel panel-heading">
            <div class="panel-title"> Hasil <b> Pembukaan Penawaran </b></div>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th style="text-align: center"> No </th>
                        <th style="text-align: center"> Nama Dokumen </th>
                        <th style="text-align: center"> Kelengkapan </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $this->renderPartial('_rowDokumen', array('model' => $model, 'form' => $form)) ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="row-fluid">
    <?php
    $cekInfo = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'], 'isbatal' => false, 'isaddendum' => true));

    if (empty($cekInfo)) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
        echo "&nbsp;";
    } else {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
            'type' => 'submit'));
    }
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('index&id=' . $model->persiapanpengadaan_id), array('class' => 'btn btn-danger',
        'onclick' => 'return refreshForm(this);'));
    ?>
    <?php
    $content = $this->renderPartial('pengadaan.views.tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php
    if (empty($model->pembukaanpenawaran_id)) {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
        echo "&nbsp;";
    } else {
         echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));
                    echo "&nbsp;";
    }
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function print(){
        window.open('<?php echo $this->createUrl('print',array('id'=>$model->pembukaanpenawaran_id)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
    $(document).ready(function () {
<?php
if ($model->isNewRecord) {
    if ($model->cek_informasi == false) {
        echo 'toastr.error("Data Informasi Umum Pengadaan belum dimasukkan, tidak bisa menambahkan transaksi Pembukaan Penawaran.", "Perhatian!")';
    }
}
?>

    });
</script>
