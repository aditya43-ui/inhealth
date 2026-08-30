<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Sel Grouping :','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeHiddenField($modUjiDarahPasien, 'ujidarahpasien_id',array('readonly'=>true)); ?>
            <?php echo CHtml::activeHiddenField($modUjiDarahPasien, 'tglujidarahpasien_temp',array('readonly'=>true)); ?>
        </div>
    </div>
        <div class="anti-a">
            <?php 
                if (empty($modUjiDarahPasien->ujidarahpasien_id)){
                    echo $form->radioButtonListInlineRow($modUjiDarahPasien,'anti_a',LookupM::getItemsUrutan('tipedarah'), array('class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)"));  
                }else{
                    echo "<div class='control-group'>";
                    echo "<label class='control-label'>Anti A</label>";
                    echo "<div class='controls'>";
                    echo CHtml::activeTextField($modUjiDarahPasien, 'anti_a',array('readonly'=>true));
                    echo "</div>";
                    echo "</div>";
                }
            ?>   
        </div>    
        <div class="anti-b">
            <?php                 
                if (empty($modUjiDarahPasien->ujidarahpasien_id)){
                    echo $form->radioButtonListInlineRow($modUjiDarahPasien,'anti_b',LookupM::getItemsUrutan('tipedarah'), array('class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)"));  
                }else{
                    echo "<div class='control-group'>";
                    echo "<label class='control-label'>Anti B</label>";
                    echo "<div class='controls'>";
                    echo CHtml::activeTextField($modUjiDarahPasien, 'anti_b',array('readonly'=>true));
                    echo "</div>";
                    echo "</div>";
                }
            ?>   
            
        </div>
        <div class="anti-ab">
            <?php                 
                if (empty($modUjiDarahPasien->ujidarahpasien_id)){
                    echo $form->radioButtonListInlineRow($modUjiDarahPasien,'anti_ab',LookupM::getItemsUrutan('tipedarah'), array('class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)"));  
                }else{
                    echo "<div class='control-group'>";
                    echo "<label class='control-label'>Anti AB</label>";
                    echo "<div class='controls'>";
                    echo CHtml::activeTextField($modUjiDarahPasien, 'anti_ab',array('readonly'=>true));
                    echo "</div>";
                    echo "</div>";
                }
            ?>   
        </div>
        <div class="anti-d">
            <?php                 
                if (empty($modUjiDarahPasien->ujidarahpasien_id)){
                    echo $form->radioButtonListInlineRow($modUjiDarahPasien,'anti_d',LookupM::getItemsUrutan('tipedarah'), array('class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)"));  
                }else{
                    echo "<div class='control-group'>";
                    echo "<label class='control-label'>Anti D</label>";
                    echo "<div class='controls'>";
                    echo CHtml::activeTextField($modUjiDarahPasien, 'anti_d',array('readonly'=>true));
                    echo "</div>";
                    echo "</div>";
                }
            ?>   
        </div>
    
    <div class="control-group">
        <?php echo CHtml::label('Kesimpulan <span class="required">*</span>','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php 
                echo CHtml::activeTextArea($modUjiDarahPasien,'kesimpulan_uji',array('class'=>'required', 'readonly'=>!empty($modUjiDarahPasien->ujidarahpasien_id)?true:false)); 
            ?>
        </div>
    </div>          
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Serum Typing :','',array('class'=>'control-label')); ?>
        <div class="controls">
            
        </div>
    </div>
    <div class="sel-a">
      <?php             
            if (empty($modUjiDarahPasien->ujidarahpasien_id)){
                echo $form->radioButtonListInlineRow($modUjiDarahPasien,'sel_a',LookupM::getItemsUrutan('tipedarah'), array('class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)"));  
            }else{
                echo "<div class='control-group'>";
                echo "<label class='control-label'>Sel A</label>";
                echo "<div class='controls'>";
                echo CHtml::activeTextField($modUjiDarahPasien, 'sel_a',array('readonly'=>true));
                echo "</div>";
                echo "</div>";
            }
        ?>   
    </div>
    <div class="sel-b">
      <?php             
            if (empty($modUjiDarahPasien->ujidarahpasien_id)){
                echo $form->radioButtonListInlineRow($modUjiDarahPasien,'sel_b',LookupM::getItemsUrutan('tipedarah'), array('class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)"));  
            }else{
                echo "<div class='control-group'>";
                echo "<label class='control-label'>Anti B</label>";
                echo "<div class='controls'>";
                echo CHtml::activeTextField($modUjiDarahPasien, 'sel_b',array('readonly'=>true));
                echo "</div>";
                echo "</div>";
            }
        ?>   
    </div>
    <div class="sel-o">
      <?php             
            if (empty($modUjiDarahPasien->ujidarahpasien_id)){
                echo $form->radioButtonListInlineRow($modUjiDarahPasien,'sel_o',LookupM::getItemsUrutan('tipedarah'), array('class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)"));  
            }else{
                echo "<div class='control-group'>";
                echo "<label class='control-label'>Anti O</label>";
                echo "<div class='controls'>";
                echo CHtml::activeTextField($modUjiDarahPasien, 'sel_o',array('readonly'=>true));
                echo "</div>";
                echo "</div>";
            }
        ?>   
    </div>
    
</div>

<div class="clear"></div>

<div class=' col-sm-12'>
    <div class="control-group hide">
        <label class="control-label required" style="color:red;padding: 0;">Note :</label>
        <div class="controls pesantertulis" style="color:red;">
            
        </div>
    </div>
</div>
