
<style>
    .instaimg{padding:5px;}
    .instaimg:hover {
        opacity:0.8;
        -moz-opacity:0.8;
        -webkit-opacity:0.8;
    }
    .pagination{
        position:relative;
        display:block !important;
        clear:both !important;
        float:left; 
        left:15px;
    }
    .summary{
        padding-left:15px;
    }


</style>



<div class="row-fluid">
    <div class="col-md-12">
        <div class="search">
            <form id="" action="<?php echo $this->createUrl('sistemAdministrator/programpromoM/searchViewCard'); ?>" method="get">
                <input type="hidden" name="r" value="sistemAdministrator/programpromoM/searchViewCard">
                <div class="control-group">

                    <div class="controls">
                        <div class="input-group">
                            <input type="text" name="q" id="q" class="form-control input-lg" placeholder="Pencarian..." >

                            <span class="input-group-btn">
                                <button class="btn-lg btn-blue" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>


                    </div>
                </div>
            </form>



        </div>

    </div>

    <div class="col-md-12">
        <div class="col-md-12">
            <p class='lead'>
                Hasil Pencarian dari <strong>"<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>"</strong>
            </p>

        </div>    
        <div class="blog-posts">
            <div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
            <div class="panel-title">Program Promo</div>
                 <div class="pull-right">
                                <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;margin-top:5px')); ?>
                         </div>
    </div>
    <div class="panel-body">
                    <div id="tampil" class="row" style="position:relative;">
                        <?php
                        $this->widget('bootstrap.widgets.BootListView', array(
                            'dataProvider' => $dataProvider,
                            'itemView' => 'viewtabel',
                        ));
                        ?>
                    </div></div>
            </div>
        </div>



    </div>
</div>

        <?php
//==================== Dialog untuk Melihat detail  =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogDetail',
            'options' => array(
                'title' => 'Informasi Detail',
                'autoOpen' => false,
                'modal' => true,
                'width' => 800,
                'resizable' => false,
            ),
        ));

        echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

        $this->endWidget();
        ?>
    </div></div>




