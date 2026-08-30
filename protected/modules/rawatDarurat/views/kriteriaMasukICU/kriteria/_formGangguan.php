<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success">
          <div class="panel-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                      <table class="items table table-bordered table-striped table-condensed" >
                      <thead>
                              <tr >
                                  <th colspan="3" >Gangguan Kondisi Lain</th>
                              </tr>
                              <tr >
                                  <th>Diagnosis/Kondisi Klinis</th>
                                  <th>Ya</th>
                                  <th>Tidak</th>
                              </tr>
                              
                          </thead>
                          <tr>
                              <th>Cidera akibat lingkungan (petir,tenggelam(drowning),hipo/hipertermia</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_iscidera',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_iscidera',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                      
                          </tr>
                          <tr>
                              <th>Trauma multiple dengan atau tanpa gangguan kardiovaskular</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_istrauma',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_istrauma',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                        
                            </tr>
                          <tr>
                              <th>Pengobatan baru / eksperimental yang berpotensi mengalami komplikasi</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_ispengobatan',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_ispengobatan',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                        
                            </tr>
                         
                          <tr>
                              <th>Intoksisasi obat akut dengan gangguan reflek jalan nafas, ketidakstabilan hemodinamik, aritmia jantung, dan/ atau membutuhkan pengawaswan tindakan bunuh diri</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isgangguanreflek',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isgangguanreflek',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                            </tr>
                         

                          <tr>
                              <th>Intoksisasi obat akut yang membutuhkan obat obatan infus kontinyu atau pemberian berkala obat obat intravena</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isobatinfus',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isobatinfus',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                            </tr>
                         
                            <tr>
                              <th>Intoksisasi obat akut yang memerlukan dialisis</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isdialisis',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isdialisis',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                            </tr>

                          <tr>
                              <th>Kondisi metabolik lainnya (misal:rabdomiolisis berat memerlukan pemantauan berkala atau intervensi medis)</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_ismetabolik',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_ismetabolik',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                            </tr>

                            <tr>
                              <th>Pasien Kehamilan dengan komplikasi hemodiamik, respirasi dan susunan syaraf pusat</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_iskehamilan',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_iskehamilan',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                            </tr>
                          

                          <tr>
                              <th>Pasien Preeklampasi dengan komplikasi hemodinamik,respirasi dan susunan syaraf pusat</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isgangguanmultiorgan',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isgangguanmultiorgan',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                            </tr>
                          
                          <tr>
                              <th>Pasien Eklampsia</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_iseklampsia',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_iseklampsia',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                            </tr>
                          
                          <tr>
                              <th>Pasien emboli air ketuba</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isemboli',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kondisilain_isemboli',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                            </tr>

                         </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
</div>
