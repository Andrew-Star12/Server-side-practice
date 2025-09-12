<?php
namespace Controller;
use Illuminate\Database\Capsule\Manager as DB;
use Src\View;
use Model\User;
use Src\Request;
use Src\Auth\Auth;
use Model\Staff;
use Model\Department;
use Model\Discipline;
use Model\DisciplineStaff;
class Site
{
    public function index(): string
    {
        $posts = DB::table('posts')->get();
        return (new View())->render('site.post', ['posts' =>
            $posts]);
    }
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
    public function signup(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all()))
        {
            app()->route->redirect('/login');
        }
        return new View('site.signup');
    }
    public function login(Request $request): string
    {
//Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
//Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        return new View('site.login', ['message' => 'Неправильные логинили пароль']);
    }
    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
    public function addStaff(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            // Валидация может быть добавлена здесь
            if (Staff::create($data)) {
                return new View('site.staff-add', ['message' => 'Сотрудник успешно добавлен']);
            }

            return new View('site.staff-add', ['message' => 'Ошибка при добавлении сотрудника']);
        }

        return new View('site.staff-add'); // Показываем форму, если GET
    }
    public function addDepartment(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            if (!empty($data['name']) && Department::create(['name' => $data['name']])) {
                return new View('site.department-add', ['message' => 'Кафедра успешно добавлена']);
            }

            return new View('site.department-add', ['message' => 'Ошибка при добавлении кафедры']);
        }

        return new View('site.department-add');
    }

    public function addDiscipline(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            if (!empty($data['name']) && Discipline::create(['name' => $data['name']])) {
                return new View('site.discipline-add', ['message' => 'Дисциплина успешно добавлена']);
            }

            return new View('site.discipline-add', ['message' => 'Ошибка при добавлении дисциплины']);
        }

        return new View('site.discipline-add');
    }
    public function assignDiscipline(Request $request): string
    {
        $staff = Staff::all();
        $disciplines = Discipline::all();

        if ($request->method === 'POST') {
            $data = $request->all();

            if (!empty($data['staff_id']) && !empty($data['discipline_id'])) {
                DisciplineStaff::create([
                    'staff_id' => $data['staff_id'],
                    'discipline_id' => $data['discipline_id']
                ]);

                return new View('site.assign-discipline', [
                    'message' => 'Сотрудник успешно прикреплён к дисциплине',
                    'staff' => $staff,
                    'disciplines' => $disciplines
                ]);
            }

            return new View('site.assign-discipline', [
                'message' => 'Ошибка: не выбраны сотрудник или дисциплина',
                'staff' => $staff,
                'disciplines' => $disciplines
            ]);
        }

        return new View('site.assign-discipline', [
            'staff' => $staff,
            'disciplines' => $disciplines
        ]);
    }

    public function listStaff(): string
    {
        $staff = Staff::with('department')->get(); // Загружаем сотрудников вместе с кафедрами
        return new View('site.staff-list', ['staff' => $staff]);
    }


}