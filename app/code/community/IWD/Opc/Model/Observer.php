<?php
class IWD_Opc_Model_Observer{
	
	public function newsletter($observer){
		$_session = Mage::getSingleton('core/session');

		$newsletterFlag = $_session->getIsSubscribed();
		if ($newsletterFlag==true){
			
			$email = $observer->getEvent()->getOrder()->getCustomerEmail();
			
			$subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
	        if($subscriber->getStatus() != Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED &&
	                $subscriber->getStatus() != Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED) {
	            $subscriber->setImportMode(true)->subscribe($email);
	        }
			
		}
		
	}
	
	
	public function applyComment($observer){
		$order = $observer->getData('order');
		$comment = Mage::getSingleton('core/session')->getOpcOrderComment();
		if (!Mage::helper('opc')->isShowComment() || empty($comment)){
			return;
		}
		try{
			$order->addStatusHistoryComment($comment)->setIsVisibleOnFront(true)->setIsCustomerNotified(true);
			$order->save();
			$order->sendOrderUpdateEmail(true, $comment);
		}catch(Exception $e){
			Mage::logException($e);
		}
	}
	
}