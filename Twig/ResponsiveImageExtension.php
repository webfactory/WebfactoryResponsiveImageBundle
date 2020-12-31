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
        trigger_deprecation('webfactory/responsive-image-bundle', '1.8.2', 'The "instanceof" Twig test is deprecated and will be removed in the 2.0 version of this bundle.');

        return $object instanceof $class;
    }

    /**
     * @param object $object
     * @return bool
     */
    public function isCollection($object)
    {
        trigger_deprecation('webfactory/responsive-image-bundle', '1.8.2', 'The "collection" Twig test is deprecated and will be removed in the 2.0 version of this bundle.');

        return $object instanceof \Doctrine\Common\Collections\Collection;
    }
}
