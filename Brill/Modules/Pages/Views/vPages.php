<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of as_subscribe
 *
 * @author almaz
 */

class vPages extends View {
     protected $defaultParent = 'pages_parent_html.php';
     protected $useParent = true;
     protected $aHeaders = array();
     protected $context;

         // выводит хидеры
    function inputHeaders ($status = '200') {

    }

    public function  __construct(RegistryContext $context) {
        $this->context = &$context;
        if (!$context->get('useParentTpl')) {
            $this->useParent = false;
            $this->defaultParent = $context->get('tpl');
        }
    }

    function  input() {
    //    parent::input();
        $t = $this->context;
        include(Pages::$pathViews . $this->defaultParent);
    }
}
