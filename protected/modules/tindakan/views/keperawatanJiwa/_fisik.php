<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Fisik
        </div>
    </div>
    <div class="panel-body">
        <table class='form_predispo'>
            <tr>
                <td width='10'><label>1.</label></td>
                <td width='200'><label>Tanda Vital</label></td>
                <td>
                    <label>TD</label> <?php echo $form->textField($model, 'fisik_tandavital[td]', array('class'=>'span2')); ?>
                    <label>N</label> <?php echo $form->textField($model, 'fisik_tandavital[n]', array('class'=>'span2')); ?>
                    <label>S</label> <?php echo $form->textField($model, 'fisik_tandavital[s]', array('class'=>'span2')); ?>
                    <label>P</label> <?php echo $form->textField($model, 'fisik_tandavital[p]', array('class'=>'span2')); ?>
                </td>
            </tr>
            <tr>
                <td><label>2.</label></td>
                <td><label>Ukur</label></td>
                <td>
                    <label>TB</label> <?php echo $form->textField($model, 'fisik_tinggibadan', array('class'=>'span2 numbers-only')); ?>
                    <label>BB</label> <?php echo $form->textField($model, 'fisik_beratbadan', array('class'=>'span2 numbers-only')); ?>
                </td>
            </tr>
            <tr>
                <td><label>3.</label></td>
                <td><?php echo $form->label($model, 'fisik_keluhan', array('label'=>"Keluhan Fisik")) ?></td>
                <td><?php echo $form->radioButtonList($model,'fisik_keluhan', array(1=>"Ya", 0=>"Tidak"), array('template'=>'{input}{label}&nbsp;&nbsp;')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><label>Jelaskan</label></td>
                <td>
                    <?php echo $form->textArea($model, 'fisik_penjelasan'); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><label><b>Masalah Keperawatan</b></label></td>
                <td>
                    <?php echo $form->textArea($model, 'fisik_masalahkeperawatan'); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
