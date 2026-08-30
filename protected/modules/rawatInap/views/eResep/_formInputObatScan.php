<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/literallycanvas/css/literallycanvas.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/react/build/react-with-addons.js'); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/literallycanvas/js/literallycanvas-core.min.js'); ?>
<style>
    .current {
        background: #f1f4e1;
        border: #bfbfbf 1px solid;
    }
</style>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Data <b>Resep</b>
        </div>
    </div>
    <div class="panel-body" id="form-dataresep">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modReseptur, 'tglreseptur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modReseptur,
                            'attribute' => 'tglreseptur',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                'yearRange' => "-60:+0",
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                        <?php echo $form->error($modReseptur, 'tglreseptur'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modReseptur, 'noresep', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modReseptur, 'noresep', array('onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true));
                        ?>
                        <?php //echo $form->textFieldRow($modReseptur,'noresep', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Dokter <span class='required'>*</span>", 'pegawai_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modReseptur, 'pegawai_id', array('id' => 'pegawai_reseptur', 'class' => 'required')); ?>
                        <?php
                        $peg = PegawaiM::model()->findByPk($modReseptur->pegawai_id);

                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modReseptur,
                            'attribute' => 'pegawai_nama',
                            'source' => 'js: function(request, response) {
					$.ajax({
					url: "' . $this->createUrl('/ActionAutoComplete/dropDokterRuangan') . '",
					dataType: "json",
					data: {
						term: request.term,
						ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
					},
					success: function (data) {
						response(data);
					}
				})
			}',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
					 $(this).val( ui.item.label);
					 return false;
				 }',
                                'select' => 'js:function( event, ui ) {
                                            setDokterReseptur(ui.item.label,ui.item.value);
                                            //$("#' . CHtml::ActiveId($modReseptur, 'pegawai_id') . '").val(ui.item.value);                                           
                                            return false;
				 }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDokterDPJP'),
                            'htmlOptions' => array('class' => 'span3 required', 'onblur' => 'if(this.value == ""){ setDokterReseptur("","")}', "placeholder" => "Nama Dokter")
                        ));
                        ?>
                    </div>
                </div>

                <?php
                // $metaRuangan = RuanganM::model()->findByPk($modReseptur->ruangan_id);
                // $modReseptur->ruangan_id = $metaRuangan->ruangan_nama;
                // echo $form->textFieldRow($modReseptur,'ruangan_id',array('readonly'=>true, 'id'=>'nama_apotek_reseptur'));
                // $modReseptur->ruangan_id = $metaRuangan->ruangan_id;
                echo $form->dropDownListRow($modReseptur, 'ruangan_id', CHtml::listData(
                    RuanganM::model()->findAllByAttributes(array(
                        'instalasi_id' => Params::INSTALASI_ID_FARMASI
                    ), array(
                        'condition' => 'ruangan_aktif = true and ruangan_id <> ' . Params::RUANGAN_ID_GUDANG_FARMASI,
                        'order' => 'ruangan_nama',
                    )),
                    'ruangan_id',
                    'ruangan_nama'
                ));
                echo $form->hiddenField($modReseptur, 'e_resep_data', array('id' => 'e_resep_data'));
                ?>
                <div class="control-group">
                    <label class="control-label" for="iter">Iter</label>
                    <div class="controls">
                        <?php echo CHtml::textField('iter', '0', array('readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1  numbers-only integer')) ?>
                    </div>
                </div>

            </div>

            <div class="col-sm-12" style="clear: both; padding: 15px;">
                <hr>
            </div>

            <div class="col-sm-6 panel-scanner" style="margin-bottom: 15px;">
                <div class="control-group">
                    <label class="control-label">Format Scan</label>
                    <div class="controls">
                        <?php echo Chtml::textField('txt_format_scanner', '', array(
                            'class' => 'span3',
                            'readonly' => true,
                            "placeholder" => "format scan",
                        )); ?>
                        <?php echo CHtml::htmlButton('<i class="fa fa-copy"></i> Salin', array(
                            'class' => 'btn btn-primary',
                            'onclick' => "copyFormat();",
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Scan Resep</label>
                    <div class="controls">
                        <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i> Refresh Load Resep', array(
                            'class' => 'btn btn-default',
                            'onclick' => "loadScanFile();",
                        )) . " " . CHtml::htmlButton('<i class="glyphicon glyphicon-file"></i> Buka Scanner', array(
                            'class' => 'btn btn-success',
                            'onclick' => "launchScanner();",
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="clear"></div>

            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="far fa-image"></i> Gambar Scan Resep
                        </div>
                    </div>

                    <div class="panel-body">
                        <?php

                        if (!$modReseptur->isNewRecord) {
                            $list = EresepT::model()->findAllByAttributes(array(
                                'reseptur_id' => $modReseptur->reseptur_id,
                            ));

                            foreach ($list as $item) {
                                echo $this->renderPartial($this->path_view . '_itemEresep', array(
                                    'item' => $item,
                                    'issubmit' => 1,
                                ));
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php if ($modReseptur->isNewRecord) : ?>

                <?php else :
                //echo "<hr>";
                // echo var_dump($modReseptur->e_resep_data); die;
                //echo CHtml::image("data:image/svg+xml;base64,".str_replace("\n", "", $modReseptur->e_resep_data));
                // die;
                endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .integer {
        text-align: right;
    }
</style>