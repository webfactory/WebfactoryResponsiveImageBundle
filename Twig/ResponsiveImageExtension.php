<?php

namespace Webfactory\ResponsiveImageBundle\Twig;

use Doctrine\Common\Collections\Collection;
use Twig\Extension\AbstractExtension;

final class ResponsiveImageExtension extends AbstractExtension
{
    public function getTests()
    {
        return [
            new \Twig_SimpleTest('instanceof', [$this, 'isInstanceof']),
            new \Twig_SimpleTest('collection', [$this, 'isCollection']),
        ];
    }

    /**
     * @param object $var
     * @param string $instance
     * @return bool
     */
    public function isInstanceof($object, $class)
    {
        return $var instanceof $instance;
    }

    /**
     * @param object $var
     * @return bool
     */
    public function isCollection($var)
    {
        return $var instanceof Collection;
    }
}
