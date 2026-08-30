<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'baserahterima-t-form',
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
                        Riwayat Berita Acara Serah Terima
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
                        Berita Acara Serah Terima
                    </a> 
                </h4> 
            </div> 
            <div id="transaksi" class="panel-collapse collapse in" aria-expanded="true"> 
                <div class="panel-body" style="background-color: #fff">
                    <div class="panel panel-success">
                        <div class="panel panel-heading">
                            <div class="panel-title"> <b> Berita Acara Serah Terima </b> </div>
                        </div>
                        <div class="panel-body">
                            <?php $this->renderPartial('_formSerahTerima', array('model' => $model, 'form' => $form)) ?>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel panel-heading">
                            <div class="panel-title"> <b> Lampiran </b> </div>
                        </div>
                        <div class="panel-body">
                            <?php $this->renderPartial('_formLampiran', array('modBADetail' => $modBADetail, 'model' => $model, 'modDetail' => $modDetail, 'modSurat' => $modSurat, 'form' => $form)) ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="form-actions">
                            <?php
                            $hitungBA = BaserahterimaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                            $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                            
                            if (!empty($modTermin)) {
                                if (count($hitungBA) == count($modTermin)) {
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                } else {
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                                }
                            } else {
                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                            }
                            
                            echo "&nbsp;";
                            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'])), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
                            echo "&nbsp;";
                            if (empty($model->baserahterima_id)) {
                              //  echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                              //  echo "&nbsp;";
                            } else {
                               
                                if(empty($modSurat->istermin)){
                              //   echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                                }else{
                              //   echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => false, 'type' => 'button', 'onclick' => 'printtermin(\'PRINT\')'));
                                }
                                echo "&nbsp;";
                            }
                            ?>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->baserahterima_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
    function printtermin() {
        window.open('<?php echo $this->createUrl('printTermin', array('id' => $model->baserahterima_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    $(document).ready(function () {
        $('.integer-decimal').each(function(){
           $(this).val(formatThousandDecimal(parseFloat($(this).val())));
       });
        setValidasiCekDisabled($("#baserahterima-t-form"), function () {
            return true;
        });

    });
    
    document.getElementById("BaserahterimaT_dokumen_pendukung").onchange = function () {
        
       
        if (this.files[0].size > 5000000) {
            toastr.error('Ukuran maksimal dokumen 5mb');
            $("#BaserahterimaT_dokumen_pendukung").attr("src", "blank");
            $('#BaserahterimaT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BaserahterimaT_dokumen_pendukung').unwrap();
            return false;
        }
    }
</script>