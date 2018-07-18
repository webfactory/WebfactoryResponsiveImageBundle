# WebfactoryResponsiveImageBundle

A convenience Symfony bundle tailored for current responsive images needs of the webfactory GmbH, without any claims on
reusability outside of this scope. Ye be warned.

## Twig macros

### Responsive image:

`responsiveImg(entity, nameOfImageAccessor, imgOptions)` with:

- `entity`: the entity that has an image, e.g. a teaser or an artist
- `nameOfImageAccessor`: the name under which the image can be requested from the entity. E.g. if you would write `artist.photo` in Twig, it's `'photo'` (with the quotes).  
- `imgOptions`: an array with the keys `sizes` and `widths`.
    - `sizes`: a string with a size or an array with sizes, which should match layout/breakpoints. Defaults to 100% is no sizes is given and lazyloading is disabled.
    - `widths`: an array of image widths. E.g. `{'480' : '480w', '768' : '768w'}`.

Example:
 
```
{% import '@WebfactoryResponsiveImageBundle/Macros/responsiveImg.html.twig' as rimg %}

{{ rimg.responsiveImg(
    artistEntity,
    'photo',
    {
        sizes: '100vw',
        widths: {
            'image_xxs' : '320w',
            'image_md' : '992w'
        }
    }
) }}
```

### Responsive image with art direction:

`macro responsivePicture(variants, picOptions)` with:

- `variants`: Array of arrays containing the upper parameters, to build multiple <source>-elements inside a <picture>-element, when art direction is needed.
- `picOptions`: an array with any number of the keys `class`, `altText`, `placeholderFilter`, `lazyload`:
    - `class`: Optional class to add to the img-tag. Defaults to empty class attribute is no value is given to keep the code readable.
    - `altText`: Optional text to add to the alt-attribute of the image.
    - `placeholderFilter`: The thumbor filter which is added to the placeholder image when lazyloading the image. Should match the target dimensions of the image. A list of default filters is provided with this bundle (see below) and can be overwritten / extended in the applicatrion configuration, e.g. the config.yml.
    - `lazyload`: Enabled by default. Let sizes-calculation be handled by lazysizes script. https://github.com/aFarkas/lazysizes

Example:
 
```
{% import '@WebfactoryResponsiveImageBundle/Macros/responsiveImg.html.twig' as rimg %}

{{ rimg.responsivePicture(
    [
        [
            artistEntity,
            'photoInPortraitFormat',
            '100vw',
            {
                'image_xxs' : '320w',
                'image_md' : '992w'
            }
        ],
        [
            artistEntity,
            'photoInSquareFormat',
            '50vw',
            {
                'image_xxs' : '320w',
                'image_md' : '992w'
            }
        ]
    ],
    {
        lazyload: true,
        class: 'js-object-fit',
        altText: artistEntity.name
    }
) }}
```


## Default Configuration for JbPhumborBundle

This bundle configures the JbPhumborBundle with [```jb_phumbor-default-config.yaml```](Resources/config/jb_phumbor-default-config.yaml):
the Thumbor server URL as well as some default transformations. You can overwrite any setting in your application config
for ```jb_phumbor``` and you still have to provide the server secret.
