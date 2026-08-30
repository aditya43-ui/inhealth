<tr>
    <td>
        <?php
            echo CHtml::checkBox(
                "BKObatalkesPasienT[$i][is_simpan]",
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
                    'attribute'=>"[$i]tglpelayanan",
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
            echo (isset($model->obatalkes->obatalkes_nama) ?$model->obatalkes->obatalkes_nama  : $model->obatalkes_nama);
            echo CHtml::hiddenField(
                "BKObatalkesPasienT[$i][obatalkespasien_id]",
                $model->obatalkespasien_id,
                array(
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField(
                "BKObatalkesPasienT[$i][tindakanpelayanan_id]",
                $model->tindakanpelayanan_id,
                array(
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField(
                "BKObatalkesPasienT[$i][daftartindakan_id]",
                $model->daftartindakan_id,
                array(
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField(
                "BKObatalkesPasienT[$i][obatalkes_id]",
                $model->obatalkes_id,
                array(
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField(
                "BKObatalkesPasienT[$i][sumberdana_id]",
                $model->sumberdana_id,
                array(
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField(
                "BKObatalkesPasienT[$i][satuankecil_id]",
                $model->satuankecil_id,
                array(
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField(
                "BKObatalkesPasienT[$i][tipepaket_id]",
                $model->tipepaket_id,
                array(
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField(
                "BKObatalkesPasienT[$i][ruangan_id]",
                $model->ruangan_id,
                array(
                    'readonly'=>true
                )
            );
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::textField("BKObatalkesPasienT[$i][qty_oa]", 
                $model->qty_oa,
                array(
                    'onblur'=>'hitungTotalSemuaTind();',
                    'class'=>'inputFormTabel currency'
                )
            );
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::textField("BKObatalkesPasienT[$i][hargasatuan_oa]", 
                $model->hargasatuan_oa,
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
            echo CHtml::textField("BKObatalkesPasienT[$i][tarifcyto]", 
                $model->tarifcyto,
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
            echo CHtml::textField("BKObatalkesPasienT[$i][discount]", 
                $model->discount,
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
            echo CHtml::textField("BKObatalkesPasienT[$i][subsidiasuransi]", 
                $model->subsidiasuransi,
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
            echo CHtml::textField("BKObatalkesPasienT[$i][subsidipemerintah]", 
                $model->subsidipemerintah,
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
            echo CHtml::textField("BKObatalkesPasienT[$i][subsidirs]", 
                $model->subsidirs,
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
            echo CHtml::textField("BKObatalkesPasienT[$i][iurbiaya]", 
                $model->iurbiaya,
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
            echo CHtml::textField("BKObatalkesPasienT[$i][total_biaya]",
                ($model->qty_oa * $model->hargasatuan_oa),
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