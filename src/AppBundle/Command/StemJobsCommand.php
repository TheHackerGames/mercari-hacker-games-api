<?php

namespace AppBundle\Command;

use AppBundle\Entity\Job;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TextAnalysis\Stemmers\SnowballStemmer;

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

        $jobRepository = $container->get('doctrine.orm.entity_manager')
                ->getRepository(Job::class);
        assert($jobRepository instanceof EntityRepository);

        $stemRepository = $container->get('doctrine.orm.entity_manager')
            ->getRepository(Stem::class);
        assert($stemRepository instanceof EntityRepository);

        $jobStemRepository = $container->get('doctrine.orm.entity_manager')
            ->getRepository(JobStem::class);
        assert($jobStemRepository instanceof EntityRepository);

        $snowballStemmer = new SnowballStemmer();

        $jobs = $jobRepository->findAll();
        foreach ($jobs as $job) {
            assert($job instanceof Job);

            $title =$job->getTitle();
            $description = $job->getDescription();

            $titleTokens = tokenize($title);
            $descriptionTokens = tokenize($description);

            $allTokens = array_merge($titleTokens, $descriptionTokens);
            $uniqueTokens = array_unique($allTokens);

            $normalizeTokens = normalize_tokens($uniqueTokens);

            foreach ($normalizeTokens as $token) {

                $stemmedToken =

                $stem = $stemRepository->findOneBy(['stem' => ]);

            }
        }

        $output->writeln('Done!');
    }
}
