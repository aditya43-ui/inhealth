<?php
/**
 * digunakan untuk modul portal rs informasi Berita
 * perubahan format hari
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
    .isi-konten{
        display: flex;
        margin-top: 3%;
    }

    .isi-konten .isiberita{
        width: 80%; 
    }
    .isi-konten .berita-lain{
        width: 20%;     
    }
    .isi-konten .berita-lain .btn{
        padding: 10px 15px;
        font-size: 18px;
        line-height: 2;
        border-radius: 3px;
        
    }
    #slideshow .hcg-slide-container {
        width: 100%;
        height: auto;
    }
    .hcg-slider {
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
    }
    .hcg-slide-container {
        width: 100%;
        /* background: #000; */
        display: inline-block;
        position: relative;
    }
    .hcg-slides {
        display: none;
        text-align: center;
        overflow: hidden;
        
    }
    .hcg-slides img {
        width: 70%;
        height: 50%;
        display: inline-block;
        border-radius: 5px;
        border: solid 1px #a0a0a0;
        vertical-align: middle;
    }
    .hcg-slide-text {
        color: #ffffff;
        font-size: 14px;
        padding: 3px 5px;
        position: absolute;
        bottom: 0;
        border-radius: 5px;
        left: 50%;
        text-align: center;
        text-shadow: 0 0 2px #000;
        background-color: rgba(255,255,255,0.30);
        display: inline-block;
        transform: translate(-50%, -5px);
    }
    .hcg-slide-prev, .hcg-slide-next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -22px;
        color: #000;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        text-decoration: none;
    }
    .hcg-slide-next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }
    .hcg-slide-prev {
        left: 0;
        border-radius: 0 3px 3px 0;
    }
    .hcg-slide-prev:hover, .hcg-slide-next:hover {
        background-color: #000c;
    }
    .hcg-slide-dot-control {
        margin-top: 10px;
        text-align: center;
    }
    .hcg-slide-dot {
        cursor: pointer;
        height: 13px;
        width: 13px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
    }
    .hcg-slide-dot.dot-active {
        background-color: #717171;
    }
    .hcg-slide-number {
        color: #ffffff;
        font-size: 12px;
        padding: 4px 7px;
        position: absolute;
        border-radius: 5px;
        top: 5px;
        left: 5px;
        background-color: rgba(255,255,255,0.30);
    }
    .komentar{
        width: 100%;
    }
    .komentar .nama{
        width:90%;
    }
    /* .flex{
        display: flex;
    } */
    .label{
        background-color: transparent;
        margin: 10px 0 5px 0;
    }
    .label label{
        font-size: 15px;
    }
    .inputan .input-nama,
    .inputan .input-email
    {
        width: 100%; 
        height: 3%;  
    }
    .inputan .input-textarea{
        width: 100%; 
        height: 15%;
    }
    .button-simpan{
        margin-top: 10px;
    }
    .button-simpan button{
        width: 20%;
        height: 5%;
        font-size: 15px; 
    }
    p{
        font-size:14px;
    }
