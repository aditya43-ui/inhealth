<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Rencana Perawatan Dialisis</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label class="control-label">Tanggal Dialisis Pertama</label>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'waktu_dialisis_pertama',
                                'mode'=>'date',
                                'options'=> array(
                                        'dateFormat'=>'dd-mm-yy',
                                        'maxDate' => 'd',
                                        'yearRange'=> "-60:+0",
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>' span4', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Masalah yang Ditemukan</label>
                <div class="controls">
                    <?= $form->textArea($model, 'masalah_yang_ditemukan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'style' => 'width: 265px; height: 101px;')); ?>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label class="control-label">Profesi</label>
                <div class="controls">
                    <?= $form->dropDownList($model, 'profesi', LookupM::getItemsUrutan('profesi'), array('empty' => '--Pilih--', 'class' => 'span4 required profesi','onchange'=>"changeProfesi(this); pilihDialog(this);")); ?>
                    <?php echo CHtml::hiddenField('kelompok_pegawai', '', array('class' => 'kelompok')); ?>
                </div>
            </div>
            <span id="pilih_pegawai" style="display: block">
            <div class="control-group">
                <label class="control-label">Nama Pegawai</label>
                <div class="controls">
                    <?php
                        echo CHtml::activeHiddenField($model, 'pegawai_id', array('readonly' => true));
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'nama_pegawai',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/GetPegawai') . '",
                                            dataType: "json",
                                            data: {
                                               term: request.term,
                                               kelompokpegawai: $(".kelompok").val()
                                            },
                                            success: function (data) {
                                                response(data);
                                            }
                                    })
                                 }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.label);
                                            $("#RIPerkembanganTerintegrasiPasienT_pegawai_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 nama_profesi', 'placeholder' => 'Ketikkan Nama Pegawai  '),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai','jsFunction'=>'setDialog(this);'),
                        ));
                    ?>
                </div>
            </div>
            </span>
        </div>
        </div>
        <div class="row-fluid">
        <div class="span12">
            <div class="control-group">
                <label class="control-label">Perencanaan</label>
                <div class="controls" style="width: 71%">
                    <div id="perencanaan" class="perencanaan">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model'=>$model, 'attribute'=>'perencanaan', 'toolbar'=>'default', 'height'=>'100px', 'width'=>'100%')); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Instruksi</label>
                <div class="controls" style="width: 71%">
                    <div id="instruksi" class="instruksi">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model'=>$model, 'attribute'=>'instruksi', 'toolbar'=>'default', 'height'=>'100px', 'width'=>'100%')); ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>