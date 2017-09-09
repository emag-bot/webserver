<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 09.09.2017
 * Time: 17:57
 */

namespace AppBundle\Command;

use AppBundle\Entity\Image;
use AppBundle\Service\GearmanService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessLabelsCommand extends ContainerAwareCommand
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
            ->setName('label:process')
            ->setDescription('Send image to python and receive raw data');
    }

    private function getLabel()
    {
        var_dump('hey');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $worker = new \GearmanWorker();
        $worker->addServer('gearman.emag-bot.com');
        $worker->addFunction('get_label', function ($job) {
            /** @var \GearmanJob $job */
            var_dump($job->workload());
        });

        while ($worker->work()) {
        }
    }
}