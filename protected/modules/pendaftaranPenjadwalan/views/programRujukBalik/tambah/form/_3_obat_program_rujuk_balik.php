<div class='panel panel-success'>
    <div class='panel-body' id='form-tambah-obat'>
        <div class="col-sm-6">
            <div class="control-group required">
                <label class='control-label'>Nama Obat<span class='required'>*</span></label>
                <div class="controls">
                    <?= $form->hiddenField($model, 'obatprb_bpjskode', ['class' => 'obatprb_bpjskode required']) ?>
                    <?= $form->hiddenField($model, 'obatprb_bpjsnama', ['class' => 'obatprb_bpjsnama required']) ?>

                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'obatbpjsprb',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('autoCompleteObatPRB') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ){
                                $(this).val(ui.item.label);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                pilihObatPRB(ui.item);
                                return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'ketik obat prb',
                            'class' => 'span3 required obatbpjsprb',
                            'onkeypress' => "return $(this).focusNextInputField(event);",
                            'onblur' => 'if(this.value==""){resetObatPRB();}'
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogObatPRB', 'jsFunction' => '$("#dialogObatPRB").dialog("open");'),
                    ));
                    ?>
                </div>
            </div>

            <div class="control-group required">
                <label class='control-label'>Signa</label>
                <div class="controls">
                    <?= $form->textField($model, 'signa', ['class' => 'signa required span1']) ?> X <?= $form->textField($model, 'signa_2', ['class' => 'signa_2 required span1']) ?> hari
                    <?php
                    // $this->widget('MyJuiAutoComplete', array(
                    //     'model' => $model,
                    //     'attribute' => 'signa',
                    //     'source' => 'js: function(request, response) {
                    //         $.ajax({
                    //             url: "' . $this->createUrl('autoCompleteSigna') . '",
                    //             dataType: "json",
                    //             data: {
                    //                 term: request.term,
                    //             },
                    //             success: function (data) {
                    //                 response(data);
                    //             }
                    //         })
                    //     }',
                    //     'options' => array(
                    //         'showAnim' => 'fold',
                    //         'minLength' => 2,
                    //         'focus' => 'js:function( event, ui ){
                    //             $(this).val(ui.item.label);
                    //             return false;
                    //         }',
                    //         'select' => 'js:function( event, ui ) {
                    //             $(this).val(ui.item.value);
                    //             return false;
                    //         }',
                    //     ),
                    //     'htmlOptions' => array(
                    //         'placeholder' => 'ketik signa',
                    //         'class' => 'span3 signa',
                    //         'onkeypress' => "return $(this).focusNextInputField(event);",
                    //     ),
                    // ));
                    ?>
                </div>
            </div>

            <!-- <div class="control-group required">
                <label class='control-label'>Signa 2</label>
                <div class="controls">
                         <?php
                            // $this->widget('MyJuiAutoComplete', array(
                            //     'model' => $model,
                            //     'attribute' => 'signa_2',
                            //     'source' => 'js: function(request, response) {
                            //     $.ajax({
                            //         url: "' . $this->createUrl('autoCompleteSigna') . '",
                            //         dataType: "json",
                            //         data: {
                            //             term: request.term,
                            //         },
                            //         success: function (data) {
                            //             response(data);
                            //         }
                            //     })
                            // }',
                            //     'options' => array(
                            //         'showAnim' => 'fold',
                            //         'minLength' => 2,
                            //         'focus' => 'js:function( event, ui ){
                            //         $(this).val(ui.item.label);
                            //         return false;
                            //     }',
                            //         'select' => 'js:function( event, ui ) {
                            //         $(this).val(ui.item.value);
                            //         return false;
                            //     }',
                            //     ),
                            //     'htmlOptions' => array(
                            //         'placeholder' => 'ketik signa 2',
                            //         'class' => 'span3 signa_2',
                            //         'onkeypress' => "return $(this).focusNextInputField(event);",
                            //     ),
                            // ));
                            ?>
                </div>
            </div> -->

            <div class="control-group">
                <label class="control-label">Cara Penggunaan</label>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'carapenggunaanobat[]', LookupM::getItems('etiket_1'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat'));
                    echo $form->dropDownList($model, 'carapenggunaanobat[]', LookupM::getItems('etiket_2'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat'));
                    echo $form->dropDownList($model, 'carapenggunaanobat[]',  LookupM::getItems('etiket_3'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat'));
                    echo $form->dropDownList($model, 'carapenggunaanobat[]', LookupM::getItems('etiket_4'), array('style' => 'width:70px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat'));
                    ?>
                </div>
            </div>

            <div class='control-group'>
                <label class='control-label'>Jumlah<span class='required'>*</span></label>
                <div class='controls'>
                    <?= $form->textField($model, 'qty_obat', ['class' => 'numbers-only qty_obat required']) ?>
                </div>
                <div class='controls'>
                    <?= CHtml::link("<span class='entypo-plus'></span>", 'javascript:;', ['class' => 'btn btn-primary btn-sm', 'onclick' => 'tambahObat();']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<br />
<table class='table table-bordered table-condensed table-striped' id='tabel-list-obat'>
    <thead>
        <tr>
            <th>Nama/Kode Obat RS</th>
            <th>Nama/Kode PRB</th>
            <th>Signa</th>
            <th>Cara Penggunaan Obat</th>
            <th>Jumlah</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (!$base->isNewRecord) {
            $det = ObatprogramrujukbalikpasienT::model()->findAllByAttributes(array(
                'programrujukbalikpasien_id'=>$base->programrujukbalikpasien_id,
            ));

            foreach ($det as $i => $row) {
                // var_dump($row->attributes); die;
                $oa = ObatalkesM::model()->findByPk($row->obatalkes_id);
                $row->obatalkes_nama = $oa->obatalkes_nama;
                $row->obatbpjsprb = $row->obatprb_bpjskode." - ".$row->obatprb_bpjsnama;
                echo $this->renderPartial('tambah/form/row/_3_detail_obat',['model'=>$row, 'i'=>$i], true);
            }

        }


        ?>
    </tbody>
</table>