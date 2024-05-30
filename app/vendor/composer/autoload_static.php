<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfdbf34b9944a7abd3eceb56cc305c687
{
    public static $files = array (
        '2cffec82183ee1cea088009cef9a6fc3' => __DIR__ . '/..' . '/ezyang/htmlpurifier/library/HTMLPurifier.composer.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'F' => 
        array (
            'Fpdf\\' => 5,
        ),
        'A' => 
        array (
            'App\\Views\\' => 10,
            'App\\Services\\' => 13,
            'App\\Repositories\\' => 17,
            'App\\Models\\' => 11,
            'App\\Controllers\\' => 16,
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Fpdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/fpdf/fpdf/src/Fpdf',
        ),
        'App\\Views\\' => 
        array (
            0 => __DIR__ . '/../..' . '/views',
        ),
        'App\\Services\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services',
        ),
        'App\\Repositories\\' => 
        array (
            0 => __DIR__ . '/../..' . '/repositories',
        ),
        'App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/models',
        ),
        'App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controllers',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $prefixesPsr0 = array (
        'H' => 
        array (
            'HTMLPurifier' => 
            array (
                0 => __DIR__ . '/..' . '/ezyang/htmlpurifier/library',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfdbf34b9944a7abd3eceb56cc305c687::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfdbf34b9944a7abd3eceb56cc305c687::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitfdbf34b9944a7abd3eceb56cc305c687::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitfdbf34b9944a7abd3eceb56cc305c687::$classMap;

        }, null, ClassLoader::class);
    }
}
