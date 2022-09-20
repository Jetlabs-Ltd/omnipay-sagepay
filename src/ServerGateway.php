<?php

namespace Omnipay\SagePay;

/**
 * Sage Pay Server Gateway
 */
class ServerGateway extends DirectGateway
{
    public function getName()
    {
        return 'Sage Pay Server';
    }

    /**
     * Authorize a payment.
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SagePay\Message\ServerAuthorizeRequest', $parameters);
    }

    /**
     * Authorize and capture a payment.
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SagePay\Message\ServerPurchaseRequest', $parameters);
    }

    /**
     * Handle notification callback.
     * Replaces completeAuthorize() and completePurchase()
     */
    public function acceptNotification(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SagePay\Message\ServerNotifyRequest', $parameters);
    }

    /**
     * Accept card details from a user and return a token, without any
     * authorization against that card.
     * i.e. standalone token creation.
     * Omnipay standard function; alias for registerToken()
     */
    public function createCard(array $parameters = array())
    {
        return $this->registerToken($parameters);
    }

    /**
     * Remove a card token from the account.
     * Standard Omnipay function.
     */
    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SagePay\Message\SharedTokenRemovalRequest', $parameters);
    }

    /**
     * Accept card details from a user and return a token, without any
     * authorization against that card.
     * i.e. standalone token creation.
     * Gateway-specific function.
     */
    public function registerToken(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SagePay\Message\ServerTokenRegistrationRequest', $parameters);
    }

    /**
     * Handle token registration notification callback.
     * Please now use acceptNotification()
     * @deprecated
     */
    public function completeRegistration(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SagePay\Message\ServerTokenRegistrationCompleteRequest', $parameters);
    }

    /**
     * Handle authorize notification callback.
     * Please now use acceptNotification()
     * @deprecated
     */
    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\SagePay\Message\ServerCompleteAuthorizeRequest', $parameters);
    }

    /**
     * Handle purchase notification callback.
     * Please now use acceptNotification()
     * @deprecated
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->completeAuthorize($parameters);
    }
}
