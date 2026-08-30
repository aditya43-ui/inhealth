<div class='block-tabel'>
    <h6>Profil <b>Picture</b></h6>
    <table id="tbl_profilpicture" class='table table-striped table-bordered table-condensed'>    

        <thead>
            <?php $models = new SAProfilpictureM(); ?>
            <th>
                
                <?php echo $form->labelEx($models, 'profilpicture_nama'); ?>
            </th>
            <th>
                <?php echo $form->labelEx($models, 'profilpicture_desc'); ?>
            </th>
            <th>
                <?php echo $form->labelEx($models, 'profilpicture_path'); ?>
            </th>
            <th>
                <?php echo $form->labelEx($models, 'display_antrian'); ?>
            </th>
            <th>
                
            </th>
        </thead>
        <tbody>
        <?php
        if (!$model->isNewRecord) {
            $modProfilPict = $model;
            $model = new SAProfilpictureM();
            foreach ($modProfilPict as $i => $row) {
                    $i++;
                $model['profilpicture_desc'] = $row->profilpicture_desc;
                $model['temp_gambar'] = $row->profilpicture_path;
                ?>
                <tr>
                    <td>
                        <?php echo $form->hiddenField($model, '['.$i.']temp_gambar'); ?>
                        <?php echo $form->hiddenField($model, '[' . $i . ']profilpicture_id', array('value' => $row->profilpicture_id)); ?>
                        <?php echo $form->textField($model, '[' . $i . ']profilpicture_nama', array('value' => $row->profilpicture_nama, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </td>
                    <td>
                        <?php echo $form->textArea($model, '[' . $i . ']profilpicture_desc', array('rows' => 2, 'cols' => 2, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </td>
                    <td>
                        <?php echo Chtml::activeFileField($model, '[' . $i . ']profilpicture_path', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambah Gambar')); ?>
                    </td>
                    <td>
                        <?php echo $form->checkBox($model, '[' . $i . ']display_antrian', array('checked' => ($row->display_antrian == true), 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::button('+', array('class' => 'btn btn-danger', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);$(this).nextFocus()', 'id' => 'row1-plus')); ?>
                        <?php if ($i != 1){
                            echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
                        } ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            $model = new SAProfilpictureM();
            ?>
            <tr>
                <td>
                    <?php echo $form->textField($model, '[1]profilpicture_nama', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </td>
                <td>
                    <?php echo $form->textArea($model, '[1]profilpicture_desc', array('rows' => 2, 'cols' => 2, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    
                            <?php echo Chtml::activeFileField($model, '[1]profilpicture_path', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambah Gambar')); ?>
                    
                </td>
                <td>
                    <?php echo $form->checkBox($model, '[1]display_antrian', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <?php echo CHtml::button('+', array('class' => 'btn btn-danger', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);$(this).nextFocus()', 'id' => 'row1-plus')); ?>
                </td>
            </tr>
        <?php } ?>
            </tbody>
    </table>  
</div> 