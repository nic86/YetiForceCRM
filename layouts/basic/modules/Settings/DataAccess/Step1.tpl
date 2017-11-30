{*<!--
/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
-->*}
{strip}
	{include file='Header.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
    <div class="editContainer">
        
		<div id="step">
			{include file='Step1Content.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
		</div>
		<input type="hidden" name="next_step" value="Step2" />
        <div class="clearfix"></div>
    </div>
{/strip}
