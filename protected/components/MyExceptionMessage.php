<?php
/**
 * Menampilkan exception message dengan dropdown
 */
class MyExceptionMessage
{
    public static function getMessage($exc,$return=false,$simple=false)
    {
        
        $code = $exc->getCode();
        $file = $exc->getFile();
        $line = $exc->getLine();
        $message = $exc->getMessage();
        $traceString = $exc->getTraceAsString();
        $trace = $exc->getTrace();
        
        $box = "
        <div style='display:none;' id='exceptionMessage'>
            $message<br/>
            On Line : <b>$line</b>, $file<br>
            <pre>$traceString</pre>
        </div>";

        $tombol = '&nbsp;&nbsp;'.CHtml::link(Yii::t('mds', 'Error Message'),'#', array('onclick'=>'toggleException();return false;','class'=>'', 'data-title'=>'', 'data-content'=>'Klik untuk menampilkan/menyembunyikan pesan', 'rel'=>'popover')); 
       Yii::app()->clientScript->registerScript('exception_message','function toggleException(){$(\'#exceptionMessage\').toggle();}', CClientScript::POS_HEAD);        
        
        
       $end_message = $simple ? "<br/>".$message : $tombol.$box;
       
        if($return)
            return $end_message;
        else
            echo $end_message;
    }
    
    /**
     * 
     * @param type $model
     * @param type $return
     * @return type
     */
    public static function getErrorMessage($model,$return=true)
    {
        $pesan = [];
        foreach ($model->getErrors() as $err) {
            $pesan[] = $err;
        }
        $pesan = json_encode($pesan);
        $pesan = strtr($pesan, ['"' => '<replacement> ', '[' => '<replacement>', ']' => '<replacement>']);
        
        return $pesan;
    }
}
?>
