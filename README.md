# WebfactoryResponsiveImageBundle

A convenience Symfony bundle tailored for current responsive images needs of the webfactory GmbH, without any claims on
reusability outside of this scope. Ye be warned.

## Installation

    composer req webfactory/responsive-image-bundle

Activate the bundle, e.g. in `src/bundles.php`:

```php
<?php
return [
    // ...
    Webfactory\ResponsiveImageBundle\WebfactoryResponsiveImageBundle::class => ['all' => true],
];
```

If you intend to use lazyloading for images (which is the default), require `"lazysizes": "^5.3"` in your `/package.json`.


## Twig macros

### Responsive image:

`responsiveImg(image, options)` with:

- `image`: an array with the following keys:
    - `url` (mandatory): the URL of the image 
    - `alt` (optional): the alternative text for the image. Defaults to empty string.
    - `title` (optional): the title text for the image. Defaults to empty string.
- `options`: an array with the following keys:
    - `sizes` (optional): a string with a size or an array with sizes, which should match layout/breakpoints. Defaults to 100% is no sizes is given and lazyloading is disabled.
    - `transformations_to_widths` (optional): an object with thumbor transformation names as keys and image widths as values. Defaults to `{'image_xxs' : '320w'}`.
    - `class` (optional): CSS classes to add to the image. Defaults to empty string.
    - `data_attributes` (optional): an iterable object with data-attribute names (= the part after `data-`) and values as key/value pairs. Defaults to empty string.
    - `placeholder_filter`: The thumbor filter which is added to the placeholder image when lazyloading the image. Should match the target dimensions of the image. A list of default filters is provided with this bundle (see below) and can be overwritten / extended in the applicatrion configuration, e.g. the config.yml.
    - `lazyload` (optional): Whether to add the Thumbor filter when lazyloading the image. Should match the target dimensions of the image. Thumbor-Filters are configured in config.yml. Defaults to true.
    - `lqip` (optional): Flag to optionally disable the LQIP-method ([original concept (2013)](https://www.guypo.com/introducing-lqip-low-quality-image-placeholders), [current popular LQIP options](https://cloudinary.com/blog/low_quality_image_placeholders_lqip_explained)) of always loading a low-quality placeholder image. Defaults to `true`.

Example:
 
```
{% import '@WebfactoryResponsiveImage/Macros/responsiveImg.html.twig' as rimg %}

{{ rimg.responsiveImg(
    {
        'url': s3_cachable_url(artist, 'photo'),
        'alt': 'Portrait of ' ~ artistEntity.name
    },
    {
        'sizes': '100vw',
        'transformations_to_widths': {
            'image_xxs': '320w',
            'image_md': '992w'
        },
        'data_attributes': {'credits': '© P. H. O'Tographer'},
    }
) }}
```

### Responsive image with art direction:

`macro responsivePicture(formats, options)` with:

- `formats`: Array of objects, with each object describing a different format variant of the motive/picture by the following keys:
    - `image_url` (mandatory): the URL of the image in this format
    - `options` (optional): an array with the following keys that parametrize this format variant:
        - `sizes` (optional): a string with a size or an array with sizes, which should match layout/breakpoints. Defaults to 100% is no sizes is given and lazyloading is disabled.
        - `transformations_to_widths` (optional): an object with thumbor transformation names as keys and image widths as values. Defaults to `{'image_xxs' : '320w'}`.
        - `media_query` (optional): media query for the source element
- `options`: an array with the following keys:
    - `class`: Optional class to add to the img-tag. Defaults to empty class attribute is no value is given to keep the code readable.
    - `alt` (optional): the alternative text for the image. Defaults to empty string.
    - `title` (optional): the title text for the image. Defaults to empty string.
    - `data_attributes` (optional): an iterable object with data-attribute names (= the part after `data-`) and values as key/value pairs.
    - `placeholder_filter`: The thumbor filter which is added to the placeholder image when lazyloading the image. Should match the target dimensions of the image. A list of default filters is provided with this bundle (see below) and can be overwritten / extended in the applicatrion configuration, e.g. the config.yml.
    - `lazyload`: Enabled by default. Let sizes-calculation be handled by lazysizes script. https://github.com/aFarkas/lazysizes

Example:
 
```
{% import '@WebfactoryResponsiveImage/Macros/responsiveImg.html.twig' as rimg %}

{{ rimg.responsivePicture(
    [
        {
            'image_url': cachable_s3_url(artistEntity, 'photoInPortraitFormat'),
            'options': {
                'sizes': '100vw',
                'transformations_to_widths': {
                    'image_xxs' : '320w',
                    'image_md' : '992w'
                },
                'media_query': '(min-width: 768px)'
            }
        },
        {
            'image_url': cachable_s3_url(artistEntity, 'photoInSquareFormat'),
            'options': {
                'sizes': '100vw',
                'transformations_to_widths': {
                    'image_xxs' : '320w',
                    'image_md' : '992w'
                },
                'media_query': '(min-width: 640px)'
            }
        }
    ],
    {
        'lazyload': true,
        'class': 'js-object-fit',
        'alt': 'Portrait of ' ~ artistEntity.name,
        'data_attributes': {'credits': '© P. H. O'Tographer'},
    }
) }}
```

### Responsive Background Video

`responsiveBackgroundVideo(video, options)` with:

- `video`: an array with the following keys:
  - `url` (mandatory): the URL of the image
- `options`: an array with the following keys:
  - `transformations` (optional): an object with thumbor transformation names as keys and MIME-Types as values. Defaults to 
    ```
    {
      'video_hevc_720p' : 'video/mp4; codecs=hevc',
      'video_webm_720p' : 'video/webm; codecs=vp9',
      'video_mp4_720p': 'video/mp4'
    }
    ```
  - `class` (optional): CSS classes to add to the image. Defaults to empty string.
  - `data_attributes` (optional): an iterable object with data-attribute names (= the part after `data-`) and values as key/value pairs. Defaults to empty string.

Example:

```
{% import '@WebfactoryResponsiveImage/Macros/responsiveVideo.html.twig' as rVid %}

{{ rVid.responsiveBackgroundVideo(
    {
        'url': s3_cachable_url(entity, 'video')
    },
    {
        'class': 'background-video',
        'data_attributes': {'credits': '© P. H. O'Tographer'},
    }
) }}
```

## Default Configuration for JbPhumborBundle

This bundle configures the JbPhumborBundle via the `Resources/config/jb_phumbor-default-config*.yaml` files, setting
some default transformations and the Thumbor server settings. You can overwrite any `jb_phumbor`-setting in your
application config.
