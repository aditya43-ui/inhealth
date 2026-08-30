<?php
/**
 * -Digunakan untuk menampilkan detail observasi
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * RSST-1534
 */
?>
<style>        
    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }

    #data-seleksi  .span2, #tandavital .span2{
        width:99px !important; 
    }
    td{
        height: 43px !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Detail <b>Observasi Donor Darah</b>
        </div>
    </div>
    <?php
    $this->widget('bootstrap.widgets.BootAlert');

    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'detail-kantong-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Data Pendonor </span></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="panel-body overflow-x" >    
                        <table style="width: 100%">
                            <tr>
                                <td>
                                    <?php echo CHtml::label("No. Formulir &nbsp;", 'no_formulir', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::activeHiddenField($modPendonor, 'pendonor_id', array('readonly' => true)); ?>
                                    <?php echo CHtml::activeHiddenField($modDaftarDonasi, 'daftardonasi_id', array('readonly' => true)); ?>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modDaftarDonasi, 'no_formulir', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::label("Agama &nbsp;", 'agama', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'agama', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                                <td rowspan="3">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php $url_photopasien = (!empty($modPendonor->photopendonor) ? Params::urlPendonorDirectory() . $modPendonor->photopendonor : Params::urlPendonorDirectory() . "no_photo.jpeg"); ?>
                                    <img id="photo-preview" src="<?php echo $url_photopasien ?>"width="84px" style="position: absolute"/>   
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo CHtml::label("No. Registrasi &nbsp;", 'no_pendonor', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'no_pendonor', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::label("Status &nbsp;", 'statusperkawinan', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'statusperkawinan', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo CHtml::label("Nama Pendonor &nbsp;", 'nama_lengkap', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'nama_lengkap', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::label("Golongan Darah &nbsp;", 'gol_darah', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'gol_darah', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo CHtml::label("Tanggal Lahir &nbsp;", 'tgllahir', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'tgllahir', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::label("Rhesus &nbsp;", 'rhesus', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'rhesus', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo CHtml::label("Umur &nbsp;", 'umur', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::textField('tgllahir', (!empty($modPendonor->tgllahir)) ? CustomFunction::hitungUmur($modPendonor->tgllahir) : "-", array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::label("&nbsp; Riwayat Donor &nbsp; <br>Terakhir &nbsp;", 'waktu_observasi', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'waktu_observasi', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo CHtml::label("Jenis Kelamin &nbsp;", 'jenis_kelamin', array('class' => 'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'jenis_kelamin', array('readonly' => true, 'class' => 'span3')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::label("Berat Badan", 'beratbadan_kg', array('class'=>'control-label')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::activeTextField($modPendonor, 'beratbadan_kg', array('readonly' => true, 'class' => 'span3')); ?> <label> Kg </label>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo $this->renderPartial($this->path_view . '_tabMenuDetail', array('modDaftarDonasi' => $modDaftarDonasi, 'modSeleksi' => $modSeleksi, 'form' => $form, 'daftardonasi_id' => $daftardonasi_id, 'observasipendonor_id' => $observasipendonor_id));
    echo $this->renderPartial($this->path_view . '_jsFunctionsDetail', array(), true);
    ?>
    <div>
        <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll;" ></iframe>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>
