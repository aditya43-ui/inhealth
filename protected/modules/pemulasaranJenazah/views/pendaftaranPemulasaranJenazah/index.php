<?php $linkHalaman = CustomFunction::getUrlByMenuID(2479); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
?>
<?php
$this->breadcrumbs = array(
    'Pendaftaran Pemulasaran Jenazah',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class='panel panel-gradient'>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pendaftaran <b>Pemulasaran Jenazah</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pendaftaran_t_form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Jenazah berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien Baru</b> </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view_jenazah . '_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien)); ?>
                <div class="col-sm-6">
                    <?php echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'form-pjpasien',
                        'content' => array(
                            'content-pjpasien' => array(
                                'header' => '<b>Penanggung Jawab Jenazah</b>',
                                'isi' => $this->renderPartial($this->path_view . '_formPenanggungJawabPasien', array(
                                    'form' => $form,
                                    'modPenanggungJawab' => $modPenanggungJawab,
                                ), true),
                                'active' => false,
                            ),
                        ),
                    )); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-users"></i> Data <b>Kunjungan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div id="form-pemeriksaan">
                        <?php echo $this->renderPartial($this->path_view_jenazah . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modAsuransiPasien' => $modAsuransiPasien, 'modPegawai' => $modPegawai,)); ?>
                        <?php echo $this->renderPartial($this->path_view_jenazah . '_formPenunjang', array('form' => $form, 'model' => $model, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'dataTindakans' => $dataTindakans,)); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->hiddenField($model, 'is_pasienrujukan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'form-rujukan',
                        'content' => array(
                            'content-rujukan' => array(
                                'header' => '<b>Rujukan</b>',
                                'isi' => $this->renderPartial($this->path_view . '_formRujukan', array(
                                    'form' => $form,
                                    'model' => $model,
                                    'modRujukan' => $modRujukan,
                                ), true),
                                'active' => $model->is_pasienrujukan,
                            ),
                        ),
                    )); ?>
                    <?php
                    if (Yii::app()->user->getState('issmsgateway')) {
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-smsgateway',
                            'content' => array(
                                'content-smsgateway' => array(
                                    'header' => '<b>Kirim SMS</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formSms', array('form' => $form, 'modSmsgateway' => $modSmsgateway), true),
                                    'active' => true,
                                ),
                            ),
                        ));
                    }
                    ?>
                    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'form-karcis',
                        'content' => array(
                            'content-karcis' => array(
                                'header' => '<b>Karcis Pemulasaran Jenazah</b>',
                                'isi' => '<div id="content-karcis-html">'
                                    //                                        .$this->renderPartial($this->path_view.'_formKarcis',array(
                                    //                                                'form'=>$form,
                                    //                                                'model'=>$model,
                                    //                                                'modKarcis'=>$modKarcis,
                                    //                                                ),true)
                                    . '</div>',
                                'active' => $modPasienMasukPenunjang->is_adakarcis,
                            ),
                        ),
                    )); ?>
                    <!--di Comment Karena Tidak Di Gunakan-->
                    <?php // $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    //                        'id'=>'form-riwayatpasien',
                    //                        'content'=>array(
                    //                            'content-riwayatpasien'=>array(
                    //                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat kunjungan pasien')).'<b>Riwayat Kunjungan Jenazah</b>',
                    //                                'isi'=>$this->renderPartial($this->path_view.'_tableRiwayatPasien',array(
                    //                                        'form'=>$form,
                    //                                        'modPasien'=>$modPasien,
                    //                                        ),true),
                    //                                'active'=>true,
                    //                            ),   
                    //                        ),
                    //                )); 
                    ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view_jenazah . '_tablePendaftaranTerakhir', array()); ?>
        <div class="form-actions">
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                ); //jika tanpa verifikasi >> formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('Index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus('$model->pendaftaran_id');return false", 'disabled' => FALSE));
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranRadiologi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-verifikasi',
    'options' => array(
        'title' => 'Verifikasi Pendaftaran',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo '<div class="dialog-content"></div>';
?>
<div class="col-sm-12 clear">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); $("#pendaftaran_t_form").submit();')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAsuransi',
    'options' => array(
        'title' => 'Pencarian Asuransi Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
$modCariAsuransiPasien = new PJAsuransipasienM('searchDialog');
$modCariAsuransiPasien->unsetAttributes();
if (isset($_GET['PJAsuransipasienM'])) {
    $modCariAsuransiPasien->attributes = $_GET['PJAsuransipasienM'];
    isset($_GET['PJAsuransipasienM']['pasien_id']) ? $modCariAsuransiPasien->pasien_id = $_GET['ROAsuransipasienM']['pasien_id'] : '';
    isset($_GET['PJAsuransipasienM']['penjamin_id']) ? $modCariAsuransiPasien->penjamin_id = $_GET['ROAsuransipasienM']['penjamin_id'] : '';
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'asuransi-m-grid',
    'dataProvider' => $modCariAsuransiPasien->searchDialog(),
    'filter' => $modCariAsuransiPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectAsuransi",
                                        "onClick" => "
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'nopeserta') . '\").val(\"$data->nopeserta\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
                                            setAsuransiLama()
                                            $(\"#dialogAsuransi\").dialog(\"close\");
                                        "))',
        ),
        'nokartuasuransi',
        'nopeserta',
        array(
            'header' => 'Nama Pemilik Asuransi',
            'value' => '$data->namapemilikasuransi',
            'filter' => CHtml::activeHiddenField($modCariAsuransiPasien, 'pasien_id', array('readonly' => true)) . "" . CHtml::activeHiddenField($modCariAsuransiPasien, 'penjamin_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariAsuransiPasien, 'namapemilikasuransi', array()),
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        'namaperusahaan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array(
    'modAsuransiPasienDepartemen'  => $modAsuransiPasienDepartemen,
    'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modPegawai' => $modPegawai, 'model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modAsuransiPasien' => $modAsuransiPasien
)); ?>
<?php $this->renderPartial($this->path_view_jenazah . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modAsuransiPasien' => $modAsuransiPasien)); ?>