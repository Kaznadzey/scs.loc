<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('report_homepage', new Route('/', array('_controller' => 'ReportBundle:Report:home')));
$collection->add('report_ajax_actions_loading', new Route('/load-actual-reports', array('_controller' => 'ReportBundle:Report:loadReports'), array(), array(), '', array(), array(), 'request.isXmlHttpRequest()'));

return $collection;
