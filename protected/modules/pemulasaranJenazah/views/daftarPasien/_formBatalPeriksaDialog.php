<div class="col-sm-12">
    <table>
        <tr>
            <td><?php echo CHtml::label('Nama Pemakai', 'username', array('class' => 'control-label')) ?></td>
            <td>
                <?php echo CHtml::textField('username', '', array('placeholder' => 'Nama Pemakai', 'class' => 'span3')); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('Password', 'password', array('class' => 'control-label')) ?></td>
            <td>
                <?php echo CHtml::passwordField('password', '', array('placeholder' => 'Password', 'class' => 'span3')); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php
        echo CHtml::hiddenField('pasienmasukpenunjang_id', '');
        echo CHtml::hiddenField('pendaftaran_id', '');
        echo CHtml::hiddenField('statusperiksa', '');
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'onclick' => 'batalperiksa();', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-cancel"></i>')),
            array('type' => 'button', 'onclick' => '$(\'#DialogBatalperiksa\').dialog(\'close\');', 'class' => 'btn btn-default')
        ); ?>
    </div>
</div>