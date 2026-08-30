<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <style>
		<!-- 
		BODY,DIV,TABLE,TBODY,TFOOT,TR,TH,TD,P { font-family:"Arial"; font-size:10pt; }
		THEAD { font-family:"Arial"; font-size:11pt; }
		 -->
		 .line-words{
			text-decoration: line-through;
		}
	</style>
        
        <script type="text/javascript">
            function chkstate(){
            if(document.readyState=="complete"){
                window.close()
            }
            else{
                setTimeout("chkstate()",2000)
            }
            }

            function print_win(){
                window.print();
//                chkstate();
            }
        </script>
        <style>
    
    @media screen {
    #whiteBg {
        display: none;
    }
}

@media print {
   #footer {
     width:100%;  
     position: fixed;
     bottom: 0;
   }
     
   
   body {
     margin: 0px 0px 0px 0px;
}
}
</style>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body style="background-color: #ffffff;" onload="print_win()">

 <div id="wrapper"> <!-- not necessary -->
        
<div class="container" id="page">
	<?php echo $content; ?>    
</div>
<div id="footer" style = "width:100%;">
     <div style = "display:inline-block;float:left;text-align:left;" >
         <i><b>
            Created At : 
            <?php 
                echo MyFormatter::formatDateTimeId(date('Y-m-d H:i:s'));
            ?>
        </b></i>
     </div>
     <div style = "text-align:right;float:right;">
         <i><b>
            Created By : 
            <?php 
                echo $this->pageTitle=Yii::app()->user->nama_pemakai;
            ?>
        </b></i>
     </div>
 </div>

</body>
</html>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/raphael-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/morris.min.js"></script>
