<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');
        $this->addElements( array(
            new Zend_Form_Element_Text('username', array(
                'required' => true,
                'filters' => array(
                    'StringTrim'
                )
            )),
            new Zend_Form_Element_Password('password', array(
                'required' => true,
                'filters' => array(
                    'StringTrim'
                )
            )),
            new Zend_Form_Element_Checkbox('remember_me'),
            new Zend_Form_Element_Submit('Sigin', array(
                'ignore' => true,
                'label' => 'Login',
            ))
        ));
    }


}

