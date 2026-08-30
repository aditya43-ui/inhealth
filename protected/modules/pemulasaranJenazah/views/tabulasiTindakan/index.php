<?php
$this->breadcrumbs = array(
    '',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<!--<legend class="rim2">Tindakan</legend>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjtindakan-pelayanan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#RJTindakanPelayananT_0_daftartindakanNama',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onSubmit' => 'return cekInput();'
    ),
)); ?>

<?php
$hide = '';
if(isset($_GET['lihat'])) {
    $hide = 'hide';
}
$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);
$kelPegawaippds = PpdsM::model()->findByPk($pegawai->ppds_id);
if ($kelPegawai != null) {


    if (!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && (!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP) || !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK))) { ?>

        <div class="formInputTab">


            <?php
            if (!empty($modViewTindakans)) {

                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'tabel-riwayattindakan',
                    'content' => array(
                        'content-detailtindakan' => array(
                            'header' => '<b>Tabel Riwayat Tindakan</b>',
                            'isi' =>
                            $this->renderPartial($this->path_view . '_listTindakanPasien2', array(
                                'modTindakans' => $modViewTindakans, 'modPendaftaran' => $modPendaftaran,
                                'modViewBmhp' => $modViewBmhp,
                                'removeButton' => true
                            ), true),
                            'active' => true,
                        ),
                    ),
                ));
            }
            ?>
            <p class="help-block">
                <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                <?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                ?></p>


            <?php
            // echo CHtml::hiddenField('tipepaket_id','',array());
            // echo CHtml::hiddenField('kelaspelayanan_id','',array());
            ?>
            <?php
            $kelaspelayanan_id = isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan_id : null;
            $penjamin_id = isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin_id : null;
            $dokter_id = isset($modPendaftaran->pegawai_id) ? $modPendaftaran->pegawai_id : null;
            echo CHtml::hiddenField('RJPendaftaranT_kelaspelayanan_id', $kelaspelayanan_id, array('value' => $modPendaftaran->kelaspelayanan_id));
            echo CHtml::hiddenField('RJPendaftaranT_penjamin_id', $penjamin_id, array('value' => $modPendaftaran->penjamin_id));
            echo CHtml::hiddenField('RJPendaftaranT_pegawai_id', $dokter_id, array('value' => $dokter_id)); ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Tindakan</b>
                    </div>
                    <div class="panel-options" <?php //echo (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ) ? 'hidden' : ''; 
                                                ?>>
                        <?php
                        //RND-9154
                        echo $form->dropDownList(
                            $modTindakan,
                            '[0]tipepaket_id',
                            Chtml::listData($modTindakan->getTipePaketItems($modPendaftaran->carabayar_id, $modPendaftaran->penjamin_id), 'tipepaket_id', 'tipepaket_nama'),
                            // array('style' => 'display: none'),	
                            array(
                                'class' => 'span3',
                                'style' => 'margin-top: 5px;',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                                'onchange' => 'loadTindakanPaket(this.value,"' . $modPendaftaran->kelaspelayanan_id . '","' . $modPendaftaran->kelompokumur_id . '",' . $modPendaftaran->pendaftaran_id . ')'
                            )
                        );

                        ?>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <div class="block-tabel">
                        <table class="items table table-bordered table-condensed" id="tblInputTindakan">
                            <thead>
                                <tr>
                                    <th rowspan="2">&nbsp;</th>
                                    <th>Kategori Tindakan</th>
                                    <th rowspan="2">Uraian Tindakan</th>

                                    <th rowspan="2">Jumlah</th>
                                    <!--<th rowspan="2">Tarif Satuan</th>-->
                                    <!--<th rowspan="2">Jumlah Tindakan</th>-->
                                    <th rowspan="2">Satuan<br>Tindakan</th>
                                    <th rowspan="2">Cyto </th>
                                    <th rowspan="2">Tarif Satuan</th>
                                    <th rowspan="2">Total Tarif</th>
                                </tr>
                                <tr>
                                    <th>Tanggal Tindakan</th>
                                </tr>
                            </thead>
                            <?php
                            $trTindakan = $this->renderPartial($this->path_view . '_rowTindakanPasien2', array('modTindakan' => $modTindakan, 'modTindakans' => $modTindakans, 'kelaspelayanan_id' => $modPendaftaran->kelaspelayanan_id), true);
                            echo $trTindakan;
                            ?>
                        </table>
                        <?php echo $form->errorSummary($modTindakan); ?>
                    </div>
                </div>
            </div>
            <!-- 
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Alat Medis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php //$this->renderPartial($this->path_view . '_formPemakaianBahan2', array()); 
                ?>
            </div>
        </div> -->

            <?php /*
	<div class="row">
			<?php $this->renderPartial($this->path_view.'_formPaketBmhp',array('modViewBmhp'=>$modViewBmhp, 'modTindakan'=>$modTindakan)); ?>
	</div>
     * 
     */ ?>
            <div class="form-actions">
                <?php // echo CHtml::htmlButton(
                // Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                // array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                //         ); 
                ?>
                <?php
                // echo CHtml::link(
                //     Yii::t(
                //         'mds',
                //         '{icon} Print',
                //         array('{icon}' => '<i class="entypo-print"></i>')
                //     ),
                //     'javascript:void(0);',
                //     array(
                //         'class' => 'btn btn-info',
                //         'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ");return false"
                //     )
                // );
                ?>
                <?php
                // echo CHtml::link(
                //     Yii::t(
                //         'mds',
                //         '{icon} Edukasi Transfusi',
                //         array('{icon}' => '<i class="' . MyIcon::getIcons('approve') . '"></i>')
                //     ),
                //     'javascript:void(0);',
                //     array(
                //         'class' => 'btn btn-primary',
                //         'onclick' => "$('#dialog-edukasi-transfusi').dialog('open');return false"
                //     )
                // );
                ?>
                <?php
                // $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                // $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                ?>

                <?php //echo CHtml::link('Test Update Stok', '#', array('onclick'=>'testUpdateStok(80,4);return false;','class'=>'btn')); 
                ?>
            </div>


            <?php $this->endWidget(); ?>

            <?php $this->renderPartial($this->path_view . '_dialogPemeriksa', array('modTindakan' => $modTindakan)); ?>
            <?php $this->renderPartial($this->path_view . '_dialogPemeriksaLengkap', array('modTindakan' => $modTindakan)); ?>
            <?php $this->renderPartial($this->path_view . '_dialogEdukasiTransfusi', array('modPendaftaran' => $modPendaftaran)); ?>

            <?php echo $this->renderPartial($this->path_view . '_jsFunction', array(
                'modTindakan' => $modTindakan,
                'modPendaftaran' => $modPendaftaran,
                'modJenisTarif' => $modJenisTarif,
            ), true); ?>

            <?php
            // Dinon aktifkan -> RND-7536
            ////========= Dialog buat daftar tindakan  =========================
            //$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            //    'id'=>'dialogDaftarTindakan',
            //    'options'=>array(
            //        'title'=>'Daftar Tindakan',
            //        'autoOpen'=>false,
            //        'modal'=>true,
            //        'width'=>800,
            //        'height'=>400,
            //        'resizable'=>false,
            //    ),
            //));
            //    //echo $modPendaftaran->kelaspelayanan_id;
            //    $this->renderPartial($this->path_view.'_daftarTindakan');
            //
            //$this->endWidget('zii.widgets.jui.CJuiDialog');
            //========= end daftar tindakan =============================
            ?>

            <?php
            $js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

