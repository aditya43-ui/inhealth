<tr id="jadwal_<?= $i ?>">
    <td style="font-size:11pt">
        <?php
            echo $terapi;
            echo CHtml::hiddenField('HasilpemeriksaanrmT[' . $i . '][tindakanterapi_rehab]', $terapi, []);
        ?>
    </td>
    <td>
        <?php 
            $this->widget('MyDateTimePicker',array(
                'model'=>$modHasilPemeriksaanrm,
                'attribute'=>'[' . $i . ']tglpemeriksaanrm',
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
            $this->widget('ext.redactorjs.Redactor', array('model' => $modHasilPemeriksaanrm, 'attribute' => '[' . $i . ']hasilpemeriksaanrm', 'name' => 'HasilpemeriksaanrmT_' . $i . '_hasilpemeriksaanrm', 'toolbar' => 'mini', 'height' => '200px'));
        ?>
    </td>
    <td>
        <?php
            $this->widget('ext.redactorjs.Redactor', array('model' => $modHasilPemeriksaanrm, 'attribute' => '[' . $i . ']keteranganhasilrm', 'name' => 'HasilpemeriksaanrmT_' . $i . '_keteranganhasilrm', 'toolbar' => 'mini', 'height' => '200px'));
        ?>
    </td>
    <?php 
    $nameInputFile = 'HasilpemeriksaanrmT[' . $i . '][dokfilerm_filepath]'; 
    $nameInputName = 'HasilpemeriksaanrmT[' . $i . '][dokfilerm_nama]'; 
    ?>
    <td colspan="4">
        <?php echo CHtml::link('<i class="fas fa-upload"></i> Upload', 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'btn btn-success')) . '&nbsp;' . CHtml::link("<u></u>", 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'labelbrowse')); ?>
        <div class="upload" style="display: none;">
            
            <?= CHtml::activeFileField($modHasilPemeriksaanrm, '[' . $i . ']dokfilerm_filepath', ['onchange' => 'cekFile(this)']) ?>
        </div>
        <div class="nama_dokumen" style="display: none;">
            <label for="">Nama Dokumen</label>
            <input type="text" name="<?= $nameInputName ?>" class="input_nama_dokumen lebar3">
            <button type="button" onclick="removeFile(this)"><i class="fas fa-times"></i></button>
            
        </div>
    </td>
</tr>