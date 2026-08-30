<?php
$this->breadcrumbs = array(
    'Informasi Daftar Pasien' => Yii::app()->request->getUrlReferrer(),
    'Pasien Radiologi
',
);
$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Pemeriksaaan Radiologi', 'icon' => 'folder-open', 'url' => array('Admin'))) :  '';
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<!--div class="white-container"-->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
?>
<style>

.sudah_bayar td {
    background-color: lime !important;
}

</style>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemeriksaanradiologi-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return cekValidasi(this);'),
    'focus' => '#no_pendaftaran',
)); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan <b>Pasien Radiologi</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                            </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (isset($_GET['sukses'])) {
                            Yii::app()->user->setFlash('success', "Data pemeriksaan pasien radiologi berhasil disimpan!");
                            $this->widget('bootstrap.widgets.BootAlert');
                        }
                        ?>
                        <fieldset class="" id="form-datakunjungan">
                            <div class="row">
                                <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                            </div>
                        </fieldset>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-file"></i> Daftar Pemeriksaan Radiologi
                                </div>
                            </div>
                            <div class="panel-body">
                                <!--<fieldset class="">
									<div id='content-pemeriksaan-lab'>-->
                                <div id="form-masukpenunjang">
                                    <?php
                                    //$this->renderPartial($this->path_view_pendaftaran.'_formCariPemeriksaan',array(
                                    //	'modPemeriksaanRad'=>$modPemeriksaanRad,                                        
                                    //)); 
                                    $this->renderPartial($this->path_view_pendaftaran . '_formDialogTindakan', array(
                                        'modPemeriksaanRad' => $modPemeriksaanRad,        'modRujukKeluar' => $modRujukKeluar,
                                    ));
                                    ?>
                                    <!--<div class='checklists'></div>-->
                                </div>
                                <!--</div>
								</fieldset>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan Radiologi</b>
                                </div>
                            </div>
                            <div class="panel-body">
                                <fieldset class="box2">
                                    <div id="form-masukpenunjang">
                                        <?php echo $this->renderPartial('_formUbahMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <?php /*
						<div class="panel panel-success">
							<div class="panel-heading">
								<div class="panel-title">Rujukan Keluar <?php echo CHtml::htmlButton("<i class='icon icon-white icon-plus'></i>", array('onclick' => 'addRowRujukan(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk rujukan keluar', 'class' => 'btn btn-primary')); ?></div>
							</div>
							<div class="panel-body">
								<div id="rujukanKeluar">    
									<table width="100%" id="table-rujukankeluar">      
										<tbody>
										<?php
											$modRujukKeluar = PemeriksaankeluarT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id),array('order'=>'tindakanpelayanan_id ASC'));

											if (count((array)$modRujukKeluar)>0){
												foreach ($modRujukKeluar as $i => $val){											
													$this->renderPartial("_formGetRujukan",array('form'=>$form, 'modRujukKeluar'=>$val, 'i'=>$i ,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang));
												}
											}else{
												$i = 0;
												$modRujukKeluar = new PemeriksaankeluarT();
												$this->renderPartial("_formGetRujukan",array('form'=>$form, 'modRujukKeluar'=>$modRujukKeluar, 'i'=>$i ,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang));
											}

										?>  
										</tbody>
									</table>        	        
								</div>
							</div>
						</div>
                         * 
                         */ ?>
                    </div>
                </div><br>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div id="form-tindakanpemeriksaan">
                            <table class="table table-responsive table-bordered table-condensed table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th <?php echo Params::HIDDEN_HARGA ?>>Tarif Tindakan</th>
                                    <th <?php echo Params::HIDDEN_HARGA ?>>Total Tarif</th>
                                    <th>Rujuk Keluar</th>
                                    <th>Refund</th>
                                    <th>Batal</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Resgistrasi</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <!--fieldset class="box2"-->
                        <div id="form-tindakanpemeriksaan-registrasi">
                            <table class="table table-bordered table-condensed table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Refund</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" style="font-weight: bold; text-align: right;"></td>
                                        <td>
                                            <?php //echo CHtml::textField('totaltarifregis', 0, array('class'=>'span2 integer', 'readonly'=>true)) ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    
                                </tfoot>
                            </table>
                        </div>
                        <!--</fieldset>-->
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    // if (!isset($_GET['sukses'])) {
                    //     echo CHtml::htmlButton(
                    //         Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    //         array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
                    //     );
                    // } else {
                    //     echo CHtml::htmlButton(
                    //         Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    //         array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
                    //     );
                    // }
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
                    );
                    if (!isset($_GET['frame'])) {
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/index'),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                            )
                        );
                    }

                    echo CHtml::link(Yii::t('mds', '{icon} Print Nota Tindakan', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
                    echo CHtml::link(Yii::t('mds', '{icon} Print Permintaan', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false"));
                    $content = $this->renderPartial('tips/tipsPemeriksaanPasienRadiologi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$modRujukKeluar = new PemeriksaankeluarT();
$this->renderPartial('_jsFunctions', array('form' => $form, 'modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan, 'modRujukKeluar' => $modRujukKeluar, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
<?php $this->endWidget(); ?>


<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailRujuk',
    'options' => array(
        'title' => 'Detail Rujukan Keluar',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));

?>
<iframe id="frameDetailRujuk" name="frameDetailRujuk" style="border: none; width: 100%; height: 350px;"></iframe>
<?php

$this->endWidget();
////======= end pendaftaran dialog =============
?>



<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRujukPasien',
    'options' => array(
        'title' => 'Rujukan Keluar',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));

echo $this->renderPartial('_formRujukKeluar', array(
    //'form' => $form,
    'i' => 0,
    'modRujukKeluar' => $modRujukKeluar,
    'modPasienMasukPenunjang' => $modPasienMasukPenunjang
), true);
$this->endWidget();
////======= end pendaftaran dialog =============
?>