JS;
            Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
            ?>
            <div style='display:none;'>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'name' => 'testingkktest',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'RJTindakanPelayananT_0_tgl_tindakan'
                    ),
                ));
                ?>
            </div>
        <?php } else { ?>

            <div class="formInputTab">
                <?php
                if (!empty($modViewTindakans)) {

                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'tabel-riwayattindakan',
                        'content' => array(
                            'content-detailtindakan' => array(
                                'header' => '<b>Tabel Riwayat Tindakan</b>',
                                'isi' =>
                                $this->renderPartial($this->path_view . '_listTindakanPasien', array(
                                    'modTindakans' => $modViewTindakans, 'modPendaftaran' => $modPendaftaran,
                                    'modViewBmhp' => $modViewBmhp,
                                    'removeButton' => true
                                ), true),
                                'active' => true,
                            ),
                        ),
                    ));
                }
                ?>
                <p class="help-block">
                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                    <?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                    ?></p>


                <?php
                // echo CHtml::hiddenField('tipepaket_id','',array());
                // echo CHtml::hiddenField('kelaspelayanan_id','',array());
                ?>
                <?php
                $kelaspelayanan_id = isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan_id : null;
                $penjamin_id = isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin_id : null;
                $dokter_id = isset($modPendaftaran->pegawai_id) ? $modPendaftaran->pegawai_id : null;
                echo CHtml::hiddenField('RJPendaftaranT_kelaspelayanan_id', $kelaspelayanan_id, array('value' => $modPendaftaran->kelaspelayanan_id));
                echo CHtml::hiddenField('RJPendaftaranT_penjamin_id', $penjamin_id, array('value' => $modPendaftaran->penjamin_id));
                echo CHtml::hiddenField('RJPendaftaranT_pegawai_id', $dokter_id, array('value' => $dokter_id)); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Tindakan</b>
                        </div>
                        <div class="panel-options" <?php //echo (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ) ? 'hidden' : ''; 
                                                    ?>>
                            <?php
                            //RND-9154
                            echo $form->dropDownList(
                                $modTindakan,
                                '[0]tipepaket_id',
                                Chtml::listData($modTindakan->getTipePaketItems($modPendaftaran->carabayar_id, $modPendaftaran->penjamin_id), 'tipepaket_id', 'tipepaket_nama'),
                                // array('style' => 'display: none'),	
                                array(
                                    'class' => 'span3',
                                    'style' => 'margin-top: 5px;',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                    'onchange' => 'loadTindakanPaket(this.value,"' . $modPendaftaran->kelaspelayanan_id . '","' . $modPendaftaran->kelompokumur_id . '",' . $modPendaftaran->pendaftaran_id . ')'
                                )
                            );

                            ?>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class="block-tabel">
                            <table class="items table table-bordered table-condensed" id="tblInputTindakan">
                                <thead>
                                    <tr>
                                        <th rowspan="2">
                                            <?php echo CHtml::checkBox('is_pilihsemua', true, array('onclick' => 'pilihSemua(this)', 'checked' => true, 'title' => 'Klik untuk pilih semua', 'rel' => 'tooltip')) ?>
                                        </th>
                                        <th colspan="2">Kategori Tindakan</th>
                                        <th rowspan="2">Uraian Tindakan 
                                            <span style="float: right;">
                                            <?php 
                                            echo CHtml::link("<i class='icon-edit' title='Klik untuk merubah dokter / perawat / bidan'></i>", '#', array('id' => 'btnAddDokter_0', 'onclick' => 'addDokterLengkap();return false;'));
                                            echo CHtml::hiddenField("is_checked", '0', array()); 
                                            ?> Ubah Dokter</span></th>
                                        <th rowspan="2">Jumlah</th>
                                        <!--<th rowspan="2">Tarif Satuan</th>-->
                                        <!--<th rowspan="2">Jumlah Tindakan</th>-->
                                        <th rowspan="2">Satuan<br>Tindakan</th>
                                        <th rowspan="2">Cyto </th>
                                        <th rowspan="2">Tarif Satuan</th>
                                        <th rowspan="2">Total Tarif</th>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Tindakan</th>
                                        <th>Kode Tindakan</th>
                                    </tr>
                                </thead>
                                <?php

                                $trTindakan = $this->renderPartial($this->path_view . '_rowTindakanPasien', array('modTindakan' => $modTindakan, 'modTindakans' => $modTindakans, 'kelaspelayanan_id' => $modPendaftaran->kelaspelayanan_id), true);
                                echo $trTindakan;
                                ?>
                            </table>
                            <?php echo $form->errorSummary($modTindakan); ?>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success" style="margin-top: 17px;">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Alat Medis</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial($this->path_view . '_formPemakaianBahan', array()); ?>
                    </div>
                </div>

                <?php /*
	<div class="row">
			<?php $this->renderPartial($this->path_view.'_formPaketBmhp',array('modViewBmhp'=>$modViewBmhp, 'modTindakan'=>$modTindakan)); ?>
	</div>
     * 
     */ ?>
                <div class="form-actions <?= $hide ?>">
                    <?php 
                    
                        if(Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GIZI) {
                            echo CHtml::htmlButton(
                                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                                array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'disabled' => $modPendaftaran->cekTindakLanjutIKF())
                            ); 
                        } else {
                            echo CHtml::htmlButton(
                                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                                array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                            ); 
                        }
                    ?>
                    <?php
                    echo CHtml::link(
                        Yii::t(
                            'mds',
                            '{icon} Print',
                            array('{icon}' => '<i class="entypo-print"></i>')
                        ),
                        'javascript:void(0);',
                        array(
                            'class' => 'btn btn-info',
                            'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ");return false"
                        )
                    );
                    echo  CHtml::link(
                        Yii::t(
                            'mds',
                            '{icon} Print Ulang',
                            array('{icon}' => '<i class="entypo-print"></i>')
                        ),
                        Yii::app()->controller->createUrl(Yii::app()->controller->id . "/printUlangTindakanDialog", array("pendaftaran_id" => $modPendaftaran->pendaftaran_id)),
                        array("title" => "Klik untuk mencetak ulang", "target" => "iframeCetakUlang", "onclick" => '$("#dialogCetakUlang").dialog("open");', "rel" => "tooltip", 'class' => 'btn btn-info')
                    );
                    ?>
                    <?php
                    echo CHtml::link(
                        Yii::t(
                            'mds',
                            '{icon} Edukasi Transfusi',
                            array('{icon}' => '<i class="' . MyIcon::getIcons('approve') . '"></i>')
                        ),
                        'javascript:void(0);',
                        array(
                            'class' => 'btn btn-primary',
                            'onclick' => "$('#dialog-edukasi-transfusi').dialog('open');return false"
                        )
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>

                    <?php //echo CHtml::link('Test Update Stok', '#', array('onclick'=>'testUpdateStok(80,4);return false;','class'=>'btn')); 
                    ?>
                </div>

            </div>

            <?php $this->endWidget(); ?>

            <?php $this->renderPartial($this->path_view . '_dialogPemeriksa', array('modTindakan' => $modTindakan)); ?>
            <?php $this->renderPartial($this->path_view . '_dialogPemeriksaLengkap', array('modTindakan' => $modTindakan)); ?>
            <?php $this->renderPartial($this->path_view . '_dialogEdukasiTransfusi', array('modPendaftaran' => $modPendaftaran)); ?>

            <?php echo $this->renderPartial($this->path_view . '_jsFunction', array(
                'modTindakan' => $modTindakan,
                'modPendaftaran' => $modPendaftaran,
                'modJenisTarif' => $modJenisTarif,
            ), true); ?>

            <?php
            // Dinon aktifkan -> RND-7536
            ////========= Dialog buat daftar tindakan  =========================
            //$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            //    'id'=>'dialogDaftarTindakan',
            //    'options'=>array(1    1   
            //        'title'=>'Daftar Tindakan',
            //        'autoOpen'=>false,
            //        'modal'=>true,
            //        'width'=>800,
            //        'height'=>400,
            //        'resizable'=>false,
            //    ),
            //));
            //    //echo $modPendaftaran->kelaspelayanan_id;
            //    $this->renderPartial($this->path_view.'_daftarTindakan');
            //
            //$this->endWidget('zii.widgets.jui.CJuiDialog');
            //========= end daftar tindakan =============================
            ?>



            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                'id' => 'dialogCetakUlang',
                'options' => array(
                    'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Cetak Ulang</span>',
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 500,
                    'height' => 400,
                    'resizable' => true
                ),
            ));
            ?>
            <iframe name='iframeCetakUlang' width="100%" height="100%"></iframe>
            <?php $this->endWidget(); ?>


            <?php
            $js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

