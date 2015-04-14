<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	protected function _initDoctype() {
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('pages.phtml');
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');

		$view->headLink()->headLink(array('rel' => 'shortcut icon',
				'href'                                => 'css/images/favicon.ico'),
			'APPEND');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/style.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/flexslider.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/js/jquery-ui-1.11.4.custom/jquery-ui.css');

		$view->headScript()->appendFile($view->baseUrl().'/js/jquery-1.11.2.js');

		$view->headScript()->appendFile($view->baseUrl().'/js/selectproduct.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/checks.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/getorder.js');

		$view->headScript()->appendFile($view->baseUrl().'/js/jquery-1.8.0.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/jquery.flexslider-min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/functions.js');

		$view->headScript()->appendFile($view->baseUrl().'/js/jquery.session.js');

	}
}
