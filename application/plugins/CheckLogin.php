<?php

class Application_Plugin_CheckLogin extends  Zend_Controller_Plugin_Abstract
{
	public function postDispatch(Zend_Controller_Request_Abstract $request) {
		parent::postDispatch($request);	
	}

	public function routeShutdown(Zend_Controller_Request_Abstract $request) {

		$controllerName = strtolower($request->getControllerName());
		$actionName = strtolower($request->getActionName());
		$auth = Zend_Auth::getInstance();
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/controllers/helpers');

        if($controllerName == 'index' && !$auth->hasIdentity()) {
            return;
        }

		if($controllerName == 'auth') {
			return;
		}

        if($controllerName == 'user' && $actionName == 'signup') {
            return;
        }

		if(!$auth->hasIdentity()){ 
			$redirect = Zend_Controller_Action_HelperBroker::getStaticHelper ( 'redirector' );
			$redirect->gotoSimple("index", "index", "default");
			return;
		}
	} 	  
}