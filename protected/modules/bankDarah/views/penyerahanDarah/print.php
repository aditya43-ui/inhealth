<div class="panel-body">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'penyerahandarah-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body" id="form_permintaan">
            <?php echo $this->renderPartial($this->path_view . 'form/_formPasien', array(
                'permintaan' => $permintaan,
                'pendaftaran' => $pendaftaran,
                'model' => $model,
            ), true); ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Pengiriman Darah
            </div>
        </div>
        <div class="panel-body" id="panel_penyiapan">
            <?php echo $this->renderPartial($this->path_view . 'form/_formPenyiapan', array(
                'permintaan' => $permintaan,
                'penyiapan' => $penyiapan,
            ), true); ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Penerimaan Darah
            </div>
        </div>
        <div class="panel-body">
            <?php echo $this->renderPartial($this->path_view . 'form/_formDetail', array(
                'permintaan' => $permintaan,
                'penyiapan' => $penyiapan,
                'model' => $model,
            ), true); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php echo $this->renderPartial($this->path_view . 'form/_jsFunctions', array(
    'permintaan' => $permintaan,
    'model' => $model
), true); ?>