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
use TextAnalysis\Tokenizers\GeneralTokenizer;

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

        $tokenizer = new GeneralTokenizer();
        $stemmer = new SnowballStemmer();

        $jobs = $jobRepository->findAll();
        foreach ($jobs as $job) {
            assert($job instanceof Job);

            $jobStemRepository->deleteByJobId($job->getId());

            $title =$job->getTitle();
            $description = $job->getDescription();

            $titleTokens = $tokenizer->tokenize($title);
            $descriptionTokens = $tokenizer->tokenize($description);

            $allTokens = array_merge($titleTokens, $descriptionTokens);
            $normalizeTokens = array_map(function ($token) { return strtolower($token); }, $allTokens);
            $uniqueTokens = array_unique($normalizeTokens);

            $output->writeln($job->getTitle() . ' | ' . json_encode($uniqueTokens));

            foreach ($uniqueTokens as $token) {

                $stemmedToken = $stemmer->stem($token);

                $stem = $stemRepository->findOneBy([
                    'word' => $token,
                    'stem' => $stemmedToken
                ]);

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
