<div class="view-eresep" style="
    border: 1px solid whitesmoke; 
    border-radius: 3px; 
    width: 150px;
    background-color: #00a651;
    float: left;
    height: 150px;
    overflow-y: hidden;
    ">
    <div style="margin-bottom: 2px; padding-left: 2px;"><?php echo CHtml::checkBox('eresep['.$item->eresep_id.']', true, array(
        'class'=>'ceklis_scan',
        'onchange'=>'$("#iter").change().blur();',
        'disabled'=>!empty($issubmit),
    )); ?></div>
    <?php echo CHtml::image(Params::urlResepturDirectory().$item->eresep_image, ''); ?>
</div>