<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Evaluasi Identifikasi Resiko </strong></div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penelitian-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);'),
            'focus' => '#',
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <div class="row-fluid">
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <div class="panel-title"><b>Identifikasi Risiko</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formIdentifikasiResiko', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <div class="panel-title"><b>Rating Analisis</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formAnalisis', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <div class="panel-title"><b>Evaluasi / Pengolahan Risiko</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formEvaluasi', array(
                        'modEvaluasi' => $modEvaluasi,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <div class="panel-title"><b>Progress Laporan Monev</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formProgress', array(
                        'modProgress' => $modProgress,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>


        </div>
        <div class="form-actions">
            <?php
            $disabled = (isset($_GET['sukses'])) ? true : false;
            ?>

            <?php
            if ((Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEPERAWATAN_YANKES) || (Yii::app()->user->getState('ruangan_id') == $model->ruangan_id)) {
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'onclick' => 'cekForm(); return false;'));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'type' => 'submit', 'disabled' => true));
                }
            }
            ?>
            &nbsp;

        </div>
    </div>
    <?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modProgress' => $modProgress)); ?>
    <?php $this->endWidget(); ?>
</div>
<script>
    function cekForm(){
        if (requiredCheck($("#penelitian-t-form"))){
            $("#penelitian-t-form").submit(); 
            window.parent.$("#dialogProgres").dialog('close');
        }
    }
</script>