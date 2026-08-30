<?php
$this->breadcrumbs = array(
    'Rujukan Keluar',
);
$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">RUJUKAN KE LUAR</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));
$visibility = isset($_GET['lihat']) ? 'hidden' : '';
?>

<style>
    tr td .add-on {
        margin: 0 !important;
    }
</style>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-dirujuk-keluar-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($modRujukanKeluar, 'nosuratrujukan'),
)); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Rujukan Ke Luar
        </div>
    </div>
    <div class="panel-body">
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-riwayat',
            'content' => array(
                'content-detailpasien' => array(
                    'header' => '<b>Riwayat Rujukan Keluar</b>',
                    'isi' => $this->renderPartial('_listRujukanKeluar', array(
                        'form' => $form,
                        'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar
                    ), true),
                    'active' => true,
                ),
            ),
        )); ?>

        <div class="text-right" style="padding-bottom: 17px;">
                <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'buttons' => array(
                        array('label' => 'Print', 'icon' => 'entypo-print', 'url' => '#', 'htmlOptions' => array('onclick' => 'print(\'PRINT\')')),
                        array('label' => '', 'items' => array(
                            array('label' => 'PDF', 'icon' => 'icon-book', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'PDF\')')),
                            array('label' => 'Excel', 'icon' => 'icon-pdf', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'EXCEL\')')),

                        )),
                    ),
                    'htmlOptions' => array('style' => 'float:right')
                    //        'htmlOptions'=>array('class'=>'btn')
                )); ?>
            </div>

        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($modRujukanKeluar); ?>

        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="col-sm-6">
                        <?php //echo $form->textFieldRow($modRujukanKeluar,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <?php //echo $form->textFieldRow($modRujukanKeluar,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modRujukanKeluar, 'tgldirujuk', array('class' => 'control-label')) ?>
                            <?php $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modRujukanKeluar,
                                    'attribute' => 'tgldirujuk',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('style' => 'width: 180px;', 'readonly' => true),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modRujukanKeluar, 'tglberlakusurat', array('class' => 'control-label')) ?>
                            <?php $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRujukanKeluar->tglberlakusurat, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modRujukanKeluar,
                                    'attribute' => 'tglberlakusurat',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('style' => 'width: 180px;', 'readonly' => true),
                                )); ?>
                            </div>
                        </div>
                        <?php echo $form->dropDownListRow(
                            $modRujukanKeluar,
                            'pegawai_id',
                            CHtml::listData($modRujukanKeluar->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                        ); ?>
                        <?php //echo $form->textFieldRow($modRujukanKeluar,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <?php //echo $form->dropDownListRow($modRujukanKeluar,'rujukankeluar_id', CHtml::listData($modRujukanKeluar->getRujukanItems(), 'rujukankeluar_id', 'rumahsakitrujukan'),
                        //                        array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>

                        <div class="control-group">
                            <?php echo CHtml::label("Rujukan Keluar <span class='required'>*</span>", "", array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php
                                //echo $form->dropDownListRow($modRujukanKeluar,'rujukankeluar_id', CHtml::listData($modRujukanKeluar->getRujukanItems(), 'rujukankeluar_id', 'rumahsakitrujukan'),
                                //	array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 

                                /**
                                 * - mengubah dropdown rujukankeluar_id menggunakan auto complete
                                 * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
                                 * @category   auto complete
                                 * @added		1 Pebruari 2018
                                 */

                                echo $form->hiddenField($modRujukanKeluar, 'rujukankeluar_id', array('readonly' => true));

                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modRujukanKeluar,
                                    'attribute' => 'rujukankeluar_nama',
                                    'source' => 'js: function(request, response) {
										$.ajax({
										url: "' . $this->createUrl('/ActionAutoComplete/dropRujukanKeluar') . '",
										dataType: "json",
										data: {
											term: request.term,
										},
										success: function (data) {
											response(data);
										}
									})
								}',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 0,
                                        'focus' => 'js:function( event, ui ) {
										 $(this).val( ui.item.label);
										 return false;
									 }',
                                        'select' => 'js:function( event, ui ) {
										 $("#' . CHtml::ActiveId($modRujukanKeluar, 'rujukankeluar_id') . '").val(ui.item.value); 
										 return false;
									 }',
                                    ),
                                    'htmlOptions' => array('placeholder' => 'Rujukan Keluar', 'class' => 'span2 required')
                                ));

                                ?>
                            </div>
                            <div class="controls">
                                <?php echo CHtml::link(
                                    "<i class='" . MyIcon::getIcons('tambah-baris') . "'></i>",
                                    Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/" . Yii::app()->controller->id . "/frameRujukanKeluar", array()),
                                    array(
                                        'class' => 'btn btn-primary',
                                        'onclick' => "$('#dialogAddMasterRujukanKeluar').dialog('open');",
                                        'target' => 'frameAddRujukanKeluar',
                                        'rel' => 'tooltip',
                                        'title' => 'Klik untuk menambah data baru rujukan keluar '
                                    )
                                ); ?>
                            </div>
                        </div>

                        <?php echo $form->textFieldRow($modRujukanKeluar, 'nosuratrujukan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'disabled' => true)); ?>
                        <?php //echo $form->textFieldRow($modRujukanKeluar,'tgldirujuk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <?php echo $form->textFieldRow($modRujukanKeluar, 'kepadayth', array('placeholder' => 'Yth. Dokter', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textFieldRow($modRujukanKeluar, 'dirujukkebagian', array('placeholder' => 'Dirujuk ke Bagian', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                        <?php //echo $form->dropDownListRow($modRujukanKeluar,'ruanganasal_id', CHtml::listData($modRujukanKeluar->getRuanganInstalasiItems($modPendaftaran->instalasi_id), 'ruangan_id', 'ruangan_nama'),
                        //array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textAreaRow($modRujukanKeluar, 'catatandokterperujuk', array('placeholder' => 'Catatan Dokter Perujuk', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($modRujukanKeluar, 'alasandirujuk', array('placeholder' => 'Alasan Dirujuk', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($modRujukanKeluar, 'hasilpemeriksaan_ruj', array('placeholder' => 'Hasil Pemeriksaan Rujukan', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                        <?php echo $form->textAreaRow($modRujukanKeluar, 'diagnosasementara_ruj', array('placeholder' => 'Diagnosa Sementara Rujukan', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($modRujukanKeluar, 'pengobatan_ruj', array('placeholder' => 'Pengobatan Rujukan', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($modRujukanKeluar, 'lainlain_ruj', array('placeholder' => 'Lain-lain', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
            </tr>
        </table>

        <div class="form-actions" <?= $visibility ?>>
            <?php if (isset($_GET['pasiendirujukkeluar_id'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
            } ?>

            <?php $content = $this->renderPartial('../tips/tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content)); ?>
        </div>
        <?php
        $urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
        $urlPrintRujukan =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRujukan&id=' . $modPendaftaran->pendaftaran_id);

        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printRujukan(caraPrint,rujukankeluar_id)
{
    window.open("${urlPrintRujukan}&rujukankeluar_id="+rujukankeluar_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>

        <?php $this->endWidget(); ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogDetailrujukan',
            'options' => array(
                'title' => 'Detail Rujukan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 800,
                'resizable' => false,
                'position' => 'top',
            ),
        ));

        echo '<div id="contentDetailRujukan"> </div>';

        $this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogAddMasterRujukanKeluar',
            'options' => array(
                'title' => 'Tambah Rujukan Keluar',
                'autoOpen' => false,
                'modal' => true,
                'width' => 500,
                'resizable' => false,
                'position' => 'top',
            ),
        ));

        echo '<iframe src="" name="frameAddRujukanKeluar" width="100%" height="400px"></iframe>';
        //$this->renderPartial($this->path_view.'_diagnosaSementara',array('modRujukanKeluar'=>$modRujukanKeluar));

        $this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>

        <script type="text/javascript">
            function viewDetailRujukan(idPasienDirujuk) {
                $.post('<?php echo $this->createUrl('ajaxDetailRujukanKeluar') ?>', {
                    idPasienDirujuk: idPasienDirujuk
                }, function(data) {
                    $('#contentDetailRujukan').html(data.result);
                }, 'json');
                $('#dialogDetailrujukan').dialog('open');
            }

            function hapusRujukan(obj, id) {
                var tabel = obj;
                myConfirm('Apakah Anda akan menghapus rujukan keluar ini?', 'Perhatian!', function(r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('hapusRujukKeluar'); ?>',
                            data: {
                                rujukankeluar_id: id
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data.sukses == 1) {
                                    var delete_row = $(tabel).parents('tr');
                                    delete_row.detach();
                                }
                                myAlert(data.pesan);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });

                    }
                });
            }

            $(document).ready(function() {
                // Notifikasi Pasien
                <?php
                if (isset($_GET['smspasien'])) {
                    if ($_GET['smspasien'] == 0) {
                ?>
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                            judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                            isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                        }; // 16 
                        insert_notifikasi(params);
                <?php
                    }
                }
                ?>
            });



                     
    $(document).ready(function() {
           var pegawai = jQuery('#<?php echo CHtml::activeId($modRujukanKeluar, 'pegawai_id') ?>');	
           jQuery(pegawai).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function searchPegawai() {
            $('#rjpasien-dirujuk-keluar-t-form input[name*="pegawai_id"]').each(function() {
            });
    }

        </script>