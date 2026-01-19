<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Registration controller class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class UsersControllerUser extends UsersController
{
	/**
	 * Method to log in a user.
	 *
	 * @since	1.6
	 */
	public function login(){
		$app = JFactory::getApplication();
		JSession::checkToken('post') or $app->redirect(JRoute::_('index.php?option=com_users&view=login', true));

		// Populate the data array:
		$data = array();
		$data['return'] = base64_decode(JRequest::getVar('return', '', 'POST', 'BASE64'));
		$data['username'] = JRequest::getVar('username', '', 'method', 'username');
		$data['password'] = JRequest::getString('password', '', 'post', JREQUEST_ALLOWRAW);
		
		// Set the return URL if empty.
		if (empty($data['return'])) {
			$data['return'] = 'index.php?option=com_users&view=profile';
		}

		// Set the return URL in the user state to allow modification by plugins
		$app->setUserState('users.login.form.return', $data['return']);

		// Get the log in options.
		$options = array();
		$options['remember'] = JRequest::getBool('remember', false);
		$options['return'] = $data['return'];
		$options['silent'] = true;

		// Get the log in credentials.
		$credentials = array();
		$credentials['username'] = $data['username'];
		$credentials['password'] = $data['password'];
		
		// Perform the log in.
		$checkLogin = $app->login($credentials, $options);
		if (true === $checkLogin) {
			// Success			
			$app->setUserState('users.login.form.data', array());
			//$app->redirect(JRoute::_($app->getUserState('users.login.form.return'), false));
			$user = JFactory::getUser();
			$authGroup = 0;
			foreach($user->groups as $value){
				if((int)$value==8){
					$authGroup = 8;
				}
			}
			if($authGroup==8){
				$app->redirect(JRoute::_('index.php'));
			} else {
				$returnData = $app->getUserState('users.login.form.return');
				if(stripos($returnData,'start_report')!==false){
					$app->redirect(JRoute::_($app->getUserState('users.login.form.return'), false));
				} else {
					$userExpert = $this->getModel('profile')->expertData($user->id);
					if(count($userExpert)>0){
						if((int)$user->profile_type==1){
							$app->redirect('index.php?option=com_survey&task=customer.referral&display='.$userExpert->id);
						} else {
							$config = JFactory::getConfig();
							$encryptPassword = $config->getValue( 'synpat_symbol' );
							$display = openssl_encrypt($userExpert->id,"AES-128-ECB",$encryptPassword);
							$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display);
							/*$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$userExpert->id);*/
						}						
					} else {
						$app->redirect(JRoute::_($app->getUserState('users.login.form.return'), false));
					}
				}				
			}
		} else {
			// Login failed !
			$data['remember'] = (int)$options['remember'];
			$app->setUserState('users.login.form.data', $data);
			$app->enqueueMessage("Please enter correct username and password", 'error');
			$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
		}
	}

	/**
	 * Method to log out a user.
	 *
	 * @since	1.6
	 */
	public function logout()
	{
		JSession::checkToken('request') or jexit(JText::_('JInvalid_Token'));

		$app = JFactory::getApplication();

		// Perform the log in.
		$error = $app->logout();

		// Check if the log out succeeded.
		if (!($error instanceof Exception)) {
			// Get the return url from the request and validate that it is internal.
			$return = JRequest::getVar('return', '', 'method', 'base64');
			$return = base64_decode($return);
			if (!JURI::isInternal($return)) {
				$return = '';
			}

			// Redirect the user.
			//$app->redirect(JRoute::_($return, false));
			$app->redirect('index.php');
		} else {
			//$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
			$app->redirect('index.php');
		}
	}

	/**
	 * Method to register a user.
	 *
	 * @since	1.6
	 */
	public function register()
	{
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));

		// Get the form data.
		$data	= JRequest::getVar('user', array(), 'post', 'array');

		// Get the model and validate the data.
		$model	= $this->getModel('Registration', 'UsersModel');
		$return	= $model->validate($data);

		// Check for errors.
		if ($return === false) {
			// Get the validation messages.
			$app	= &JFactory::getApplication();
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'notice');
				} else {
					$app->enqueueMessage($errors[$i], 'notice');
				}
			}

			// Save the data in the session.
			$app->setUserState('users.registration.form.data', $data);

			// Redirect back to the registration form.
			$this->setRedirect('index.php?option=com_users&view=registration');
			return false;
		}

		// Finish the registration.
		$return	= $model->register($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('users.registration.form.data', $data);

			// Redirect back to the registration form.
			$message = JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_users&view=registration', $message, 'error');
			return false;
		}

		// Flush the data from the session.
		$app->setUserState('users.registration.form.data', null);

		exit;
	}

	/**
	 * Method to login a user.
	 *
	 * @since	1.6
	 */
	public function remind()
	{
		// Check the request token.
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));

		$app	= JFactory::getApplication();
		$model	= $this->getModel('User', 'UsersModel');
		$data	= JRequest::getVar('jform', array(), 'post', 'array');

		// Submit the username remind request.
		$return	= $model->processRemindRequest($data);

		// Check for a hard error.
		if ($return instanceof Exception) {
			// Get the error message to display.
			if ($app->getCfg('error_reporting')) {
				$message = $return->getMessage();
			} else {
				$message = JText::_('COM_USERS_REMIND_REQUEST_ERROR');
			}

			// Get the route to the next page.
			$itemid = UsersHelperRoute::getRemindRoute();
			$itemid = $itemid !== null ? '&Itemid='.$itemid : '';
			$route	= 'index.php?option=com_users&view=remind'.$itemid;

			// Go back to the complete form.
			$this->setRedirect(JRoute::_($route, false), $message, 'error');
			return false;
		} elseif ($return === false) {
			// Complete failed.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getRemindRoute();
			$itemid = $itemid !== null ? '&Itemid='.$itemid : '';
			$route	= 'index.php?option=com_users&view=remind'.$itemid;

			// Go back to the complete form.
			$message = JText::sprintf('COM_USERS_REMIND_REQUEST_FAILED', $model->getError());
			$this->setRedirect(JRoute::_($route, false), $message, 'notice');
			return false;
		} else {
			// Complete succeeded.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getLoginRoute();
			$itemid = $itemid !== null ? '&Itemid='.$itemid : '';
			$route	= 'index.php?option=com_users&view=login'.$itemid;

			// Proceed to the login form.
			$message = JText::_('COM_USERS_REMIND_REQUEST_SUCCESS');
			$this->setRedirect(JRoute::_($route, false), $message);
			return true;
		}
	}

	/**
	 * Method to login a user.
	 *
	 * @since	1.6
	 */
	public function resend()
	{
		// Check for request forgeries
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));
	}
}
