<?php

namespace AppBundle\Command;

use AppBundle\Entity\Job;
use AppBundle\Entity\JobSkill;
use AppBundle\Entity\Skill;
use AppBundle\Entity\Stem;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JobSkillMatchCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('job:skill:match')
            ->setDescription('Uses skill and job stems to match skills to jobs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $skillRepository = $entityManager->getRepository(Skill::class);
        assert($skillRepository instanceof EntityRepository);

        $jobRepository = $entityManager->getRepository(Job::class);
        assert($jobRepository instanceof EntityRepository);

        $stemRepository = $entityManager->getRepository(Stem::class);
        assert($stemRepository instanceof EntityRepository);

        $jobSkillRepository = $entityManager->getRepository(JobSkill::class);
        assert($jobSkillRepository instanceof EntityRepository);

        $jobs = $jobRepository->findAll();
        foreach ($jobs as $job) {

            assert($job instanceof Job);
            $jobSkillRepository->deleteByJobId($job->getId());

            $jobStems = $stemRepository->findByJobId($job->getId());
            $jobStemTokens = array_map(function($stem) { return $stem->getStem(); }, $jobStems);

            $skills = $skillRepository->findByStemTokenMatch($jobStemTokens);
            foreach ($skills as $skill) {

                assert($skill instanceof Skill);

                $jobSkill = new JobSkill();
                $jobSkill->setJobId($job->getId())
                    ->setSkillId($skill->getId())
                    ->setCreated(new \DateTime());

                $entityManager->persist($jobSkill);
                $entityManager->flush();

                $output->writeln('Connected the following skill and job...');
                $output->writeln('Job: ' . $job->getTitle());
                $output->writeln('Skill: ' . $skill->getName());
            }
        }
    }
}
