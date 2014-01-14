<?php

namespace Acme\Bundle\TaskBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Oro\Bundle\CronBundle\Command\Logger\OutputLogger;
use Oro\Bundle\CronBundle\Command\CronCommandInterface;
use Oro\Bundle\ConfigBundle\Config\UserConfigManager;

use Acme\Bundle\TaskBundle\Model\Statistics;

/**
 * Class SyncCommand
 * Console command implementation
 *
 * @package Oro\Bundle\IntegrationBundle\Command
 */
class SendStatisticsCommand extends ContainerAwareCommand implements CronCommandInterface
{
    const COMMAND_NAME   = 'oro:cron:acme:task:send-statistics';

    /**
     * {@internaldoc}
     */
    public function getDefaultDefinition()
    {
        return $this->getConfig()->get('acme_task.send_statistics_cron_schedule');
    }

    /**
     * Console command configuration
     */
    public function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Send email notification about tasks statistics');
    }

    /**
     * Runs command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     *
     * @throws \InvalidArgumentException
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->getConfig()->get('acme_task.send_statistics_enabled')) {
            return;
        }

        $emailTo = $this->getConfig()->get('acme_task.send_statistics_email_to');
        $emailFrom = $this->getConfig()->get('acme_task.send_statistics_email_from');

        $output = new OutputLogger($output);

        if (!$emailTo) {
            $output->notice($this->getTranslator()->trans('acme.task.send_statistics.statistics_email_not_configured'));
        }

        /** @var Statistics $statistics */
        $statistics = $this->getContainer()->get('acme_task.statistics');
        $statistics->getCounts();

        $output->notice($this->getTranslator()->trans('acme.task.send_statistics.task_statistics_counted'));

        /** @var \Twig_Environment $twig */
        $twig = $this->getContainer()->get('twig');

        /** @var \Swift_Mailer $mailer */
        $mailer = $this->getContainer()->get('mailer');

        $body = $twig->render(
            'AcmeTaskBundle:Task:statisticsMail.txt.twig',
            array('counts' => $statistics->getCounts())
        );

        $message = $mailer->createMessage();
        $message->setSubject($this->getTranslator()->trans('acme.task.send_statistics.mail.subject'));
        if ($emailFrom) {
            $message->setFrom($emailFrom);
        }
        $message->setTo($emailTo);
        $message->setBody($body, 'text/plain');

        $mailer->send($message);

        $output->notice(
            $this->getTranslator()->trans(
                'acme.task.send_statistics.mail_sent',
                array('%emailTo%' => $emailTo)
            )
        );
    }

    /**
     * @return UserConfigManager
     */
    protected function getConfig()
    {
        return $this->getContainer()->get('oro_config.user');
    }

    /**
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
        return $this->getContainer()->get('translator');
    }
}
