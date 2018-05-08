<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace AppBundle\Features\Context;

use Assert\Assertion;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Behat base feature context
 *
 * @package AcmeBundle\Features\Context
 * @author  Luis A. Pabon Flores
 */
class FeatureContext extends MinkContext implements KernelAwareContext
{
    /**
     * Bring in kernel and container
     */
    use KernelDictionary;

    /**
     * @Then /^I should have a contact form$/
     * @throws \Assert\AssertionFailedException
     */
    public function iShouldHaveAContactForm()
    {
        $page = $this->getSession()->getPage();

        Assertion::notNull($page->find('css', 'form input[name="contact_request[senderEmail]"]'));
        Assertion::notNull($page->find('css', 'form textarea[name="contact_request[message]"]'));
        Assertion::notNull($page->find('css', 'form input[type=submit]'));
    }
}
