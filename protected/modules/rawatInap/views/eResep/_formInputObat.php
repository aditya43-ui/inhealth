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

            <div class="control-group">
                <?php echo CHtml::label("Dokter <span class='required'>*</span>", 'pegawai_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($modReseptur, 'pegawai_id', array('id' => 'pegawai_reseptur', 'class' => 'required', "placeholder" => "Nama Dokter")); ?>
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
                        'htmlOptions' => array('class' => 'span3 required', 'onblur' => 'if(this.value == ""){ setDokterReseptur("","")}')
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
                    <?php echo CHtml::textField('iter', '0', array('readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1  numbers-only')) ?>
                </div>
            </div>
            <hr>
            <table id="tampung_gambar" width="100%">

            </table>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        &nbsp;
                    </div>

                    <div class="panel-options" style="float:left;">
                        <a href="javascript:void(0);"><label>Tools :</label></a>
                        <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk menyimpam file gambar yang sudah dibuat" href="javascript:void(0);" id="open-image" data-rel="reload"><i class="glyphicon glyphicon-floppy-save"></i></a>
                        <a class="nohref">||</a>
                        <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk membuat garis pada bidang gambar" href="javascript:void(0);" id="tool-pencil"><i class="glyphicon glyphicon-pencil"></i></a>
                        <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk menghapus pada bidang gambar" href="javascript:void(0);" id="tool-eraser"><i class="glyphicon glyphicon-trash"></i></a>
                        <a class="nohref">||</a>
                        <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 1" href="javascript:void(0);" class='tool' id="sizeTool-1" style="border: 1px solid;">
                            <svg width="10" height="10" version="1.1" data-reactid=".1.$1.0.0">
                                <circle cx="5" cy="5" r="0.5" data-reactid=".1.$1.0.0.0"></circle>
                            </svg>
                        </a>
                        <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 5" href="javascript:void(0);" class='tool' id="sizeTool-2" style="border: 1px solid;">
                            <svg width="10" height="10" version="1.1" data-reactid=".1.$5.0.0">
                                <circle cx="5" cy="5" r="2.5" data-reactid=".1.$5.0.0.0"></circle>
                            </svg>
                        </a>
                        <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 10" href="javascript:void(0);" class='tool' id="sizeTool-3" style="border: 1px solid;">
                            <svg width="10" height="10" version="1.1" data-reactid=".1.$10.0.0">
                                <circle cx="5" cy="5" r="3.5" data-reactid=".1.$10.0.0.0"></circle>
                            </svg>
                        </a>
                        <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 15" href="javascript:void(0);" class='tool' id="sizeTool-4" style="border: 1px solid;">
                            <svg width="10" height="10" version="1.1" data-reactid=".1.$15.0.0">
                                <circle cx="5" cy="5" r="4.5" data-reactid=".1.$15.0.0.0"></circle>
                            </svg>
                        </a>
                        <a class="nohover"><label>||</label></a>
                        <!--<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>-->
                        <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengembalikan perubahan bidang gambar ke awal" href="javascript:void(0);" id="clear-lc" data-rel="reload"><i class="glyphicon glyphicon-refresh"></i></a>

                    </div>
                </div>

                <div class="panel-body">
                    <div class="literally core"></div>
                    <div class="controls">
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