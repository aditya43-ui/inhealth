<?php ?>
<tr class="rencanaaskepdet">
    <td>
        <?php echo CHtml::activeHiddenField($modDetail, '[0]diagnosakep_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[0]implementasiaskepdet_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
        <?php
        if (!empty($modDetail->diagnosakep_id)) {
            ?><div class="control-group"><?php
            echo CHtml::activeCheckBox($modDetail, '[0]isdiagnosa', array('uncheckValue' => 0, 'onclick' => 'cekListDiagnosa(this)', 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'control-label'));
            ?><div class="controls">
                <?php echo CHtml::activeTextField($modDetail, '[0]diagnosakep_nama', array('readonly' => true)); ?>	
                </div>
            </div>
            <?php
        }
        ?>
        <div class="control-group span12 redactor">
            <?php echo CHtml::label('Subjektif <span class="required">*</span>', '[0]evaluasiaskepdet_subjektif', array('class' => 'control-label')) ?>
            <!--<div class="controls">
            <?php //echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_subjektif', array('required'=>true,'class' => 'span10')); ?>	
            </div>-->
            <div class="controls" style="width:80%;">
                <?php //echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_planning', array('required'=>true,'class' => 'span10')); ?>
                <?php
                $this->widget('ext.redactorjs.Redactor', array(
                    'model' => $modDetail,
                    'attribute' => '[0]evaluasiaskepdet_subjektif',
                    'toolbar' => 'mini', 'height' => '150px',
                    'htmlOptions' =>
                    array('class' => 'required')));
                ?>
            </div>
        </div>
        <div class="control-group span12 redactor">
            <?php echo CHtml::label('Objektif <span class="required">*</span>', '[0]evaluasiaskepdet_objektif', array('class' => 'control-label')) ?>
            <!--<div class="controls">
            <?php // echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_objektif', array('required'=>true,'class' => 'span10')); ?>
            </div>-->
            <div class="controls" style="width:80%;">
                <?php //echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_planning', array('required'=>true,'class' => 'span10')); ?>
                <?php
                $this->widget('ext.redactorjs.Redactor', array(
                    'model' => $modDetail,
                    'attribute' => '[0]evaluasiaskepdet_objektif',
                    'toolbar' => 'mini', 'height' => '150px',
                    'htmlOptions' =>
                    array('class' => 'required')));
                ?>
            </div>
        </div>
        <div class="control-group span12 redactor">
            <?php echo CHtml::label('Assessment <span class="required">*</span>', '[0]evaluasiaskepdet_assessment', array('class' => 'control-label')) ?>
            <!--<div class="controls">
            <?php //echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_assessment', array('required'=>true,'class' => 'span10')); ?>
            </div>-->
            <div class="controls" style="width:80%;">
                <?php //echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_planning', array('required'=>true,'class' => 'span10')); ?>
                <?php
                $this->widget('ext.redactorjs.Redactor', array(
                    'model' => $modDetail,
                    'attribute' => '[0]evaluasiaskepdet_assessment',
                    'toolbar' => 'mini', 'height' => '150px',
                    'htmlOptions' =>
                    array('class' => 'required')));
                ?>
            </div>
        </div>
        <div class="control-group span12 redactor">
            <?php echo CHtml::label('Planning <span class="required">*</span>', '[0]evaluasiaskepdet_planning', array('class' => 'control-label')) ?>
            <div class="controls" style="width:80%;">
                <?php //echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_planning', array('required'=>true,'class' => 'span10')); ?>
                <?php
                $this->widget('ext.redactorjs.Redactor', array(
                    'model' => $modDetail,
                    'attribute' => '[0]evaluasiaskepdet_planning',
                    'toolbar' => 'mini', 'height' => '150px',
                    'htmlOptions' =>
                    array('class' => 'required')));
                ?>
            </div>
        </div>
        <div class="control-group span12 redactor">
            <?php echo CHtml::label('Implementasi <span class="required">*</span>', '[0]evaluasiaskepdet_implementasi', array('class' => 'control-label')) ?>
            <div class="controls" style="width:80%;">
                <?php
                $this->widget('ext.redactorjs.Redactor', array(
                    'model' => $modDetail,
                    'attribute' => '[0]evaluasiaskepdet_implementasi',
                    'toolbar' => 'mini', 'height' => '150px',
                    'htmlOptions' =>
                    array('class' => 'required')));
                ?>
            </div>
        </div>
        <div class="control-group span12">
            <?php echo CHtml::label('Hasil Evaluasi', '[0]evaluasiaskepdet_hasil', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeDropDownList($modDetail, '[0]evaluasiaskepdet_hasil', array('tercapai' => 'Tercapai',
                    'tidak tercapai' => 'Tidak Tercapai',), array('class' => 'required', 'empty' => '-- Pilih --'));
                ?>
            </div>
        </div>
    </td>
</tr>
