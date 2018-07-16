# WebfactoryResponsiveImageBundle

Symfony bundle for responsive images.

## Twig macros

Delivers an image or picture in different resolutions and/or formats.

Simple Image:

```
{% import '@WebfactoryResponsiveImageBundle/Macros/responsiveImg.html.twig' as rimg %}

{{ rimg.responsiveImg(
    image,
    {
        sizes: '100vw',
        widths: {
            'image_xxs' : '320w',
            'image_md' : '992w'
        }
    }
) }}
```

Image with art direction:

```
{% import '@WebfactoryResponsiveImageBundle/Macros/responsiveImg.html.twig' as rimg %}

{{ rimg.responsivePicture(
    [
        [
            motivee_in_fomat_a,
            '100vw',
            {
                'image_xxs' : '320w',
                'image_md' : '992w'
            }
        ],
        [
            motivee_in_fomat_bs,
            '50vw',
            {
                'image_xxs' : '320w',
                'image_md' : '992w'
            }
        ]
    ]
) }}
```

### Parameters

image(media collection):
the image source

sizes(array):
A list of sizes, which should match layout/breakpoints.
Defaults to 100% is no sizes is given and lazyloading is disabled.

widths(array):
A list of image widths.
E.g. {'480' : '480w', '768' : '768w'}

variants(array):
Array of arrays containing the upper parameters, to build multiple <source>-elements inside a <picture>-element, when art direction is needed.

class(string, optional):
Optional class to add to the img-tag. Defaults to empty class attribute is no value is given to keep.
the code readable.

altText(string, optional):
Optional text to add to the alt-attribute of the image.

placeholderFilter(string, optional):
The Thumbor-Filter which is added to the placehold-image when lazyloading the image. Should match the target dimensions of the image. Thumbor-Filters are configured in config.yml.

lazyload(not null, optional):
Enabled by default. Let sizes-calculation be handled by lazysizes script.
https://github.com/aFarkas/lazysizes


## Default configuration for JbPhumborBundle

This bundle configures the JbPhumborBundle with [```jb_phumbor-default-config.yaml```](Resources/config/jb_phumbor-default-config.yaml):
the Thumbor server URL as well as some default transformations. You can overwrite any setting in your application config
for ```jb_phumbor``` and you still have to provide the server secret.


