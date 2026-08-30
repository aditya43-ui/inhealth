<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo Chtml::label('Ventilasi', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                echo CHtml::activeCheckBox($modIntraAnastesi, 'ventilasi_circuit', array());
                ?> <label>Circuit</label>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                echo CHtml::activeCheckBox($modIntraAnastesi, 'ventilasi_spontan', array());
                ?> <label>Spontan</label>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                echo CHtml::activeCheckBox($modIntraAnastesi, 'ventilasi_assisted', array());
                ?> <label>Assisted / SIMV</label>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                echo CHtml::activeCheckBox($modIntraAnastesi, 'ventilasi_cmv', array());
                ?> <label>CMV</label>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                echo CHtml::activeCheckBox($modIntraAnastesi, 'ventilasi_pcv', array());
                ?> <label>PCV</label>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <label>TV &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <?php
                echo CHtml::activeTextField($modIntraAnastesi, 'ventilasi_tv', array('class' => 'span3'));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  <label>Rate &nbsp;&nbsp;</label>
                <?php
                echo CHtml::activeTextField($modIntraAnastesi, 'ventilasi_rate', array('class' => 'span3'));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  <label>Peep &nbsp;</label>
                <?php
                echo CHtml::activeTextField($modIntraAnastesi, 'ventilasi_peep', array('class' => 'span3'));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        
        <div id="form-gas-flow">
            <div class="control-group ">
                <?php echo Chtml::label('Gas Flow', '', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    echo CHtml::activeCheckBox($modIntraAnastesi, 'gasflow_n2o', array('onClick'=>'changeN20();','class'=>'adatext check'));
                    ?> <label>N20 &nbsp;&nbsp;&nbsp;&nbsp;</label> <?php
                    echo CHtml::activeTextField($modIntraAnastesi, 'gasflow_n2o_keterangan', array('class' => 'span2 numbers-only txtlain','readonly'=>!empty($modIntraAnastesi->gasflow_n2o_keterangan)? false : true));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    echo CHtml::activeCheckBox($modIntraAnastesi, 'gasflow_o2', array('onClick'=>'changeO2();','class'=>'adatext check'));
                    ?> <label>O2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php
                    echo CHtml::activeTextField($modIntraAnastesi, 'gasflow_o2_keterangan', array('class' => 'span2 numbers-only txtlain','readonly'=>!empty($modIntraAnastesi->gasflow_o2_keterangan)? false : true));
                    ?>
                </div>
            </div>
        </div>
            <div class="control-group ">
                <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    echo CHtml::activeCheckBox($modIntraAnastesi, 'gasflow_air', array('onClick'=>'changeAir();','class'=>'adatext check'));
                    ?> <label>Air &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><?php
                    echo CHtml::activeTextField($modIntraAnastesi, 'gasflow_air_keterangan', array('class' => 'span2 txtlain','readonly'=> !empty($modIntraAnastesi->gasflow_air_keterangan)? false : true));
                    ?>
                </div>
            </div>        
        
        <div class="control-group ">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <?php
                                echo CHtml::activeCheckBox($modIntraAnastesi, 'gasflow_gasinhalasi', array('value' => true, 'uncheckValue' => false, 'onchange'=>'cekGasInhalasi(this);'));
                                ?> 
                            </th>
                            <th>&nbsp;</th>
                            <th>Gas Inhalasi</th>
                            <th>&emsp;</th>
                            <th>&emsp;</th>
                            <th>
                                <table id="table-gasflow">
                                    <tbody>

                                    </tbody>
                                </table>
                            </th>
                        </tr>
                    </thead>
                </table>
<!--                <table id="table-gasflow">
                    <thead>
                        <tr>
                            <th>
                                <?php
                                //echo CHtml::activeCheckBox($modIntraAnastesi, 'gasflow_gasinhalasi', array('value' => true, 'uncheckValue' => false, 'onchange'=>'cekGasInhalasi(this);'));
                                ?> 
                            </th>
                            <th>Gas Inhalasi</th>
                            <th>&emsp;</th>
                            <th>&emsp;</th>
                            <th>
                                <?php
                                //echo CHtml::textField('gasinhalasi[0][nama]','', array('class' => 'span2'));
                                ?>
                            </th>
                            <th>
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>-->
                
                <table id="table-gasflow-hapus" class="hide">
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>