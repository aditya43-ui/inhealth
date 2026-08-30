<?php $this->beginContent('//layouts/main'); ?>
<?php 
$modulMenu = ((!empty($this->module->menu_side)) ? $this->module->menu_side : null); 
?>
<div class="white-container">
    <table width="100%">
        <tr>
            <td style="width:17%">
                <div class="sidebar">
                    <?php
                        $this->widget('MySideMenu',array(
                            'id'=>'mysidemenu',
                            'items'=>$this->module->menu_side,
                            'htmlOptions'=>array('class'=>'span3'),
                            'header'=>array('label'=>"Dashboard", 'url'=>  Yii::app()->createUrl("/".$this->module->id, array('moduleId'=>Yii::app()->session['modul_id'])))
                            ));
                    ?>
                </div>
            </td>
            <td style="width:83%">
                <div id="content">
                    <?php echo $content; ?>
                </div>
            </td>
        </tr>
    </table>
    <?php $this->endContent(); ?>
</div>