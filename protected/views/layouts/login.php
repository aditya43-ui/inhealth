<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl;?>/images/icon/faveicon.png"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-1.2.6.min.js" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form_login.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animation-loading.css" />
	<link rel="shortcut icon" href="fav.ico" type="image/x-icon" />
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.maskMoney.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.maskedinput.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/realtimeClock.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
	<style type="text/css">
        .pengumuman{
            margin: 25px auto !important;
            padding:10px 10px 15px 10px;
            width:70%;
            border:0;
            color:#ffffff;
            font-size:20px;
            position: relative;
            bottom: 0 !important;
            display: table;
            background: rgba(255, 255, 255, 0.8);
            padding: 10px;
            box-shadow: 0px 0px 12px black;
            border: 1px solid rgba(255, 255, 255, 0.4);
            -webkit-border-radius:15px;
            -moz-border-radius:15px;
            border-radius:15px;
        }
        .logo-login{float:left;}
        .logo-bakti{float:right;}
        .profil_rs{text-align:center;color: #212121;font-size: 14px; float: left; width: calc(100% - 140px)}
        .contain{width:60%;margin:0 auto;}
        .nama_rs{font-size: 35px; font-weight:bold; }
    </style>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script>
		
function slideSwitch() {
    var $active = $('#slideshow IMG.active');

    if ( $active.length == 0 ) $active = $('#slideshow IMG:last');

    // use this to pull the images in the order they appear in the markup
    var $next =  $active.next().length ? $active.next()
        : $('#slideshow IMG:first');

    // uncomment the 3 lines below to pull the images in random order
    
    // var $sibs  = $active.siblings();
    // var rndNum = Math.floor(Math.random() * $sibs.length );
    // var $next  = $( $sibs[ rndNum ] );


    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval( "slideSwitch()", 5000 );
});
		
		
            function updateClock ( )
            {
                var currentTime = new Date ( );
                var currentHours = currentTime.getHours ( );
                var currentMinutes = currentTime.getMinutes ( );
                var currentSeconds = currentTime.getSeconds ( );
                
                // Pad the minutes and seconds with leading zeros, if required
                currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
                currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
                
                // Choose either "AM" or "PM" as appropriate
                var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
                
                // Convert the hours component to 12-hour format if needed
                currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
                
                // Convert an hours component of "0" to "12"
                currentHours = ( currentHours == 0 ) ? 12 : currentHours;
                
                // Compose the string for display
                var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
                
                $("#clock").html(currentTimeString);
                
            }
             
            $(document).ready(function()
            {
                setInterval('updateClock()', 1000);
            });


        </script>	
</head>

<body>
        <?php // $this->widget('BoxPengumuman');?>

<!--        <div class="span-25">
	<?php if(isset($this->breadcrumbs)){
            $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
                        'links'=>$this->breadcrumbs,
                    )); // breadcrumbs 
        }
        ?>
        </div>-->
        
        <?php //echo '<pre>'.print_r($menu,1).'</pre>'; ?>
        <?php //echo '<pre>'.print_r($this->arrMenuModul,1).'</pre>'; ?>
    	<?php echo $content; ?>
    
	<div class="clear">
	<!-- <div id="footer">
		Copyright &copy; <?php //echo date('Y'); ?> by Innova-eHospital.
		<?php //echo Yii::powered(); ?>
	</div>footer -->
        </div>

<!--	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div> header -->

	<div id="mainmenu">
        
         <?php $profil=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
        <div class='pengumuman'>
            <div class='logo-login'>
                <img src='<?php echo Params::urlProfilRSDirectory().$profil->logo_rumahsakit ?>' alt='logo RUMKIT' />
            </div>
            <div class="profil_rs col-sm-4">
                <div class="nama_rs"><?php echo $profil->nama_rumahsakit; ?></div>
                <?php echo $profil->alamatlokasi_rumahsakit; ?>,
                Telp : <?php echo $profil->no_telp_profilrs; ?> - 
                Fax : <?php echo $profil->no_faksimili; ?><br/> 
                <i class="icon-envelope"></i>  <?php echo CHtml::link($profil->email,'mailto:'.$profil->email,array('target'=>'_BLANK')); ?> 
                <i class="icon-home"></i>  <?php echo CHtml::link($profil->website,'http://'.$profil->website,array('target'=>'_BLANK')); ?>
            </div>
            <div class='logo-bakti'>
                <img src='<?php echo Params::urlProfilRSDirectory()."../baktihusada1.png" ?>' alt='logo BAKTIHUSADA' />
            </div>
        </div>
		<?php 
//                $this->widget('zii.widgets.CMenu',array(
//			'items'=>array(
//				array('label'=>'Home', 'url'=>array('/site/index')),
//				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
//				array('label'=>'Contact', 'url'=>array('/site/contact')),
//				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
//				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
//			),
//		));
$this->layout = '//layouts/column1';
 ?>
	</div><!-- mainmenu -->

</body>
</html>
<?php
$js = <<< JSCRIPT
    function dialog_kertas()
        {
        $('#ubah_kertas').dialog('open');
        
        }
    function simpan_kertas()
        {
            ukuranKertas = $('#ukuranKertas').val();
            posisiKertas = $('#posisiKertas').val();
            posisiNama = $('#posisiKertas :selected').html();
            $.post("index.php?r=site/setKertas",{ukuranKertas:ukuranKertas,posisiKertas:posisiKertas,posisiNama:posisiNama },function(data){
                myAlert(data.pesan);
                 $('#ubah_kertas').dialog('close');
                
        return false;
    },"json");
        }
JSCRIPT;

Yii::app()->clientScript->registerScript('jsPendaftaran',$js, CClientScript::POS_HEAD);

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'ubah_kertas',
    'options'=>array(
        'title'=>'Ubah Ukuran dan Posisi Kertas',
        'autoOpen'=>false,
        'width'=>450,
        'height'=>300,
        'modal'=>'true',
        'hide'=>'explode',
        'resizelable'=>false,
    ),
));

//$form=$this->beginWidget('CActiveForm', array(
//	'id'=>'setting-print-form',
//        'enableAjaxValidation'=>false,
//        'action'=>'/simrs/index.php?r=site/setKertas',
//        'htmlOptions'=>array('class'=>'form-horizontal'),
//));
?>
<div class="control-group">
    <?php echo CHtml::label('Ukuran Kertas', 'print_ukuranKertas', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::dropDownList('ukuranKertas', Yii::app()->user->getState('ukuran_kertas'), CustomFunction::getUkuranKertas(), array('class'=>'span3')); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Posisi Kertas', 'print_posisiKertas', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::dropDownList('posisiKertas', Yii::app()->user->getState('posisi_kertas'), CustomFunction::getPosisiKertas(), array('class'=>'span3')); ?>
    </div>
</div>
<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'button', 'name'=>'btn_simpan','onclick'=>'simpan_kertas()')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                        array('class'=>'btn btn-danger', 'type'=>'button', 'name'=>'btn_batal','onclick'=>'$(\'#ubah_kertas\').dialog(\'close\')')); ?>                
         
</div>
<?php //$this->endWidget(); ?>    
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
