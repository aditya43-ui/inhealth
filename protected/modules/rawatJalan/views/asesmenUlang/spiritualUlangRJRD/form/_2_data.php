<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Asesmen Ulang Spiritual Rawat Jalan/IGD</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <?= $form->textFieldRow($model, 'ruangan_nama', ['readonly'=>true]); ?>
            <?= $form->textFieldRow($model, 'tanggal', ['readonly'=>true]); ?>
        </div>
        
        <div class="clear"></div>
        
        <?php
            $listpilihan = $model->listPilihan();
            $tharoh = $listpilihan['thoharoh'];
            $sebelumsakit = $listpilihan['sebelumsakit'];
            $selamasakit = $listpilihan['selamasakit'];
            $psiko = $listpilihan['psiko'];
            $rencanaedukasi = $listpilihan['rencanaedukasi'];
        ?>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <td width="3%">A.</td>
                    <td>THOHAROH</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>                    
                    <?php
                        if (!empty($tharoh)){
                            foreach($tharoh as $key => $val){
                                $id  = $key.str_replace(' ','_',strtolower($val));
                                echo "<td>".$form->checkBox($model, $key, ['id'=>$id])."<label for='".$id."'>".$val."</label></td>";
                            }
                        }
                    ?>                    
                </tr>
                <tr>
                    <td>B.</td>
                    <td>IBADAH</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Sebelum sakit :</td>
                </tr
                <tr>
                    <td>&nbsp;</td>                    
                    <?php
                        if (!empty($sebelumsakit)){
                            foreach($sebelumsakit as $key => $val){
                                $id  = $key.str_replace(' ','_',strtolower($val));
                                echo "<td>".$form->checkBox($model, $key, ['id'=>$id])."<label for='".$id."'>".$val."</label></td>";
                            }
                        }
                    ?>                    
                </tr>
                <tr>
                    <td></td>
                    <td>Selama sakit :</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>                    
                    <?php
                        if (!empty($selamasakit)){
                            foreach($selamasakit as $key => $val){
                                $id  = $key.str_replace(' ','_',strtolower($val));
                                echo "<td>".$form->checkBox($model, $key, ['id'=>$id])."<label for='".$id."'>".$val."</label></td>";
                            }
                        }
                    ?>                    
                </tr>
                <tr>
                    <td>C.</td>
                    <td>MASALAH PSIKO - SPIRITUAL</td>
                </tr>               
                <tr>
                    <td>&nbsp;</td>                    
                    <?php
                        echo "<td>";
                        if (!empty($psiko)){
                            $temp = [];
                            foreach($psiko as $key => $val){
                                $init  = $val->lookup_name;
                                $temp[$init] = $init;
                            }
                            echo $form->checkBoxList($model,'masalahpsiko', $temp, [
                                'template'=>'{input}{label}<br/>',                                  
                            ]);
                        }
                        echo "</td>";
                    ?>                    
                </tr>
                <tr>
                    <td>D.</td>
                    <td>DIAGNOSA SPIRITUAL</td>
                </tr>               
                <tr>
                    <td>&nbsp;</td>                    
                    <td>
                        <?= $form->textArea($model, 'diagnosaspiritual', [ 'id'=>'masalahpsiko']) ?>
                    </td>                 
                </tr>
                <tr>
                    <td>E.</td>
                    <td>RENCANA EDUKASI ISLAMI</td>
                </tr>               
                <tr>
                    <td>&nbsp;</td>                    
                    <?php
                        echo "<td>";
                        if (!empty($rencanaedukasi)){
                            $temp = [];
                            foreach($rencanaedukasi as $key => $val){
                                $init  = $val->lookup_name;
                                $temp[$init] = $init;
                            }
                            echo $form->checkBoxList($model,'rencanaedukasiislami', $temp, [
                                'template'=>'<div class="group-data">{input}{label}</div><br/>',    
                                'onchange' => 'rencanaEdukasiLain(this);',
                                'class'=>'rencanaedukasiislami'
                            ]);
                            
                                 
                        }
                        
                        echo '<br/>';
                    ?>
                        <div class="control-group">
                            <label class="controls">Sumber</label>
                        </div>
                        <div class="control-group" style="padding-left: 20px;">
                            <div class="controls"><?= $form->radioButton($model, 'sumber', ['class'=>'sumber','value'=>'pasien','uncheckValue'=>null, 'id'=>'sumber_pasien','onclick'=>'cekSumber();']) ?></div>
                            <label class="controls" for="sumber_pasien" style="padding:0px;margin:0px;">Pasien</label>
                        </div>
                        <div class="control-group" style="padding-left: 20px;">
                            <div class="controls"><?= $form->radioButton($model, 'sumber', ['class'=>'sumber','value'=>'keluarga','uncheckValue'=>null, 'id'=>'sumber_keluarga','onclick'=>'cekSumber();']) ?></div>
                            <label class="controls" for="sumber_keluarga" style="padding:0px;margin:0px;">Keluarga</label>
                        </div>
                
                        <div class="control-group sumber_text sumber_nama_pasien hide"style="padding-left: 20px;">
                            <?= $form->textField($model, 'nama_pasien',['class'=>'span8']) ?>
                        </div>
                
                        <div class="control-group sumber_text sumber_nama_keluarga hide"style="padding-left: 20px;">
                            <?= $form->textField($model, 'nama_keluarga',['class'=>'span8']) ?>
                        </div>
                    <?php
                        
                        echo "</td>";
                    ?>                      
                </tr>
                <tr>
                    <td></td>
                    <td>
                         <div class="control-group">
                            <label class="controls">Petugas</label>
                            <div class="controls">
                                <?= $form->textField($model, 'petugas_nama',['readonly'=>true]) ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>           
        </div>
                
        <div class="clear"></div>
                
    </div>
</div>