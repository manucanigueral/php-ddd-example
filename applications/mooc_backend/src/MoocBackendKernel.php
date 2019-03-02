<?php

declare(strict_types = 1);

namespace CodelyTv\MoocBackend;

use CodelyTv\Mooc\Shared\Infrastructure\Symfony\Bundle\CodelyTvMoocBundle;
use CodelyTv\Shared\Infrastructure\Symfony\Bundle\CodelyTvInfrastructureBundle;
use FOS\RestBundle\FOSRestBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

final class MoocBackendKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new CodelyTvInfrastructureBundle(),
            new CodelyTvMoocBundle(),

            new FrameworkBundle(),
            new TwigBundle(),

            new MonologBundle(),

            new FOSRestBundle(),
            new JMSSerializerBundle(),
        ];
    }

    public function getName()
    {
        return 'api';
    }

    public function getRootDir()
    {
        return \dirname(__DIR__);
    }

    public function getCacheDir()
    {
        return $this->getRootDir() . '/var/cache';
    }

    public function getLogDir()
    {
        return $this->getRootDir() . '/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    public function getContainer()
    {
        $this->bootKernelInTestEnvironmentToDiscoverErrorsWhenDeveloping();

        return parent::getContainer();
    }

    private function bootKernelInTestEnvironmentToDiscoverErrorsWhenDeveloping(): void
    {
        if ($this->getEnvironment() === 'test') {
            $this->boot();
        }
    }
}
