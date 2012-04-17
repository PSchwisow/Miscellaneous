<?php
/**
 * First iteration with MVC
 * 
 * @author Patrick Schwisow
 * @copyright 2012
 */
class BasicMvcController extends Zend_Controller_Action
{
    /**
     * Index action
     * 
     * @return void
     */
    public function indexAction()
    {
        $productModel = new Model_Product();
        $brandModel = new Model_Brand();
        $request = $this->getRequest();
        $params = $request->getParams();
        $form = new Form_ProductForm(
            array('brandOptions' => $brandModel->getBrandOptions())
        );
        
        if ($request->isPost() && $form->isValid($params)) {
            $productId = $productModel->insert($form->getValues());
            $this->view->message = 'Record saved';
        }
        $this->view->form = $form;
    }
}
