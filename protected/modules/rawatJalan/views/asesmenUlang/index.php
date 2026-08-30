<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ckeditor/ckeditor.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">    
    <div class="panel-body">                
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $this->renderPartial($this->path_view . '_tabMenu', array());
        $this->renderPartial($this->path_view . '_jsFunctions', array('model' => new AsesmenspiritualUlangpasienrajaldetT)); 
        
        $arr=array(
            array('id'=>1),
        );
        
        $dataProvider=new CArrayDataProvider($arr,array(
        ));
        
        echo '<div class="hide">';
         $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'testing',
                'dataProvider'=> $dataProvider,	
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                        'id'
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        echo '</div>';
        ?>
        
        
        
        <div id="form-panel-asesmen-ulang">
        </div>
    </div>
</div>