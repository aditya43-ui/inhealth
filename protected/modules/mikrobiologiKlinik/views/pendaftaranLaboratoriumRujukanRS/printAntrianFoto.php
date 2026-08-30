
<html>
    <head>
        <style>

            .barcode-label{
                margin-top:-20px;
                z-index: 1;
                text-align: center;
                letter-spacing: 10px;
            }
            body{
                width: 100%;
            }
            th, td, div{
                font-family:Times New Roman;
                font-size: 9pt;
                line-height: 12px;
            }
            @page {
                padding:0;
                margin: 0.25cm 0.25cm 0cm 0.5cm;
                width: 11 cm;
                height: 14 cm;

            }

            @media print {
                tr.page-break  { height:100%; page-break-after: always; }
             
                .header-space{

                    height: 2.5cm;
                }

                html, body {

                    width: 11 cm;
                    height: 14 cm;
                    /*            padding: 0.25cm 0.25cm 0.25cm 0.25cm;*/
                    padding-top:0.25cm;
                    padding-bottom:0.25cm;

                    BODY,DIV,TABLE,TBODY,TFOOT,TR,TH,TD{
                        font-family:Times New Roman;
                        font-size: 8.0pt;
                        line-height: 12px;
                    }

                }


            }
        </style>
    </head>
    <body>
   
        <?php
        $format = new MyFormatter;
        ?>
        <table width="100%" style="margin-top:-0.5cm" >
            
            <thead>
                <tr>
                    <td colspan="3">
                        <div class="header-space">
                            
                            <?php 
                                
                            echo $this->renderPartial('application.views.headerReport.headerJobList'); 
                                
                            ?>
                        </div>  
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr class=''>
                    <td>
                        <div class="content"><?php
                        
                            $this->renderPartial('_tableAntrianFoto', array(
                                'modKunjungan' => $modKunjungan,
                                'modSpesimen'=>$modSpesimen,
                                'judul_print'=>$judul_print,
                                'format'=>$format,
                                ));
                            
                            
                        ?>
                            
                        </div>

                    </td></tr>

            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <div class="footer-space">&nbsp;</div>
                    </td>
                </tr>
            </tfoot>
        </table>
   
    </body>
</html>