<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Blacklist Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Blacklist Pasien',
                );
                ?>

                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'pembayaran-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#RKPendaftaranT_no_pendaftaran',
                    'htmlOptions' => array(
                        'onKeyPress' => 'return disableKeyPress(event)',
                        'onsubmit' => 'return cekRequired();'
                        // 'onsubmit'=>'return cekOtorisasi();'
                    ),
                ));
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-user"></i> Identitas Pasien
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <?php $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran)); ?>
                        </div>
                    </div>
                </div>

                <div class="box row">
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'hutang',
                        'content' => array(
                            'content-hutang' => array(
                                'header' => '<b>Data Pasien Berhutang</b>',
                                'isi' => $this->renderPartial($this->path_view . '_tblPasienBerhutang', array(), true),
                                'active' => false,
                            ),
                        ),
                    )); ?>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Pasien Bermasalah</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <?php $this->renderPartial('_dataPasienBermasalah', array('model' => $model, 'form' => $form)); ?>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Pasien Blacklist</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <?php $this->renderPartial('_dataPasienBlacklist', array('model' => $model, 'form' => $form)); ?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <?php
                    if ($model->isNewRecord) {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
                        );
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array(
                                'title' => 'Simpan',
                                'class' => 'btn btn-danger',
                                'type' => 'submit',
                                'onKeypress' => 'return formSubmit(this,event)',
                                'disabled' => true
                            )
                        );
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    }
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/pasienBlacklist/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

$js = <<< JSCRIPT

function print(caraPrint)
{
window.open("${urlPrint}/&pasienblacklist_id="+$model->pasienblacklist_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>

<?php
$this->renderPartial('_jsFunctions', array(
    'modPendaftaran' => $modPendaftaran,
    'model' => $model,
    'modHutang' => $modHutang,
    'form' => $form
));
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPembayaran',
    'options' => array(
        'title' => 'Rincian Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false
    ),
));
?>
<iframe name='iframePembayaran' style="width:100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>