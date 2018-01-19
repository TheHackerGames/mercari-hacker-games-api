<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StemJobsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('stem:jobs')
            ->setDescription('Stems job title and descriptions into jobs_stems table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();


        $output->writeln('Done!');
    }
}
