<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Pejabat Terkait </b></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pejabatpenggunaanggaran_id', array(
                    'class'=>'control-label',
                )); ?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'pejabatpenggunaanggaran_id', array(
                            'class'=>'pejabatpenggunaanggaran_id',
                        ));

                        $pejabatpenggunaanggaran_nama = "";

                        // --- kondisi jika ada data-nya
                        if (!empty($model->pejabatpenggunaanggaran_id)) {
                            $peg = PegawaiM::model()->findByPk($model->pejabatpenggunaanggaran_id);
                            $model->pejabatpenggunaanggaran_nama = $peg->namaLengkap;
                        }
                        // --- end
                        echo $form->textField($model, 'pejabatpenggunaanggaran_nama', array(
                            'class'=>'span3 pejabatpenggunaanggaran_nama','readonly'=>true
                        ));
                        /*
                        $this->widget('MyJuiAutoComplete', array(
                                'name'=>'pejabatpenggunaanggaran_nama',
                                'value'=>$pejabatpenggunaanggaran_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompletePejabatPengguna').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 3,
                                       'focus'=> 'js:function( event, ui ) {
                                            $(this).val("");
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.label);
                                            $(this).parents(".controls").find(".pejabatpenggunaanggaran_id").val(ui.item.value);
                                            $("#SuratperjanjiankerjaT_nosuratperjanjiankerja").blur();
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array(
                                    'disabled'=>false,
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'span3 pejabatpenggunaanggaran_nama',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPejabatPengguna'),
                            ));*/
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label"> Kuasa Pengguna Anggaran <span class="required"> * </span></label>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'kuasapenggunaanggaran_id', array(
                            'class'=>'kuasapenggunaanggaran_id',
                        ));

                        $kuasapenggunaanggaran_nama = "";

                        // --- kondisi jika ada data-nya
                        if (!empty($model->kuasapenggunaanggaran_id)) {
                            $peg = PegawaiM::model()->findByPk($model->kuasapenggunaanggaran_id);
                            $model->kuasapenggunaanggaran_nama = $peg->namaLengkap;
                        }
                        // --- end
                        
                        $this->widget('MyJuiAutoComplete', array(
                                'model'=>$model,
                                'attribute'=>'kuasapenggunaanggaran_nama',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompleteKuasaPengguna').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 3,
                                       'focus'=> 'js:function( event, ui ) {
                                            $(this).val("");
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.label);
                                            $(this).parents(".controls").find(".kuasapenggunaanggaran_id").val(ui.item.value);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array(
                                    'disabled'=>false,
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'span3 kuasapenggunaanggaran_nama required',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogKuasaPengguna'),
                            ));
                    ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>