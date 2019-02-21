<?php

$themes = $pages->find("template=theme, sort=-created");

if($input->get->theme) {
    $id = $sanitizer->selectorValue($input->get->theme);
    $firstTheme = $pages->get($id);
} else {
    $firstTheme = $pages->get("template=theme, sort=-created");
}

$thumbSize = "200px";

$demo_size = $system->site_info->demo_site;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php if(empty($page->seo_title)): ?>
        <title><?= $page->title ?></title>
    <?php endif;?>

    <!-- favicon -->
    <?php if(!empty($system->favicon)): ?>
        <link rel="shortcut icon" type="image/ico" href="<?= $system->favicon->url ?>" />
        <link rel="apple-touch-icon-precomposed" href="<?= $system->favicon->url ?>" />
    <?php endif ?>

    <!-- jquery
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    -->

    <!-- less -->
    <link rel="stylesheet" type="text/css" href="<?php echo AIOM::CSS('less/theme.less');  ?>">

    <!-- uikit -->
    <script type='text/javascript' src='<?= $config->urls->templates . 'lib/uikit/js/uikit.min.js' ; ?>'></script>
    <script type='text/javascript' src='<?= $config->urls->templates . 'lib/uikit/js/uikit-icons.min.js' ; ?>'></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <style>
        html,body {
			height:100%;
			width:100%;
            overflow: hidden;
        }
        #toolbar {
            height: 70px;
            padding-left:20px;
            position: relative;
            z-index:999;
        }
        #iframe {
            width:100%;
            min-height:100%;
			padding-bottom: 70px;
			box-sizing:border-box;
        }
        #loader svg {
            stroke: #3e5681 !important;
        }
        #responsive > a {
            margin-left:5px;
            opacity: 0.5;
        }
        #responsive > a:hover {
            opacity: 0.7;
        }
        #responsive > a.active {
            opacity:1;
        }

        #theme-slider {
            top:70px;
        }
        .tm-demo-theme-card {
            margin-top:0;
            transition: margin 0.3s ease;
        }
        .tm-demo-theme-card:hover {
            margin-top: -10px;
        }
        .uk-slider-container {
            padding-top: 10px !important;
        }

        @media(min-width: 768px) {
            body {
                background: #eee;
            }
            #iframe {
                display: block;
                margin: auto;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }
            #iframe.desktop {max-width: 100%;}
            #iframe.laptop {max-width: 1440px;}
            #iframe.tablet {max-width: 959px;}
            #iframe.mobile {max-width: 480px;}
        }
    </style>

</head>

