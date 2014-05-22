<?php

namespace JhHub\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package JhHub\Controller
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class IndexController extends AbstractActionController
{

    /**
     * @return array|ViewModel
     */
    public function dashboardAction()
    {
        $config = $this->getServiceLocator()->get('Config');

        //if we have come from the login URL - Redirect to URL
        if ($this->getRequest()->getHeader('Referer')->uri()->getPath() === '/user/login' &&
            isset($config['hub']['default_route'])
        ) {
            return $this->redirect()->toRoute($config['hub']['default_route']);
        }

        return new ViewModel();
    }
}