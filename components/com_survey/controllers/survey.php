<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class

jimport('joomla.application.component.controllerform');

class SurveyControllerSurvey extends JControllerForm {

    public function __construct() {
        parent::__construct();
    }

    public function getModel($name = 'Survey', $prefix = 'SurveyModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, array('ignore_request' => false));
    }

    function surveylist() {
        $user = JFactory::getUser();
        if($user->id==0){
			$app = JFactory::getApplication();
			$app->redirect('index.php/profile','Please login first.','error');
		}
		$app = JFactory::getApplication();
		$getExpertData = $this->getModel('Customer')->expertUserData($user->id);
		if($getExpertData>0){
			$sessionEXpertID = $getExpertData->id;
			$app->redirect('http://claimcharts.synpat.com/component/survey/?task=customer.expertOpportunites&display='.$sessionEXpertID);
		} else {
			$app->redirect('http://claimcharts.synpat.com/profile');
		}
		
        /*JRequest::setVar("view", "survey");
        $view = $this->getView("survey", "html");
        $view->setLayout("default");
        $view->setModel($this->getModel(), true);
        $view->listform();*/
    }

    function login() {
        JRequest::setVar("view", "survey");
        $view = $this->getView("survey", "html");
        $view->setLayout("login");
        $view->setModel($this->getModel(), true);
        $view->login();
    }

    function register() {
        JRequest::setVar("view", "survey");
        $view = $this->getView("survey", "html");
        $view->setLayout("register");
        $view->setModel($this->getModel(), true);
        $view->register();
    }
	
