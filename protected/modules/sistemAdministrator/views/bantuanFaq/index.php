<?php
    $this->breadcrumbs = array(
        'Bantuan FAQ',
    );
    $this->widget('bootstrap.widgets.BootAlert');
?>
<style>
    .menuFaq{
       border: 1px solid #f2f2f4;
       background: #fff;
       overflow: hidden;
       margin-top: 20px;
       background-clip: padding-box;
       border-radius: 3px;
    }
    .menuFaq #main-menu{
        list-style: none;
        margin-left: 0 !important;
        margin-bottom: 0 !important;
        padding-left: 0 !important;
        margin-top: 0 !important;
        border-bottom: 1px solid #f2f2f4;
        
    }
    .menuFaq #main-menu li{
        position: relative;
        display: block;
        cursor: pointer;
        margin: 0;
        font-size: 12px;
        border-bottom: 1px solid rgba(69,74,84,0.4);
    }
    .menuFaq #main-menu li a{
        position: relative;
        display: block;
        padding: 10px 15px;
        color: #373e4a;
        text-decoration: none;
        background: transparent;
    }
    .menuFaq #main-menu li a i{
        float: right;
    }
    .menuFaq-content{
        margin-top: 20px;
    }
    .activeMenuFaq{
        background: #eeeeee;
    }
    .activeMenuFaq a{
        font-weight: bold;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Bantuan FAQ
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-gray" style="background: #57a595 !important; border-radius: 10px !important;">
                    <div class="panel-body" style="height: 150px; background: #57a595 !important; border-radius: 10px !important;">
                        <div style="margin-top: 40px;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icon-search"></i></span>   
                                <?php echo CHtml::textField('searchFaq','',array('class'=>'form-control', 'placeholder'=>'Ketik Pencarian Faq')) ?>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="loadPencarianFaq" style="padding-top: 10px;">

                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>

