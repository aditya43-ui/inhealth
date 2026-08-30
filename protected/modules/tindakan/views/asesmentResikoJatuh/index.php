<!-- <div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Asesment Skoring Resiko Jatuh
        </div>
    </div>
    <div class="panel-body"> -->
<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'resikojatuh-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

echo $this->renderPartial($this->path_view . '_dataPasien', array(
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien,
    'modResikoJatuh' => $modResikoJatuh
), true);

echo $this->renderPartial($this->path_view . '_skoringResiko', array(
    'form' => $form,
    'model' => $model,
), true);

echo $this->renderPartial($this->path_view . '_implementasiResikoTinggi', array(
    'form' => $form,
    'model' => $model,
), true);

echo $this->renderPartial($this->path_view . '_implementasiResikoRendah', array(
    'form' => $form,
    'model' => $model,
), true);

?>

<div class="form-actions">
    <?php
    if ($model->isNewRecord) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
        );
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => 'disabled')
        ); //RND-8620
    }
    
    if (!isset($_GET['skoringresikojatuh_id'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
        
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-succes', 'onclick' => 'print();'));
        
    }
    
    ?>

    <?php
    // $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    // $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
    <?php
    $this->endWidget();

    echo $this->renderPartial($this->path_view . '_jsFunction', array('model' => $model), true);
    ?>
</div>
<!-- </div>
</div> -->

<script>
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $modPendaftaran->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
</script>