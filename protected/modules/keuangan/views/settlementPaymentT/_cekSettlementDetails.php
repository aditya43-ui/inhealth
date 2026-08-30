<?php
foreach ($modSettlementPaymentDetails as $i => $modSettlementPaymentDetail) {
?>
<tr>
    
    <td>
        <div class="input-append">
        <?php 
           
            echo CHtml::activeTextField($modSettlementPaymentDetail, '[0]tgltransaksi', array('readonly'=>true,'class'=>'tanggal dtPicker2 realtime', 'style'=>'float:left;','value'=>  MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')),'onchange'=>'setDate(this)')); 
        ?>
        <span class="add-on"><i class="icon-calendar"></i><i class="icon-time"></i></span></div>
  </td>
  <td><?php echo CHtml::activeHiddenField($modSettlementPaymentDetail, '[0]jenispengeluaran_id', array('readonly'=>true,'class'=>'inputFormTabel daftartindakan_id')) ?>
  <?php
        // echo $form->hiddenField($model,'jenispengeluaran_id',array('readonly'=>true, 'class'=>'required'));
        $this->widget('MyJuiAutoComplete', array(
                'model' => $modSettlementPaymentDetail,
                'attribute' => '[0]jenispengeluaran_nama',
                'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/JenisPengeluaran'),
                'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.jenispenerimaan);
                                        return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                          setPengeluaran($(this), ui.item);
                                        return false;
                            }'
                ),
                'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder'=>'Ketikan Jenis Pengeluaran',
                        'class'=>'span3 required',
                        // 'style'=>'width:150px;',
                ),
                'tombolDialog' => array('idDialog' => 'dialogJenisPengeluaran','jsFunction'=>"setDialogJenisPengeluaran(this);"),
        ));
    ?>
        
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]kelaspelayanan_id', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]subsidiasuransi_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]subsidipemerintah_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]subsisidirumahsakit_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]iurbiaya_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
		<?php //echo CHtml::activeHiddenField($modTindakan, '[0]keltindakanid', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </td>
  <td>
    <?php echo CHtml::activeTextArea($modSettlementPaymentDetail, '[0]deskripsi', array('class'=>'inputFormTabel')) ?>
  </td>
  <td>
    <?php echo CHtml::activeTextField($modSettlementPaymentDetail, '[0]noreferensi', array('class'=>'inputFormTabel')) ?>
  </td>
  <td>
    <?php echo CHtml::activeTextField($modSettlementPaymentDetail, '[0]volume', array('class'=>'inputFormTabel integer span2','onblur'=>'hitungTotalUraian(this)')) ?>
  </td>
  <td>
    <?php echo CHtml::activeDropDownList($modSettlementPaymentDetail, '[0]satuanvol', LookupM::getItems('satuanumum'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span2')) ?>
  </td>
  <td>
    <?php echo CHtml::activeTextField($modSettlementPaymentDetail, '[0]hargasatuan', array('class'=>'inputFormTabel integer-decimal span2','onblur'=>'hitungTotalUraian(this)')) ?>
  </td>
  <td>
    <?php echo CHtml::activeTextField($modSettlementPaymentDetail, '[0]totalharga', array('readonly'=>true,'class'=>'inputFormTabel integer-decimal span2')) ?>
  </td>
  <td><?php echo CHtml::activeHiddenField($modSettlementPaymentDetail, '[0]rekening5_id', array('readonly'=>true,'class'=>'inputFormTabel daftartindakan_id')) ?>
  <?php
  $this->widget('MyJuiAutoComplete', array(
                        'model' => $modSettlementPaymentDetail,
                        'attribute' => '[0]rekening5_nama',
                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening1);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening5);
                                setRekening($(this), ui.item);
                               return false;
                            }'
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder'=>'Ketikan Nama Rekening',
                            'class'=>'span2',
                            'style'=>'width:50px;',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogRekDebit','jsFunction'=>"setDialogRekening(this);"),
                    ));
                ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]kelaspelayanan_id', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]subsidiasuransi_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]subsidipemerintah_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]subsisidirumahsakit_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]iurbiaya_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
		<?php //echo CHtml::activeHiddenField($modTindakan, '[0]keltindakanid', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </td>
  <td>
        <?php 
            if(!isset($removeButton)){
                $removeButton = false;
            }
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowUraian(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian SAP', 'data-placement'=>'right')); 
                echo "&nbsp;&nbsp;";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalUraian(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan uraian SAP', 'data-placement'=>'right'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowUraian(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan', 'data-placement'=>'right'));
            }
        ?>
    </td>
    <!-- <td><?php //echo CHtml::activeHiddenField($modTindakan, '[0]daftartindakan_id', array('readonly'=>true,'class'=>'inputFormTabel daftartindakan_id')) ?>
        <?php
        // $this->widget('MyJuiAutoComplete',array(
                    // 'model'=>$modTindakan,
                    // 'attribute'=>'[0]daftartindakanNama',
                    // //'name'=>'daftartindakan_nama',
                    // 'source'=>'js: function(request, response) {
                    //                $.ajax({
                    //                    url: "'.Yii::app()->createUrl('rawatInap/tindakanTRI/DaftarTindakan').'",
                    //                    dataType: "json",
                    //                    data: {
                    //                        term: request.term,
                    //                        tipepaket_id: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
                    //                        kelaspelayanan_id: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                    //                        penjamin_id: $("#RJPendaftaranT_penjamin_id").val(),
                    //                    },
                    //                    success: function (data) {
                    //                            response(data);
                    //                    }
                    //                })
                    //             }',
                    // 'options'=>array(
                    //    'showAnim'=>'fold',
                    //    'minLength' => 2,
                    //    'focus'=> 'js:function( event, ui ) {
                    //         $(this).val( ui.item.label);
                    //         return false;
                    //     }',
                    //    'select'=>'js:function( event, ui ) {
                    //         setPengeluaran($(this), ui.item);
                    //         return false;
                    //     }',

                    // ),
                    // 'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket','jsFunction'=>"setDialog(this);"),
                    // 'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", ),
        //)); ?>
        
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]kelaspelayanan_id', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]subsidiasuransi_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]subsidipemerintah_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]subsisidirumahsakit_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php //echo CHtml::activeHiddenField($modTindakan, '[0]iurbiaya_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
		<?php //echo CHtml::activeHiddenField($modTindakan, '[0]keltindakanid', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </td> -->
     <td><?php //echo CHtml::activeDropDownList($modSettlementPaymentDetail, '[0]satuantindakan', LookupM::getItems('satuantindakan'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span2')) ?></td>
</tr>

<?php }?>