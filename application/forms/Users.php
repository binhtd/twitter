<?php

class Application_Form_Users extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        $this->addElements( array(
            new Zend_Form_Element_Text('name', array(
                'required' => true,
                'filters' => array(
                    'StringTrim'
                )
            )),
            new Zend_Form_Element_Text('email', array(
                'required' => true,
                'filters' => array(
                    'StringTrim'
                ),
                'validators' => array(
                    'EmailAddress'
                )
            )),
            new Zend_Form_Element_Password('password', array(
                'required' => true,
                'filters' => array(
                    'StringTrim'
                )
            )),
            new Zend_Form_Element_Text('phonenumber', array(
                'required' => true,
                'filters' => array(
                    'StringTrim'
                ),
                'validators' => array(
                    'Digits'
                )
            )),

            new Zend_Form_Element_Submit('Sigin', array(
                'ignore' => true,
                'label' => 'Login',
            ))
        ));
    }


}

