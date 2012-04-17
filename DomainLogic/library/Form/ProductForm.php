<?php
/**
 * Form used for adding / editing a product
 * 
 * @author Patrick Schwisow
 * @copyright 2012
 */
class Form_ProductForm extends Zend_Form
{
    /**
     * Array of options for brand element
     * 
     * @var array
     */
    protected $_brandOptions = array();
    
    /**
     * Set array of options for brand element
     * 
     * @param array $options
     * @return void
     */
    public function setBrandOptions(array $options)
    {
        $this->_brandOptions = $options;
    }
    
    /**
     * Initialize the form
     * 
     * @see Zend_Form::init()
     */
    public function init()
    {
        $this->addElements(
            array(
                $this->_getNameElement(),
                $this->_getSkuElement(),
                $this->_getPriceElement(),
                $this->_getBrandElement(),
                new Zend_Form_Element_Submit('submit')
            )
        );
    }
    
    /**
     * Create 'name' element
     * 
     * @return Zend_Form_Element_Text
     */
    protected function _getNameElement()
    {
        $element = new Zend_Form_Element_Text('name');
        $element->setLabel('Name:')
            ->setRequired(true);
        return $element;
    }
    
    /**
     * Create 'sku' element
     * 
     * @return Zend_Form_Element_Text
     */
    protected function _getSkuElement()
    {
        $element = new Zend_Form_Element_Text('sku');
        $element->setLabel('Sku:')
            ->setRequired(true);
        return $element;
    }
    
    /**
     * Create 'price' element
     * 
     * @return Zend_Form_Element_Text
     */
    protected function _getPriceElement()
    {
        $element = new Zend_Form_Element_Text('price');
        $element->setLabel('Price:')
            ->setRequired(true)
            ->addValidator('Float');
        return $element;
    }
    
    /**
     * Create 'brand' element
     * 
     * @return Zend_Form_Element_Select
     */
    protected function _getBrandElement()
    {
        $element = new Zend_Form_Element_Select('brand_id');
        $element->setLabel('Brand:')
            ->setRequired(true)
            ->addMultiOptions(array('' => '-Select-') + $this->_brandOptions);
        return $element;
    }
}