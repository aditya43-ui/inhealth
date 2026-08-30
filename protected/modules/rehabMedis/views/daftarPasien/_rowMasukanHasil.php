<tr id="jadwal_0">
    <td style="font-size:11pt">
        <?php
            echo $modHasilPemeriksaanrm->tindakanterapi_rehab ?? '';
            CHtml::hiddenField('HasilpemeriksaanrmT[tindakanrm_id]', $modHasilPemeriksaanrm->tindakanrm_id ?? '', []);


        ?>
    </td>
    <td>
        <?php 

            $this->widget('MyDateTimePicker',array(
                'model'=>$modHasilPemeriksaanrm,
                'attribute'=>'tglpemeriksaanrm',
                'mode'=>'datetime',
                'options'=> array(
                    'dateFormat'=>Params::DATE_FORMAT,
                    // 'maxDate' => 'd',
                ),
                'htmlOptions'=>array('class'=>'dtPicker3', 'readonly' => true),
            ));
        
        ?>
    </td>
    <td>
        <?php
        echo CHtml::hiddenField('HasilpemeriksaanrmT[hasilpemeriksaanrm_id]', $modHasilPemeriksaanrm->hasilpemeriksaanrm_id);
        //                    echo CHtml::textArea('hasilpemeriksaanrm[hasilpemeriksaanrm][]',$hasilpemeriksaan->hasilpemeriksaanrm).'</br></br>';
        $this->widget('ext.redactorjs.Redactor', array('model' => $modHasilPemeriksaanrm, 'attribute' => 'hasilpemeriksaanrm', 'name' => 'HasilpemeriksaanrmT_hasilpemeriksaanrm', 'toolbar' => 'mini', 'height' => '200px'));
        ?>
    </td>
    <td>
        <?php
        //                    echo CHtml::textArea('hasilpemeriksaanrm[keteranganhasilrm][]',$hasilpemeriksaan->keteranganhasilrm).'</br></br>';  
        $this->widget('ext.redactorjs.Redactor', array('model' => $modHasilPemeriksaanrm, 'attribute' => 'keteranganhasilrm', 'name' => 'HasilpemeriksaanrmT_keteranganhasilrm', 'toolbar' => 'mini', 'height' => '200px'));
        ?>
    </td>
    <?php 
    $nameInputFile = 'HasilpemeriksaanrmT[dokfilerm_filepath]'; 
    $nameInputName = 'HasilpemeriksaanrmT[dokfilerm_nama]'; 
    ?>
    <td colspan="4">
        <?php echo CHtml::link('<i class="fas fa-upload"></i> Upload', 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'btn btn-success')) . '&nbsp;' . CHtml::link("<u></u>", 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'labelbrowse')); ?>
        <div class="upload" style="display: none;">
            
            <?= CHtml::activeFileField($modHasilPemeriksaanrm, 'dokfilerm_filepath', ['onchange' => 'cekFile(this)']) ?>
        </div>
        <div class="nama_dokumen" style="display: none;">
            <label for="">Nama Dokumen</label>
            <input type="text" name="<?= $nameInputName ?>" class="input_nama_dokumen lebar3">
            <button type="button" onclick="removeFile(this)"><i class="fas fa-times"></i></button>
            
        </div>
        <div style="margin-top: 20px;">
            <?php if(!empty($modHasilPemeriksaanrm->dokfilerm_filepath)) :  ?>
                <img src="<?= Yii::app()->request->baseUrl . '/data/images/hasilPemeriksaanTindakan/'. $modHasilPemeriksaanrm->dokfilerm_filepath ?>" alt="" srcset="" width="200" height="200">

                <br>
                Nama Dokumen : <b><?= $modHasilPemeriksaanrm->dokfilerm_nama ?? '' ?></b>
            <?php endif ?>
        </div>
    </td>
    
</tr>