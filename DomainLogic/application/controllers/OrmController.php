<?php
/**
 * ORM-based controller
 * 
 * @author Patrick Schwisow
 * @copyright 2012
 */
class OrmController extends Zend_Controller_Action
{
    /**
     * Index action
     * 
     * @return void
     */
    public function indexAction()
    {
        $service = new ServiceLayer();
        $service->setEntityManager($this->getInvokeArg('bootstrap')->getResource('entitymanager'));
        $request = $this->getRequest();
        $params = $request->getParams();
        $form = new Form_ProductForm(
            array('brandOptions' => $service->getBrandOptions())
        );
        
        if ($request->isPost() && $form->isValid($params)) {
            try {
                $service->insertProduct($form->getValues());
                $this->view->message = 'Record saved';
            } catch (DomainException $ex) {
                $this->view->message = 'Could not save: ' . $ex->getMessage();
            }
        }
        $this->view->form = $form;
    }
}
