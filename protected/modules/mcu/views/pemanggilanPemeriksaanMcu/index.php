<?php $linkHalaman = CustomFunction::getUrlByMenuID(2947); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('#search').submit(function(){
		$.fn.yiiGridView.update('daftarpasien-v-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
$this->breadcrumbs = array(
    'Transaksi Pemanggilan MCU'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pemanggilan MCU</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('#pencarianpasien-form').submit(function(){
                $('#pemanggilanmcu-v-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('pemanggilanmcu-v-grid', {
                    data: $(this).serialize()
                });
                return false;
            });
            ");
        ?>
        <?php
        if (isset($_GET['sukses'])) {
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <fieldset class="box" id="form-pasien">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian
                    </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view . '_formPencarian', array('model' => $model, 'modPasien' => $modPasien, 'modPemanggilan' => $modPemanggilan, 'modPemanggilanMcu' => $modPemanggilanMcu)); ?>
                </div>
        </fieldset>
        <div class="clear"></div>
        <hr>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemanggilanmcu-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
        ));
        ?>
        <?php echo $form->errorSummary($modPemanggilan); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemanggilan Pasien MCU</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_tabelPemanggilan', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPemanggilan' => $modPemanggilan, 'modPemanggilanMcu' => $modPemanggilanMcu)); ?>
            </div>
        </div>
        <div class="panel panel-success" id="form-pemanggilan">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pemanggilan Pemeriksaan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formPemanggilan', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPemanggilan' => $modPemanggilan, 'modPemanggilanMcu' => $modPemanggilanMcu)); ?>
                </div>
                <div class="form-actions">
                    <?php
                    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                    $disableSave = false;
                    $disableSave = (!empty($_GET['no_pemanggilan'])) ? true : (($sukses > 0) ? true : false);
                    ?>
                    <?php $disablePrint = ($disableSave) ? false : true; ?>
                    <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'title' => 'Simpan', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                    );
                    ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
                        'class' => 'btn btn-default',
                        'title' => 'Ulang',
                        'onclick' => 'return refreshForm(this);'
                    ));
                    ?>
                    <?php
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    ?>
                    <?php
                    $content = $this->renderPartial($this->path_view . 'tips/tipsPemanggilanPemeriksaan', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPemanggilan' => $modPemanggilan, 'modPemanggilanMcu' => $modPemanggilanMcu)); ?>