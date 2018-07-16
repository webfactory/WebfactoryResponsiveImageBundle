<?php

namespace Webfactory\ResponsiveImageBundle\Twig;

use Twig\Extension\AbstractExtension;

final class ResponsiveImageExtension extends AbstractExtension
{
    public function getTests()
    {
        return [
            new \Twig_SimpleTest('instanceOf', [$this, 'isInstanceof']),
        ];
    }

    /**
     * @param object $object
     * @param string $instance
     * @return bool
     */
    public function isInstanceof($object, $instance) {
        return $object instanceof $instance;
    }
}
