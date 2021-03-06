<?php
/**
 * @version     1.0.0
 * @package     com_fitness
 * @copyright   LIVE FIT LIVE LEAN PTY LTY © 2014. All rights reserved
 * @license     GNU General Public License
 * @author      Nikolay Korban <npkorban@mail.ru> - http://
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_fitness')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$document = JFactory::getDocument();
$document -> addStyleSheet(JURI::base() . 'components' . DS. 'com_fitness' . DS .'assets' . DS . 'bootstrap' . DS . 'css' . DS . 'bootstrap.min.css');




$controller	= JControllerLegacy::getInstance('Fitness');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

