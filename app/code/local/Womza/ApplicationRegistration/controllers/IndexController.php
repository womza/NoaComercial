<?php
class Womza_ApplicationRegistration_IndexController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('core/session');
        $this->renderLayout();
    }

    public function SaveAction()
    {
        // get form data
        $params = $this->getRequest()->getParams();
        try
        {
            $applicationregistration = Mage::getModel('applicationregistration/registration');
            $applicationregistration->setData('name', $params['name']);
            $applicationregistration->setData('location', $params['location']);
            $applicationregistration->setData('province', $params['province']);
            $applicationregistration->setData('company', $params['company']);
            $applicationregistration->setData('email', $params['email']);
            $applicationregistration->setData('phone', $params['phone']);
            $applicationregistration->setData('comment', $params['comment']);
            $applicationregistration->setData('created_time', date('Y-m-d h:m:s', Mage::getModel('core/date')->timestamp(time())));
            $applicationregistration->save();

            Mage::getSingleton('core/session')->addSuccess(Mage::helper('applicationregistration')->__('Thank you, your application will be processed'));

            // send email to administrator
            $this->_sendCustomEmail();
        }
        catch(Exception $e)
        {
            Mage::getSingleton('core/session')->addError(Mage::helper('applicationregistration')->__('Your data could not be saved, try again!'));
        }

        // Redirect back to index action of applicationregistration controller
        $this->_redirect('applicationregistration/');
    }

    private function _sendCustomEmail()
    {
        //Getting the Store E-Mail Sender Name.
        $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
        //Getting the Store General E-Mail.
        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

        // the message
        $msg = '<table cellspacing="0" cellpadding="0" border="0" width="650">
                    <tr>
                        <td valign="top">
                            <h1 style="font-size: 22px; font-weight: normal; line-height: 22px; margin: 0 0 11px 0;">Solicitud de Registro</h1>
                            <br/>
                            <p style="font-size: 16px; line-height: 16px; margin: 0 0 8px 0;">Se ha enviado una solicitud de registro, por favor ve al &aacute;rea administrativa para comprobar los datos del nuevo usuario.</p>
                        </td>
                    </tr>
                </table>';

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: '.$senderName.'<'.$senderEmail.'>' . "\r\n";

        // send email
        mail("alejandrogray@gmail.com", "Nueva solicitud de registro", $msg, $headers);
    }
}