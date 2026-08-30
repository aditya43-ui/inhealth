<?php 
Yii::import('bootstrap.widgets.BootWidget');

class BootAccordion extends BootWidget {

    public $content = array();
    public $parent = true;
    public $accordion = true;
    public $slide = true;
         
    public function run(){
        if (isset($this->id)){
            $this->htmlOptions['id'] = $this->id;
        }
        else{
            $this->htmlOptions['id'] = 'accordion';
        }
        if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' accordion';
		else
			$this->htmlOptions['class'] = 'accordion';
                
        echo CHtml::openTag('div', $this->htmlOptions);
        $this->getContent();
        echo CHtml::closeTag('div', $this->htmlOptions);
        Yii::app()->bootstrap->enableTransitions();
        if ($this->accordion == true){
            Yii::app()->bootstrap->registerCollapse('.'.$this->id);
        }else{
            Yii::app()->bootstrap->registerCollapse('#'.$this->id);
        }
    }
    
    protected function getContent(){
//        $jumlah = count($this->content['']);
        $slide = '';
        foreach ($this->content as $i => $v){
            if ($v['active'] == 1){
				if (isset($v['multi'])){
					$active = ' in multi';
				}else{
					$active = ' in';
				}
            }
            else{
                if (isset($v['multi'])){
                        $active = ' multi';
                }else{
                        $active = ' ';
                }
            }
            if ($this->parent == true){
                $parent = 'data-parent="#'.$this->id.'"';
            }
            if ($this->slide == true){
                $slide = 'data-toggle="collapse" href="#'.$i.'"';
            }
            echo '<div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle btn-success"  '.$parent.' '.$slide.'>
                        '.$v['header'].' <i style=" font-size:16px" class="glyphicon glyphicon-chevron-down pull-right"></i>
                    </a>
                  </div>';
            
            echo '<div id="'.$i.'" class="accordion-body collapse'.$active.'">
                    <div class="accordion-inner">
                        '.$v['isi'].'
                    </div>
                  </div>
                </div>';
        }
        
        
    }

}