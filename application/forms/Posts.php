<?php

class Application_Form_Posts extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        // Add an email element
        $this->addElement('textarea', 'body', array(
            'label'      => 'Tweet:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'rows' => '3',
            'maxlength' => 140,
            'class' => 'form-control',
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 140))
            )
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            "class" => "btn btn-default",
            'ignore'   => true,
            'label'    => 'Save',
        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}

