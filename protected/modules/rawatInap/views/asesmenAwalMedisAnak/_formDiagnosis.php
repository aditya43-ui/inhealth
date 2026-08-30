<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Diagnosis</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-12">
                <div class="form-horizontal">
                <div class="control-group">
                    <?php echo CHtml::label('Diagnosis ICD X <span class="required">*</span>', 'Diagnosis', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeHiddenField($modPasienMorbiditas, 'diagnosa_id', array('readonly' => true));
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPasienMorbiditas,
                            'attribute' => 'diagnosa_nama',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/diagnosa') . '",
                                            dataType: "json",
                                                data: {
                                                    term: request.term,
                                                    tipe: 1,
                                            },
                                                success: function (data) {
                                                response(data);
                                        }
                                         })
                                        }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                                    $(this).val(ui.item.value);
                                                    return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                                set_diagnosis();
                                                $("#PasienmorbiditasT_diagnosa_kode").val(ui.item.diagnosa_kode);
                                                $("#PasienmorbiditasT_diagnosa_nama1").val(ui.item.diagnosa_nama);
                                                $("#PasienmorbiditasT_diagnosa_nama").val(ui.item.diagnosa_nama);
                                                $("#PasienmorbiditasT_diagnosa_id").val(ui.item.diagnosa_id);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array('placeholder' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required'),
                            'tombolDialog' => array('idDialog' => 'Diagnosadialog'),
                        ));
                        ?>
                    </div>
                </div>
                </div><br><br>
                <table class="table table-striped" id="form-diagnosis">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl.Diagnosis <span class="required">*</span></th>
                        <th>Kelompok Diagnosis <span class="required">*</span></th>
                        <th>Kasus Diagnosis <span class="required">*</span></th>
                        <th>Kode Diagnosis</th>
                        <th>Nama Diagnosis</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (!empty($modPasienMorbiditas->pasienmorbiditas_id)){
                                echo $this->renderPartial($this->path_view.'_row_diagnosis',['model'=>$modPasienMorbiditas], true);
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

