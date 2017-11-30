<?php
/* +***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 * *********************************************************************************************************************************** */

class Settings_Password_Save_Action extends Settings_Vtiger_Index_Action
{

	public function process(Vtiger_Request $request)
	{
		$moduleName = $request->getModule(false);
		$type = $request->get('type');
		$vale = $request->get('vale');
		if (Settings_Password_Record_Model::validation($type, $vale)) {
			Settings_Password_Record_Model::setPassDetail($type, $vale);
			$resp = vtranslate('LBL_SAVE_OK', $moduleName);
		} else {
			$resp = vtranslate('LBL_ERROR', $moduleName);
		}
		$response = new Vtiger_Response();
		$response->setResult($resp);
		$response->emit();
	}
}