    function logincheck() {
        $app = JFactory::getApplication();
        $data = JRequest::get('post');
        $model = $this->getModel();
        $checkLogin = $model->userLogin($data['login_username'], $data['login_password']);
        if (count($checkLogin) > 0) {
            $session = JFactory::getSession();
            $session->set('expertSession', $checkLogin);
            $getExpertSession = $session->get('expertSession');

            if (!empty($getExpertSession)) {

                if (!empty($data['redirect'])) {
                    /*
                      $app->redirect(base64_decode($data['redirect']));
                     */
                    $app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $checkLogin->id);
                } else {
                    $app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $checkLogin->id);
                }
            } else {
                $app->redirect('index.php/profile', "Username or Password is wrong", "message");
            }
        } else {
            $app->redirect('index.php/profile', "Username or Password is wrong", "message");
        }
    }

    function logoff() {
        $session = JFactory::getSession();
        $getExpertSession = $session->clear('expertSession');
        $app = JFactory::getApplication();
        $app->redirect('index.php');
    }

    function registerExpert() {
        $data = JRequest::get('post');
        $app = JFactory::getApplication();
        /*
          $session = JFactory::getSession();
          $getSesVal = $session->get('6_letters_code_register'); */
        if (session_id() != '') {
            session_start();
        }
//		$getSesVal =$_SESSION['6_letters_code_register'];
//		if(strcasecmp($getSesVal, $data['captcha_code_register']) != 0){
//			unset($_SESSION['access_token']);
//			$app->redirect(JRoute::_('index.php'),'Please enter correct captcha.','message');
//		}
        if (!empty($data['username'])) {
            $checkEmailAddress = $this->getModel('expert')->checkExpertUsername($data['username']);
        } else {
            $app->redirect(JRoute::_('index.php'), 'Please enter correct captcha.', 'message');
        }
        if (count($checkEmailAddress) == 0) {
            $expert['password'] = md5($data['password']);
            $name = $data['first_name'] . " " . $data['last_name'];
            $expert['first_name'] = $data['first_name'];
            $expert['last_name'] = $data['last_name'];
            $expert['name'] = $name;
            $expert['username'] = $data['username'];
            $expert['email'] = $data['email_address'];
            $expert['linkedin_id'] = $data['linkedin_id'];
            $expert['linkedin_pic'] = $data['linkedin_pic'];
            $expert['linkedin_profile_url'] = $data['linkedin_profile_url'];
            $expert['id'] = 0;
            $getID = $this->getModel('expert')->save($expert);
            if ($getID > 0) {
                unset($_SESSION['access_token']);
                $app->redirect(JRoute::_('index.php?option=com_survey&task=survey.login'), 'Thank you for registering, Please login to access your account.', 'message');
            } else {
                unset($_SESSION['access_token']);
                $app->redirect(JRoute::_('index.php'), 'Getting some error. Please try after sometime.', 'message');
            }
        } else {
            unset($_SESSION['access_token']);
            $app->redirect(JRoute::_('index.php'), 'Email address already exist. Please try with another email address.', 'message');
        }
    }

    function checkCaptcha() {
        if (session_id() == '') {
            session_start();
        }
        $post = JRequest::get('post');
        if ($_SESSION['6_letters_code_register'] == $post['captcha_code']) {
            echo '0';
        } else {
            echo '1';
        }
    }
    
	function apply_coupon(){
		$data = JRequest::get('post');
		$getDataApply = $this->getModel('Survey')->findCoupon($data['cou']);
		if(count($getDataApply)>0){
			echo json_encode($getDataApply);
		} else {
			echo json_encode(array("error"=>1));
		}
		die;
	}
    
    
    

    function registerExpert1() {

        $data = JRequest::get('post');
        $app = JFactory::getApplication();
        /* JPluginHelper::importPlugin('captcha');

          $dispatcher = JDispatcher::getInstance();
          $res = $dispatcher->trigger('onCheckAnswer',$data['recaptcha_response_field']);
          if(!$res[0]){
          $app->enqueueMessage("Invalid Captcha","error");
          $this->register();
          }
         */
        /*
          $session = JFactory::getSession();
          $getSesVal = $session->get('6_letters_code_register');
         */
        if (session_id() != '') {
            session_start();
        }
        $getSesVal = $_SESSION['6_letters_code_register'];
        if (strcasecmp($getSesVal, $data['captcha_code_register1']) != 0) {
            $app->enqueueMessage("Invalid Captcha", "error");
            unset($_SESSION['access_token']);
            $app->redirect(JRoute::_('index.php'), 'Please enter correct captcha.', 'message');
        }
        if (!empty($data['username1'])) {
            $checkEmailAddress = $this->getModel('expert')->checkExpertUsername($data['username1']);
        } else {
            $app->redirect(JRoute::_('index.php'), 'Please enter correct captcha.', 'message');
        }


        if (count($checkEmailAddress) == 0) {
            $expert['password'] = md5($data['password1']);
            $name = $data['first_name'] . " " . $data['last_name1'];
            $expert['first_name'] = $data['first_name1'];
            $expert['last_name'] = $data['last_name1'];
            $expert['name'] = $name;
            $expert['username'] = $data['username1'];
            $expert['email'] = $data['email_address1'];
            $expert['linkedin_id'] = $data['linkedin_id1'];
            $expert['linkedin_pic'] = $data['linkedin_pic1'];
            $expert['linkedin_profile_url'] = $data['linkedin_profile_url1'];
            $expert['id'] = 0;
            $getID = $this->getModel('expert')->save($expert);
            if ($getID > 0) {
                unset($_SESSION['access_token']);
                $app->enqueueMessage('Thank you for registering, Please login to access your account.', 'message');
                $app->redirect(JRoute::_('index.php?option=com_survey&task=survey.login'), 'Thank you for registering, Please login to access your account.', 'message');
            } else {
                unset($_SESSION['access_token']);
                $app->enqueueMessage("Getting some error. Please try after sometime", "message");
                $app->redirect(JRoute::_('index.php'), 'Getting some error. Please try after sometime.', 'message');
            }
        } else {
            unset($_SESSION['access_token']);
            $app->enqueueMessage("Email address already exist. Please try with another email address", "message");
            $app->redirect(JRoute::_('index.php'), 'Email address already exist. Please try with another email address.', 'message');
        }
    }

    function getAuthenticateUser() {
        // Change these
        define('API_KEY', '03un4sib96jz');
        define('API_SECRET', 'JisA5yo9TH0CNC0J');
        /* define('REDIRECT_URI', 'http://oscuz.com/survey/index.php?option=com_survey&task=survey.register&tab=auth&l=register'); */
        define('REDIRECT_URI', 'http://claimcharts.info/index.php');
        define('SCOPE', 'r_fullprofile r_emailaddress rw_nus');
        session_name('linkedin');
        if(session_id() == '') {
			session_start();
		}
    }

    function getAccessToken() {

        $params = array('grant_type' => 'authorization_code',
            'client_id' => API_KEY,
            'client_secret' => API_SECRET,
            'code' => $_GET['code'],
            'redirect_uri' => REDIRECT_URI,
        );
        // Access Token request
        $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
        // Tell streams to make a POST request
        $context = stream_context_create(
                array('http' =>
                    array('method' => 'POST',
                    )
                )
        );
        // Retrieve access token information
        if (file_get_contents($url, false, $context)) {
            $response = file_get_contents($url, false, $context);
        } else {
            unset($_SESSION['access_token']);
            $app = JFactory::getApplication();
            $app->redirect('index.php#join');
        }
        // Native PHP object, please
        $token = json_decode($response);
        // Store access token and expiration time
        $_SESSION['access_token'] = $token->access_token; // guard this!
        $_SESSION['expires_in'] = $token->expires_in; // relative time (in seconds)
        $_SESSION['expires_at'] = time() + $_SESSION['expires_in']; // absolute time
        return true;
    }

    function getAuthorizationCode() {
        $params = array('response_type' => 'code',
            'client_id' => API_KEY,
            'scope' => SCOPE,
            'state' => uniqid('', true), // unique long string
            'redirect_uri' => REDIRECT_URI,
        );
        // Authentication request
        $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
        // Needed to identify request when it returns to us
        $_SESSION['state'] = $params['state'];
        return $url;
    }

    function fetch($method, $resource, $body = '') {
        $params = array('oauth2_access_token' => $_SESSION['access_token'],
            'format' => 'json',
        );
        // Need to use HTTPS
        $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);

        // Tell streams to make a (GET, POST, PUT, or DELETE) request
        $context = stream_context_create(
                array('http' =>
                    array('method' => $method,
                    )
                )
        );
        // Hocus Pocus
        $response = file_get_contents($url, false, $context);
        // Native PHP object, please
        return json_decode($response);
    }

    function searchExperts() {
        $result = false;
        $post = JRequest::get('post');
        if ($post['name'] != "") {
            $name = $post['name'];
            $model = $this->getModel('Expert');
            $getList = $model->searchExperts($name);
            $result = true;
        } else {
            $getList = null;
        }

        // Return JSON Response to ajax caller.
        $response = array('status' => $result, 'data' => $getList);
        echo json_encode($response);
        jexit(); // to only return json.
    }
    
    function searchExpertsWithReports() {
        $result = false;
        $post = JRequest::get('post');
        if ($post['name'] != "") {
            $name = $post['name'];
            $model = $this->getModel('Expert');
            $getList = $model->searchExpertsWithReports($name);
            $result = true;
        } else {
            $getList = null;
        }

        // Return JSON Response to ajax caller.
        $response = array('status' => $result, 'data' => $getList);
        echo json_encode($response);
        jexit(); // to only return json.
    }

}
