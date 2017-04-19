<?php
namespace PHPDocker\Interfaces;

/**
 * @package PHPDocker\Interfaces
 */
interface ContainerNameSuffixInterface
{
    /**
     * Should return the suffix to use in a given container name.
     *
     * @return string
     */
    public function getContainerNameSuffix(): string;
}
