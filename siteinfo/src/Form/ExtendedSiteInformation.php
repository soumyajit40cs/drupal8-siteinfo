<?php

namespace Drupal\siteinfo\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;


class ExtendedSiteInformation extends SiteInformationForm {
 
	  public function buildForm(array $form, FormStateInterface $form_state) {
		$site_config = $this->config('system.site');
		$form =  parent::buildForm($form, $form_state);
		$form['site_information']['siteapikey'] = [
			'#type' => 'textfield',
			'#title' => t('Site API Key'),
			'#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
		];
		
		if($site_config->get('siteapikey')==''){
			$form['actions']['submit']['#value'] = t('Save configuration');
		}else{
			$form['actions']['submit']['#value'] = t('Update Configuration');
		}
		
		return $form;
	}
	
	  public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->config('system.site')
		  ->set('siteapikey', $form_state->getValue('siteapikey'))
		  ->save();
		parent::submitForm($form, $form_state);
		if($form_state->getValue('siteapikey')!='No API Key yet'){
			\Drupal::messenger()->addMessage(t('Site API Key has been saved with that value:'.$form_state->getValue('siteapikey')), 'status');
		}
	  }
}
