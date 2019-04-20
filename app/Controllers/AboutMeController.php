<?php
namespace App\Controllers;

class AboutMeController  extends BaseController {
    public function getAboutMe() {
        return $this->renderHTML('AboutMe.twig');
    }
}
