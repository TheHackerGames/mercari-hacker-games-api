<?php

namespace AppBundle\Command;

use AppBundle\Entity\Job;
use AppBundle\Entity\JobStem;
use AppBundle\Entity\Stem;
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

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $jobRepository = $entityManager->getRepository(Job::class);
        assert($jobRepository instanceof EntityRepository);

        $stemRepository = $entityManager->getRepository(Stem::class);
        assert($stemRepository instanceof EntityRepository);

        $jobStemRepository = $entityManager->getRepository(JobStem::class);
        assert($jobStemRepository instanceof EntityRepository);

        $snowballStemmer = new SnowballStemmer();

        $jobs = $jobRepository->findAll();
        foreach ($jobs as $job) {
            assert($job instanceof Job);

            $jobStemRepository->deleteByJobId($job->getId());

            $title =$job->getTitle();
            $description = $job->getDescription();

            $titleTokens = tokenize($title);
            $descriptionTokens = tokenize($description);

            $allTokens = array_merge($titleTokens, $descriptionTokens);
            $uniqueTokens = array_unique($allTokens);

            $normalizeTokens = normalize_tokens($uniqueTokens);

            $output->writeln($job->getTitle() . ' | ' . json_encode($normalizeTokens));

            foreach ($normalizeTokens as $token) {

                $stemmedToken = $snowballStemmer->stem($token);

                $stem = $stemRepository->findOneBy(['stem' => $stemmedToken]);
                if (!($stem instanceof Stem)) {

                    $stem = new Stem();
                    $stem->setStem($stemmedToken)
                        ->setWord($token)
                        ->setCreated(new \DateTime());

                    $entityManager->persist($stem);
                    $entityManager->flush();
                }

                $jobStem = new JobStem();
                $jobStem->setJobId($job->getId())
                    ->setStemId($stem->getId())
                    ->setCreated(new \DateTime());

                $entityManager->persist($jobStem);
                $entityManager->flush();
            }
        }
    }
}
