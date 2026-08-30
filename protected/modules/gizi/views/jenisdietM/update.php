<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jenis Diet</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Gzjenisdiet Ms' => array('index'),
            $model->jenisdiet_id => array('view', 'id' => $model->jenisdiet_id),
            'Update',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Diet', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Diet', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->jenisdiet_id))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Diet', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gzjenisdiet-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#JenisdietM_jenisdiet_nama',
        ));
        ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'jenisdiet_nama', array('placeholder' => 'Nama Jenis', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
                <?php echo $form->textareaRow($model, 'jenisdiet_keterangan', array('placeholder' => 'Keterangan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'rows' => 5,)); ?>
                <div class="control-group">
                    <?php echo CHtml::label("", 'jenisdiet_aktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model, 'jenisdiet_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'jenisdiet_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
                <div class="control-group">
                    <label class="control-label"><?php echo Yii::t('mds', 'Catatan'); ?></label>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'jenisdiet_catatan', 'name' => 'jenisdiet_catatan', 'toolbar' => 'mini', 'width' => '50px', 'height' => '100px')) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php /* echo $form->textareaRow($model,'jenisdiet_catatan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",)); */ ?>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan'));
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/JenisdietM/admin'), array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            ));
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jenis Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('JenisdietM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            ?>
            <?php
            $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>

            <?php $this->endWidget(); ?>

            <script type="text/javascript">
                function namaLain(nama) {
                    document.getElementById('JenisdietM_jenisdiet_namalainnya').value = nama.value.toUpperCase();
                }
            </script>
        </div>
    </div>