JS;
            Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
            ?>
            <div style='display:none;'>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'name' => 'testingkktest',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'RJTindakanPelayananT_0_tgl_tindakan'
                    ),
                ));
                ?>
            </div>

        <?php

    }


    /* Dinon aktifkan -> RND-7536
 * PAKET LUAR */
    //$this->beginWidget('zii.widgets.jui.CJuiDialog',
    //    array(
    //        'id'=>'dialogTindakanPaketLuar',
    //        'options'=>array(
    //            'title'=>'Daftar Tindakan',
    //            'autoOpen'=>false,
    //            'modal'=>true,
    //            'width'=>800,
    //            'height'=>500,
    //            'resizable'=>false,
    //        ),
    //    )
    //);
    //
    //$tindakanPaketLuar = new PaketpelayananV;
    //if(Yii::app()->user->getState('tindakanruangan'))
    //    $tindakanPaketLuar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //
    //if(Yii::app()->user->getState('tindakankelas'))
    //    //$tindakanPaketLuar->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    //    $tindakanPaketLuar->kelaspelayanan_id = 2;
    //
    //$tindakanPaketLuar->tipepaket_id = Params::TIPEPAKET_ID_LUARPAKET;
    //
    //if (isset($_GET['PaketpelayananV']))
    //{
    //    $tindakanPaketLuar->attributes = $_GET['PaketpelayananV'];
    //}
    //
    //$this->widget('ext.bootstrap.widgets.BootGridView',
    //    array(
    //        'id'=>'tindakanLuarPaket',
    //        'dataProvider'=>$tindakanPaketLuar->search(),
    //        'filter'=>$tindakanPaketLuar,
    //        'template'=>"{summary}\n{items}\n{pager}",
    //        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    //        'columns'=>array(
    //            array(
    //                'header'=>'Pilih',
    //                'type'=>'raw',
    //                'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small","id" => "selectObat","onClick" => "setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);return false;"))',
    //            ),
    //            'kategoritindakan_nama',
    //            array(
    //                'header'=>'Nama Tindakan',
    //                'name'=>'daftartindakan_nama',
    //            ),
    //        ),
    //        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    //    )
    //);
    //
    //$this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>

    <?php } else { ?>
        <?php
        if (!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && (!empty($kelPegawaippds->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP) || !empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK))) { ?>

            <div class="formInputTab">


                <?php
                if (!empty($modViewTindakans)) {

                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'tabel-riwayattindakan',
                        'content' => array(
                            'content-detailtindakan' => array(
                                'header' => '<b>Tabel Riwayat Tindakan</b>',
                                'isi' =>
                                $this->renderPartial($this->path_view . '_listTindakanPasien2', array(
                                    'modTindakans' => $modViewTindakans, 'modPendaftaran' => $modPendaftaran,
                                    'modViewBmhp' => $modViewBmhp,
                                    'removeButton' => true
                                ), true),
                                'active' => true,
                            ),
                        ),
                    ));
                }
                ?>
                <p class="help-block">
                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                    <?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                    ?></p>


                <?php
                // echo CHtml::hiddenField('tipepaket_id','',array());
                // echo CHtml::hiddenField('kelaspelayanan_id','',array());
                ?>
                <?php
                $kelaspelayanan_id = isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan_id : null;
                $penjamin_id = isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin_id : null;
                $dokter_id = isset($modPendaftaran->pegawai_id) ? $modPendaftaran->pegawai_id : null;
                echo CHtml::hiddenField('RJPendaftaranT_kelaspelayanan_id', $kelaspelayanan_id, array('value' => $modPendaftaran->kelaspelayanan_id));
                echo CHtml::hiddenField('RJPendaftaranT_penjamin_id', $penjamin_id, array('value' => $modPendaftaran->penjamin_id));
                echo CHtml::hiddenField('RJPendaftaranT_pegawai_id', $dokter_id, array('value' => $dokter_id)); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Tindakan</b>
                        </div>
                        <div class="panel-options" <?php //echo (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ) ? 'hidden' : ''; 
                                                    ?>>
                            <?php
                            //RND-9154
                            echo $form->dropDownList(
                                $modTindakan,
                                '[0]tipepaket_id',
                                Chtml::listData($modTindakan->getTipePaketItems($modPendaftaran->carabayar_id, $modPendaftaran->penjamin_id), 'tipepaket_id', 'tipepaket_nama'),
                                // array('style' => 'display: none'),	
                                array(
                                    'class' => 'span3',
                                    'style' => 'margin-top: 5px;',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                    'onchange' => 'loadTindakanPaket(this.value,"' . $modPendaftaran->kelaspelayanan_id . '","' . $modPendaftaran->kelompokumur_id . '",' . $modPendaftaran->pendaftaran_id . ')'
                                )
                            );

                            ?>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class="block-tabel">
                            <table class="items table table-bordered table-condensed" id="tblInputTindakan">
                                <thead>
                                    <tr>
                                        <th rowspan="2">&nbsp;</th>
                                        <th>Kategori Tindakan</th>
                                        <th rowspan="2">Uraian Tindakan</th>

                                        <th rowspan="2">Jumlah</th>
                                        <!--<th rowspan="2">Tarif Satuan</th>-->
                                        <!--<th rowspan="2">Jumlah Tindakan</th>-->
                                        <th rowspan="2">Satuan<br>Tindakan</th>
                                        <th rowspan="2">Cyto </th>
                                        <th rowspan="2">Tarif Satuan</th>
                                        <th rowspan="2">Total Tarif</th>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Tindakan</th>
                                    </tr>
                                </thead>
                                <?php
                                $trTindakan = $this->renderPartial($this->path_view . '_rowTindakanPasien2', array('modTindakan' => $modTindakan, 'modTindakans' => $modTindakans, 'kelaspelayanan_id' => $modPendaftaran->kelaspelayanan_id), true);
                                echo $trTindakan;
                                ?>
                            </table>
                            <?php echo $form->errorSummary($modTindakan); ?>
                        </div>
                    </div>
                </div>
                <!-- 
    <div class="panel panel-success" style="margin-top: 17px;">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Alat Medis</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <?php //$this->renderPartial($this->path_view . '_formPemakaianBahan2', array()); 
            ?>
        </div>
    </div> -->

                <?php /*
<div class="row">
        <?php $this->renderPartial($this->path_view.'_formPaketBmhp',array('modViewBmhp'=>$modViewBmhp, 'modTindakan'=>$modTindakan)); ?>
</div>
 * 
 */ ?>
                <div class="form-actions">
                    <?php // echo CHtml::htmlButton(
                    // Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    // array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                    //         ); 
                    ?>
                    <?php
                    // echo CHtml::link(
                    //     Yii::t(
                    //         'mds',
                    //         '{icon} Print',
                    //         array('{icon}' => '<i class="entypo-print"></i>')
                    //     ),
                    //     'javascript:void(0);',
                    //     array(
                    //         'class' => 'btn btn-info',
                    //         'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ");return false"
                    //     )
                    // );
                    ?>
                    <?php
                    // echo CHtml::link(
                    //     Yii::t(
                    //         'mds',
                    //         '{icon} Edukasi Transfusi',
                    //         array('{icon}' => '<i class="' . MyIcon::getIcons('approve') . '"></i>')
                    //     ),
                    //     'javascript:void(0);',
                    //     array(
                    //         'class' => 'btn btn-primary',
                    //         'onclick' => "$('#dialog-edukasi-transfusi').dialog('open');return false"
                    //     )
                    // );
                    ?>
                    <?php
                    // $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                    // $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>

                    <?php //echo CHtml::link('Test Update Stok', '#', array('onclick'=>'testUpdateStok(80,4);return false;','class'=>'btn')); 
                    ?>
                </div>


                <?php $this->endWidget(); ?>

                <?php $this->renderPartial($this->path_view . '_dialogPemeriksa', array('modTindakan' => $modTindakan)); ?>
                <?php $this->renderPartial($this->path_view . '_dialogPemeriksaLengkap', array('modTindakan' => $modTindakan)); ?>
                <?php $this->renderPartial($this->path_view . '_dialogEdukasiTransfusi', array('modPendaftaran' => $modPendaftaran)); ?>

                <?php echo $this->renderPartial($this->path_view . '_jsFunction', array(
                    'modTindakan' => $modTindakan,
                    'modPendaftaran' => $modPendaftaran,
                    'modJenisTarif' => $modJenisTarif,
                ), true); ?>

                <?php
                // Dinon aktifkan -> RND-7536
                ////========= Dialog buat daftar tindakan  =========================
                //$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                //    'id'=>'dialogDaftarTindakan',
                //    'options'=>array(
                //        'title'=>'Daftar Tindakan',
                //        'autoOpen'=>false,
                //        'modal'=>true,
                //        'width'=>800,
                //        'height'=>400,
                //        'resizable'=>false,
                //    ),
                //));
                //    //echo $modPendaftaran->kelaspelayanan_id;
                //    $this->renderPartial($this->path_view.'_daftarTindakan');
                //
                //$this->endWidget('zii.widgets.jui.CJuiDialog');
                //========= end daftar tindakan =============================
                ?>

                <?php
                $js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
