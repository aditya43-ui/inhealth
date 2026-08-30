<?php

class MessageOffline extends CWidget
{
    protected $messages;
    protected $count;
    public $htmlOptions;

    public function init() {
        $this->messages = Chat::model()->offline()->findAll();
        $this->count = Chat::model()->countByAttributes(array('chat_to'=>str_replace(' ', '', Yii::app()->user->name),
                                                              'chat_recd'=>'0'));
    }
    
    public function run() {
        echo CHtml::openTag('ul', $this->htmlOptions);
        $this->renderItems($this->messages);
        echo '</ul>';
    }
    
    /**
     * Renders the items in this menu.
     * @param array $items the menu items
     */
    public function renderItems($messages)
    {
        $this->render('messageOffline/list',array('messages'=>$messages,'count'=>$this->count));
    }
}
?>
