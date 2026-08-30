<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Asesmen Ulang Spiritual Rawat Inap</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <?= $form->textFieldRow($model, 'kamarruangan_nama', ['readonly'=>true]); ?>
            <?= $form->textFieldRow($model, 'tanggal', ['readonly'=>true]); ?>
            
            <div class="control-group">
                <label class="control-label">Sumber Data</label>
                <div class="controls"><?= $form->radioButton($model, 'sumber', ['class'=>'sumber','value'=>'pasien','uncheckValue'=>null, 'id'=>'sumber_pasien','onclick'=>'cekSumber();']) ?></div>
                <label class="controls" for="sumber_pasien" style="padding:0px;margin:0px;">Pasien</label>
                
                <div class="controls"><?= $form->radioButton($model, 'sumber', ['class'=>'sumber','value'=>'keluarga','uncheckValue'=>null, 'id'=>'sumber_keluarga','onclick'=>'cekSumber();']) ?></div>
                <label class="controls" for="sumber_keluarga" style="padding:0px;margin:0px;">Keluarga</label>
            </div>                       
        </div>
        
        <div class="clear"></div>
        <?php
            $pilihandata = $model->pilihanData();
            
            $selamasakit = $pilihandata['ibadahsholat'];
            unset($selamasakit["TIDAK"]);
            $selamasakit['SAKIT'] = 'Sakit';
        ?>
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Penerimaan Kondisi Sakit</div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label"><u>Pernyataan Pasien</u></label>
                    </div>
                    
                    <?php
                        if (!empty($pilihandata['penerimaankondisisakit'])){
                            foreach($pilihandata['penerimaankondisisakit'] as $key => $val){
                                echo '<div class="col-sm-6">';
                                foreach($val as $k => $v){
                                    $id = 'penerimaankondisi_pasien_'.strtolower(str_replace(' ', '_', $v));
                                    echo $form->checkBox($model, 'penerimaankondisi_pasien[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                                }
                                echo '</div>';
                            }
                        }
                    ?>
                    <div class="clear"></div>
                    <div class="control-group">
                        <label class="control-label"><u>Pernyataan Pasien</u></label>
                    </div>
                    
                    <?php
                        if (!empty($pilihandata['penerimaankondisisakit'])){
                            foreach($pilihandata['penerimaankondisisakit'] as $key => $val){
                                echo '<div class="col-sm-6">';
                                foreach($val as $k => $v){
                                    $id = 'penerimaankondisi_keluarga_'.strtolower(str_replace(' ', '_', $v));
                                    echo $form->checkBox($model, 'penerimaankondisi_keluarga[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                                }
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
                
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label"><u>Ekspresi</u></label>
                    </div>
                    
                    <?php
                        if (!empty($pilihandata['ekspresi'])){
                            foreach($pilihandata['ekspresi'] as $key => $val){
                                echo '<div class="col-sm-6">';
                                foreach($val as $k => $v){
                                    $id = 'ekspresi_'.strtolower(str_replace(' ', '_', $v));
                                    echo $form->checkBox($model, 'ekspresi[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                                }
                                echo '</div>';
                            }
                        }
                    ?>
                    <div class="clear"></div>
                    <div class="control-group">
                        <label class="control-label"><u>Penilaian</u></label>
                    </div>
                    
                    <?php
                        if (!empty($pilihandata['penilaian'])){
                            foreach($pilihandata['penilaian'] as $key => $val){
                                echo '<div class="col-sm-6">';
                                foreach($val as $k => $v){
                                    $id = 'penilaian_kondisipasien_'.strtolower(str_replace(' ', '_', $v));
                                    echo $form->checkBox($model, 'penilaian_kondisipasien[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                                }
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Ibadah Sholat</div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label"><u>Pernyataan Pasien</u></label>
                    </div>
                    
                    <?php
                        if (!empty($pilihandata['ibadahsholat'])){                            
                            echo '<div class="col-sm-6">';
                            echo '<div class="control-group" style="padding-left:10px;">';
                                echo '<label class="control-label">Sebelum Sakit</label>';
                            echo '</div>';
                            foreach($pilihandata['ibadahsholat'] as $k => $v){
                                $id = 'ibadahsholatpasien_sebelumsakit_'.strtolower(str_replace(' ', '_', $v));
                                echo '<span style="padding-left:20px"></span>'.$form->checkBox($model, 'ibadahsholatpasien_sebelumsakit[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                            }
                            echo '</div>';                            
                        }
                        
                        if (!empty($selamasakit)){
                            echo '<div class="col-sm-6">';
                            echo '<div class="control-group" style="padding-left:10px;">';
                                echo '<label class="control-label">Selama Sakit</label>';
                            echo '</div>';                            
                            
                            
                            foreach($selamasakit as $k => $v){
                                $id = 'ibadahsholatpasien_selamasakit_'.strtolower(str_replace(' ', '_', $v));
                                echo '<span style="padding-left:20px"></span>'.$form->checkBox($model, 'ibadahsholatpasien_selamasakit[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                            }
                            echo '</div>';    
                        }
                    ?>
                    
                    <div class="control-group">
                        <label class="control-label"><u>Pernyataan Keluarga</u></label>
                    </div>
                    
                    <?php
                        if (!empty($pilihandata['hafalan'])){                            
                            echo '<div class="col-sm-6">';
                            echo '<div class="control-group" style="padding-left:10px;">';
                                echo '<label class="control-label">Hafalan</label>';
                            echo '</div>';
                            foreach($pilihandata['hafalan'] as $k => $v){
                                $id = 'pernyataankeluarga_hafalan_'.strtolower(str_replace(' ', '_', $v));
                                echo '<span style="padding-left:20px"></span>'.$form->checkBox($model, 'pernyataankeluarga_hafalan[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                            }
                            echo '</div>';                            
                        }
                        
                        if (!empty($pilihandata['mediabersuci'])){   
                            echo '<div class="col-sm-6">';
                            echo '<div class="control-group" style="padding-left:10px;">';
                                echo '<label class="control-label">Media Bersuci</label>';
                            echo '</div>';
                            
                            
                            foreach($pilihandata['mediabersuci'] as $k => $v){
                                $id = 'pernyataankeluarga_mediabersuci_'.strtolower(str_replace(' ', '_', $v));
                                echo '<span style="padding-left:20px"></span>'.$form->checkBox($model, 'pernyataankeluarga_mediabersuci[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                            }
                            echo '</div>';    
                        }
                    ?>
                </div>
                
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label"><u>Pernyataan Keluarga</u></label>
                    </div>
                    
                    <?php
                        if (!empty($pilihandata['penerimaankondisisakit'])){                            
                            echo '<div class="col-sm-6">';
                            echo '<div class="control-group" style="padding-left:10px;">';
                                echo '<label class="control-label">Sebelum Sakit</label>';
                            echo '</div>';
                            foreach($pilihandata['ibadahsholat'] as $k => $v){
                                $id = 'ibadahsholatkeluarga_sebelumsakit_'.strtolower(str_replace(' ', '_', $v));
                                echo '<span style="padding-left:20px"></span>'.$form->checkBox($model, 'ibadahsholatkeluarga_sebelumsakit[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                            }
                            echo '</div>';                            
                            
                            echo '<div class="col-sm-6">';
                            echo '<div class="control-group" style="padding-left:10px;">';
                                echo '<label class="control-label">Selama Sakit</label>';
                            echo '</div>';
                            
                            
                            foreach($selamasakit as $k => $v){
                                $id = 'ibadahsholatkeluarga_selamasakit_'.strtolower(str_replace(' ', '_', $v));
                                echo '<span style="padding-left:20px"></span>'.$form->checkBox($model, 'ibadahsholatkeluarga_selamasakit[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                            }
                            echo '</div>';    
                        }
                    ?>
                    
                    <div class="clear"></div>
                    <div class="control-group">
                        <label class="control-label"><u>Penilaian</u></label>
                    </div>
                    
                    <?php
                        if (!empty($pilihandata['penilaian'])){
                            foreach($pilihandata['penilaian'] as $key => $val){
                                echo '<div class="col-sm-6">';
                                foreach($val as $k => $v){
                                    $id = 'penilaian_ibadah_'.strtolower(str_replace(' ', '_', $v));
                                    echo $form->checkBox($model, 'penilaian_ibadah[]', ['value'=>$k, 'id'=>$id, 'uncheckValue'=>null])."<label for='".$id."'>".$v."</label><br/>";
                                }
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <br/>
         <?= $form->textAreaRow($model, 'kesimpulan', [ 'id'=>'kesimpulan']) ?>
               
                
        <div class="clear"></div>
                
    </div>
</div>