var berubah = $('#berubah').val();
if(berubah=='Ya'){
    myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
        if(r){
            $('#url').val(obj);
            $('#btn_simpan').click();
        }
    });
}      
}

JS;
                Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
                ?>
                <div style='display:none;'>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'testingkktest',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'RJTindakanPelayananT_0_tgl_tindakan'
                        ),
                    ));
                    ?>
                </div>
            <?php } else { ?>

                <div class="formInputTab">
                    <?php
                    if (!empty($modViewTindakans)) {

                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'tabel-riwayattindakan',
                            'content' => array(
                                'content-detailtindakan' => array(
                                    'header' => '<b>Tabel Riwayat Tindakan</b>',
                                    'isi' =>
                                    $this->renderPartial($this->path_view . '_listTindakanPasien', array(
                                        'modTindakans' => $modViewTindakans, 'modPendaftaran' => $modPendaftaran,
                                        'modViewBmhp' => $modViewBmhp,
                                        'removeButton' => true
                                    ), true),
                                    'active' => true,
                                ),
                            ),
                        ));
                    }
                    ?>
                    <p class="help-block">
                        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                        <?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                        ?></p>


                    <?php
                    // echo CHtml::hiddenField('tipepaket_id','',array());
                    // echo CHtml::hiddenField('kelaspelayanan_id','',array());
                    ?>
                    <?php
                    $kelaspelayanan_id = isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan_id : null;
                    $penjamin_id = isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin_id : null;
                    $dokter_id = isset($modPendaftaran->pegawai_id) ? $modPendaftaran->pegawai_id : null;
                    echo CHtml::hiddenField('RJPendaftaranT_kelaspelayanan_id', $kelaspelayanan_id, array('value' => $modPendaftaran->kelaspelayanan_id));
                    echo CHtml::hiddenField('RJPendaftaranT_penjamin_id', $penjamin_id, array('value' => $modPendaftaran->penjamin_id));
                    echo CHtml::hiddenField('RJPendaftaranT_pegawai_id', $dokter_id, array('value' => $dokter_id)); ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Tindakan</b>
                            </div>
                            <div class="panel-options" <?php //echo (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ) ? 'hidden' : ''; 
                                                        ?>>
                                <?php
                                //RND-9154
                                echo $form->dropDownList(
                                    $modTindakan,
                                    '[0]tipepaket_id',
                                    Chtml::listData($modTindakan->getTipePaketItems($modPendaftaran->carabayar_id, $modPendaftaran->penjamin_id), 'tipepaket_id', 'tipepaket_nama'),
                                    // array('style' => 'display: none'),	
                                    array(
                                        'class' => 'span3',
                                        'style' => 'margin-top: 5px;',
                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                        'onchange' => 'loadTindakanPaket(this.value,"' . $modPendaftaran->kelaspelayanan_id . '","' . $modPendaftaran->kelompokumur_id . '",' . $modPendaftaran->pendaftaran_id . ')'
                                    )
                                );

                                ?>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <div class="block-tabel">
                                <table class="items table table-bordered table-condensed" id="tblInputTindakan">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">&nbsp;</th>
                                            <th>Kategori Tindakan</th>
                                            <th rowspan="2">Uraian Tindakan</th>

                                            <th rowspan="2">Jumlah</th>
                                            <!--<th rowspan="2">Tarif Satuan</th>-->
                                            <!--<th rowspan="2">Jumlah Tindakan</th>-->
                                            <th rowspan="2">Satuan<br>Tindakan</th>
                                            <th rowspan="2">Cyto </th>
                                            <th rowspan="2">Tarif Satuan</th>
                                            <th rowspan="2">Total Tarif</th>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Tindakan</th>
                                        </tr>
                                    </thead>
                                    <?php

                                    $trTindakan = $this->renderPartial($this->path_view . '_rowTindakanPasien', array('modTindakan' => $modTindakan, 'modTindakans' => $modTindakans, 'kelaspelayanan_id' => $modPendaftaran->kelaspelayanan_id), true);
                                    echo $trTindakan;
                                    ?>
                                </table>
                                <?php echo $form->errorSummary($modTindakan); ?>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success" style="margin-top: 17px;">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Alat Medis</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <?php $this->renderPartial($this->path_view . '_formPemakaianBahan', array()); ?>
                        </div>
                    </div>

                    <?php /*
<div class="row">
        <?php $this->renderPartial($this->path_view.'_formPaketBmhp',array('modViewBmhp'=>$modViewBmhp, 'modTindakan'=>$modTindakan)); ?>
</div>
 * 
 */ ?>
                    <div class="form-actions <?= $hide ?>">
                        <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'disabled' => $modPendaftaran->isPasienPulangAtauTindakLanjut($_GET['konsulpoli_id'] ?? null))
                        ); ?>
                        <?php
                        echo CHtml::link(
                            Yii::t(
                                'mds',
                                '{icon} Print',
                                array('{icon}' => '<i class="entypo-print"></i>')
                            ),
                            'javascript:void(0);',
                            array(
                                'class' => 'btn btn-info',
                                'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ");return false"
                            )
                        );
                        echo  CHtml::link(
                            Yii::t(
                                'mds',
                                '{icon} Print Ulang',
                                array('{icon}' => '<i class="entypo-print"></i>')
                            ),
                            Yii::app()->controller->createUrl(Yii::app()->controller->id . "/printUlangTindakanDialog", array("pendaftaran_id" => $modPendaftaran->pendaftaran_id)),
                            array("title" => "Klik untuk mencetak ulang", "target" => "iframeCetakUlang", "onclick" => '$("#dialogCetakUlang").dialog("open");', "rel" => "tooltip", 'class' => 'btn btn-info')
                        );
                        ?>
                        <?php
                        echo CHtml::link(
                            Yii::t(
                                'mds',
                                '{icon} Edukasi Transfusi',
                                array('{icon}' => '<i class="' . MyIcon::getIcons('approve') . '"></i>')
                            ),
                            'javascript:void(0);',
                            array(
                                'class' => 'btn btn-primary',
                                'onclick' => "$('#dialog-edukasi-transfusi').dialog('open');return false"
                            )
                        );
                        ?>
                        <?php
                        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                        ?>

                        <?php //echo CHtml::link('Test Update Stok', '#', array('onclick'=>'testUpdateStok(80,4);return false;','class'=>'btn')); 
                        ?>
                    </div>

                </div>

                <?php $this->endWidget(); ?>

                <?php $this->renderPartial($this->path_view . '_dialogPemeriksa', array('modTindakan' => $modTindakan)); ?>
                <?php $this->renderPartial($this->path_view . '_dialogPemeriksaLengkap', array('modTindakan' => $modTindakan)); ?>
                <?php $this->renderPartial($this->path_view . '_dialogEdukasiTransfusi', array('modPendaftaran' => $modPendaftaran)); ?>

                <?php echo $this->renderPartial($this->path_view . '_jsFunction', array(
                    'modTindakan' => $modTindakan,
                    'modPendaftaran' => $modPendaftaran,
                    'modJenisTarif' => $modJenisTarif,
                ), true); ?>

                <?php
                // Dinon aktifkan -> RND-7536
                ////========= Dialog buat daftar tindakan  =========================
                //$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                //    'id'=>'dialogDaftarTindakan',
                //    'options'=>array(
                //        'title'=>'Daftar Tindakan',
                //        'autoOpen'=>false,
                //        'modal'=>true,
                //        'width'=>800,
                //        'height'=>400,
                //        'resizable'=>false,
                //    ),
                //));
                //    //echo $modPendaftaran->kelaspelayanan_id;
                //    $this->renderPartial($this->path_view.'_daftarTindakan');
                //
                //$this->endWidget('zii.widgets.jui.CJuiDialog');
                //========= end daftar tindakan =============================
                ?>



                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                    'id' => 'dialogCetakUlang',
                    'options' => array(
                        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Cetak Ulang</span>',
                        'autoOpen' => false,
                        'modal' => true,
                        'width' => 500,
                        'height' => 400,
                        'resizable' => true
                    ),
                ));
                ?>
                <iframe name='iframeCetakUlang' width="100%" height="100%"></iframe>
                <?php $this->endWidget(); ?>


                <?php
                $js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
