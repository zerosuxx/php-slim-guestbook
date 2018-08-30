<?php
namespace Test\Dao;

use Guestbook\Dao\PDOFactory;
use PHPUnit\Framework\TestCase;

class PDOFactoryTest extends TestCase
{
    /**
     * @var PDOFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new PDOFactory();
    }

    /**
     * @test
     */
    public function getPDO_WithEnvConfig_ReturnsSamePDOInstance() {
        $pdo = $this->factory->getPDO();
        $this->assertInstanceOf(\PDO::class, $this->factory->getPDO());
        $this->assertSame($pdo, $this->factory->getPDO());
    }

    /**
     * @test
     */
    public function getPDOWithoutDatabase_WithEnvConfig_ReturnsSamePDOInstanceWithoutUseDatabase() {
        $pdo = $this->factory->getPDOWithoutDatabase();
        $result = $pdo->query('SELECT DATABASE() AS db')->fetch();
        $this->assertInstanceOf(\PDO::class, $pdo);
        $this->assertNull($result['db']);
        $this->assertSame($pdo, $this->factory->getPDOWithoutDatabase());
    }
}
