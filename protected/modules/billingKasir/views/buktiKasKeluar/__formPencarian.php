<fieldset>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                Pencarian Kas Keluar
            </div>
        </div>
        <div class="panel-body">
            <?php
            $form = $this->beginWidget(
                'ext.bootstrap.widgets.BootActiveForm',
                array(
                    'id' => 'caripasien-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#',
                    'method' => 'GET',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                )
            );
            ?>
            <?php
            $this->endWidget();
            ?>
        </div>
    </div>
</fieldset>