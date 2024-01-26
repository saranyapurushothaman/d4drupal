<?php

use Drupal\DrupalExtension\Context\RawDrupalContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I should receive :code status code
     */
    public function iShouldReceiveXxStatusCode2($code)
    {
        $response_code = (string) $this->getSession()->getStatusCode();
        if ($response_code != $code) {
            throw new \Exception("Access denied");
        }
    }

}
