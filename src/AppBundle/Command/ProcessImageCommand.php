<?php

namespace AppBundle\Command;

use AppBundle\Entity\Image;
use AppBundle\Service\GearmanService;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessImageCommand extends ContainerAwareCommand
{
    /**
     * @return EntityManager
     */
    private function getManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('image:process')
            ->setDescription('Send image to python and receive raw data')
            ->addArgument('start', InputArgument::REQUIRED, 'Image start')
            ->addArgument('stop', InputArgument::REQUIRED, 'Image stop');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = $input->getArgument('start');
        $stop = $input->getArgument('stop');

        /** @var GearmanService $service */
        $service = $this->getContainer()->get(GearmanService::ID);

        $repo = $this->getManager()->getRepository(Image::class);
        $images = $repo->findBy([], [], $stop, $start);

        /** @var Image $image */
        foreach ($images as $image) {
            var_dump($image->getId());
            $image->setRaw($service->getRawData($image->getUrl()));
            $this->getManager()->persist($image);
            $this->getManager()->flush();
        }

    }
}
