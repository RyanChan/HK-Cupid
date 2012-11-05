<?php


class IndexControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \Bisna\Application\Container\DoctrineContainer
     */
    protected $doctrineContainer;

    public static function dropSchema($params){
        if(file_exists($params['path'])){
            unlink($params['path']);
        }
    }

    public function getClassMetas($path, $namespace){
        $metas = array();
        if ($handle = opendir($path)){
            while(false !== ($file = readdir($handle))){
                if (strstr($file, '.php')){
                    list($class) = explode('.', $file);
                    $metas[] = $this->doctrineContainer->getEntityManager()->getClassMetadata($namespace.$class);
                }
            }
        }
        return $metas;
    }

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->bootstrap->bootstrap();
        $this->doctrineContainer = Zend_Registry::get('doctrine');

        self::dropSchema($this->doctrineContainer->getConnection()->getParams());

        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->doctrineContainer->getEntityManager());
        $metas = $this->getClassMetas(APPLICATION_PATH.'/../library/Champs/Entity', 'Champs\Entity\\');
        $tool->createSchema($metas);

        parent::setUp();
    }

    public function tearDown(){
        parent::tearDown();

        self::dropSchema($this->doctrineContainer->getConnection()->getParams());
    }

    public function testUserEntity(){
        $this->assertInstanceOf('Champs\Entity\User', new \Champs\Entity\User());
    }

    public function testUserEntitySave(){
        $u = new \Champs\Entity\User();
        $u->username = 'ming';
        $u->password = 'aoa';
        $u->password_salt = '123';

        $em  = $this->doctrineContainer->getEntityManager();
        $em->persist($u);
        $em->flush();

        $profiles = array(
            'email' => array(
                'key' => 'email',
                'value' => 'kimchan1314@gmail.com'
            ),
            'phone' => array(
                'key' => 'phone',
                'value' => '92148924'
            )
        );

        foreach ($profiles as $profile){
            $userProfile = new Champs\Entity\UserProfile();
            $userProfile->user = $u;
            $userProfile->profile_key = $profile['key'];
            $userProfile->profile_value = $profile['value'];
            $u->setProfile($userProfile);
            $em->persist($userProfile);
        }

        $em->flush();

        $users = $em->createQuery('select u from Champs\Entity\User u')->execute();
        $this->assertEquals(1, count($users));
        $this->assertEquals('ming', $users[0]->username);
        $this->assertEquals('aoa', $users[0]->password);
        $this->assertEquals('123', $users[0]->password_salt);
        $this->assertInstanceOf('\\DateTime', $users[0]->ts_created);
        $this->assertEquals(null, $users[0]->ts_last_updated);

//        $this->assertInstanceOf(, $users[0]->getProfile('email'));
//        $this->assertInstanceOf('Champs\Entity\UserProfile', $users[0]->getProfile('phone'));
        $this->assertEquals($profiles['email']['value'], $users[0]->getProfile('email'));
        $this->assertEquals($profiles['phone']['value'], $users[0]->getProfile('phone'));

        $users[0]->unsetProfile('phone');

        $em->flush();

        $this->assertEquals(null, $users[0]->getProfile('phone'));
    }
}

