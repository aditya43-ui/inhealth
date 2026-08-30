
<div class="tabber">
    <?php
    $module = '/'.$this->module->id;
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>array(
            array('label'=>'Data Obat Alergi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_ObatAlergi','class'=>'tab_rekonobat', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlRekonsiliasiObatAlergi())),
            array('label'=>'Data Obat Sebelum Admisi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_obatadmisi','class'=>'tab_rekonobat', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlRekonsiliasiObatAdmisi())),
            array('label'=>'Data Obat Transfer', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_evaluasi','class'=>'tab_rekonobat', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlRekonsiliasiObatTransfer())),
            array('label'=>'Data Obat Discharge', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_evaluasi','class'=>'tab_rekonobat', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlRekonsiliasiObatDischarge())),
        ),
    ));
    ?>

</div>
