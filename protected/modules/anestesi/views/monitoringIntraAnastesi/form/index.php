 <div class="control-group menit-ke">
    <label class="control-label">Menit Ke - </label>
    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'menit_ke',array('class' => 'numbers-only', 
            //'style' => 'border: 1px solid #333;'
            )) ?>
    </div>
</div>
<p>&nbsp;</p>
<div class="steps-progress">
        <div class="progress-indicator"></div>
</div>

<ul id="wizard-progress">
        <li class="active completed">
                <a href="#tab1" data-toggle="tab" no-urut="1"><span></span>Nadi</a>
        </li>
        <li>
                <a href="#tab2" data-toggle="tab" no-urut="2"><span></span>Tekanan Darah</a>
        </li>
        <li>
                <a href="#tab3" data-toggle="tab" no-urut="3"><span></span>Resp. Rate</a>
        </li>
        <li>
                <a href="#tab4" data-toggle="tab" no-urut="4"><span></span>Tourniquet</a>
        </li>
        <li>
                <a href="#tab5" data-toggle="tab" no-urut="5"><span></span>SpO2</a>
        </li>
        <li>
                <a href="#tab6" data-toggle="tab" no-urut="6"><span></span>ETCO2</a>
        </li>
        <li>
                <a href="#tab7" data-toggle="tab" no-urut="7"><span></span>CVP/ScVO2</a>
        </li>
        <li>
                <a href="#tab8" data-toggle="tab" no-urut="8"><span></span>BIS</a>
        </li>
        <li>
                <a href="#tab9" data-toggle="tab" no-urut="9"><span></span>Temp</a>
        </li>
        <li>
                <a href="#tab10" data-toggle="tab" no-urut="10"><span></span>Input</a>
        </li>
        <li>
                <a href="#tab11" data-toggle="tab" no-urut="11"><span></span>Output</a>
        </li>
</ul>

<div class="tab-content">

    <div class="tab-pane active" id="tab1">                    
        <div class="col-sm-11">
            <p>&nbsp;</p>            
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Nadi</div>
                </div>
                <div class="panel-body">
                    <?php echo $this->renderPartial($this->path_view.'form/_formNadi',array('model'=>$model)); ?>
                </div>
            </div>                       
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'15px')); ?>
            
    </div>
    <div class="tab-pane" id="tab2">        
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'100px')); ?>                     
        <div class="col-sm-10">            
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Tekanan Darah</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                    <?php echo $this->renderPartial($this->path_view.'form/_formTekananDarah',array('model'=>$model)); ?>
                    </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>
            
            <p>&nbsp;</p>            
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Mean arterial Press</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <?php echo $this->renderPartial($this->path_view.'form/_formMeanArterialPress',array('model'=>$model)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'100px')); ?>
    </div>
    <div class="tab-pane" id="tab3">
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'50px')); ?>                   
        <div class="col-sm-10">
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Respiration Rate</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <?php echo $this->renderPartial($this->path_view.'form/_formRespirationRate',array('model'=>$model)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>                        
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'50px')); ?>
    </div>
    <div class="tab-pane" id="tab4">
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'15px')); ?>                   
        <div class="col-sm-10">
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Tourniquet</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <?php echo $this->renderPartial($this->path_view.'form/_formTourniquet',array('model'=>$model)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>                        
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'15px')); ?>
    </div>
    <div class="tab-pane" id="tab5">
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'15px')); ?>                   
        <div class="col-sm-10">
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">SpO2</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <?php echo $this->renderPartial($this->path_view.'form/_formSpO2',array('model'=>$model)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>                        
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'15px')); ?>
    </div>
    <div class="tab-pane" id="tab6">
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'15px')); ?>                   
        <div class="col-sm-10">
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">SpO2</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <?php echo $this->renderPartial($this->path_view.'form/_formETCO2',array('model'=>$model)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>                        
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'15px')); ?>
    </div>
    <div class="tab-pane" id="tab7">
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'15px')); ?>                   
        <div class="col-sm-10">
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">CVP/ScVO2</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <?php echo $this->renderPartial($this->path_view.'form/_formCVP',array('model'=>$model)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>                        
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'15px')); ?>
    </div>
    <div class="tab-pane" id="tab8">
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'15px')); ?>                   
        <div class="col-sm-10">
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">BIS</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <?php echo $this->renderPartial($this->path_view.'form/_formBIS',array('model'=>$model)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>                        
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'15px')); ?>
    </div>
    <div class="tab-pane" id="tab9">
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'15px')); ?>                   
        <div class="col-sm-10">
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Temp</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <?php echo $this->renderPartial($this->path_view.'form/_formTemp',array('model'=>$model)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>                        
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'15px')); ?>
    </div>
    <div class="tab-pane" id="tab10">
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'180px')); ?>                   
        <div class="col-sm-10">
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Input</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10" id='form-input-anestesi'>
                        <?php echo $this->renderPartial($this->path_view.'form/_formInput',array('model'=>$modInput, 'loadInput' => $loadInput)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>                        
        </div>
        <?php echo $this->renderPartial($this->path_view.'form/_pagerNext',array('top'=>'180px')); ?>
    </div>
    <div class="tab-pane" id="tab11">
        <?php echo $this->renderPartial($this->path_view.'form/_pagerPrevious',array('top'=>'90px')); ?>                   
        <div class="col-sm-10">
            <p>&nbsp;</p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Output</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <?php echo $this->renderPartial($this->path_view.'form/_formOutput',array('model'=>$modOutput)); ?>
                        </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>                        
        </div>
        <div class="clear"></div>
            <?php echo $this->renderPartial($this->path_view.'_button',array('model' => $model)); ?>
    </div>

        

</div>
