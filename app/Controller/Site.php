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
use Src\Validator\Validator;
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
        if ($request->method === 'POST') {
            $data = $request->all();

            // Хэшируем пароль через md5
            if (!empty($data['password'])) {
                $data['password'] = md5($data['password']);
            }

            if (User::create($data)) {
                app()->route->redirect('/login');
            }
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
        // Получаем список кафедр для формы
        $departments = Department::all();

        if ($request->method === 'POST') {
            $data = $request->all();

            if (Staff::create($data)) {
                return new View('site.staff-add', [
                    'message' => 'Сотрудник успешно добавлен',
                    'departments' => $departments,
                ]);
            }

            return new View('site.staff-add', [
                'message' => 'Ошибка при добавлении сотрудника',
                'departments' => $departments,
            ]);
        }

        // GET-запрос: просто показываем форму с кафедрами
        return new View('site.staff-add', [
            'departments' => $departments,
        ]);
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

    public function listStaff(\Src\Request $request): string
    {
        $query = Staff::with('department');

        // Если в запросе есть department_id, фильтруем
        if ($request->get('department_id')) {
            $query->where('department_id', $request->get('department_id'));
        }

        $staff = $query->get();
        $departments = Department::all(); // Список всех кафедр для формы фильтрации

        return new View('site.staff-list', [
            'staff' => $staff,
            'departments' => $departments,
            'selectedDepartment' => $request->get('department_id') // передаём выбранную кафедру в шаблон
        ]);
    }
    public function listDisciplines(\Src\Request $request): string
    {
        $departmentId = $request->get('department_id');

        // Запрос дисциплин, читаемых сотрудниками (по кафедре, если указана)
        $query = \Model\Discipline::with(['staff']);

        if ($departmentId) {
            $query->whereHas('staff', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $disciplines = $query->get();
        $departments = \Model\Department::all();

        return new \Src\View('site.discipline-list', [
            'disciplines' => $disciplines,
            'departments' => $departments,
            'selectedDepartmentId' => $departmentId
        ]);
    }

    public function addDeanStaff(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            if (!empty($data['login']) && !empty($data['password'])) {
                $data['role'] = 'dean_staff';
                $data['password'] = md5($data['password']);

                if (User::create($data)) {
                    return new View('site.deanstaff-add', ['message' => 'Сотрудник деканата добавлен']);
                }
            }

            return new View('site.deanstaff-add', ['message' => 'Ошибка при добавлении']);
        }

        return new View('site.deanstaff-add');
    }



}