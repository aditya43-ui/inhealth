<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesa',
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END);
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
));

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

?>
<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan <b>Asesmen Triage</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($modAsesTriase); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Asesmen Triase</b>
                </div>
            </div>    
            <?php /*
            <div class="panel-body table-responsive">
                
                <?php echo $form->hiddenField($modAsesTriase, 'pendaftaran_id', array('readonly' => true)) ?>
                <?php echo $form->hiddenField($modAsesTriase, 'pasien_id', array('readonly' => true)) ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modAsesTriase, 'tglasesmentriase', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAsesTriase,
                            'attribute' => 'tglasesmentriase',
                            'value' => null,
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 htpd',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="control-group">

                    <label class="control-label" style="width:100%;text-align: left;">
                        <?php echo $form->checkBox($modAsesTriase, 'trauma', array('onchange' => 'cekTrauma(this);', 'val' => 'trauma')) ?> Trauma &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->checkBox($modAsesTriase, 'nontrauma', array('onchange' => 'cekTrauma(this);', 'val' => 'nontrauma')) ?> Non Trauma
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->checkBox($modAsesTriase, 'isobstetri') ?> Obstetri
                    </label>
                </div>
            </div>

            <?php echo $this->renderPartial($this->path_view . 'form._formTriase', array(
                'modLookup' => $modLookup,
                'dataTriase' => $dataTriase,
                'form' => $form,
                'modAsesTriase' => $modAsesTriase,
                'modAsesTriDet' => $modAsesTriDet,
                'getTriase' => $getTriase,
            ), true); ?>

                */ 
            $this->renderPartial($this->path_view.'form._formTriageBaru', ['form'=>$form, 'model'=>$modAsesTriase]);
            ?>
            
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Asesmen Nyeri</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <?php echo $this->renderPartial($this->path_view . 'form._formNyeriV2', array(
                'modFisik' => $modFisik,
                'form' => $form,
                'modAsesTriase' => $modAsesTriase,
                'modFlaCcs' => $modFlaCcs,
                'dataFlaCcs' => $dataFlaCcs,
                'getFlaCcs' => $getFlaCcs
            ), true); ?>
        </div>
    </div>

    <div class="panel panel-success" style="display: none;">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Skrining Resiko Jatuh (Morse Falls Scale)</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <?php echo $this->renderPartial($this->path_view . 'form._formResikoJatuh', array('modFisik' => $modFisik, 'form' => $form), true); ?>
        </div>
    </div>

    <table class="noborder" id="petugas_triase">
        <thead>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label("Petugas Triage", 'pegawai_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::dropDownList('getpegawaitriase', '', PegawaiM::model()->dropDokterParamedisItems(Yii::app()->user->getState('ruangan_id')), array('class' => 'pegawai', 'multiple' => 'multiple')); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php
            $cekPeg = RDAsesmentriasepegT::model()->findByAttributes(array('asesmentriase_id' => $modAsesTriase->asesmentriase_id));
            if (empty($cekPeg)) {
                //echo $this->renderPartial($this->path_view.'form._rowPetugasTriaseV2',array('modTriPeg'=>$modTriPeg ,'form'=>$form, 'i'=>0),true);
            } else {
                $i = 0;
                foreach ($modTriPeg as $detPeg) {
                    // echo $this->renderPartial($this->path_view.'form._rowPetugasTriaseV2',array('modTriPeg'=>$detPeg ,'form'=>$form, 'i'=>$i),true);
                    $i++;
                }
            }

            $modTriPeg = new RDAsesmentriasepegT;
            ?>
        </tbody>
    </table>
    <?php 
    if (!(!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN)) {
       
    ?>
    <div class="form-actions">
        <?php
        if ($modAsesTriase->isNewRecord) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'enabled' => true)
            );
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false;", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
        } else {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => false)
            );
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printAsesmen();return false", 'enabled' => 'true'));
        }
        ?>
        <?php
        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </div>
    <?php 
    }
    ?>

</div>
</div>
<?php echo $this->renderPartial($this->path_view . 'js._jsFunctions', array('modGcs' => $modGcs, 'modFlaCcs' => $modFlaCcs, 'modFisik' => $modFisik, 'form' => $form, 'modAsesTriase' => $modAsesTriase, 'modAsesTriDet' => $modAsesTriDet, 'modTriPeg' => $modTriPeg), true); ?>

<?php $this->endWidget(); ?>