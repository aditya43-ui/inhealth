<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Identifikasi Resiko </strong></div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penelitian-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
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
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><b>Identifikasi Resiko</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial($this->path_view . 'detail/_formIdentifikasiResiko', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><b>Rating Analisis</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial($this->path_view . 'detail/_formAnalisis', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>



        </div>

    </div>

    <?php $this->endWidget(); ?>
</div>
<script>
    $(document).ready(function () {
        $("#penelitian-t-form select").attr("disabled", true);
        $("#penelitian-t-form input").attr("disabled", true);
        $("#penelitian-t-form textarea").attr("disabled", true);

    });
</script>    