<?php

namespace Bazinga\ExposeTranslationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Dumps translations to the filesystem.
 *
 * @author Kashmir Singh Thakur <kashmir@agilemedialab.in>
 */
class DumpTranslationsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bazinga:translations:dump')
            ->setDescription('Extracts translations from a given domain for a user locale and outputs them in javascript')
            ->addArgument('domain_name', InputArgument::REQUIRED, 'Translation message domain')
            ->addArgument('locale', InputArgument::REQUIRED, 'Locale')
            ->addArgument('file_location', InputArgument::REQUIRED, 'Output file location');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $domain_name = $input->getArgument('domain_name');
        $locale      = $input->getArgument('locale');
        $path        = $input->getArgument('file_location');
        $format      = 'js'; 
        
        $controller = $this->getContainer()->get('bazinga.exposetranslation.controller');
        $result = $controller->exposeTranslationAction($domain_name, $locale, $format);
        
        $this->write($path, $result->getContent());
    }
    
    private function write($path, $contents)
    {
        if (!is_dir($dir = dirname($path)) && false === @mkdir($dir, 0777, true)) {
            throw new \RuntimeException('Unable to create directory '.$dir);
        }

        if (false === @file_put_contents($path, $contents)) {
            throw new \RuntimeException('Unable to write file '.$path);
        }
    }

}