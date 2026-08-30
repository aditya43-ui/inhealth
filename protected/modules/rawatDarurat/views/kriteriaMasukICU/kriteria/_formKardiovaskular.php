<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success">
          <div class="panel-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                      <table class="items table table-bordered table-striped table-condensed" >
                     <thead>
                              <tr >
                                  <th colspan="3" >Gangguan Sistem Kardiovaskular</th>
                              </tr>
                              <tr >
                                  <th>Diagnosis/Kondisi Klinis</th>
                                  <th>Ya</th>
                                  <th>Tidak</th>
                              </tr>
                              
                          </thead>
                          <tr>
                              <th>Miokard infark akut dengan komplikasi</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_ismiokardinfark',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_ismiokardinfark',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                           <tr>
                              <th>Shock Kardiogenik</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_iskardiogenik',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_iskardiogenik',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             </tr>
                           <tr>
                              <th>Aritmia kompleks yang membutuhkan monitoring ketat dan intervensi invasif</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isaritmiakompleks',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isaritmiakompleks',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            </tr>
                           <tr>
                              <th>Congestive heart failure akut disertai gagal nafas yang memerlukan support</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_ischfakut',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_ischfakut',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            </tr>
                           <tr>
                              <th>Hipertensi emergensi</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_ishipertensi',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_ishipertensi',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                           </tr>
                           <tr>
                              <th>Angina pektoris tidak stabil, terutama dengan adanya disritmia, instabilitas hemodinamik, atau nyeri dada yang menetap</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isanginapektoris',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isanginapektoris',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                           </tr>
                           <tr>
                              <th>Pasca pemulihan setelah henti jantung</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_ispemulihan',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_ispemulihan',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                           </tr>
                           <tr>
                              <th>Tamponade jantung atau konstriksi curah jantung disertai instabilitasi haemodinamik</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_istamponadejantung',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_istamponadejantung',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                           </tr>
                           <tr>
                              <th>diseksi aneurisma aorta</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isdiseksi',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isdiseksi',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                           </tr>
                          <tr>
                              <th>blok jantung kompleks (derajat 3) </th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isblokjantung',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isblokjantung',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          <tr>
                              <th>Sindrom coroner akut tanpa perbaikan nyeri iskemik paska terapi </th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_issindromcoroner',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_issindromcoroner',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          <tr>
                              <th>Pemasangan pompa balon intraaorta atau alat bantu ventrikel mekanik yang lain</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isintraaorta',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isintraaorta',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          <tr>
                              <th>Pemantauan kateter arteri pulmonal atau tekanan vena sentral yang terkait dengan masalah jantung</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_iskateter',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_iskateter',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          <tr>
                              <th>Gagal jantung kronis dekompensata yang membutuhkan</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isgagaljantung',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_isgagaljantung',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          <tr>
                              <th colspan="2"><b>PARAMETER FISIOLOGIS</b></th>
                              <th> <?php echo "Ya"; ?> </th>
                              <th> <?php echo "Tidak"; ?> </th>
                         
                            </tr>
                          <tr>
                              <th colspan="2">Laju Jantung < 50x / menit atau > 150x / menit dengan instabilitas hemodinamik</th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_islajujantung',array('value'=>'1','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'kardiovaskular_islajujantung',array('value'=>'0','class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                        </tr>
                          
                      </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
</div>