</style>
<?php //include_once("analyticstracking.php")         ?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/blog/theme-blog.css" media="screen" />

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php if (Yii::app()->user->hasFlash('comment')) { ?>
    <div class="alert alert-success" id="commentSuccess">
        <?php echo Yii::app()->user->getFlash('comment'); ?>
        <span class="pull-right">
            <a href="#" onclick="$('#commentSuccess').hide()"><i class="fa fa-close"></i></a>
        </span>
    </div>

<?php } ?>
<?php
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="container">
    <!-- HEADING -->
    <div class="heading">
            <div class="logo-rs">
                <!-- <img  src="<?php echo Yii::app()->request->baseUrl . '/images/logo-innova.png' ?>" id="logo2"/> -->
            </div>
            <div class="logo-innova">
                <!-- <img  src="<?php echo Yii::app()->request->baseUrl . '/images/logo-innova.png' ?>"/> -->
            </div>
        </div>
    <div style="border-bottom: 3px solid #009efb;"></div>
    <br>

    <!-- CARROUSEL -->
    <!-- <div class="carousel-body">
        <?php
        $gambarcount = PostgambarM::model()->count("post_id=" . $modBlog->post_id);
        if ($gambarcount > 0) {
            ?>
            <div id="carouselExampleIndicators" style=""  class="carousel slide" data-ride="carousel">
                <?php $modgambar = PostgambarM::model()->findAllByAttributes(array("post_id" => $modBlog->post_id)); ?>
                <ol class="carousel-indicators">
                    <?php
                    $i = 1;
                    foreach ($modgambar as $row) {
                        ?>
                        <?php if ($i == 1) { ?>
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>" class="active"></li>
                        <?php } else { ?>
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>"></li>

                        <?php } ?>
                        <?php
                        $i++;
                    }
                    ?>
                </ol>
                <div class="carousel-inner" align="right">
                    <?php
                    $i = 1;
                    foreach ($modgambar as $row) {
                        ?>
                        <?php if ($i == 1) { ?>
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="<?php echo Params::urlBeritaGambar() . $row->pathgambar; ?>" alt="<?php echo $row->pathgambar ?>">
                            </div>
                        <?php } else { ?>
                            <div class="carousel-item ">
                                <img class="d-block w-100" src="<?php echo Params::urlBeritaGambar() . $row->pathgambar; ?>" alt="<?php echo $row->pathgambar ?>">
                            </div>

                        <?php } ?>
                        <?php
                        $i++;
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        <?php } ?>
    </div> -->

<div class="carousel-body">
    <div id="slideshow" class="hcg-slider">
        <div class="hcg-slide-container">
            <div class="hcg-slider-body">
                <a class="hcg-slides animated" style="display:block">
                    <span class="hcg-slide-number">1/5</span>
                    <img src="" alt="image 1">
                    <span class="hcg-slide-text">image 1</span>
                </a>
            </div>
            <a class="hcg-slide-prev" href="#">❮</a>
            <a class="hcg-slide-next" href="#">❯</a>
        </div>
        <div class="hcg-slide-dot-control"></div>
    </div>
</div>


    <!-- ISI -->
    <div class="isi-konten">
        <div class="isiberita">
            <div class="blog-posts single-post">
                <article class="post post-large blog-single-post">
                    <div class="post-date">
                        <span class="day" style="color:#009efb"><?php echo date('d', strtotime($modBlog->post_tgl)); ?></span>
                        <span class="month" style="background-color:#009efb"><?php echo MyFormatter::getDayUser(date('w', strtotime($modBlog->post_tgl))); ?></span>
                    </div>

                    <div class="post-content">
                        <h2><a href="<?php echo $this->createUrl('viewblog', array('id' => CHtml::encode($modBlog->post_id))); ?>"><?php echo CHtml::encode($modBlog->post_judul); ?></a></h2>

                        <div class="post-meta">
                            <?php
                            $modul = LoginpemakaiK::model()->findByPk($modBlog->create_loginpemakai_id);
                            if (!empty($modul->nama_pemakai)) {
                                $namapemakai = $modul->nama_pemakai;
                            }
                            $modul = KategoripostM::model()->findByPk($modBlog->kategoripost_id);
                            if (!empty($modul->kategoripost_id)) {
                                $kategori = $modul->kategoripost_nama;
                            }
                            ?>
                            <span><i class="entypo-user"></i> Oleh <a href="#"><?php echo isset($modBlog->create_loginpemakai_id) ? CHtml::encode($namapemakai) : 'Tidak Diketahui'; ?></a> </span>
                            <span><i class="entypo-tag"></i> <a href="#"><?php echo isset($modBlog->kategoripost_id) ? CHtml::encode($kategori) : 'Tidak Diketahui'; ?></a> </span>
                            <span><i class="entypo-comment"></i> <a href="<?php echo $this->createUrl('viewblog', array('id' => CHtml::encode($modBlog->post_id))); ?>"><?php echo ($modBlog->getJumlahComment() > 0) ? $modBlog->getJumlahComment() . ' Komentar' : 'Ketik Komentar..'; ?></a></span>
                        </div>

                        <?php if (!empty($modBlog->post_gambar)) { ?>
                            <div style="text-align:justify;width:75%; padding:8px;">
                                <div class="row">
                                    <div class="col-3">
                                        <img class="img-responsive" src="<?php echo Params::urlBeritaGambar() . $modBlog->post_gambar; ?>" alt="" width="150px;" style="float:left; margin:0 10px 5px 0;">
                                    </div>
                                    <div class="col-9" >
                                       <?php echo CHtml::decode($modBlog->post_desc); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div style="text-align:justify;width:75%; padding:8px;">
                                <div class="row">
                                    <div class="col-12">
                                        <?php echo CHtml::decode($modBlog->post_desc); ?>
                                      
                                    </div>
                                </div>
                            </div>
                        <?php } ?>



                        <div class="post-block post-comments clearfix">
                            <h3><i class="fa fa-comments" style="color:#009efb"></i><?php echo "Komentar"; ?> (<?php echo $modBlog->getJumlahComment(); ?>)</h3>

                            <ul class="comments">
                                <?php foreach ($modBlog->getComment() as $i => $comment) { ?>
                                    <li>
                                        <div class="comment">
                                            <div class="img-thumbnail">
                                                <img class="avatar" alt="" src="<?php echo Yii::app()->request->baseUrl . '/images/'; ?>web-app-user2.png">
                                            </div>
                                            <div class="comment-block">
                                                <div class="comment-arrow"></div>
                                                <span class="comment-by">
                                                    <strong><?php echo $comment->kommentar_nama; ?></strong>
                                                    <!-- <span class="pull-right">
                                                            <span> <a href="#"><i class="fa fa-reply"></i> Reply</a></span>
                                                    </span> -->
                                                </span>
                                                <p><?php echo $comment->kommentar_desc; ?></p>
                                                <span class="date pull-right"><?php echo date('F d, Y \a\t g:i a', strtotime($comment->create_time)); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="post-block post-leave-comment komentar">
                            <h3><i class="fa fa-plus-square"> Komentar</i></h3>

                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'comment-form',
                                'enableClientValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                ),
                            ));
                            ?>

                            <div class="form-group">
                                <div class="flex">
                                    <div class="label">
                                        <label>Nama <span class="required">*</span></label>
                                    </div>
                                    <!-- <input type="text" value="" maxlength="100" class="form-control" name="name" id="name"> -->
                                    <div class="inputan">
                                        <?php echo $form->textField($modComment, 'kommentar_nama', array('data-msg-required' => "Please enter your name.", 'maxlength' => "100", 'class' => "required form-control input-nama")); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="flex">
                                    <div class="label">
                                        <label>e-Mail <span class="required">*</span></label>
                                    </div>
                                    <!-- <input type="email" value="" maxlength="100" class="form-control" name="email" id="email"> -->
                                    <div class="inputan">
                                        <?php echo $form->textField($modComment, 'kommentar_email', array('data-msg-required' => "Please enter your name.", 'maxlength' => "100", 'class' => "required form-control input-email")); ?>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">

                                <div class="flex">
                                    <div class="label">
                                        <label>Komentar Anda <span class="required">*</span></label>
                                    </div>
                                    <!-- <textarea maxlength="5000" rows="10" class="form-control" name="comment" id="comment"></textarea> -->
                                    <div class="inputan">
                                        <?php echo $form->textArea($modComment, 'kommentar_desc', array('maxlength' => "5000", 'data-msg-required' => "Please enter your message.", 'rows' => "10", 'class' => "required form-control input-textarea")); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="button-simpan">
                                <div class="col-md-12">
                                    <button type="button" value="" onclick="cekForm()" class="btn btn-success btn-lg" data-loading-text="Loading...">Simpan Komentar</button>
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>


                    </div>
                </article>

            </div>
        </div>
        <div class="berita-lain" align="right">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Lihat Berita Lain', array('{icon}' => '<i class="entypo-newspaper "></i>')), $this->createUrl('blog', array()), array('class' => 'btn btn-info ')) . "&nbsp&nbsp"; ?>   
            <?php //echo CHtml::link(Yii::t('mds', '{icon} Kembali Ke Login', array('{icon}' => '<i class="entypo-back "></i>')), $this->createUrl('index', array()), array('class' => 'btn btn-default')) . "&nbsp&nbsp"; ?>
        </div>
    </div>

