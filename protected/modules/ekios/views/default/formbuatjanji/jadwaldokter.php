                            <input type="hidden"  id="statuspasien" />
                                <div id="">
                                    <div style="text-align:center">
                                        <h1>Jadwal Pemeriksaan Gigi</h1>
                                    </div>
                                    <div class="row" id="setpad">
                                        <div class="col-xs-12" id="setpad">
                                        <div class="control-group ">
                                                <?php echo $form->labelEx($modPPBuatJanjiPoli,'tgljadwal', array('class'=>'control-label')) ?>
                                                    <div class="controls">
                                                        <?php   
                                                        
                                                        echo $form->hiddenField($modPPBuatJanjiPoli, 'ruangan_id');
                                                        
                                                                $this->widget('MyDateTimePicker',array(
                                                                                'model'=>$modPPBuatJanjiPoli,
                                                                                'attribute'=>'tgljadwal',
                                                                                'mode'=>'date',
                                                                                'options'=> array(
                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                                    // 'onkeypress'=>"js:function(){getUmur(this);}",
                                                                                    'onSelect'=>'js:function(){loadJadwalPerhari(this);}',
                                                                                    // 'onSelect'=>'js:function(){loadJadwalPerhari(this);}',
                                                                                ),
                                                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                                ),
                                                        )); ?>
                                                        <?php echo $form->error($modPPBuatJanjiPoli, 'tgljadwal'); ?>
                                                    </div>
                                      </div>
                                        </div>
                                        <div class="col-xs-12" id="setpad">
                                            <div class="control-group" id="berdasarkan-klinik" style="display:block;">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2">
                                                                Berdasarkan Klinik <span id="klinikNama"></span> <i class="entypo-down-open"></i>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne-2" class="panel-collapse collapse in">
                                                        <div class="panel-body">
                                                            <span id="janjipoli-klinik">                            
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <ul class="list-inline pull-left">
                                    <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>
                                </ul>
                                <ul class="list-inline pull-right">
                                    
                                                                       <li><button
                    type="button" class="btn btn-primary next-step" >Lanjut</button></li>    
                                </ul>

    <script type="text/javascript">
          $(document).ready(function () {
                console.log('sdfhsdkjfgkhjsdfgj')
                console.log($('#BuatjanjipoliT_tgljadwal').val())
               
            });

    </script>