<?php

/**
 * 
 * @package YetiForce.Models
 * @license licenses/License.html
 * @author Mriusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_LoginHistory_Record_Model extends Settings_Vtiger_Record_Model
{

	/**
	 * Function to get the Id
	 * @return <Number> Profile Id
	 */
	public function getId()
	{
		return $this->get('login_id');
	}

	/**
	 * Function to get the Profile Name
	 * @return string
	 */
	public function getName()
	{
		return $this->get('user_name');
	}

	public function getAccessibleUsers()
	{
		$usersListArray = [];
		$dataReader = (new \App\Db\Query())->select('user_name')
				->from('vtiger_users')
				->createCommand()->query();
		while ($userName = $dataReader->readColumn(0)) {
			$usersListArray[$userName] = $userName;
		}
		return $usersListArray;
	}

	/**
	 * Function to retieve display value for a field
	 * @param string $fieldName - field name for which values need to get
	 * @return string
	 */
	public function getDisplayValue($fieldName, $recordId = false)
	{
		switch ($fieldName) {
			case 'login_time':
			case 'logout_time':
				$value = $this->get($fieldName);
				if ($value && $value !== '0000-00-00 00:00:00') {
					return Vtiger_Datetime_UIType::getDateTimeValue($value);
				} else {
					return '--';
				}
			case 'user_name':
				return $this->getForHtml($fieldName);
			case 'status':
				return App\Language::translate($this->get($fieldName), 'Settings::Vtiger');
			default:
				return $this->get($fieldName);
		}
	}
}