</div>

<script>
    (function(){
//If you want to include more images, add the link name and URL of the image in the array list below.
	let images_list2 = [
		{"url":"https://www.html-code-generator.com/images/slider/1.png","name":"image 1","link":""},
		{"url":"https://www.html-code-generator.com/images/slider/2.png","name":"image 2","link":""},
	];

    let images_list = [
        <?php foreach ($modgambar as $row) { ?>
		{"url":"<?php echo Params::urlBeritaGambar() . $row->pathgambar; ?>","name":"image 1","link":""},
        <?php } ?>

	];    

	let slider_id = document.querySelector("#slideshow");

	// append all images
	let dots_div = "";
	let images_div = "";
	for (let i = 0; i < images_list.length; i++) {
		// if no link without href="" tag
		let href = (images_list[i].link == "" ? "":' href="'+images_list[i].link+'"');
		images_div += '<a'+href+' class="hcg-slides"'+(i === 0 ? ' style="display:block"':'')+'>'+
						'<span class="hcg-slide-number">'+(i+1)+'/'+images_list.length+'</span>'+
						'<img src="'+images_list[i].url+'" alt="'+images_list[i].name+'">'+
						'<span class="hcg-slide-text">'+images_list[i].name+'</span>'+
					 '</a>';
		dots_div += '<span class="hcg-slide-dot'+(i === 0 ? ' dot-active':'')+'" data-id="'+i+'"></span>';
	}
	slider_id.querySelector(".hcg-slider-body").innerHTML = images_div;
	slider_id.querySelector(".hcg-slide-dot-control").innerHTML = dots_div;

	let slide_index = 0;

	let images = slider_id.querySelectorAll(".hcg-slides");
	let dots = slider_id.querySelectorAll(".hcg-slide-dot");
	let prev_button = slider_id.querySelector(".hcg-slide-prev");
	let next_button = slider_id.querySelector(".hcg-slide-next");

	function showSlides() {
		if (slide_index > images.length-1) {
			slide_index = 0;
		}
		if (slide_index < 0) {
			slide_index = images.length-1;
		}
		for (let i = 0; i < images.length; i++) {
			images[i].style.display = "none";
			dots[i].classList.remove("dot-active");
			if (i == slide_index) {
				images[i].style.display = "block";
				dots[i].classList.add("dot-active");
			}
		}
	}

	prev_button.addEventListener("click", function(event) {
		event.preventDefault();
		slide_index--;
		showSlides();
	}, false);

	next_button.addEventListener("click", function(event){
		event.preventDefault();
		slide_index++;
		showSlides();
	}, false);

	function dot_click(event) {
		slide_index = event.target.dataset.id;
		showSlides();
	}

	for (let i = 0; i < dots.length; i++) {
		dots[i].addEventListener("click", dot_click, false);
	}
})();


    function cekForm() {
        if (requiredCheck($("#comment-form"))) {
            $('#comment-form').submit();
        }

        return false;
    }
</script>