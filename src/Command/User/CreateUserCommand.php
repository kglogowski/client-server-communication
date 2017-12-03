<?php

namespace CSC\Command\User;

use CSC\Model\Interfaces\UserInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CreateUserCommand
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class CreateUserCommand extends Command implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var QuestionHelper
     */
    protected $helper;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('security:create-user')
            ->setDescription('Create user')
        ;

        parent::configure();
    }

    /**
     * TODO Draft
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->helper = $this->getHelper('question');
        $em = $this->getContainer()->get('csc.entity_manager.provider')->getEntityManager();

        $entity = $this->question('Please enter the path to the entity: ', 'AppBundle\Entity\User\User');

        try {
            /** @var UserInterface $user */
            $user = new $entity();
        } catch (\Error $e) {
            throw new \Exception("Entity does not exist");
        }

        $login = $this->question('Login: ', 'admin');
        $email = $this->question('Email: ', 'email@email.com');
        $password = $this->question('Password: ', 'admin');
        $rePassword = $this->question('Repeat password: ', 'admin');
        $active = $this->question('Active: ', true);
        $status = $active ? UserInterface::STATUS_ACTIVE : UserInterface::STATUS_INACTIVE;

        if ($password !== $rePassword) {
            throw new \Exception("Bad repeat password");
        }

        $user
            ->setLogin($login)
            ->setEmail($email)
            ->setupUserPassword($password)
            ->setStatus($status)
        ;

        $errors = $this->getContainer()->get('validator')->validate($user);

        if (0 === $errors->count()) {
            $em->persist($user);
            $em->flush();
        } else {
            throw new \Exception($errors);
        }
    }

    private function question(string $message, $default)
    {
        $question = new Question($message, $default);

        return $this->helper->ask($this->input, $this->output, $question);
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}