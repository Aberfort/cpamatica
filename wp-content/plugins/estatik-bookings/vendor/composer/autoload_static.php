<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite60e13b7d099b651f5851a3e83d28a86
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Spatie\\Emoji\\' => 13,
            'SlevomatCodingStandard\\' => 23,
        ),
        'P' => 
        array (
            'PHPStan\\PhpDocParser\\' => 21,
            'PHPCSStandards\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 57,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Spatie\\Emoji\\' => 
        array (
            0 => __DIR__ . '/..' . '/spatie/emoji/src',
        ),
        'SlevomatCodingStandard\\' => 
        array (
            0 => __DIR__ . '/..' . '/slevomat/coding-standard/SlevomatCodingStandard',
        ),
        'PHPStan\\PhpDocParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpstan/phpdoc-parser/src',
        ),
        'PHPCSStandards\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite60e13b7d099b651f5851a3e83d28a86::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite60e13b7d099b651f5851a3e83d28a86::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite60e13b7d099b651f5851a3e83d28a86::$classMap;

        }, null, ClassLoader::class);
    }
}
