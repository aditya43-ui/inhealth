<div class="panel panel-primary panel-gradient">
   <div class="panel-heading">
       <div class="panel-title"><strong>Rencana Tindak Lanjut & Rencana Pulang/ Dishcarger Planning</strong></div>
   </div>
    <div class="panel-body">
      <p></p>

      <div class="row">
        <div class="col-sm-12">
          <div class="control-group">
            <?php echo CHtml::label('Rencana Tindak Lanjut','',array('class'=>'control-label','style'=>'width: 130px')) ?>
          </div>
          <div class="control-group ">
              <div class="controls" style="width: 100%;">
                 <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAskepgeriatriT, 'attribute'=>'rencana_tindaklanjut', 'toolbar'=>'mini','height'=>'200px')) ?>
              </div>
         </div>
        </div>
      </div>
      <p style="color: black">Rencana Pulang/ Dishcarger Planning (dilengkapi dalam 48 jam pertama pasien masuk ruang rawat)</p>
      <div class="table-responsive" style="overflow-x:auto;">
          <div class='block-tabel'>
             <table class="items table table-bordered">
                 <thead>
                     <tr>
                         <th style="text-align: center">Komponen Penilaian</th>
                         <th style="text-align: center" width="50px">Ya</th>
                         <th style="text-align: center" width="50px">Tidak</th>
                         <th style="text-align: center" width="300px">Keterangan</th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php
                      $look_rencanapul = LookupM::model()->findAll("lookup_type = 'penilaianrencanpulang' order by lookup_urutan ASC");

                        if(count((array)$look_rencanapul) > 0){
                          foreach ($look_rencanapul as $i => $look) {
                              $penilaian_lainnya = "";
                              $hasil = "";
                              $keterangan = "";
                              $penilaianrencanapulang_id = null;

                              if(count((array)$modPenilaianRenPulang) > 0){
                                foreach($modPenilaianRenPulang as $oriNilaiRenPulang){
                                  if($look->lookup_name == $oriNilaiRenPulang->penilaian){
                                    $penilaianrencanapulang_id = $oriNilaiRenPulang->penilaianrencanapulang_id;
                                    $penilaian_lainnya = $oriNilaiRenPulang->penilaian_lainnya;
                                    $hasil = $oriNilaiRenPulang->hasil;
                                    $keterangan = $oriNilaiRenPulang->keterangan;
                                  }
                                }
                              }
                            ?>
                            <tr>
                              <td>
                                <?php echo CHtml::hiddenField('PenilaianrencanapulangT['.$i.'][penilaianrencanapulang_id]',$penilaianrencanapulang_id); ?>
                                <?php echo CHtml::hiddenField('PenilaianrencanapulangT['.$i.'][penilaian]',$look->lookup_name); ?>
                                <?php if($look->lookup_name == 'Lain-Lain'){
                                  echo $look->lookup_name .' : ';
                                  echo CHtml::textField('PenilaianrencanapulangT['.$i.'][penilaian_lainnya]',$penilaian_lainnya,array('style'=>'width: 300px'));
                                  }else{
                                    echo $look->lookup_name;
                                  }
                                ?>

                              </td>
                              <td style="text-align: center">
                                <?php echo CHtml::radioButton('PenilaianrencanapulangT['.$i.'][hasil]',$hasil,array('class'=>'hasil','value'=>'Ya','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                              </td>
                              <td style="text-align: center">
                                <?php echo CHtml::radioButton('PenilaianrencanapulangT['.$i.'][hasil]',$hasil,array('class'=>'hasil','value'=>'Tidak','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                              </td>
                              <td>
                                <?php echo CHtml::textField('PenilaianrencanapulangT['.$i.'][keterangan]',$keterangan,array('style'=>'width: 100%')); ?>
                              </td>
                            </tr>
                            <?php
                          }
                        }
                     ?>
                  </tbody>
             </table>
         </div>
      </div>

    </div>
</div>
