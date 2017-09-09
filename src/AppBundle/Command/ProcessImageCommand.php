<?php

namespace AppBundle\Command;

use AppBundle\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessImageCommand extends ContainerAwareCommand
{
    /**
     * @return Registry
     */
    private function getDoctrine()
    {
        return $this->get('doctrine');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('image:process')
            ->setDescription('Send image to python and receive raw data');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository(Image::class);

        $repo->findBy(['raw' => null]);
    }
}
