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
            Detail <b>Kantong Darah</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'detail-kantong-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
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
                                    <img id="photo-preview" src="<?php echo $url_photopasien ?>"width="184px" style="position: absolute"/>   
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
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo $this->renderPartial('_formDetailKantong', array('modDaftarDonasi' => $modDaftarDonasi, 'modKantong' => $modKantong, 'model' => $model, 'form' => $form), true);

        if (!empty($modKantong)) {
            ?>
            <div class="form-actions">
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcodeLab();return false"));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Komponen', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcodeKomponen();return false"));
                ?>
            </div>
            <?php
        } else {
            ?>
            <div class="form-actions">
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Komponen', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                ?>
            </div>
            <?php
        }

        $this->endWidget();
        ?>


    </div>
</div>
<?php
if (!empty($modelKantong)) {
    ?>
    <script>

        function printBarcodeLab()
        {
            window.open('<?php echo $this->createUrl('PrintBarcode', array('kantongdarah_id' => $modelKantong->kantongdarah_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');

        }

        function printBarcodeKomponen()
        {
            window.open('<?php echo $this->createUrl('PrintBarcodeKomponen', array('kantongdarah_id' => $modelKantong->kantongdarah_id, 'daftarpendonor_id' => $modelKantong->daftarpendonor_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');

        }
    </script>
    <?php
}
?>