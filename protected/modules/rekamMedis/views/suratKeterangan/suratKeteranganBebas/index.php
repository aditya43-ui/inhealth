<?php
$this->breadcrumbs = array(
    'Rujukan',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$modul_id = Yii::app()->user->getState('modul_id');
$readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");

?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/literallycanvas/css/literallycanvas.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/react/build/react-with-addons.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/literallycanvas/js/literallycanvas-core.min.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'suratketerangan-r-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<style>
    .groupUkurans {
        display: inline;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi <strong>Surat Keterangan</strong></div>
            </div>
            <div class="panel-body">
                <div class="controls">
                    <div class="col-md-12">
                        <div class="control-group">
                            <?php echo $form->label($model, 'keterangan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'keterangan', 'height' => '400px', 'width' => '1000px')) ?>
                            </div>
                        </div>
                        <table width="100%">
                            <tr>
                                <td width="50%">&nbsp;&nbsp;</td>
                                <td width="24%"></td>
                                <td width="50%" align="center">
                                    <?php
                                    $modProfil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
                                    ?>
                                    <br>
                                    <p><?= $modProfil->kabupaten->kabupaten_nama; ?> , <?php echo date('d F Y'); ?></p>
                                    <span style="text-align: left!important;"> </span>
                                    <br>
                                    <div class="row-fluid" style="margin: auto;">
                                    </div>
                                    <!-- <div id=""></div> -->
                                    <?php //} ?>
                                    <br/><br/><br/><br/><br/>
                                    <?php
                                        $pegawaiList = DokterV::model()->findAll(array(
                                            'condition' => 'pegawai_aktif = true AND kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                                            'order' => 'nama_pegawai'
                                        ));

                                        $pegawaiOpt = array();
                                        foreach ($pegawaiList as $item) {
                                            $pegawaiOpt[$item->namaLengkap] = array(
                                                'data-nama' => $item->namaLengkap,
                                                'data-sip' => $item->suratizinpraktek ?? "-",
                                                'data-jabatan' => $item->jabatan->jabatan_nama ?? "-",
                                                'data-instansi' => 'RSUD Ketet Provinsi Jawa Tengah',
                                            );
                                        }

                                        echo $form->dropDownListRow($model, 'mengetahui_surat', CHtml::listData($pegawaiList, 'namaLengkap', 'namaLengkap'), array(
                                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setPenandaTangan();',
                                            'options' => $pegawaiOpt,
                                        ));
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="clear"></div>
                <?php
                // $this->renderPartial($this->path_view.'suratKeterangan',array('model'=>$model,'modPasien'=>$modPasien,
                //             'modPendaftaran'=>$modPendaftaran,
                //             // 'modAdmisi'=>$modAdmisi
                // ));
                ?>
    <div class="form-actions" <?=$hidden?>>
                    <?php
                    if (!empty($_GET['suratketerangan_id'])) {
                        echo CHtml::htmlButton(Yii::t(
                            'mds',
                            '{icon} Create',
                            array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')
                        ), array(
                            'class' => 'btn btn-primary', 'type' => 'submit',
                            'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => true
                        ));
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-primary', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                    } else {
                        echo CHtml::htmlButton(Yii::t(
                            'mds',
                            '{icon} Create',
                            array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')
                        ), array(
                            'class' => 'btn btn-primary', 'type' => 'submit',
                            'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'
                        ));
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-primary', 'disabled' => true, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
if (!empty($_GET['suratketerangan_id'])) {
    $urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/Print&suratketerangan_id=' . $_GET['suratketerangan_id']);
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=980px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);}?>

<script type="text/javascript">


function setPenandaTangan() {
        var opt = $("#RKSuratketeranganR_mengetahui_surat :selected");

        $("#nama_pegawai").val($(opt).data('nama'));
        $("#sip").val($(opt).data('sip'));
        $("#jabatan").val($(opt).data('jabatan'));
        $("#instansi").val($(opt).data('instansi'));
    }

$(document).ready(function() {
           var mengetahui_surat = jQuery('#<?php echo CHtml::activeId($model, 'mengetahui_surat') ?>');	
           jQuery(mengetahui_surat).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();

           <?php if($readonly):?>
                $('input,select,textarea').attr('disabled', true);
                $('.multiselect-selected-text').attr('disabled', true);
                $('.redactor_frame').each(function() {
                    $(this).contents().find('html > body > #page').attr("contenteditable", false);
                });
        <?php endif;?>
       });


    function searchMengetahui() {
            $('#rjpasien-laboratorium-t-form input[name*="mengetahui_surat"]').each(function() {
            });
    }

    // $(document).ready(function() {
    //     var lc = LC.init(document.getElementsByClassName('literally pegawai')[0]);
    //     $("#clear-lc").click(function() {
    //         lc.clear();
    //     });
    //     $("#ttdpeg").click(function() {
    //         // console.log('safhgsahfg')
    //         // var lc4 = LC.init(document.getElementsByClassName('literally pegawai')[0]);
    //         var imagepeg = lc.getImage({
    //             scale: 1,
    //             margin: {
    //                 top: 10,
    //                 right: 10,
    //                 bottom: 10,
    //                 left: 10
    //             }
    //         }).toDataURL();
    //         $('#KUSuratketeranganT_pegawaittd').val(imagepeg);
    //         // console.log($('#SuratpersetujuantmT_meyetujuittd').val())
    //     })
    // });





</script>