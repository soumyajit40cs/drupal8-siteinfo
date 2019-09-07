<?php

namespace Drupal\siteinfo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;



class SiteinfoJsonController extends ControllerBase {

  
  public function pageinfo($param1, $param2) {
    
	
	$site_config = $this->config('system.site');
	if($param2!==$site_config->get('siteapikey')){
		$response['data'] = 'Access denied'; 
	}else{
		$node_storage = \Drupal::entityTypeManager()->getStorage('node');
		$node = $node_storage->load($param1);
		if(!empty($node)){
			if($node->getType()=='page'){
				$response['title'] = $node->get('title')->value;
			}else{
				$response['data'] = 'Invalid node'; 
			}
		}else{
			$response['data'] = 'No data found'; 
		}
	}
	
	
	
	
	
	
	
    return new JsonResponse($response);
	
	
  }

}
