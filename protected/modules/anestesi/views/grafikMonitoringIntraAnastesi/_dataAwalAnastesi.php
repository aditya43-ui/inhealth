<div class="row-fluid">
    <?php echo CHtml::activeHiddenField($modIntraAnestesi, 'intraanastesi_id', array('readonly' => true)); ?>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('<b>Ventilasi</b>', '', array('class' => 'control-label', 'style' => 'padding-top:2px')); ?>
            <div class="controls" id="1" style="display: none;">  
                <?php
                echo CHtml::checkBox('ventilasi_circuit', '1', array('disabled' => true, 'checked' => true));
                ?> Circuit
                <?php echo CHtml::activeHiddenField($modIntraAnestesi, 'ventilasi_circuit', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group " id="2" style="display: none;">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                echo CHtml::checkBox('ventilasi_spontan', '1', array('disabled' => true, 'checked' => true));
                ?> Spontan
                <?php echo CHtml::activeHiddenField($modIntraAnestesi, 'ventilasi_spontan', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group " id="3" style="display: none;">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                echo CHtml::checkBox('ventilasi_assisted', '1', array('disabled' => true, 'checked' => true));
                ?> Assisted / SIMV
                <?php echo CHtml::activeHiddenField($modIntraAnestesi, 'ventilasi_assisted', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group " id="4" style="display: none;">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                echo CHtml::checkBox('ventilasi_cmv', '1', array('disabled' => true, 'checked' => true));
                ?> CMV
                <?php echo CHtml::activeHiddenField($modIntraAnestesi, 'ventilasi_cmv', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group " id="5" style="display: none;">
            <?php echo Chtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                echo CHtml::checkBox('', '1', array('disabled' => true, 'checked' => true));
                ?> PCV
                <?php echo CHtml::activeHiddenField($modIntraAnestesi, 'ventilasi_pcv', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group" id="6" style="display: none;">
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modIntraAnestesi, 'ventilasi_tv', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group" id="7" style="display: none;">
            <?php echo CHtml::label('', 'ventilasi_rate', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modIntraAnestesi, 'ventilasi_rate', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group" id="8" style="display: none;">
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modIntraAnestesi, 'ventilasi_peep', array('readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group" id="9" style="display: none;">
            <?php echo CHtml::label('<b>Gas Flow</b>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modIntraAnestesi, 'gasflow_n2o_keterangan', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group" id="10" style="display: none;">
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modIntraAnestesi, 'gasflow_o2_keterangan', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group" id="11" style="display: none;">
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modIntraAnestesi, 'gasflow_air_keterangan', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group" id="12" style="display: none;">
            <?php echo CHtml::label('<b>Gas Inhalasi</b>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modIntraAnestesi, 'gasflow_gasinhalasi', array('readonly' => true)); ?>
                <table id="tabelgasinhalasi" border="0px" width="100%">

                </table>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('<b>Cairan Pra Anastesi</b>', '', array('class' => 'control-label')); ?>
            <div class="controls">
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Cairan Masuk', '', array('class' => 'control-label')); ?>
            <div class="controls">
            </div>
        </div>
        <div class="control-group" id="13" style="display: none;">
            <?php echo CHtml::label('Kristoloid', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <table id="tabelkristaloid" border="0px" width="100%">

                </table>
            </div>
        </div>

        <div class="control-group" id="14" style="display: none;">
            <?php echo CHtml::label('Kolloid', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <table id="tabelkolloid" border="0px" width="100%">

                </table>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Darah', '', array('class' => 'control-label')); ?>
            <div class="controls">
            </div>
        </div>
        <div class="control-group" id="15" style="display: none;">
            <?php echo CHtml::label('WB', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <table id="tabeldarah_wb" border="0px" width="100%">

                </table>
            </div>
        </div>
        <div class="control-group" id="16" style="display: none;">
            <?php echo CHtml::label('PRC', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <table id="tabeldarah_prc" border="0px" width="100%">

                </table>
            </div>
        </div>
        <div class="control-group" id="17" style="display: none;">
            <?php echo CHtml::label('FFP', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <table id="tabeldarah_ffp" border="0px" width="100%">

                </table>
            </div>
        </div>
        <div class="control-group" id="18" style="display: none;">
            <?php echo CHtml::label('TC', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <table id="tabeldarah_tc" border="0px" width="100%">

                </table>
            </div>
        </div>
        <div class="control-group" id="19" style="display: none;">
            <?php echo CHtml::label('PPR', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <table id="tabeldarah_ppr" border="0px" width="100%">

                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('<span style="color:transparent"><b>Cairan Pra Anastesi</b></span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Cairan Keluar', '', array('class' => 'control-label')); ?>
            <div class="controls">

            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Urin', 'urin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modObat, 'urin', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('S&I', 's_dan_i', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modObat, 's_dan_i', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Darah', 'darah', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modObat, 'darah', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('EBL', 'ebl', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modObat, 'ebl', array('readonly' => true)); ?>
                <label>%</label>
            </div>
        </div>
    </div>
</div>