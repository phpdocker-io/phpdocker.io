<?php
namespace AppBundle\Services;

/**
 * Custom twig extensions
 *
 * @package   AppBundle\Services
 * @copyright Auron Consulting Ltd
 */
class TwigCustomExtensions extends \Twig_Extension
{
    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('unescape', array($this, 'unescape')),
        ];
    }

    /**
     * Unescape filter removes HTML entities back into chars.
     *
     * @param string $value
     *
     * @return mixed
     */
    public function unescape(string $value) : string
    {
        return html_entity_decode($value);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() : string
    {
        return 'Twig custom extensions';
    }
}