var berubah = $('#berubah').val();
if(berubah=='Ya'){
    myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
        if(r){
            $('#url').val(obj);
            $('#btn_simpan').click();
        }
    });
}      
}

JS;
                Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
                ?>
                <div style='display:none;'>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'testingkktest',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'RJTindakanPelayananT_0_tgl_tindakan'
                        ),
                    ));
                    ?>
                </div>

            <?php

        }


        /* Dinon aktifkan -> RND-7536
* PAKET LUAR */
        //$this->beginWidget('zii.widgets.jui.CJuiDialog',
        //    array(
        //        'id'=>'dialogTindakanPaketLuar',
        //        'options'=>array(
        //            'title'=>'Daftar Tindakan',
        //            'autoOpen'=>false,
        //            'modal'=>true,
        //            'width'=>800,
        //            'height'=>500,
        //            'resizable'=>false,
        //        ),
        //    )
        //);
        //
        //$tindakanPaketLuar = new PaketpelayananV;
        //if(Yii::app()->user->getState('tindakanruangan'))
        //    $tindakanPaketLuar->ruangan_id = Yii::app()->user->getState('ruangan_id');
        //
        //if(Yii::app()->user->getState('tindakankelas'))
        //    //$tindakanPaketLuar->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        //    $tindakanPaketLuar->kelaspelayanan_id = 2;
        //
        //$tindakanPaketLuar->tipepaket_id = Params::TIPEPAKET_ID_LUARPAKET;
        //
        //if (isset($_GET['PaketpelayananV']))
        //{
        //    $tindakanPaketLuar->attributes = $_GET['PaketpelayananV'];
        //}
        //
        //$this->widget('ext.bootstrap.widgets.BootGridView',
        //    array(
        //        'id'=>'tindakanLuarPaket',
        //        'dataProvider'=>$tindakanPaketLuar->search(),
        //        'filter'=>$tindakanPaketLuar,
        //        'template'=>"{summary}\n{items}\n{pager}",
        //        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        //        'columns'=>array(
        //            array(
        //                'header'=>'Pilih',
        //                'type'=>'raw',
        //                'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small","id" => "selectObat","onClick" => "setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);return false;"))',
        //            ),
        //            'kategoritindakan_nama',
        //            array(
        //                'header'=>'Nama Tindakan',
        //                'name'=>'daftartindakan_nama',
        //            ),
        //        ),
        //        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        //    )
        //);
        //
        //$this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
        <?php } ?>
        <?php
        //========= Dialog buat daftar tindakan  =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDaftarTindakanPaket',
            'options' => array(
                'title' => 'Daftar Tindakan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 800,
                'height' => 440,
                'resizable' => false,
            ),
        ));

        echo '<div id="tableDaftarTindakanPaket"></div>';
        //echo $modPendaftaran->kelaspelayanan_id;
        $this->renderPartial($this->path_view . '_daftarTindakanPaket');

        $this->endWidget('zii.widgets.jui.CJuiDialog');
        //========= end daftar tindakan =============================
        ?>



        <?php
        /* Dinon aktifkan -> RND-7536
 * NON PAKET */
        //$this->beginWidget('zii.widgets.jui.CJuiDialog',
        //    array(
        //        'id'=>'dialogTindakanNonPaket',
        //        'options'=>array(
        //            'title'=>'Daftar Tindakan',
        //            'autoOpen'=>false,
        //            'modal'=>true,
        //            'width'=>800,
        //            'height'=>500,
        //            'resizable'=>false,
        //        ),
        //    )
        //);
        //
        //if(Yii::app()->user->getState('tindakanruangan'))
        //{
        //    $tindakanPaketLuar = new TariftindakanperdaruanganV;
        //    $tindakanPaketLuar->ruangan_id = Yii::app()->user->getState('ruangan_id');
        //} else {
        //    $tindakanPaketLuar = new TariftindakanperdaV;
        //}
        //
        //if(Yii::app()->user->getState('tindakankelas'))
        //    $tindakanPaketLuar->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        //
        //if (isset($_GET['TariftindakanperdaruanganV']))
        //{
        //    $tindakanPaketLuar->attributes = $_GET['TariftindakanperdaruanganV'];
        //}
        //
        //$this->widget('ext.bootstrap.widgets.BootGridView',
        //    array(
        //        'id'=>'tindakanLuarPaket',
        //        'dataProvider'=>$tindakanPaketLuar->search(),
        //        'filter'=>$tindakanPaketLuar,
        //        'template'=>"{summary}\n{items}\n{pager}",
        //        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        //        'columns'=>array(
        //            array(
        //                'header'=>'Pilih',
        //                'type'=>'raw',
        //                'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small","id" => "selectObat","onClick" => "setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);return false;"))',
        //            ),
        //            'kategoritindakan_nama',
        //            array(
        //                'header'=>'Nama Tindakan',
        //                'name'=>'daftartindakan_nama',
        //            ),
        //        ),
        //        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        //    )
        //);
        //
        //$this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>