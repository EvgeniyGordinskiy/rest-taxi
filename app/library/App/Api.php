<?php
namespace App;

class Api extends \PhalconRest\Api
{
    public function getMatchedEndpoint()
    {
        $collectionIdentifier = $this->getMatchedRouteNamePart('collection');
        $endpointIdentifier = $this->getMatchedRouteNamePart('endpoint');

        if (!$endpointIdentifier) {
            return null;
        }

        $fullIdentifier = $collectionIdentifier . ' ' . $endpointIdentifier;
        $this->endpointsByIdentifier[$fullIdentifier]->startRequest();
        return array_key_exists($fullIdentifier,
            $this->endpointsByIdentifier) ? $this->endpointsByIdentifier[$fullIdentifier] : null;
    }
}