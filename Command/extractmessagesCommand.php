<?php

namespace Bazinga\ExposeTranslationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Bazinga\ExposeTranslationBundle\Controller\Controller;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

use Symfony\Component\HttpFoundation\Response;
use Bazinga\ExposeTranslationBundle\Service\TranslationFinder;

class extractmessagesCommand extends ContainerAwareCommand
{
    
    protected function configure()
    {
        $this
            ->setName('bazinga:messages')
            ->setDescription('extracts messages from a given domain for a user locale')
            ->setDefinition(array());
        //        new InputArgument('domain_name', InputArgument::REQUIRED, 'Domain Name'),
        //        new InputArgument('locale', InputArgument::REQUIRED, 'Locale'),
        //        new InputArgument('format', InputArgument::REQUIRED, 'Format'),
        //        outputfile
        //        ))
        //;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $domain_name = 'messages'; //$input->getArgument('domain_name');
        $locale      = 'es'; //$input->getArgument('locale');
        $format      = 'js'; //$input->getArgument('format');
        
        $controller = $this->getContainer()->get('bazinga.exposetranslation.controller');
        $result = $controller->exposeTranslationAction($domain_name, $locale, $format);

        // output to file
        print_r($result->getContent());
    }
}