<?php
/**
 * view ini digunakan untuk menampilkan semua form pada menu transaksi persiapan pengadaan
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'persiapanpengadaan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
        //'focus' => '#'.CHtml::activeId($model, 'persiapanpengadaan_tanggal').'',
        ));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Review <b>Persiapan Pengadaan</b></div>
    </div>
    <div class="panel-body">        
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Persiapan Pengadaan</div>
                </div>
                <div class="panel-body">                
                    <?php
                    echo $this->renderPartial($this->path_view_detail . '_formPersiapan', array(
                        'form' => $form,
                        'model' => $model,
                        'modRencana' => $modRencana
                            ), true);
                    ?>
                    <div class="clear"></div>
                    <hr/>                
                    <?php
                    echo $this->renderPartial($this->path_view_detail . '_formLanjutan', array(
                        'form' => $form,
                        'model' => $model,
                        'modRencana' => $modRencana,
                        'modPersiapan' => $modPersiapan,
                            ), true);
                    ?>                
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">HPS</div>
                </div>
                <div class="panel-body overflow-x">
                    <?php
                    echo $this->renderPartial($this->path_view_detail . '_formHPS', array(
                        'form' => $form,
                        'model' => $model,
                        'modDetail' => $modDetail
                            ), true);
                    ?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Dokumen RUP</div>
                    </div>
                    <div class="panel-body" >
                        <i><label ><span class="required">Maksimal Ukuran file adalah 2000kb/2mb</span></label></i>

                        <table class="table table-bordered table-striped table-condensed" id="form-dokrup">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Jenis Dokumen</th>
                                    <th style="text-align: center;">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($modDokRUP)): ?>
                                    <?php foreach ($modDokRUP as $dokumen): ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $dokumen->dokumenpendukungpengadaan_nama; ?></td>
                                            <td style="text-align: center;"><?php echo CHtml::link($dokumen->dokumenpendukungpengadaan_file, $this->createUrl('UnduhDokRUP', array('dokumenpendukungpengadaan_id' => $dokumen->dokumenpendukungpengadaan_id)), array('title' => 'Unduh Dokumen', 'rel' => 'tooltip')); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>                
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Dokumen Persiapan Pengadaan</div>
                    </div>
                    <div class="panel-body" >
                        <i><label ><span class="required">Maksimal Ukuran file adalah 2000kb/2mb</span></label></i>

                        <table class="table table-bordered table-striped table-condensed" id="form-dokpendukung">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Jenis Dokumen</th>
                                    <th style="text-align: center;">File</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                if (!empty($modDokumen)) {
                                    foreach ($modDokumen as $dokumen) {?>                                        
                                            <td style="text-align: center;"><?php echo $dokumen['nama']; ?></td>
                                            <td style="text-align: center;">
                                                <?php         
                                                    $a = 1;
                                                    foreach($dokumen['det'] as $dok){
                                                        $pisah = explode('.', $dok['file']);
                                                        $nama_file = '';
                                                        if (!empty($dok['file'])){
                                                            $nama_file = $pisah[0].'-'.($a).'.'.$pisah[1];
                                                        }
                                                        
                                                        echo CHtml::link($nama_file, $this->createUrl('UnduhDok', array('dokumenpendukungpengadaan_id' => $dok['id'])), array('title' => 'Unduh Dokumen', 'rel' => 'tooltip'))."<br/>"; 
                                                        $a++;
                                                    }                                                    
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>                
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Catatan</div>
                </div>
                <div class="panel-body overflow-x">
                    <?php
                    echo $this->renderPartial($this->path_view_detail . '_formCatatan', array(
                        'form' => $form,
                        'model' => $model,
                        'modDetail' => $modDetail,
                        'modRiwayatPengadaan' => $modRiwayatPengadaan
                            ), true);
                    ?>
                </div>
            </div>
        </div>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'data-riwayat',
            'content' => array(
                'content-datariwayat' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini',
                        'onclick' => 'Pengorganisasidata()',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip',
                        'title' => 'Klik untuk tampilkan Riwayat')) . '<b> Riwayat</b>',
                    'isi' => $this->renderPartial('_riwayat', array('modRiwayat' => $modRiwayat), true),
                    'active' => true,
                ),
            ),
        ));
        ?>
        <div>
            <?php
            if (empty($_GET['sukses'])) {
                $cekUnitkerja = UnitkerjaM::model()->findByPk(Params::UNITKERJA_ID_PENGADAAN_DAN_JASA);
                if($cekUnitkerja->kepalaunitpeg_id == Yii::app()->user->getState('pegawai_id') && $model->persiapanpengadaan_status == 'Diajukan') {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Setuju', array('{icon}' => "<i class='fa fa-check'></i>")), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'setMenyetujui("' . $model->persiapanpengadaan_id . '");return false;'));
                    echo '&nbsp;';
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Revisi', array('{icon}' => "<i class='fa fa-pencil'></i>")), array('class' => 'btn btn-blue', 'type' => 'button', 'onclick' => 'setRevisi("' . $model->persiapanpengadaan_id . '");return false;'));
                    echo '&nbsp;';
                }else{
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Setuju', array('{icon}' => "<i class='fa fa-check'></i>")), array('class' => 'btn btn-success', 'type' => 'button', 'disabled' => true));
                    echo '&nbsp;';
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Revisi', array('{icon}' => "<i class='fa fa-pencil'></i>")), array('class' => 'btn btn-blue', 'type' => 'button', 'disabled' => true));
                    echo '&nbsp;';
                }
                echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
            } else {
                echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.go(-2);return false;', 'style' => 'color: white;'));
            }
            ?>	
        </div>


    </div>
</div>
<?php $this->renderPartial('jsFunction'); ?>    
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function () {
        //loadDokpendukung();
    });

    function loadDokpendukung() {
        var rencanaumumpengadaan_id = $("#ADPersiapanpengadaanT_rencanaumumpengadaan_id").val();
        var kategori = $("#RencanaumumpengadaanT_rencanaumumpengadaan_kategori").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadDokpendukung'); ?>',
            data: {kategori: kategori, persiapanpengadaan_id:<?php echo!empty($_GET['id']) ? $_GET['id'] : "''"; ?>},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#form-dokpendukung > tbody").html(data.dokDukung);
                } else {
                    toastr.error(data.pesan);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>