<?php
/**
 * application version of CWebUser class file
 *
 * @author ankit
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CWebUser represents the persistent state for a Web application user.
 *
 * CWebUser is used as an application component whose ID is 'user'.
 * Therefore, at any place one can access the user state via
 * <code>Yii::app()->user</code>.
 *
 * CWebUser should be used together with an {@link IUserIdentity identity}
 * which implements the actual authentication algorithm.
 **/
 class AppWebUser extends CWebUser
{
	private $_appAccess=array();//substitute of 	private $_access=array(); in this class
		
	/**
	 * Performs access check for this user.
	 * @param string $operation the name of the operation that need access check.
	 * @param array $params name-value pairs that would be passed to business rules associated
	 * with the tasks and roles assigned to the user.
	 * Since version 1.1.11 a param with name 'userId' is added to this array, which holds the value of
	 * {@link getId()} when {@link CDbAuthManager} or {@link CPhpAuthManager} is used.
	 * @param boolean $allowCaching whether to allow caching the result of access check.
	 * When this parameter
	 * is true (default), if the access check of an operation was performed before,
	 * its result will be directly returned when calling this method to check the same operation.
	 * If this parameter is false, this method will always call {@link CAuthManager::checkAccess}
	 * to obtain the up-to-date access result. Note that this caching is effective
	 * only within the same request and only works when <code>$params=array()</code>.
	 * @return boolean whether the operations can be performed by this user.
	 */
	public function checkAccess($operation,$params=array(),$allowCaching=true)
	{
		
		if($allowCaching && $params===array() && isset($this->_appAccess[$operation]))
			return $this->_appAccess[$operation];

		$role = AppCommon::getUserRole();
		if( $role === false)
			$access = false;
		elseif( $role === $operation)
			$access = true;
		else
			$access = false;
		if($allowCaching && $params===array())
			$this->_appAccess[$operation]=$access;

		return $access;
	}
}
