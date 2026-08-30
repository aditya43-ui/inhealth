<?php
$this->breadcrumbs = array(
    'Pemeriksaan Pasien Rehabilitasi Medis' //=> Yii::app()->request->getUrlReferrer(),
    //'Rehabilitasi Medis',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pemeriksaan Pasien <b>Rehabilitasi Medis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemeriksaanrm-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>

        <div class="panel panel-success" <?php echo $this->action->id == "pemeriksaan" ? "hidden" : "" ?>>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <div class="row">
                    <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 17px;">
            <div class="col-sm-6">
                <fieldset class="">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Daftar Pemeriksaan Rehabilitasi Medis
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id='content-pemeriksaan-lab' class="col-sm-12">
                                <?php
                                $this->renderPartial($this->path_view_pendaftaran . '_formCariPemeriksaan', array(
                                    'modPemeriksaanRm' => $modPemeriksaanRm,
                                )); ?>
                                <div class='checklists'></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="form-tindakanpemeriksaan">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'title' => 'Simpan',  'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            );
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
            }

            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
            $content = $this->renderPartial('tips/tipsPemeriksaanPasienLaboratorium', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan)); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        cekDisabled('form');

        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function() {
            cekDisabled('form');
        });
    });
</script>