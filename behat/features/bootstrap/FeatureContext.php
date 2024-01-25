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
     * @Given I should receive 200 status code
     */
    public function iShouldReceiveXxStatusCode2()
    {
        $response_code = (string) $this->getSession()->getStatusCode();
        if ($response_code != 200) {
            throw new \Exception("Access denied");
        }
    }

}
