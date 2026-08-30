<tr class ="<?php echo $model->pendaftaran_id; ?>">
    <?php if ($cekTabelDetail == 0 && $i == 0){ ?>
        <td class="aturbaris cekbox" rowspan="<?php echo ($countJnsWaktu); ?>"  style="vertical-align: middle;text-align: center;">
            <?php echo CHtml::activeCheckBox($model,'['.$i.']checkList', array('class'=>'cekList','onclick'=>'pilihMenuDiet(this);', 'value'=>$model->pendaftaran_id)); ?>
        </td>
        <td class="aturbaris"  rowspan="<?php echo ($countJnsWaktu); ?>"><?php echo '<label>'.$model->ruangan_nama.'</label>'; ?></td>
        <td class="aturbaris"  rowspan="<?php echo ($countJnsWaktu); ?>"><?php echo '<label>'.$model->no_pendaftaran.'</label>'; ?></td>
        <td class="aturbaris"  rowspan="<?php echo ($countJnsWaktu); ?>"><?php echo '<label>'.$model->no_rekam_medik.'</label>'; ?></td>
        <td class="aturbaris"  rowspan="<?php echo ($countJnsWaktu); ?>"><?php echo '<label>'.$model->nama_pasien.'</label>'; ?></td>
        <td class="aturbaris"  rowspan="<?php echo ($countJnsWaktu); ?>"><?php echo '<label>'.$model->jeniskelamin.'</label>/ <br/><label>'.$model->umur.'</label>' ?></td>
        <td class="aturbaris"  rowspan="<?php echo ($countJnsWaktu); ?>"><?php echo '<label>'.$model->jenisdiet_nama.'</label>' ?></td>
    <?php } ?>  
    <td hidden>
        <?php echo '<label class="lbl-tipediet_id">'.$model->tipediet_nama.'</label>'; ?>
    </td>   
    <td hidden>
        <?php 
            echo '<label class="lbl-jenismakan">'.$model->jenismakanan_nama.'</label>';
            echo CHtml::activeCheckBox($model,'['.$i.']ceklis_baris',array('class' => 'ceklis_baris hide'));            
            echo CHtml::activeHiddenField($model,'['.$i.']jenismakanan_id',array('class' => 'det_jenismakanan_id'));
            echo CHtml::activeHiddenField($model, '['.$i.']pendaftaran_id', array('class'=>'det_pendaftaran_id'));
            echo CHtml::activeHiddenField($model, '['.$i.']pasien_id', array('class' => 'det_pasien_id'));
            echo CHtml::activeHiddenField($model, '['.$i.']pasienadmisi_id', array('class'=>'det_pasienadmisi_id'));
            echo CHtml::activeHiddenField($model, '['.$i.']kelaspelayanan_id', array('class'=>'det_kelaspelayanan_id'));
            echo CHtml::activeHiddenField($model, '['.$i.']pesanmenudiet_id', array('class'=>'pesanmenudiet_id'));
            echo CHtml::activeHiddenField($model, '['.$i.']jenisdiet_id', array('class' => 'jenisDiet det_jenisdiet_id det_jenismenudiet_id'));
            echo CHtml::activeHiddenField($model, '['.$i.']menudiet_id', array('class' => 'jenisDiet det_menudiet_id menudiet_id'));
            echo CHtml::activeHiddenField($model, '['.$i.']pesanmenudiet_riwayat_id', array('class' => 'jenisDiet det_pesanmenudiet_riwayat_id'));            
            echo CHtml::activeHiddenField($model, '['.$i.']pesanmenudetail_id', array('class' => 'jenisDiet det_pesanmenudetail_id'));      
            // echo CHtml::activeHiddenField($model, '['.$i.']menudiet_id', array('class' => 'jenisDiet menudiet_id'));      
            echo CHtml::activeTextField($model, '['.$i.']tipediet_id', array('class' => 'jenisDiet det_tipediet_id'));            
            echo CHtml::activeHiddenField($model, '['.$i.']alatmakanan_id', array('class' => 'det_alatmakan_id'));        
            echo CHtml::activeHiddenField($model, '['.$i.']adaalergimakanan', array('class' => 'adaalergimakanan'));            
            echo CHtml::activeHiddenField($model, '['.$i.']keterangan', array('class' => 'keterangan'));         
        ?>
    </td>
    <td>
        <?php echo '<label class="lbl-jenismenudiet">'.$model->menudiet_nama.'</label>'; ?>
    </td>
    <td>
        <?php
            echo '<label class="lbl-jeniswaktu">'.$model->jeniswaktu_nama.'</label>';
            echo CHtml::activeHiddenField($model, '['.$i.']jeniswaktu_id', array('class' => 'det_jeniswaktu_id'));      
            echo CHtml::activeHiddenField($model, '['.$i.']verifikasi_id', array('class' => 'verifikasi_id'));  
        ?>
    </td>
    <td hidden>
        <?php
            echo '<label class="lbl-alatmakanan_nama">'.$model->alatmakanan_nama.'</label>';
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '['.$i.']jml_pesan_porsi', array('class'=>' span1 numbersOnly det_jml_pesan_porsi', 'style'=>'text-align: right;'))
        ?>
    </td>
    <td class="hide">
        <label><?php echo $model->satuanjml_urt; ?></label>
        <?php 
        echo CHtml::activeHiddenField($model, '['.$i.']satuanjml_urt', array('class' => ' det_urt'));
        ?>
    </td>
    <td hidden>
        <div class="urldetail">
        <?php 
            echo CHtml::link("<i class='icon-form-detail'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/detailBahanmenudiet', array('pendaftaran_id'=>$model->pendaftaran_id,'pasienadmisi_id'=>$model->pasienadmisi_id,'jeniswaktu_id'=>$model->jeniswaktu_id,'menudiet_id'=>$model->menudiet_id,'jenismakanan_id'=>$model->jenismakanan_id, 'kelaspelayanan_id'=>$model->kelaspelayanan_id)), array(

                            "target" => "frameDetail",
                            'rel'=>'tooltip',
                            'data-original-title'=>'klik untuk melihat detail bahan makanan',
                            "onclick" => '$("#dialogDetail").dialog("open");',));
        ?>
        </div>
    </td>   
    <td hidden>
        <?php 
            echo CHtml::link("<span style='font-size:20px;'><i class='entypo-cancel'></i></span>", 'javascript:;', array(                            
                            'rel'=>'tooltip',
                            'class'=>'btn btn-danger',
                            'style' => 'padding:0px;',
                            'data-original-title'=>'klik untuk menghapus pesan menu detail ini ',
                            "onclick" => 'hapusDetailPerMenu(this);',));
            echo "<br><br>";            
            echo CHtml::link("<span style='font-size:20px;'><i class='entypo-pencil'></i></span>", "javascript:;", array(                            
                            'rel'=>'tooltip',
                            'class'=>'btn btn-primary',
                            'style' => 'padding:0px;',
                            'style' => 'padding:0px;',
                            'data-original-title'=>'klik untuk mengubah pesan menu detail ini',
                            "onclick" => 'generateFormTambahMenu(this,"ubah");',));
        ?>
    </td>  
    <?php if (empty($model->pesanmenudetail_id)) { ?>
    <td>
        <?php

        
            echo CHtml::link("<span style='font-size:20px;'><i class='entypo-cancel'></i></span>", 'javascript:;', array(                            
                'rel'=>'tooltip',
                'class' => 'btn btn-danger',
                'style' => 'padding:0px;',
                'data-original-title'=>'klik untuk hapus pesan menu detail ini',
                "onclick" => 'hapusMenu(this)'
            )); 
        ?>
    </td>
    <?php } ?>
     <?php if ($cekTabelDetail == 0 && $i == 0 && !empty($model->pesanmenudiet_id)){ ?>
        <td class="aturbaris tombolaksi"  rowspan="<?php echo ($countJnsWaktu); ?>" style="vertical-align: middle;text-align: center;">
            <?php
                echo CHtml::link("<span style='font-size:20px;'><i class='entypo-pencil'></i></span>", 'javascript:;', array(                            
                    'rel'=>'tooltip',
                    'class'=>'btn btn-success',
                    'style' => 'padding:0px;',
                    'style' => 'padding:0px;',
                    'data-original-title'=>'klik untuk mengubah pesan menu detail ini',
                    "onclick" => 'ubahMenu(this)'
                ));  
                if (empty($model->pesanmenudetail_id)) { 
                    echo CHtml::link("<span style='font-size:20px;'><i class='".MyIcon::getIcons('tambah-baris')."'></i></span>", "javascript:;", array(                            
                        'rel'=>'tooltip',
                        'class'=>'btn btn-primary',
                        'style' => 'padding:0px;',
                        'style' => 'padding:0px;',
                        'data-original-title'=>'klik untuk menambahkan menu diet lain',
                        "onclick" => 'generateFormTambahMenu(this,"tambah");',
                    ));
                }
            ?>
        </td>
     <?php } ?> 
</tr>