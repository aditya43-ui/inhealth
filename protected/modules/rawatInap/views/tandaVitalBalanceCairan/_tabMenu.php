
<div class="tabber">
    <?php
    $module = '/'.$this->module->id;
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>array(
            array('label'=>'Tanda Vital', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_TandaVital', 'onclick'=>'setTab(this);', 'tab'=>'/rawatInap/grafikTandaVital/create')),
            array('label'=>'Balance Cairan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_BalanceCairan', 'onclick'=>'setTab(this);', 'tab'=>'/rawatInap/BalanceCairan/index')),
        ),
    ));
    ?>

</div>
