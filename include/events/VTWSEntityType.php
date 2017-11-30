<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

require_once 'include/Webservices/Utils.php';
require_once("modules/Users/Users.php");
require_once("include/Webservices/VtigerCRMObject.php");
require_once("include/Webservices/VtigerCRMObjectMeta.php");
require_once("include/Webservices/DataTransform.php");
require_once("include/Webservices/WebServiceError.php");
require_once 'include/utils/utils.php';
require_once 'include/Webservices/ModuleTypes.php';
require_once('include/Webservices/DescribeObject.php');
require_once 'include/Webservices/WebserviceField.php';
require_once 'include/Webservices/EntityMeta.php';
require_once 'include/Webservices/VtigerWebserviceObject.php';

/*
 * An implementation of VTEntityType that uses the webservices api to reflect on vtiger's types.
 */

class VTWSEntityType
{

	function __construct($entityTypeName, $user)
	{
		$describeResult = vtws_describe($entityTypeName, $user);
		//print_r($describeResult);
		$this->entityTypeName = $entityTypeName;
		$this->description = $describeResult;
	}

	function usingGlobalCurrentUser($entityTypeName)
	{
		$current_user = vglobal('current_user');
		return new VTWSEntityType($entityTypeName, $current_user);
	}

	function forUser($entityTypeName, $user)
	{
		return new VTWSEntityType($entityTypeName, $user);
	}

	function getTabId()
	{
		$adb = PearDatabase::getInstance();
		if (!isset($this->tabId)) {
			$result = $adb->pquery("select tabid from vtiger_tab where name=?", array($this->entityTypeName));
			$this->tabId = $adb->query_result($result, 0, "tabid");
		}
		return $this->tabId;
	}

	function getModuleName()
	{
		return $this->moduleName;
	}

	function getFieldNames()
	{
		if (!isset($this->fieldNames)) {
			$fields = $this->description['fields'];
			$arr = [];
			foreach ($fields as $field) {
				$arr[] = $field["name"];
			}
			$this->fieldNames = $arr;
		}
		return $this->fieldNames;
	}

	function getFieldLabel($fieldName)
	{
		if (!isset($this->fieldLabels)) {
			$this->getFieldLabels();
		}
		return $this->fieldLabels[$fieldName];
	}

	function getFieldLabels()
	{
		if (!isset($this->fieldLabels)) {
			$fields = $this->description['fields'];
			foreach ($fields as $field) {
				$this->fieldLabels[$field['name']] = $field['label'];
			}
		}
		return $this->fieldLabels;
	}

	function getFieldType($fieldName)
	{
		if (!isset($this->fieldTypes[$fieldName])) {
			$fields = $this->description['fields'];
			foreach ($fields as $field) {
				if ($field['name'] == $fieldName) {
					$type = $field['type'];
					$et = new VTWSFieldType();
					switch ($type['name']) {
						case 'reference':
							$et->type = 'Related';
							$et->relatedTo = $type['refersTo'];
							break;
						case 'integer':
							$et->type = 'Number';
							$et->format = 'Integer';
							break;
						case 'url':
							$et->type = 'Url';
							break;
						case 'string':
							$et->type = 'String';
							break;
						case 'picklist':
							$et->type = 'Select';
							$et->values = $type['picklistValues'];
							break;
						case 'datetime':
							$et->type = 'DateTime';
							break;
						case 'email':
							$et->type = 'Email';
							break;
						case 'boolean':
							$et->type = 'Boolean';
							break;
						case 'phone':
							$et->type = 'Phone';
							break;
						case 'text':
							$et->type = 'String';
							break;
						case 'a'://Autogenerated type is getting messed up for Accounts
							$et->type = 'Id';
							break;
						case 'date':
							$et->type = 'Date';
							break;
						case 'time':
							$et->type = 'Time';
							break;
						case 'double':
							$et->type = 'Number';
							$et->format = 'Decimal';
							break;
						case 'autogenerated':
							$et->type = 'Id';
							break;
						case 'owner':
							$et->type = 'Owner';
							break;
						case 'multipicklist':
							$et->type = 'Select';
							$et->values = [];
							break;
						case 'skype':
							$et->type = 'Skype';
							break;
						case 'password':
							$et->type = 'Password';
							break;
						case 'decimal':
							$et->type = 'Number';
							$et->format = 'Decimal';
							break;
						case 'currency':
							$et->type = 'Number';
							$et->format = 'Decimal';
							break;
						default:
							throw new Exception($type["name"] . " is not supported yet.");
					}
					$this->fieldTypes[$fieldName] = $et;
					break;
				}
			}
		}
		return $this->fieldTypes[$fieldName];
	}

	function getFieldTypes()
	{
		$adb = $this->adb;
		$fieldNames = $this->getFieldNames();
		$fieldTypes = [];
		foreach ($fieldNames as $fieldName) {
			$fieldTypes[$fieldName] = $this->getFieldType($fieldName);
		}
		return $fieldTypes;
	}
}

class VTWSFieldType
{

	function toArray()
	{
		$ro = new ReflectionObject($this);
		$props = $ro->getProperties();
		$arr = [];
		foreach ($props as $prop) {
			$arr[$prop->getName()] = $prop->getValue($this);
		}
		return $arr;
	}
}
