<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caridata-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_pengajuan'),
    'htmlOptions' => array(),
)); ?>
<fieldset class="box row">
    <div class="rim"><i clas="entypo-search"></i> Pencarian</div>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <!--<div class="control-group">
                                    <?php // $model->tgl_awal = isset($model->tgl_awal) ? MyFormatter::formatDateTimeForUser($model->tgl_awal) : date('d M Y'); 
                                    ?>
                                    <label class='control-label'>Tanggal Pengajuan</label>
                                    <div class="controls">
                                            <?php
                                            //                                                            $this->widget('MyDateTimePicker',array(
                                            //                                                                                            'model'=>$model,
                                            //                                                                                            'attribute'=>'tgl_awal',
                                            //                                                                                            'mode'=>'date',
                                            //                                                                                            'options'=> array(
                                            //                                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                            //                                                                                                    'maxDate' => 'd',
                                            //                                                                                            ),
                                            //                                                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                            //                                            )); 
                                            ?>
                                    </div>
                            </div>-->
                <!--<div class="control-group">
                                    <label class='control-label'>Sampai Dengan</label>
                                    <div class="controls">
                                            <?php // $model->tgl_akhir = isset($model->tgl_akhir) ? MyFormatter::formatDateTimeForUser($model->tgl_akhir) : date('d M Y'); 
                                            ?>
                                            <?php
                                            //                                                    $this->widget('MyDateTimePicker',array(
                                            //                                                                                            'model'=>$model,
                                            //                                                                                            'attribute'=>'tgl_akhir',
                                            //                                                                                            'mode'=>'date',
                                            //                                                                                            'options'=> array(
                                            //                                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                            ////                                                                                                    'maxDate' => 'd',
                                            //                                                                                            ),
                                            //                                                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                            //                                            )); 
                                            ?>    
                                    </div>
                            </div>-->
                <!--<div class="col-sm-6">
                        <br>-->
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <!--</div>-->
            </td>
            <td>
                <br><br>
                <?php echo $form->textFieldRow($model, 'no_pengajuan', array('placeholder' => 'No. Memo', 'class' => 'span3', 'maxlength' => 10)); ?>
                <?php echo $form->dropDownListRow($model, 'status', $model->statusGanti(), array('empty' => '-- Pilih --', 'style' => 'width:120px;')); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions" style="padding: 5px 0px 20px 20px">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
        );
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        ); ?>
        <?php
        $content = $this->renderPartial('tips/informasi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>