<body>

    <div id="toolbar" class="uk-flex uk-flex-middle uk-background-primary uk-light uk-box-shadow-medium uk-position-relative">
        <div class="uk-width-1-1" uk-grid>
            <div class="uk-width-auto uk-visible@s">
                <a href="<?=$pages->get("/")->url ?>">
                    <img src="<?= $system->logo->url ?>" alt="logo" width="120" />
                </a>
            </div>
            <div class="uk-width-expand uk-flex uk-flex-middle">
                <div class="uk-width-1-1 uk-width-auto@m">
                    <a id="themes-button" class="uk-button uk-button-default uk-button-small uk-width-1-1" href="#"
                    uk-toggle="target: #theme-slider;cls: uk-hidden">
                        <span><?= $firstTheme->title ?></span>
                        <i class="fas fa-sort uk-margin-small-left"></i>
                    </a>
                </div>
                <div id="responsive" class="uk-margin-left uk-visible@l">
                    <a class="active" href="#" data-cls="desktop"><i class="fas fa-desktop"></i></a>
                    <a href="#" data-cls="laptop"><i class="fas fa-laptop"></i></a>
                    <a href="#" data-cls="tablet"><i class="fas fa-tablet-alt"></i></a>
                    <a href="#" data-cls="mobile"><i class="fas fa-mobile-alt"></i></a>
                </div>
            </div>
            <div class="uk-width-auto uk-text-right">
                <a class="uk-button uk-button-secondary uk-button-small" href="<?= $system->site_info->buy_link ?>" target="_blank">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="uk-visible@m uk-margin-small-left">Purchase</span>
                </a>
                <a id="remove-toolbar" href="<?= $firstTheme->link ?>" class="uk-button uk-button-text uk-button-small uk-visible@m uk-margin-left">Remove Toolbar</a>
            </div>
        </div>
    </div>
    <div id="theme-slider" class="uk-background-muted uk-animation-slide-top-small uk-animation-fast uk-hidden uk-position-top">
        <div class="uk-container">

            <div uk-slider="sets: true;finite: false">
                <div class="uk-position-relative uk-padding">

                    <div class="uk-slider-container">
                        <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-5@l uk-grid">
                            <?php foreach($themes as $theme) :?>
                                <li>
                                    <div class="tm-demo-theme-card uk-panel uk-text-center">
                                        <?php if($theme->img) :?>
                                            <img class="uk-border-rounded uk-box-shadow-small uk-box-shadow-hover-medium" src="<?= $theme->img->size($thumbSize, $thumbSize, "north")->url ?>" alt="<?= $theme->title ?>">
                                        <?php else: ?>
                                            <div class="uk-inline-block uk-background-primary" style="width:<?= $thumbSize ?>;height:<?= $thumbSize ?>;"></div>
                                        <?php endif;?>
                                        <div class="uk-text-small uk-margin-small-top"><?= $theme->title ?></div>
                                        <a class="theme uk-position-cover" href="#" data-url="<?= $theme->link ?>" data-title="<?= $theme->title ?>"></a>
                                    </div>
                                </li>
                            <?php endforeach;?>
                        </ul>

                        <a class="uk-position-center-left-out uk-visible@l" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-center-right-out uk-visible@l" href="#" uk-slidenav-next uk-slider-item="next"></a>

                        <a class="uk-position-center-left uk-hidden@l" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-center-right uk-hidden@l" href="#" uk-slidenav-next uk-slider-item="next"></a>

                    </div>

                </div>
            </div>
        </div>
        <a class="uk-close-large uk-position-top-right uk-position-medium" href="#" uk-close uk-toggle="target: #theme-slider;cls: uk-hidden"></a>
    </div>

    <iframe id="iframe" src="<?= $firstTheme->link ?>"></iframe>

    <div id="loader" class="uk-hidden uk-position-cover uk-background-muted uk-flex uk-flex-middle uk-flex-center">
        <img class="uk-text-primary" src="<?= $config->urls->templates ?>media/loader.svg" uk-svh width="60" height="60" />
    </div>

<script>

/**
 *  Theme Switcher
 *
 */

var theme = document.querySelectorAll(".theme");

for(let i = 0; i < theme.length; i++ ) {
    theme[i].addEventListener("click", e => {

        // hide theme slider
        document.getElementById("theme-slider").classList.add("uk-hidden");

        // show loader
        let loader = document.getElementById("loader");
        loader.classList.remove("uk-hidden");

        // get clicked url & title
        let url = e.target.getAttribute("data-url");
        // change iframe src
        document.getElementById("iframe").setAttribute("src", url);

        // get theme title
        let button = document.querySelector("#themes-button > span");
        let title = e.target.getAttribute("data-title");
        button.textContent = title;

        // set remove toolbar link
        document.getElementById("remove-toolbar").setAttribute("href", url);

        //console.log(url);

        <?php if($input->get->theme) :?>
            // remove php GET varibales from URL
            // window.location.href =  window.location.href.split("?")[0];
        <?php endif;?>

    });

}

// Hide loader
document.getElementById('iframe').onload = function() {
    let loader = document.getElementById("loader");
    loader.classList.add("uk-hidden");
};

/**
 *  Responsive Switcher
 *
 */
var responsive = document.querySelectorAll("#responsive > a");

for(let i = 0; i < responsive.length; i++ ) {
    responsive[i].addEventListener("click", e => {

        let element = e.target.parentElement;
        let thisClass = element.getAttribute("data-cls");

        // remove active class for links
        for(let i = 0; i < responsive.length; i++ ) {
            responsive[i].classList.remove("active");
        }
        // add active class to the clicked link
        element.classList.add("active");

        // remove all classes
        document.getElementById("iframe").className = '';
        // add current class
        document.getElementById("iframe").classList.add(thisClass);

        // console.log(thisClass);

    });
}

</script>

</body>
</html>
