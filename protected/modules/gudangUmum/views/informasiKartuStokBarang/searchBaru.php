<div id="divSearch-form">
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">
                    <?php echo $form->checkBox($model, 'pilihTgl', array('uncheckValue' => false)) ?> Tanggal Transaksi
                </label>
                <?php //echo CHtml::label("Tgl. Transaksi",'tgl_rekam', array('class' => 'control-label')) 
                ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Jenis Transaksi', 'Nama Transaksi', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'transaksi', $model->getNamaTransaksiKartuStok(), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                </div>
            </div>
            <!--				 <div class="control-group">
                    <?php // echo $form->dropDownListRow($model,'instalasi_id', $instalasiAsals, 
                    //                    array('disabled'=>$disabled,'class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                    //                        'ajax'=>array('type'=>'POST',
                    //                            'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                    //                            'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
                    //                        )
                    //                    ));
                    ?>
                </div>-->
            <!--<div class="control-group">-->
            <?php // echo $form->dropDownListRow($model,'ruangan_id',$ruanganAsals,array('disabled'=>$disabled,'class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <!--</div>-->
            <?php /*
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Kedaluwarsa",'tglkadaluarsa', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
						$model->tglkadaluarsa = null;
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglkadaluarsa',
                            'mode'=>'date',
                            'options'=> array(
                                'showOn' => false,
                                //'maxDate' => 'd',
								'minDate' => 'd',
                                'yearRange'=> "-0:+20",
                            ),
                            'htmlOptions'=>array('readonly'=>true,'placeholder'=>'00/00/0000','class'=>'col-sm-6 dtPicker3 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                            ),
                        ));
                        $model->tglkadaluarsa = $format->formatDateTimeforDb($model->tglkadaluarsa); ?>
                    </div>
                </div>
				 * 
				 */ ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cariKartuStok(); return false;')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print("PRINT")')
        );
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print("PDF")')
        );
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print("EXCEL")')
        );
        $content = $this->renderPartial($this->path_view . '/tips/tipsInformasi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>