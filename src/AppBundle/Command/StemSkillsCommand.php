<?php

namespace AppBundle\Command;

use AppBundle\Entity\Skill;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StemSkillsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('stem:skills')
            ->setDescription('Stems skills into skills_stems table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $skillRepository = $this->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository(Skill::class);
        assert($skillRepository instanceof EntityRepository);

        $output->writeln('Done!');
    }
}
