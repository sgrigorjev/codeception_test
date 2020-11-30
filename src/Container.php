<?php

namespace CodeceptionCuriosity;

use Psr\Container\ContainerInterface;

class Container
{
    /**
     * @var ContainerInterface
     */
    private static $instance;

    private static function create(): ContainerInterface
    {
        $container = new \Pimple\Container();
        $container['template_dir'] = __DIR__ . '/../templates';
        $container['template_cache_dir'] = __DIR__ . '/../var/cache/twig';

        $container[\Twig\Loader\FilesystemLoader::class] = function ($c) {
            return new \Twig\Loader\FilesystemLoader($c['template_dir']);
        };

        $container[\Twig\Environment::class] = function ($c) {
            return new \Twig\Environment($c[\Twig\Loader\FilesystemLoader::class], [
                //'cache' => $c['template_cache_dir']
            ]);
        };

        // Aliases
        $container['template'] = $container[\Twig\Environment::class];

        return new \Pimple\Psr11\Container($container);
    }

    /**
     * @return ContainerInterface
     */
    public static function get()
    {
        if (!isset(self::$instance)) {
            self::$instance = self::create();
        }

        return self::$instance;
    }
}
