<?php
/**
 * digunakan untuk cetak windows
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 * 
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <style>

            BODY,DIV,TABLE,TBODY,TFOOT,TR,TH,TD,P { font-family:"Arial"; font-size:10pt !important; }
            THEAD { font-family:"Arial"; font-size:16pt !important; }
            -->
            .line-words{
                text-decoration: line-through;
            }
        </style>

        <script type="text/javascript">
            function chkstate() {
                if (document.readyState == "complete") {
                    window.close()
                } else {
                    setTimeout("chkstate()", 2000)
                }
            }

            function print_win() {
                window.print();
//                chkstate();
            }
        </script>


        <style>

            @page {
                /*   size: 7in 9.25in;*/
                padding-top: 30px;
                margin-top: 0mm;
                margin-bottom: 0mm;
                width: <?php echo Params::width_A4 ?>mm;
                height:<?php echo Params::height_A4 ?>mm;


            }
            @media print {

                html, body {
                    padding-top: 30px;
                    width: <?php echo Params::width_A4 ?>mm;
                    height: <?php echo Params::height_A4 ?>mm;

                    BODY,DIV,TABLE,TBODY,TFOOT,TR,TH,TD,P { font-family:"Arial"; font-size:10pt !important; }
                    THEAD { font-family:"Arial"; font-size:12pt !important; }
                    -->
                    .line-words{
                        text-decoration: line-through;
                    }
                }


                .footer, .footer-space {
                    height: 40mm;
                }
                .header-space{

                    height: 40mm;
                }
                .header {

                    width: 100%;
                    top: 0;

                }
                .header .header-space{

                    height: 40mm;
                }
                .footer {
                    width: 100%;
                    position: fixed;
                    bottom: 0;
                }
                #pageFooter:after {
                    counter-increment: page;
                    content: counter(page);
                }



            }



        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body style="background-color: #ffffff;" onload="print_win()">

        <div id="wrapper"> <!-- not necessary -->

            <?php
            echo $content;
            ?> 


        </div>
    </body>
</html>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/raphael-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/morris.min.js"></script>
