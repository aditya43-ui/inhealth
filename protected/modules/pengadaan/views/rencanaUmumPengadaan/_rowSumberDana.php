<tr data-row="0">
    <?php echo CHtml::hiddenField('no_row','',array('readonly' => true)); ?>
    <td class="row_num" style="text-align: right;">
        1
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modSumberDana, '[0]sumberanggaran_id', CHtml::listData(SumberanggaranM::model()->findAll('sumberanggaran_aktif IS TRUE ORDER BY sumberanggarannama ASC'), 'sumberanggaran_id', 'sumberanggarannama'), array('class' => 'span2 required sumberanggaran_id', 'onchange' => 'setSumberDana(this)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => "width: 120px"));
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modSumberDana, '[0]asal_dana', array('class' => 'span2 asal_nama', 'style' => "width: 120px", 'placeholder' => 'Asal Dana')); ?>
    </td>
    <td>
        <?php
//        echo $form->dropDownList($modSumberDana, '[0]rekening5_id', ADRencanaumumpengadaanT::getRekeningMAK(), array('class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => "width: 120px"));
        echo CHtml::activeHiddenField($modSumberDana, '[0]kegiatanprogram_id', array('readonly' => true, 'class' => 'span3 kegiatanprogram_id required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
        echo CHtml::activeHiddenField($modSumberDana, '[0]rekening5_id', array('readonly' => true, 'class' => 'span3 mak_id', 'onkeyup' => "return $(this).focusNextInputField(event);"));
        echo CHtml::activeHiddenField($modSumberDana, '[0]mappingrekeninganggaran_id', array('readonly' => true, 'class' => 'span3 mappingrekeninganggaran_id', 'onkeyup' => "return $(this).focusNextInputField(event);"));
        echo CHtml::activeHiddenField($modSumberDana, '[0]rekeninganggaran5_id', array('readonly' => true, 'class' => 'span3 rekeninganggaran5_id', 'onkeyup' => "return $(this).focusNextInputField(event);"));
        //echo CHtml::activeTextField($modSumberDana,'[0]kode_rekening',array('class'=>'span3 mak_nama required', 'readonly'=>true));
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modSumberDana,
            'attribute' => '[0]kode_rekening',
            'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('RekeningMAK') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    subprogramkerja_id:$("#ADRencanaumumpengadaanT_subkegiatanprogram_id").val()
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 2,
                'focus'=> 'js:function( event, ui ) {
                                $(this).val(ui.item.label);
                                return false;
                            }',
                'select' => 'js:function( event, ui ) {                        
                                setPengadaan(ui.item,this);
                                return false;
                            }',
            ),
            'htmlOptions' => array(
                'class' => 'hurufs-only span3 mak_nama required',
                'placeholder' => 'Ketik MAK',
            ),
            'tombolDialog' => array('idDialog' => 'dialogMAK','jsFunction'=>"setDialog(this);"),
        ));
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modSumberDana, '[0]komponen_kegiatan', array('readonly'=>true,'class' => 'span2 komponen_kegiatan', 'style' => "width: 120px", 'placeholder' => 'Komponen Kegiatan')); 
        
//            $this->widget('MyJuiAutoComplete', array(
//                'model' => $modSumberDana,
//                'attribute' => '[0]komponen_kegiatan',
//                'source' => 'js: function(request, response) {
//                                $.ajax({
//                                    url: "' . $this->createUrl('AutoCompleteKegiatanProgram') . '",
//                                    dataType: "json",
//                                    data: {
//                                        term: request.term,
//                                        subprogramkerja_id:$("#ADRencanaumumpengadaanT_subkegiatanprogram_id").val()
//                                    },
//                                    success: function (data) {
//                                        response(data);
//                                    }
//                                })
//                            }',
//                'options' => array(
//                    'showAnim' => 'fold',
//                    'minLength' => 2,
//                    'focus'=> 'js:function( event, ui ) {
//                                    $(this).val(ui.item.label);
//                                    return false;
//                                }',
//                    'select' => 'js:function( event, ui ) {                        
//                                    setKomponenKegiatan(ui.item,this);
//                                    return false;
//                                }',
//                ),
//                'htmlOptions' => array(
//                    'class' => 'hurufs-only span3 komponen_kegiatan required',
//                    'placeholder' => 'Ketik MAK',
//                ),
//                'tombolDialog' => array('idDialog' => 'dialogKegiatan','jsFunction'=>"setDialog(this);"),
//            ));
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modSumberDana, '[0]pagu', array('class' => 'span2 integer-decimal required nilaipagu', 'style' => "width: 110px;text-align:right", 'onblur' => 'hitungTotalSumberDana(this);', 'placeholder' => '10.000', 'readonly'=>false)); ?>
    </td>
    <td class="" style="width: 100px; text-align: center; display: <?= isset($_GET['sukses']) ? "none" : "block" ?>" >
        <?php
        echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', '#', array(
            'onclick' => 'tambahSumberDana(this); return false;',
        ));
        
        if (empty($sendiri) || !$sendiri) {
            echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', '#', array(
                'onclick' => 'hapusSumberDana(this); return false;',
            ));
        }
        ?>
    </td>
</tr>