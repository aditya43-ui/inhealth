<?php $linkHalaman = CustomFunction::getUrlByMenuID(3594); ?>
<?php
$this->breadcrumbs = array(
    'Penggabungan Rekam Medis',
); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sadokrekammedis-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<style>
    .tab-content {
        min-height: 101px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> <b>Penggabungan Rekam Medis</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data Rekam Medis
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $this->renderPartial('_dataPasien', array('id' => 1, 'rm_label' => 'Dari No. RM'), true); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $this->renderPartial('_dataPasien', array('id' => 2, 'rm_label' => 'Menjadi No. RM'), true); ?>
                    </div>
                </div>
                <?php
                /*
		$this->widget('bootstrap.widgets.BootMenu', array(
			'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
			'stacked'=>false, // whether this is a stacked menu
			'items'=>array(
				array('label'=>'Riwayat Kunjungan', 'url'=>'#tab_menu_kunjungan', 'itemOptions'=>array('data-toggle'=>'tab')),
				array('label'=>'Riwayat Medis', 'url'=>'#tab_menu_medis', 'itemOptions'=>array('data-toggle'=>'tab')),
				array('label'=>'Riwayat Tagihan', 'url'=>'#tab_menu_tagihan', 'itemOptions'=>array('data-toggle'=>'tab')),
			),
		));
		 * 
		 */
                ?>
                <div>
                    <ul class="nav nav-tabs bordered">
                        <li class="active">
                            <a href="#tab_menu_kunjungan" data-toggle="tab">Riwayat Kunjungan</a>
                        </li>
                        <li>
                            <a href="#tab_menu_medis" data-toggle="tab">Riwayat Medis</a>
                        </li>
                        <li>
                            <a href="#tab_menu_tagihan" data-toggle="tab">Riwayat Tagihan</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_menu_kunjungan" class="tab-pane active">
                            <div class="row">
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Tgl. Pendaftaran</th>
                                                <th>No. Pendaftaran</th>
                                                <th>Instalasi</th>
                                                <th>Ruangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_kunjungan_1">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Tgl. Pendaftaran</th>
                                                <th>No. Pendaftaran</th>
                                                <th>Instalasi</th>
                                                <th>Ruangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_kunjungan_2">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab_menu_medis" class="tab-pane">
                            <div class="row">
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Tgl. Pendaftaran/<br>No. Pendaftaran</th>
                                                <th>Anamnesis</th>
                                                <th>Pemeriksaan Penunjang</th>
                                                <th>Pelayanan</th>
                                                <th>Diagnosis</th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_medis_1">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Tgl. Pendaftaran/<br>No. Pendaftaran</th>
                                                <th>Anamnesis</th>
                                                <th>Pemeriksaan Penunjang</th>
                                                <th>Pelayanan</th>
                                                <th>Diagnosa</th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_medis_2">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab_menu_tagihan" class="tab-pane">
                            <div class="row">
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Tgl. Pendaftaran/<br>No. Pendaftaran</th>
                                                <th>Pembayaran/<br>No. Pembayaran</th>
                                                <th>Ruangan Pelayanan</th>
                                                <th>Jumlah Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_tagihan_1">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Tgl. Pendaftaran/<br>No. Pendaftaran</th>
                                                <th>Pembayaran/<br>No. Pembayaran</th>
                                                <th>Ruangan Pelayanan</th>
                                                <th>Jumlah Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_tagihan_2">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning" id="alert_tab_info" hidden>
                    Terdapat <strong id="jml_tabel"></b> tabel yang akan dipindahkan datanya dari No. RM <strong id="rm_lama"></b> ke No. RM <strong id="rm_baru"></b>
                </div>
                <div class="alert alert-warning" id="alert_progress_info" hidden>
                    <strong id="jml_progress"></b> dari <strong id="jml_progress_total"></b> tabel yang dipindahkan.
                            <div class="progress" id="rm_progress_bar">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                </div>
                            </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Verifikasi', array(
                'title' => 'Simpan',
                'class' => 'btn btn-danger',
                'type' => 'button',
                'onclick' => 'verifikasiSubmit();',
                'disabled' => false,
            )) . CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('tips/gabungRM', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('_jsFunction', array(), true); ?>
<?php echo $this->renderPartial('_dialog', array(), true); ?>