<?php

namespace AppBundle\Command;

use AppBundle\Entity\Skill;
use AppBundle\Entity\SkillStem;
use AppBundle\Entity\Stem;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TextAnalysis\Documents\TokensDocument;
use TextAnalysis\Filters\LowerCaseFilter;
use TextAnalysis\Filters\NumbersFilter;
use TextAnalysis\Filters\PossessiveNounFilter;
use TextAnalysis\Filters\PunctuationFilter;
use TextAnalysis\Filters\StopWordsFilter;
use TextAnalysis\Generators\StopwordGenerator;
use TextAnalysis\Stemmers\SnowballStemmer;
use TextAnalysis\Tokenizers\GeneralTokenizer;

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
        $entityManager = $this->getContainer()
            ->get('doctrine.orm.entity_manager');
        assert($entityManager instanceof EntityManager);
        $skillRepository = $entityManager
            ->getRepository(Skill::class);
        assert($skillRepository instanceof EntityRepository);
        $skillStemRepository = $entityManager
            ->getRepository(SkillStem::class);
        assert($skillStemRepository instanceof EntityRepository);
        $stemRepository = $entityManager
            ->getRepository(Stem::class);
        assert($stemRepository instanceof EntityRepository);

        $skills = $skillRepository->findAll();
        foreach ($skills as $skill) {
            $skillStemRepository->deleteBySkillId($skill->getId());

            $tokensDoc = new TokensDocument(
                (new GeneralTokenizer())
                    ->tokenize($skill->getName())
            );
            $stopWords = array_map('trim', file(__DIR__ . '/../Resources/stop_words.txt'));

            $tokens = $tokensDoc
                ->applyTransformation(new LowerCaseFilter())
                ->applyTransformation(new PossessiveNounFilter())
                ->applyTransformation(new PunctuationFilter([]))
                ->applyTransformation(new StopWordsFilter($stopWords))
                ->applyTransformation(new NumbersFilter())
                ->getDocumentData();
            $uniqueTokens = array_unique($tokens);

            foreach ($uniqueTokens as $token) {
                $stem = (new SnowballStemmer())
                    ->stem($token);

                $stemEntity = $stemRepository->findOneBy([
                    'stem' => $stem,
                    'word' => $token
                ]);

                if (!$stemEntity) {
                    $stemEntity = (new Stem())
                        ->setStem($stem)
                        ->setWord($token)
                        ->setCreated(new \DateTime());
                    $entityManager->persist($stemEntity);
                    $entityManager->flush();
                }

                $skillStem = (new SkillStem())
                    ->setSkillId($skill->getId())
                    ->setStemId($stemEntity->getId())
                    ->setCreated(new \DateTime());
                $entityManager->persist($skillStem);
                $entityManager->flush();
            }
        }

        $output->writeln('Done!');
    }
}
