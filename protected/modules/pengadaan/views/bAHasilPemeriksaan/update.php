<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); 
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bahasilpemeriksaan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div style="min-height: 950px !important">
    <div class="panel-group joined" id="accordion-khp"> 
        <div class="panel panel-success"> 
            <div class="panel-heading"> 
                <h4 class="panel-title" style="background-color: #a6db9c"> 
                    <a data-toggle="collapse" data-parent="#accordion-khp" href="#riwayat" aria-expanded="true" class="">
                        Riwayat Berita Acara Hasil Pemeriksaan Pekerjaan
                    </a> 
                </h4> 
            </div> 
            <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
                <div class="panel-body" style="background-color: #fff">
                    <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'form' => $form), true); ?>
                </div> 
            </div> 
        </div> 
        <div class="panel panel-success"> 
            <div class="panel-heading"> 
                <h4 class="panel-title" style="background-color: #b0eaa5"> 
                    <a data-toggle="collapse" data-parent="#accordion-khp" href="#transaksi" class="" aria-expanded="false">
                        Berita Acara Hasil Pemeriksaan Pekerjaan
                    </a> 
                </h4> 
            </div>
            <div id="transaksi" class="panel-collapse collapse in" aria-expanded="true"> 
                <div class="panel-body" style="background-color: #fff">
                    <div class="panel panel-gradient">
                        <div class="panel-heading">
                            <div class="panel-title">Transaksi <strong>Berita Acara Hasil Pemeriksaan Pekerjaan</strong></div>
                        </div>
                        <div class="panel-body">

                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title"><span class='judul'>Data Berita Acara Hasil Pemeriksaan Pekerjaan</span></div>
                                </div>
                                <div class="panel-body">
                                    <?php $this->renderPartial('_formHasilPemeriksaan', array('model' => $model, 'modPeriksaKerja' => $modPeriksaKerja, 'form' => $form)); ?>
                                </div>
                            </div>
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title"><span class='judul'>Lampiran</span></div>
                                </div>
                                <div class="panel-body">
                                    <?php $this->renderPartial('_formLampiran', array('modelDetail' => $modelDetail, 'form' => $form, 'modSPK' => $modSPK, 'model' => $model)); ?>
                                </div>
                            </div>

                            <div class="row-fluid">
                                <div class="form-actions">
                                    <?php
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));

                                    echo "&nbsp;";
                                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'bahasilpemeriksaanpekerjaan_id' => $_GET['bahasilpemeriksaanpekerjaan_id'])), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
                                    echo "&nbsp;";

                                    echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'])), array('class' => 'btn btn-success'));

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 

    <?php $this->endWidget(); ?>
    <script>
    document.getElementById("BahasilpemeriksaanpekerjaanT_dokumen_pendukung").onchange = function () {
        if (this.files[0].size > 5000000) {
            toastr.error('Ukuran maksimal dokumen 5mb');
            $("#BahasilpemeriksaanpekerjaanT_dokumen_pendukung").attr("src", "blank");
            $('#BahasilpemeriksaanpekerjaanT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BahasilpemeriksaanpekerjaanT_dokumen_pendukung').unwrap();
            return false;
        }
    }
    
    $(document).ready(function(){
        $('.integer-decimal').each(function(){
                $(this).val(formatThousandDecimal(parseFloat($(this).val())));
            }); 
    });
    </script>