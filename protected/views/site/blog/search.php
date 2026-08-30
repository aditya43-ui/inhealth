<?php
/**
 * digunakan untuk modul portal rs informasi Berita
 * RSST-2445
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */
?>
<style>
    .instaimg{padding:5px;}
    .instaimg:hover {
        opacity:0.8;
        -moz-opacity:0.8;
        -webkit-opacity:0.8;
    }
    .carousel-inner{
        width:100%;
        height: 200px !important;
    }
    p{
        font-size:14px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/blog/theme-blog.css" media="screen" />



<div class="container">
    <div class="row">
        <div class="col-9">
            <img  width="30%" src="<?php echo Yii::app()->request->baseUrl . '/images/logo-rsst-transparan.png' ?>" id="logo2"/>
        </div>
        <div class="col-3" >

            <!-- <img  src="<?php echo Yii::app()->request->baseUrl . '/images/logo-innova.png' ?>" style="height:80px" /> -->
        </div>
    </div>
    <div style="border-bottom: 3px solid #009efb;"></div>
    <br>
    <div class="row">
        <div class="row" align="right">
            <?php //echo CHtml::link(Yii::t('mds', '{icon} Kembali Ke Login', array('{icon}' => '<i class="entypo-back "></i>')), $this->createUrl('index', array()), array('class' => 'btn btn-default')) . "&nbsp&nbsp"; ?>
        </div>
        <div class="col-12">
            <p class='lead'>
                Hasil Pencarian dari <strong>"<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>"</strong>
            </p>

        </div>
        <div class="col-8">
            <div class="blog-posts">
                <?php
                $this->widget('bootstrap.widgets.BootListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => './blog/_view',
                ));
                ?>
            </div>
        </div>
        <div class="col-4">
            <div class="search">
                <form id="" action="<?php echo $this->createUrl('site/searchBlog'); ?>" method="get">
                    <input type="hidden" name="r" value="site/searchBlog">
                    <div class="control-group">

                        <div class="controls">
                            <div class="input-group">
                                <input type="text" name="q" id="q" class="form-control input-lg" placeholder="Search..." >

                                <span class="input-group-btn">
                                    <button class="btn btn-info btn-lg" type="submit"><i class="fa fa-search"></i></button>
                                </span>
                            </div>


                        </div>
                    </div>
                </form>



            </div>

        </div>


    </div>
</div>




