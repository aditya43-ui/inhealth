<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,user-scalable=no,minimal-ui,minimum-scale=1.0,maximum-scale=1.0">
 
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/antrian/style.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animation-loading.css" />
    
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/js.sound/jquery.jplayer.min.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/socket.io.js'); ?>
        
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script>
            function updateClock() {
                var currentTime = new Date();
                // Operating System Clock Hours for 12h clock
                var currentHoursAP = currentTime.getHours();
                // Operating System Clock Hours for 24h clock
                var currentHours = currentTime.getHours();
                // Operating System Clock Minutes
                var currentMinutes = currentTime.getMinutes();
                // Operating System Clock Seconds
                var currentSeconds = currentTime.getSeconds();
                // Adding 0 if Minutes & Seconds is More or Less than 10
                currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
                currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
                // Picking "AM" or "PM" 12h clock if time is more or less than 12
                var timeOfDay = (currentHours < 12) ? "AM" : "PM";
                // transform clock to 12h version if needed
                currentHoursAP = (currentHours > 12) ? currentHours - 12 : currentHours;
                // transform clock to 12h version after mid night
                currentHoursAP = (currentHoursAP == 0) ? 12 : currentHoursAP;
                // display first 24h clock and after line break 12h version
                var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;// + "" + "<br>" + "12h kello: "    + currentHoursAP + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
                // print clock js in div #clock.
                $("#clock").html(currentTimeString);
            }     
            
             function disabledTombol(){                 
                var jamsekarang =  $("#clock").html();
                var totalsekarang = (parseInt(jamsekarang.substring(0,2)) * 3600) + (parseInt(jamsekarang.substring(3,5)) * 60) + (parseInt(jamsekarang.substring(6,8)));
                $(".model-load").each(function(){            
                    if (typeof $(this).attr('buka') !== 'undefined'){                        
                        var buka = $(this).attr('buka');                        
                        var tutup = $(this).attr('tutup');
                        var nourut = $(this).attr('nourut');

                        if (buka != '' && tutup !=''){            
                            var totalbuka = (parseInt(buka.substring(0,2)) * 3600) + (parseInt(buka.substring(3,5)) * 60) + (parseInt(buka.substring(6,8)));
                            var totaltutup = (parseInt(tutup.substring(0,2)) * 3600) + (parseInt(tutup.substring(3,5)) * 60) + (parseInt(tutup.substring(6,8)));

                            var class_close = 'closeall'+nourut;
                            var noklik = 'noklik';
                            if (totalsekarang < totalbuka || totalsekarang >= totaltutup){                           
                                $(this).addClass(class_close);
                                $(this).addClass(noklik);                                
                            }else{
                                $(this).removeClass(class_close);
                                $(this).removeClass(noklik);                            
                            }

                        }   
                    }
                });
            }                        
        </script>
</head>
        
<body>
    <?php echo $content; ?>
</body>
</html>
