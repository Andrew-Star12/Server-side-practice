<?php

use PHPUnit\Framework\TestCase;
use Controller\Site;
use Src\Request;
use Src\View;
use Model\User;

class SiteSignupTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Мок для редиректа (app()->route->redirect)
        if (!function_exists('app')) {
            function app() {
                return new class {
                    public $route;
                    public function __construct() {
                        $this->route = new class {
                            public $redirectedTo = null;
                            public function redirect($url) {
                                $this->redirectedTo = $url;
                            }
                        };
                    }
                };
            }
        }
    }

    public function testSignupWithEmptyDataShowsErrors()
    {
        $site = new Site();

        // Симуляция запроса POST с пустыми данными
        $request = new Request([
            'method' => 'POST',
            'name' => '',
            'login' => '',
            'password' => ''
        ]);

        $response = $site->signup($request);

        $this->assertInstanceOf(View::class, $response);
        $this->assertArrayHasKey('errors', $response->data);
        $this->assertArrayHasKey('name', $response->data['errors']);
        $this->assertArrayHasKey('login', $response->data['errors']);
        $this->assertArrayHasKey('password', $response->data['errors']);
    }

    public function testSignupWithValidDataRedirectsToLogin()
    {
        $site = new Site();

        // Мок модели User
        $userMock = $this->getMockBuilder(User::class)
            ->onlyMethods(['create'])
            ->getMock();

        $userMock->expects($this->once())
            ->method('create')
            ->willReturn(true);

        // Заменяем User на мок через alias (или через DI контейнер в реальном проекте)
        class_alias(get_class($userMock), 'Model\User');

        // Симуляция запроса POST с валидными данными
        $request = new Request([
            'method' => 'POST',
            'name' => 'Иван',
            'login' => 'ivan123',
            'password' => '12345678'
        ]);

        $response = $site->signup($request);

        // Метод возвращает false при успешной регистрации
        $this->assertFalse($response);

        // Проверяем редирект
        $this->assertEquals('/login', app()->route->redirectedTo);
    }
}
