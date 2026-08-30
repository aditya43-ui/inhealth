<tr>
    <td>
        <?php
            echo CHtml::checkBox(
                "BKPembayaranpelayananT[$i][is_simpan]",
                $is_load,
                array()
            );
        ?>
    </td>
    <td>
        <?php
            $this->widget('MyDateTimePicker',
                array(
                    'model'=>$model,
                    'attribute'=>"[$i]tgl_tindakan",
                    'mode'=>'datetime',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                        'maxDate' => 'd',
                        'yearRange'=> "-60:+0",
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                        'class'=>'dtPicker3 span2', 
                        'onkeypress'=>"return $(this).focusNextInputField(event)"
                    ),
                )
            );
        ?>
    </td>
    <td>
        <?php
            $this->widget('MyJuiAutoComplete',
                array(
                    'model'=>$model,
                    'value'=>(isset($model->daftartindakan->daftartindakan_nama) ? $model->daftartindakan->daftartindakan_nama : ""),
                    'name'=>"BKPembayaranpelayananT[$i][daftartindakan_nama]",
                    'source'=>'js: function(request, response){
                        $.ajax(
                            {
                                url:"'.Yii::app()->createUrl('ActionAutoComplete/daftarTindakanBilling').'",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    idTipePaket: 1,
                                    idKelasPelayanan: 5
                                },
                                success: function (data) {
                                    response(data);
                                }
                            }
                        )
                    }',
                    'htmlOptions'=>array(
                        'class' => 'span2',
                    ),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 2,
                        'focus'=> 'js:function( event, ui ){
                            $(this).val(ui.item.value);
                            return false;
                        }',
                        'select'=>'js:function( event, ui ){
                            isiDataPasien(ui.item);
                            return false;
                        }',
                    ),

                )
            );            
            echo CHtml::hiddenField(
                "BKPembayaranpelayananT[$i][tindakanpelayanan_id]",
                $model->tindakanpelayanan_id,
                array(
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField(
                "BKPembayaranpelayananT[$i][daftartindakan_id]",
                $model->daftartindakan_id,
                array(
                    'readonly'=>true
                )
            )
        ?>
    </td>
    <td>
        <?php
            echo CHtml::DropDownList("BKPembayaranpelayananT[$i][ruangan_id]", 
                $model->ruangan_id,
                RuanganM::items(),
                array(
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'class'=>'inputFormTabel'
                )
            );
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::textField("BKPembayaranpelayananT[$i][qty_tindakan]", 
                $model->qty_tindakan,
                array(
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'span1 currency'
                )
            );
            echo CHtml::DropDownList("BKPembayaranpelayananT[$i][satuantindakan]", 
                $model->satuantindakan,
                LookupM::getItems('satuantindakan'),
                array(
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'class'=>'inputFormTabel'
                )
            );
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::textField("BKPembayaranpelayananT[$i][tarif_tindakan]", 
                $model->tarif_tindakan,
                array(
                    'readonly'=>false,
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'inputFormTabel currency'
                )
            );
            echo CHtml::hiddenField(
                "BKPembayaranpelayananT[$i][tarif_rsakomodasi]",
                $model->tarif_rsakomodasi
            );
            echo CHtml::hiddenField(
                "BKPembayaranpelayananT[$i][tarif_medis]",
                $model->tarif_medis
            );
            echo CHtml::hiddenField(
                "BKPembayaranpelayananT[$i][tarif_paramedis]",
                $model->tarif_paramedis
            );
            echo CHtml::hiddenField(
                "BKPembayaranpelayananT[$i][tarif_bhp]",
                $model->tarif_bhp
            );
            echo CHtml::hiddenField(
                "BKPembayaranpelayananT[$i][tarif_satuan]",
                $model->tarif_satuan
            );
        ?>        
    </td>
    <td>
        <?php
            echo CHtml::DropDownList("BKPembayaranpelayananT[$i][cyto_tindakan]",
                $model->cyto_tindakan,
                array(
                    '0'=>'Tidak',
                    '1'=>'Ya'
                ),
                array(
                    'onchange'=>'hitungCyto(this)',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'class'=>'inputFormTabel lebar2-5'
                )
            );
            echo CHtml::textField("BKPembayaranpelayananT[$i][tarifcyto_tindakan]", 
                $model->tarifcyto_tindakan,
                array(
                    'style'=>($model->cyto_tindakan == true ? 'display:both' : 'display:none'),
                    'readonly'=>false,
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'inputFormTabel currency'
                )
            );
        ?>        
    </td>
    <td>
        <?php 
            echo CHtml::textField("BKPembayaranpelayananT[$i][discount_tindakan]", 
                $model->discount_tindakan,
                array(
                    'readonly'=>false,
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'inputFormTabel currency'
                )
            );
        ?>        
    </td>
    <td>
        <?php 
            echo CHtml::textField("BKPembayaranpelayananT[$i][subsidiasuransi_tindakan]", 
                $model->subsidiasuransi_tindakan,
                array(
                    'readonly'=>false,
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'inputFormTabel currency'
                )
            );
        ?>        
    </td>
    <td>
        <?php 
            echo CHtml::textField("BKPembayaranpelayananT[$i][subsidipemerintah_tindakan]", 
                $model->subsidipemerintah_tindakan,
                array(
                    'readonly'=>false,
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'inputFormTabel currency'
                )
            );
        ?>        
    </td>
    <td>
        <?php 
            echo CHtml::textField("BKPembayaranpelayananT[$i][subsisidirumahsakit_tindakan]", 
                $model->subsisidirumahsakit_tindakan,
                array(
                    'readonly'=>false,
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'inputFormTabel currency'
                )
            );
        ?>        
    </td>
    <td>
        <?php 
            echo CHtml::textField("BKPembayaranpelayananT[$i][iurbiaya_tindakan]", 
                $model->iurbiaya_tindakan,
                array(
                    'readonly'=>false,
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'inputFormTabel currency'
                )
            );
        ?>        
    </td>
    <td>
        <?php
            echo CHtml::textField("BKPembayaranpelayananT[$i][total_biaya]",
                ($model->cyto_tindakan == true ? (($model->qty_tindakan * $model->tarif_tindakan) + $model->tarifcyto_tindakan) : ($model->qty_tindakan * $model->tarif_tindakan)) ,
                array(
                    'readonly'=>false,
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'inputFormTabel currency'
                )
            );
        ?>        
    </td>
    <td>
        <a onclick="removeTindakan(this);return false;" rel="tooltip" href="#" data-original-title="Klik untuk menghapus tindakan">
            <i class="icon-minus"></i>
        </a>
    </td>
</tr>