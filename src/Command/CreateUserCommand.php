<?php

namespace App\Command;

use App\Util\User\UserManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateUserCommand extends Command
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

	/**
	 * CreateUserCommand constructor.
	 *
	 * @param UserManagerInterface $userManager
	 */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
        parent::__construct(null);
    }

    protected function configure()
    {
        $this
            ->setName('create:user')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('email', InputArgument::OPTIONAL, 'Enter email address:')
            ->addArgument('password', InputArgument::OPTIONAL, 'Enter password:')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $plainPassword = $input->getArgument('password');
        $user = $this->userManager->createUser();
        $user->setEmail($email);
        $user->setPlainPassword($plainPassword);
        $this->userManager->save($user, true);
        $io->success('User has been successfully created!');
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = [];
        if (!$input->getArgument('email')) {
            $question = new Question('Please choose a email:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty and must be valid email address');
                }

                return $email;
            });
            $questions['email'] = $question;
        }
        if (!$input->getArgument('password')) {
            $question = new Question('Please choose a password:');
            $question->setValidator(function ($plainPassword) {
                if (empty($plainPassword)) {
                    throw new \Exception('Password can not be empty');
                }

                return $plainPassword;
            });
            $questions['password'] = $question;
        }
        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}
