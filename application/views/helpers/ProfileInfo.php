<?php

require_once 'Zend/View/Interface.php';

class Zend_View_Helper_ProfileInfo
{
	public $view;
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function profileInfo()
	{
		$auth = Zend_Auth::getInstance();
	
		if(!$auth->hasIdentity() ){		
			return "";			
		}

        $postMapper = new Application_Model_PostsMapper();
        $sweets = $postMapper->findByUserId($auth->getIdentity()->id, 0);
        $sweets = empty($sweets) ? 0 : count($sweets);

        $followingMapper = new Application_Model_FollowingMapper();
        $followings = $followingMapper->findByWhoFolowingMe($auth->getIdentity()->id);
        $followings = empty($followings) ? 0 : count($followings);

        $str = <<<PROFILE
        <h4><a class="u-textInheritColor" href="#">{$auth->getIdentity()->fullname}</a></h4>
        <a href="#" class="DashboardProfileCard-screennameLink u-linkComplex u-linkClean">@<span class="u-linkComplex-target">{$auth->getIdentity()->fullname}</span></a>
        <div class="row">
            <div class="col-md-4"><span>Tweets</span>
                <h4>{$sweets}</h4>
            </div>
            <div class="col-md-4"><span>Following</span>
                <h4>{$followings}</h4>
            </div>
        </div>
PROFILE;

		return $str;
	}
}