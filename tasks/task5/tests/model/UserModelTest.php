<?php

require '../bootstrap.php';

use App\Bootstrap;
use Nette\DI\Container;
use Tester\Assert;
use Tester\Environment;
use App\Model\UserModel;

/**
 * TEST: Test class for UserModel
 * @testCase
 */

class UserModelTestCase extends Tester\TestCase {

    private $database;
    private $userModel;

    public function __construct(Container $container) {
        $this->database = $container->getByType('Nette\Database\Context');
        $this->userModel = new UserModel($this->database);
    }

    public function setUp() {
        Environment::lock('database', __DIR__ . '/../../temp');
    }

    /**
     * @dataProvider getAddUserData
     * @param $userToAdd
     * @param $result
     * @throws Exception
     */
    public function testAddUser($userToAdd, $result) {
        $addedUser = $this->userModel->insertUser($userToAdd);

        if ($result) {
            Assert::type('integer', $addedUser);
        } else {
            Assert::null($addedUser);
        }
    }

    public function getAddUserData() {
        return [
            [
                [
                    'surname' => 'Taro',
                    'firstname' => 'Tomáš',
                    'is_admin' => true,
                    'pid_id' => 1,
                    'phone' => '721359909',
                    'personal_number' => '960527'
                ],
                true
            ],
            [
                [
                    'surname' => null,
                    'firstname' => 'Tomáš',
                    'registered' => false,
                    'is_admin'   => null,
                ],
                false
            ],
            [
                true,
                false
            ],
        ];
    }


    /*
    public function testEditUser() {
        $users = $this->userModel->listUsers();

        echo "";

    }
    */

    /*
    public function getEditUserData() {

    }


    public function testRemoveUser() {

    }
    */

    public function tearDown() {
        // Reset DB to its default state
        $this->database->query(file_get_contents(__DIR__ . '/../../sql/init.sql'));
    }
}

$container = Bootstrap::getContainer();

$test = new UserModelTestCase($container);
$test->run();