<?php

class ActivationController extends Controller
{
	public $defaultAction = 'activation';

	
	/**
	 * Activation user account
	 */
	public function actionActivation () {
		$email = $_GET['email'];
		$activkey = $_GET['activkey'];
		if ($email&&$activkey) {
			$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
			if (isset($find)&&$find->status) {
			    $this->render('/user/message',array('title'=>AdminModule::t("User activation"),'content'=>AdminModule::t("You account is active.")));
			} elseif(isset($find->activkey) && ($find->activkey==$activkey)) {
				$find->activkey = AdminModule::encrypting(microtime());
				$find->status = 1;
				$find->save();
			    $this->render('/user/message',array('title'=>AdminModule::t("User activation"),'content'=>AdminModule::t("You account is activated.")));
			} else {
			    $this->render('/user/message',array('title'=>AdminModule::t("User activation"),'content'=>AdminModule::t("Incorrect activation URL.")));
			}
		} else {
			$this->render('/user/message',array('title'=>AdminModule::t("User activation"),'content'=>AdminModule::t("Incorrect activation URL.")));
		}
	}

}