<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchInfoKunjungan',
        'focus' => '#' . CHtml::activeId($modPPInfoKunjunganV, 'instalasi_id'),
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        table {
            margin-bottom: 0;
        }

        .form-actions {
            padding: 4px;
            margin-top: 5px;
        }

        .nav-tabs>li>a {
            display: block;
            cursor: pointer;
        }

        .nav-tabs>.active a:hover {
            cursor: pointer;
        }
    </style>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-search"></i> Pencarian
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class="control-group">
                        <?php echo $form->hiddenField($modPPInfoKunjunganV, 'jns_periode', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($modPPInfoKunjunganV, 'bln_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($modPPInfoKunjunganV, 'bln_akhir', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($modPPInfoKunjunganV, 'thn_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($modPPInfoKunjunganV, 'thn_akhir', array('class' => 'span2')); ?>
                        <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPPInfoKunjunganV->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPPInfoKunjunganV->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($modPPInfoKunjunganV->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPPInfoKunjunganV->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($modPPInfoKunjunganV, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($modPPInfoKunjunganV, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php
                        echo $form->textFieldRow($modPPInfoKunjunganV, 'jumlahTampil', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbersOnly'));
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPPInfoKunjunganV, 'instalasi_id', CHtml::listData(InstalasiM::model()->getDropInsPelayanan(), 'instalasi_id', 'instalasi_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $modPPInfoKunjunganV,
                                'ruangan_id',
                                array(),
                                array('class' => 'form-control', 'multiple' => 'multiple')
                            ); ?>
                        </div>

                    </div>
                </div>
                <!--
                <div class="row">
                    <div class="col-sm-6">

                    </div>
                    <?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'big',							
//                                    'disabled'=>true,
                            'content'=>array(
                                'content1'=>array(
									'multi' => 'multi',
                                    'header'=>'Berdasarkan Instalasi/Ruangan',
                                    'isi'=>'<div class="control-group">
												'.CHtml::label('Instalasi','instalasi_id', array('class' => 'control-label')).' 
												<div class="controls">
													'.$form->dropDownList($modPPInfoKunjunganV,'instalasi_id',CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'),array(
													'class'=>'form-control', 'multiple'=>'multiple')).'											
												</div>
											</div>
											<div class="control-group">
												'.CHtml::label('Ruangan','ruangan_id', array('class' => 'control-label')).' 
												<div class="controls">												 
													'.$form->dropDownList($modPPInfoKunjunganV,'ruangan_id',
															array(),
															array('class'=>'form-control', 'multiple'=>'multiple')).' 													
												</div>
											</div>',
//                                                       
                                    'active'=>true,
                                    ),   ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    ));*/ ?>
                </div>-->
                <?php
                // echo $form->dropDownListRow($modPPInfoKunjunganV, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'style'=>'width:200px;',
                //  'ajax' => array('type' => 'POST',
                //           'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modPPInfoKunjunganV))),
                //            'update' => '#' . CHtml::activeId($modPPInfoKunjunganV, 'ruangan_id') . ''),));
                ?>

                <?php //echo $form->dropDownListRow($modPPInfoKunjunganV, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id' => $modPPInfoKunjunganV->instalasi_id, 'ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2','style'=>'width:200px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); 
                ?>

            </div>
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'title' => 'Cari'));
                ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'class' => 'btn btn-default', 'title' => 'Ulang',
                        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
<?php //$this->widget('UserTips', array('type' => 'create')); 
?>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php
$urlAjax = $this->createUrl('GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => $modPPInfoKunjunganV->getNamaModel()));
Yii::app()->clientScript->registerScript(
    'numbers',
    '
    $(".numbersOnly").keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
        if ($(this).val() == 0){
            $(this).val(1);
        }
    });
    $(".numbersOnly").keyup(function(event){
        if ($(this).val() == 0){
            $(this).val(1);
        }
    });
//    $("#' . CHtml::activeId($modPPInfoKunjunganV, 'instalasi_id') . '").change(function(){
//        $.ajax({
//            type:"POST",
//            data:$("#searchInfoKunjungan").serialize(),
//            url:"' . $urlAjax . '",
//            success:function(data){
//                $("#' . CHtml::activeId($modPPInfoKunjunganV, 'ruangan_id') . '").html("<option value>-- Pilih --</pilih>"+data)
//            }
//        });
//    })
',
    CClientScript::POS_READY
); ?>
<?php $this->renderPartial($this->pathViewPP . '_jsFunctions', array('model' => $modPPInfoKunjunganV)); ?>