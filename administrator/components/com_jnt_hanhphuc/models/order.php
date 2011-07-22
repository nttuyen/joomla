<?php
/**
 * @version		$Id: banner.php 20228 2011-01-10 00:52:54Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Banner model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_cl_diamond
 * @since		1.6
 */
class Jnt_HanhPhucModelOrder extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_JNT_HANHPHUC_ORDER';

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	boolean	True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canDelete($record)
	{
		$user = JFactory::getUser();

		if (!empty($record->catid)) {
			return $user->authorise('core.delete', 'com_cl_diamond.category.'.(int) $record->catid);
		}
		else {
			return parent::canDelete($record);
		}
	}

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	boolean	True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		// Check against the category.
		if (!empty($record->catid)) {
			return $user->authorise('core.edit.state', 'com_cl_diamond.category.'.(int) $record->catid);
		}
		// Default to component settings if category not known.
		else {
			return parent::canEditState($record);
		}
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Order', $prefix = 'Jnt_HanhPhucTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_cl_diamond.order', 'order', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
        
        $currentState = $form->getValue('state');
        if($currentState == 1) {
            $form->setFieldAttribute('state', 'readonly', "true");
        }

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_cl_diamond.edit.order.data', array());

		if (empty($data)) {
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('order.id') == 0) {
				$app = JFactory::getApplication();
				$data->set('catid', JRequest::getInt('catid', $app->getUserState('com_cl_diamond.order.filter.category_id')));
			}
		}
		
		//echo '<pre>'; print_r($data); echo '</pre>';
		
		if(is_array($data))
			$data['total_price'] = number_format($data['total_price'], 2);
		else
			$data->total_price = number_format($data->total_price, 2);

		return $data;
	}

    public function save($data) {
        //Load old state
        $db = JFactory::getDbo();
        $db->setQuery(
                'SELECT * FROM #__cl_diamond_orders WHERE id = '.(int)$data['id']
        );
        $oldData = $db->loadObject();
        $oldState = $oldData->state;
        
        $state = $data['state'];
        if($state == $oldState || $oldState == 1) {
            //Neu state khong doi hoac oldstate == 1 thi khoi can save
            return true;
        }
        
        //Save
        if(!parent::save($data)) {
            return false;
        }
        
        $emailToUserSubject = '';
        $emailToAdminSubject = '';
        
        //Gui mail
        if($oldState != 1 && $state == 1) {
            //Order finished
            //Send 2 email: 1 to customer (user_id), 1 to admin (config)
            		
            $emailToUserSubject = 'Order has been invoiced';
            $emailToAdminSubject = 'Notice: Order Invoiced';
            
        } else if($oldState == 0 && $state == 2) {
            //Send 2 email notice order was canceled
            $emailToUserSubject = 'Order Watches was cancelled';
            $emailToAdminSubject = 'Notice: Order was cancelled';
        } else if($oldState == 2 && $state == 0) {
            //Send email notice user that order was cancelled would be confirmed
            $emailToUserSubject = 'Order Watches would be confirmed';
            $emailToAdminSubject = 'Notice: Order would be confirmed';
        }
        
        $user = JFactory::getUser($data['user_id']);
            
        //To user
        $mail = JFactory::getMailer();
        
        $mail->isHTML(true);

        $mail->setSubject($emailToUserSubject);

        $userTemplate = $this->emailTemplate($user, $oldData);

        $mail->addRecipient($user->email);
        $mail->setBody( $userTemplate );

        $mail->Send();

        //To admin
        $mail = JFactory::getMailer();
        
        $mail->isHTML(true);

        $mail->setSubject($emailToAdminSubject);

        $config =& JFactory::getConfig();
        $mail->addRecipient( $config->getValue( 'config.mailfrom' ) );

        $adminTemplate = $this->emailTemplate($user, $oldData, true);		
        $mail->setBody( $adminTemplate );

        $mail->Send();
        
        return true;
        
    }
    
    public function getOrderItems() {
        $id = JRequest::getInt('id', 0);
        $db = JFactory::getDbo();
        $query = 'SELECT i.* FROM #__hp_order_items i
                  WHERE i.order_id = '.$id;
        $db->setQuery($query);
        return $db->loadObjectList();
    }
    
	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param	object	A record object.
	 * @return	array	An array of conditions to add to add to ordering queries.
	 * @since	1.6
	 */
	protected function getReorderConditions($table)
	{
		$condition = array();
		$condition[] = 'catid = '. (int) $table->catid;
		$condition[] = 'state >= 0';
		return $condition;
	}
    
    function emailTemplate($user, $order, $isAdmin = false) {
		$template = '';
		if(!$isAdmin) {
			$template .= 'Hello <strong>'.$user->name.'</strong>';
			$template .= '<br> <br>';
			$template .= 'This is confirm email that you order watches from website with these infos:';
		} else  {
			$template .= 'Hello <strong>Administrator</strong>';
			$template .= '<br> <br>';
			$template .= 'This is notice email that one of users on website order watches from website with these infos:';
		}

		$template .= '<br> <br>';
		$template .= '<strong>Order</strong> <br>';
		$template .= 'Order ID: 		'.$order->id.' <br>';
		$template .= 'Total Price: 	'.$order->price_unit.' '.$order->total_price.'<br>';
		$template .= 'Created:		'.$order->created.' <br> <br>';

		$template .= '<strong>Customer Info</strong> <br>';
		$template .= 'Username: 		'.$user->username.' <br>';
		$template .= 'Fullname: 		'.$order->fullname.' <br>';
		$template .= 'Address 1:		'.$order->address1.' <br>';
		$template .= 'Address 2:		'.$order->address2.' <br>';
		$template .= 'City:				'.$order->city.' <br>';
		$template .= 'Region			'.$order->region.' <br>';
		$template .= 'Country: 		'.$order->country.' <br>';
		$template .= 'Postal Code: 	'.$order->postal_code.' <br>';
		$template .= 'Phone:		'.$order->phone.' <br> <br>';

		$template .= '<strong>Comments</strong> <br>';
		$template .= $order->order_note.' <br>';
		 $template .= '<br>';
		$template .= '---<br>';
		$template .= 'Regards - '.JURI::base();
		
		return $template;
	}
}
