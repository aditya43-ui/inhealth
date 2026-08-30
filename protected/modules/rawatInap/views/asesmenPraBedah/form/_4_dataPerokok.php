<div class="col-sm-12">
    <?= $form->radioButtonListRow($model,'is_konsumsirokok',[
        1 => 'Konsumsi',
        0 => 'Tidak Pernah'
    ]) ?>
    
    <div class="control-group">
        <label class="controls" style="margin-left:0px;margin-right:15px;">Alat bantu yang dipakai</label>
        <div class="controls" style="width: 80%">
            <table width="100%">
                <tr>
                    <td>
                        <?= $form->checkBox($model, 'is_alatbantu_dengar',['id'=>'is_alatbantu_dengar']) ?> <label for="is_alatbantu_dengar">Alat bantu dengar</label>
                    </td>
                    <td>
                        <?= $form->checkBox($model, 'is_alatbantu_pacujantung',['id'=>'is_alatbantu_pacujantung']) ?> <label for="is_alatbantu_pacujantung">Alat pacu jantung</label>
                    </td>
                    <td>
                        <?= $form->checkBox($model, 'is_alatbantu_gigipalsu',['id'=>'is_alatbantu_gigipalsu']) ?> <label for="is_alatbantu_gigipalsu">Gigi palsu</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= $form->checkBox($model, 'is_alatbantu_kacamata',['id'=>'is_alatbantu_kacamata']) ?> <label for="is_alatbantu_kacamata">Kacamata</label>
                    </td>
                    <td>
                        <?= $form->checkBox($model, 'is_alatbantu_sofelens',['id'=>'is_alatbantu_sofelens']) ?> <label for="is_alatbantu_sofelens">Sofelens</label>
                    </td>
                    <td>
                        <?= $form->checkBox($model, 'is_alatbantu_prostese',['id'=>'is_alatbantu_prostese']) ?> <label for="is_alatbantu_prostese">Prostese/Implant</label>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
     <?= $form->radioButtonListRow($model,'is_zatadiktif',[
        1 => 'Ada',
        0 => 'Tidak ada'
    ]) ?>
</div>
