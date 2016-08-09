<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Common\ArrayToolKit;

class DefaultController extends BaseController
{
    public function indexAction(Request $request)
    {
        $knowledges = $this->getKnowledgeService()->find();
        $users = $this->getUserService()->findByIds(ArrayToolKit::column($knowledges, 'userId'));
        $users = ArrayToolKit::index($users, 'id');
        $Favorites = $this->getFavoriteService()->findByKnowledgeIds(ArrayToolKit::column($knowledges, 'id'));
        $hasFavorites = $this->getFavoriteService()->hasFavoritedKnowledge($Favorites);
        $hasFavorites = ArrayToolKit::index($hasFavorites, 'userId');
        return $this->render('TopxiaWebBundle:Default:index.html.twig',array(
            'knowledges' => $knowledges,
            'users' => $users,
            'hasFavorites' => $hasFavorites
        ));
    }

    public function shareListAction(Request $request)
    {   
        $shareKnowledges = $this->getKnowledgeService()->getKnowledgesByUserId(1);

        return $this->render('TopxiaWebBundle:Default:my-knowledge.html.twig',array(
            'shareKnowledges' => $shareKnowledges
        ));
    }

    protected function getKnowledgeService()
    {
        return $this->getServiceKernel('knowledge_service');
    }

    protected function getUserService()
    {
        return $this->getServiceKernel('user_service');
    }

    protected function getFavoriteService()
    {
        return$this->getServiceKernel('favorite_service');
    }
}