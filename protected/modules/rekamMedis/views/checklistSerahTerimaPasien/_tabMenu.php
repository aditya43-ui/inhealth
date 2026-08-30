
<div class="tabber">
    <?php
    $module = '/'.$this->module->id;
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>array(
            array('label'=>'Pre Operasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_checklistpre', 'onclick'=>'setTab_checklist(this);', 'tab'=>'/bedahSentral/ChecklistPraOperasi/index')),
            array('label'=>'Post Operasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_checkistpro', 'onclick'=>'setTab_checklist(this);', 'tab'=>'/bedahSentral/ChecklistPostOperasi/index')),
        ),
    ));
    ?>

</div>
