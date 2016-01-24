<?php

// src/AppBundle/Controller/UserController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController {

  /**
   * @Route("/user/organization/{org_id}")
   */
  public function numberAction($org_id) {
    $number = rand(0, 100);

    return new Response(
      '<html><body>Lucky number: '.$number.'</body></html>'
    );
  }

}
