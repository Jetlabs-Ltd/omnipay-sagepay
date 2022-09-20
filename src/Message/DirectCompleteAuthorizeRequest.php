<?php

namespace Omnipay\SagePay\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * Sage Pay Direct Complete Authorize Request
 */
class DirectCompleteAuthorizeRequest extends AbstractRequest
{
    /**
     * @return array|mixed|string[]
     * @throws InvalidResponseException
     */
    public function getData()
    {
        // Inconsistent letter case is intentional.
        // The issuing bank will return PaRes, but the merchant
        // site must send this result as PARes to Sage Pay.
 
        // New 3D secure logic
        if ($this->httpRequest->request->has('cres')) {
            $CRes = $this->httpRequest->request->get('cres');
            $VPSTxId = $this->httpRequest->request->get('threeDSSessionData');

            if (!$VPSTxId) {
                throw new InvalidResponseException('3DSecure: Missing VPSTxId');
            }

            if (!$CRes) {
                throw new InvalidResponseException('3DSecure: Missing CRes');
            }

            return compact('CRes', 'VPSTxId');
        }

        $data = array(
            'MD' => $this->httpRequest->request->get('MD'),
            'PARes' => $this->httpRequest->request->get('PaRes'),
        );

        if (empty($data['MD']) || empty($data['PARes'])) {
            throw new InvalidResponseException;
        }

        return $data;
    }

    public function getService()
    {
        return 'direct3dcallback';
    }
}
