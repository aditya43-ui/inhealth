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
    .container{
        width: 90%;
        padding: 10px;
        box-sizing: border-box;
    }
    .heading{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .heading .logo-rs{
        width: 20%;
    }

    .heading .logo-innova{
        width: 15%;
    }

    .content{
        display: flex;
        margin-top: 3%;
    }
    .content .blog{
        width: 65%;
        
    }
    .content .pencarian{
        margin-left: 5%;
        width: 30%;
    }

    .search input{
        /* width: 100%; */
        height: 40px;
    }
    .search button{
        width: 40px;
        height: 40px;
    }

    .btn-me{
        padding: 3px 5px;
        font-size: 14px;
        line-height: 2;
        border-radius: 3px;
    }
    .headline-news{
        display: flex;
        /* align-items: center; */
    }
    .headline-news .images{
        margin-right: 10px;
    }
    
    .instaimg{padding:5px;}
    .instaimg:hover {
        opacity:0.8;
        -moz-opacity:0.8;
        -webkit-opacity:0.8;
    }
    .pagination a:hover, .pagination .active a {
        background: #009efb;
        color: #ffffff !important;
    }
    .pagination a {
        float: left;
        padding: 0 8px;
        line-height: 24px;
        text-decoration: none;
        border: 1px solid #009efb;
        border-left-width: 1px;
        border-left-width: 0;
    }
    p{
        font-size:16px;
    }
    /* .post-meta a:nth-child(4){
        background: #000;
        width: 20%;
        height: 1.3%;
        font-size: 14px;
        text-align: center;
    } */
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/blog/theme-blog.css" media="screen" />
<!-- <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/custom.css"> -->

<div class="container">
    <div class="heading">
        <div class="logo-rs">
            <!-- <img  src="<?php echo Yii::app()->request->baseUrl . '/images/logo-innova.png' ?>" id="logo2"/> -->
        </div>
        <div class="logo-innova">
            <!-- <img  src="<?php echo Yii::app()->request->baseUrl . '/images/logo-innova.png' ?>"/> -->
        </div>
    </div>
    <div style="border-bottom: 3px solid #009efb;"></div>

    <div class="content">
        <div class="blog">
            <div class="blog-posts">
                <?php
                    $this->widget('bootstrap.widgets.BootListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => './blog/_view',
                    ));
                ?>
            </div>
        </div>
        <div class="pencarian">
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




