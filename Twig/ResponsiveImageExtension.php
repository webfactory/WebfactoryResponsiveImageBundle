<?php

namespace Webfactory\ResponsiveImageBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

final class ResponsiveImageExtension extends AbstractExtension
{
    public function getTests()
    {
        return [
            new TwigTest('instanceof', [$this, 'isInstanceof']),
            new TwigTest('collection', [$this, 'isCollection']),
        ];
    }

    /**
     * @param object $object
     * @param string $class
     * @return bool
     */
    public function isInstanceof($object, $class)
    {
        return $object instanceof $class;
    }

    /**
     * @param object $object
     * @return bool
     */
    public function isCollection($object)
    {
        return $object instanceof \Doctrine\Common\Collections\Collection;
    }
}
