<?php
/**
* @version		$version 3.0.0
* @copyright	Copyright (C) 2012 HerdBoy Web Design. All rights reserved.
* @license		GPLv2
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin');

class plgSystemSuperuikit extends JPlugin
{
	function plgSuperuikit(&$subject, $config)
	{		
		parent::__construct($subject, $config);
		$this->_plugin = JPluginHelper::getPlugin( 'system', 'superuikit' );
		$this->_params = new JParameter( $this->_plugin->params );
	}

	function onAfterInitialise()
	{

		$app = JFactory::getApplication();

		if($app->isAdmin())
		{
			return;
		}

  		$doc = & JFactory :: getDocument();

        // load template
        $suikit_theme  = $this->params->get('suikit_theme', '');

        switch ($suikit_theme) {

	        case "flat":

    	    $doc->addStylesheet('plugins/system/superuikit/assets/css/uikit.almostflat.min.css');

   		        break;

	        case "gradient":

    	    $doc->addStylesheet('plugins/system/superuikit/assets/css/uikit.gradient.min.css');

   		        break;

	        default:

            $doc->addStylesheet(JURI :: base(true) . '/plugins/system/superuikit/assets/css/uikit.min.css');

       }

	}

	function onAfterRender()
	{

		$stickydiv = $this->params->get( 'stickydiv', '' );

		$app = JFactory::getApplication();

		if($app->isAdmin())
		{
			return;
		}

        if (!version_compare(JVERSION, '3', 'ge') && !JFactory::getApplication()->get('jquery', false)) {

        JFactory::getApplication()->set('jquery',true);
        $document = JFactory::getDocument();
        $document->addScript(JURI::root() . '/plugins/system/superuikit/assets/js/jquery.js');

        }

		$buffer = JResponse::getBody();

        $suikpath = (JURI :: root(true) . '/plugins/system/superuikit/assets/js/uikit.min.js');

		$javascript = '<script src="'.$suikpath.'" type="text/javascript"></script>';

        $buffer = preg_replace ("/<\/body>/", "".$javascript."\n\n</body>", $buffer);

		JResponse::setBody($buffer);

		return true;
	}
}
?>