<?php

namespace Drupal\site_information\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Component\Serialization\Json;
/**
 * Class save_site_api_key.
 */
class save_site_api_key extends ControllerBase {

  /*
  * {@inheritdoc}
  */
  protected function getEditableConfigNames() {
    return ['siteApiKey.settings'];
  }



  /**
   * Page Json.
   *
   * @return string
   *   Return Page Json string.
   */
  public function page_json($key,$nid) {
    
    if($node = node_load($nid)) {
      $siteApiKeyValue = \Drupal::state()->get('siteApiKey');
      
      if($key == $siteApiKeyValue && $node->getType() == 'page') {
        
        $response = new JsonResponse();
        $data = array(
          'date' => time(),
          'random_node' => array(
            'title' => $node->get('title')->getValue()[0]['value'],
            'body' => $node->get('body')->getValue()[0]['value'],
          )
        );

        $response->setData($data);
        
        return $response;
      }else {
        $msg = 'Access denied!';
      }

    }else{
      $msg = 'Invalid node id';
    }

    return [
      '#type' => 'markup',
      '#markup' => $msg
    ];
  }

}
