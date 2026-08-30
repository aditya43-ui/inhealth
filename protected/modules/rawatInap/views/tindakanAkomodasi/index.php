<style>
    .cls_verif {
        background-color: yellow;
    }
</style>

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

$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);
$kelPegawaippds = PpdsM::model()->findByPk($pegawai->ppds_id);
if($kelPegawai != null){


 // if (!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && (!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP) || !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK) )) { 
    /* ?>

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
                                    <th>&nbsp;</th>
                                    <th>Tanggal Verifikasi Akomodasi</th>
                                    <th>Kode Akomodasi</th>
                                    <th>Uraian Akomodasi</th>

                                    <th>Jumlah</th>
                                    <!--<th rowspan="2">Tarif Satuan</th>-->
                                    <!--<th rowspan="2">Jumlah Tindakan</th>-->
                                    <th>Satuan<br>Akomodasi</th>
                                    <th>Tarif Satuan</th>
                                    <th>Total Tarif</th>
                                    <th>Validasi Akomodasi</th>
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
        <?php */ // } else { ?>

        <div class="formInputTab">
            <?php
            /*
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
            // */
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
                        <i class="entypo-credit-card"></i> Tabel <b>Akomodasi</b>
                    </div>
                    <div hidden class="panel-options" <?php //echo (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ) ? 'hidden' : ''; 
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
                                    <!--th>&nbsp;</th-->
                                    <th>Tanggal Verifikasi Akomodasi</th>
                                    <th>Kode Akomodasi</th>
                                    <th>Uraian Akomodasi</th>

                                    <th>Jumlah</th>
                                    <!--<th rowspan="2">Tarif Satuan</th>-->
                                    <!--<th rowspan="2">Jumlah Tindakan</th>-->
                                    <th>Satuan<br>Akomodasi</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Tarif Satuan</th>
                                    <th>Total Tarif</th>
                                    <th>Validasi Akomodasi</th>
                                </tr>
                            </thead>
                            <?php
                            
                            $trTindakan = "";
                            foreach ($modTindakans as $idx => $item) {
                                $trTindakan .= $this->renderPartial($this->path_view . '_rowTindakanPasien', array('modTindakan' => $item, 'modTindakans' => null, 'kelaspelayanan_id' => $item->kelaspelayanan_id, 'i' => $idx), true);

                            } 
                            echo $trTindakan;
                            ?>
                        </table>
                        <?php echo $form->errorSummary($modTindakan); ?>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'disabled'=>true)
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
                <?php /*
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
                ); */
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
        //========= Dialog buat daftar tindakan  =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDaftarTindakanPaket',
            'options' => array(
                'title' => 'Daftar Akomodasi',
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

?>

<?php // } ?>