<?php

namespace Test\Form;

use Guestbook\Filter\EmailFilter;
use Guestbook\Filter\StringFilter;
use Guestbook\Form\Form;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;

/**
 * Class FormTest
 * @package Test\Form
 */
class FormTest extends TestCase
{

    /**
     * @var Form
     */
    private $form;
    
    protected function setUp()
    {
        $this->form = new Form();
    }

    /**
     * @test
     */
    public function handle_GivenSomeInputAndRequest_ReturnsFilteredData()
    {
        $mockRequest = $this->createMock(ServerRequestInterface::class);
        $mockRequest
            ->expects($this->once())
            ->method('getParsedBody')
            ->willReturn([
                'name' => 'Test name<br>',
                'email' => 'test@test.test()',
                'message' => 'Test message<br>',
            ]);

      

        $this->form->input('name', new StringFilter());
        $this->form->input('email', new EmailFilter());
        $this->form->input('message', new StringFilter());

        $data = $this->form->handle($mockRequest)->getData();
        $this->assertCount(3, $data);
        $this->assertEquals('Test name', $data['name']);
        $this->assertEquals('test@test.test', $data['email']);
        $this->assertEquals('Test message', $data['message']);
    }

    /**
     * @test
     */
    public function handle_GivenSomeInputAndRequestWithoutInputDatas_ReturnsDataWithNullValues()
    {
        $mockRequest = $this->createMock(ServerRequestInterface::class);
        $mockRequest
            ->expects($this->once())
            ->method('getParsedBody')
            ->willReturn([
                'not-exists' => null
            ]);

        $this->form->input('name', new StringFilter());
        $this->form->input('email', new EmailFilter());
        $this->form->input('message', new StringFilter());

        $data = $this->form->handle($mockRequest)->getData();
        $this->assertCount(3, $data);
        $this->assertEquals('', $data['name']);
        $this->assertEquals('', $data['email']);
        $this->assertEquals('', $data['message']);
    }

    /**
     * @test
     */
    public function add_GivenSameInputs_ThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->form->input('name', new StringFilter());
        $this->form->input('name', new StringFilter());
    }
}