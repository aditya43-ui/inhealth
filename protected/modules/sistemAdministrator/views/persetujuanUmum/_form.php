<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'persetujuanumum-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Informasi Awal Persetujuan <?php echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array(
                'onclick'=>'return false;',
                'rel'=>'tooltip', 'title'=>'Informasi Awal Persetujuan adalah informasi yang ditempatkan sebelum isi persetujuan.<br/>Contoh : Bahwa karena penyakit yang diderita pasien, dengan ini menyatakan sesungguhnya telah memberikan PERSETUJUAN untuk dilakukan perawatan di ruang rawat :',
                'data-placement'=>'bottom',
            )); ?>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'persetujuaninformasi_awal',  'height' => '200px')) ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Informasi Akhir Persetujuan <?php echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array(
                'onclick'=>'return false;',
                'rel'=>'tooltip', 'title'=>'Informasi Akhir Persetujuan adalah informasi yang ditempatkan sebagai penutup persetujuan dan sebelum tanda tangan persetujuan.<br/>Contoh :
SAYA TELAH MEMBACA, telah memahami, dan sepenuhnya setuju dengna setiap pernyataan yang terdapat pada formulir ini dan
menandatangani tanpa paksaan dan dengan kesadaran penuh.',
                'data-placement'=>'bottom',
            )); ?>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'persetujuaninformasi_akhir', 'height' => '200px')) ?>
    </div>
</div>


<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('create'),
            array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
    ?>
</div>
</div>
<?php $this->endWidget(); ?>
