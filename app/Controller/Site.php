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
use Src\Validator\PasswordValidator;
use Src\Validator\SimpleValidator;
use Src\Validator\ImageValidator;
use FileUploader\FileUploader;
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

            // Проверка обычных правил
            $validator = new SimpleValidator($data, [
                'name'     => ['not_empty'],
                'login'    => ['not_empty', 'unique:users,login'],
                'password' => ['not_empty'],
            ]);

            $passwordValidator = new PasswordValidator($data['password'] ?? '');

            if ($validator->fails() || $passwordValidator->fails()) {
                $errors = $validator->errors();
                if ($passwordValidator->fails()) {
                    $errors['password'] = array_merge($errors['password'] ?? [], $passwordValidator->errors());
                }

                return new View('site.signup', [
                    'errors' => $errors,
                    'old'    => $data
                ]);
            }

            // Хэшируем и сохраняем
            $data['password'] = md5($data['password']);
            if (User::create($data)) {
                app()->route->redirect('/login');
            }
        }

        return new View('site.signup');
    }



    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        $data = $request->all();

        // Валидация полей логина и пароля
        $validator = new \Src\Validator\SimpleValidator($data, [
            'login'    => ['not_empty'],
            'password' => ['not_empty']
        ]);

        if ($validator->fails()) {
            return new View('site.login', [
                'errors' => $validator->errors(),
                'old'    => $data
            ]);
        }

        // Проверка авторизации
        if (\Src\Auth\Auth::attempt($data)) {
            app()->route->redirect('/hello');
        }

        return new View('site.login', [
            'message' => 'Неправильные логин или пароль',
            'old'     => $data
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
    public function addStaff(Request $request): string
    {
        $departments = Department::all();

        if ($request->method === 'POST') {
            $data = $request->all();

            // --- Правила для текстовых полей ---
            $rules = [
                'lastname'      => ['not_empty', 'min:2'],
                'firstname'     => ['not_empty', 'min:2'],
                'gender'        => ['not_empty'],
                'birthdate'     => ['not_empty'],
                'position'      => ['not_empty'],
                'department_id' => ['not_empty'],
            ];

            $validator = new SimpleValidator($data, $rules);
            if ($validator->fails()) {
                return new View('site.staff-add', [
                    'departments' => $departments,
                    'errors'      => $validator->errors(),
                    'old'         => $data
                ]);
            }

            // --- Проверка корректности даты ---
            $dateValidator = new \Src\Validator\DateValidator($data['birthdate']);
            if ($dateValidator->fails()) {
                return new View('site.staff-add', [
                    'departments' => $departments,
                    'errors'      => ['birthdate' => $dateValidator->errors()],
                    'old'         => $data
                ]);
            }

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploader = new FileUploader($_FILES['photo']);
                $filename = $uploader->save(dirname(__DIR__, 2) . '/public/uploads/staff');

                if ($filename) {
                    $data['photo'] = 'uploads/staff/' . $filename;
                } else {
                    return new View('site.staff-add', [
                        'departments' => $departments,
                        'errors' => ['photo' => $uploader->errors()],
                        'old' => $data
                    ]);
                }
            }


            // --- Сохранение ---
            if (Staff::create($data)) {
                return new View('site.staff-add', [
                    'message'     => 'Сотрудник успешно добавлен',
                    'departments' => $departments,
                ]);
            }

            return new View('site.staff-add', [
                'message'     => 'Ошибка при добавлении сотрудника',
                'departments' => $departments,
            ]);
        }

        return new View('site.staff-add', [
            'departments' => $departments,
        ]);
    }


    public function addDepartment(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            // Правила валидации
            $rules = [
                'name' => ['not_empty', 'min:2']
            ];

            // Создаём валидатор
            $validator = new \Src\Validator\SimpleValidator($data, $rules);

            if ($validator->fails()) {
                return new View('site.department-add', [
                    'errors' => $validator->errors(),
                    'old' => $data
                ]);
            }

            // Если валидация успешна — сохраняем в БД
            if (Department::create(['name' => $data['name']])) {
                return new View('site.department-add', [
                    'message' => 'Кафедра успешно добавлена'
                ]);
            }

            return new View('site.department-add', [
                'message' => 'Ошибка при добавлении кафедры'
            ]);
        }

        return new View('site.department-add');
    }

    public function addDiscipline(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            // Правила валидации
            $rules = [
                'name' => ['not_empty', 'min:2']
            ];

            // Валидатор
            $validator = new \Src\Validator\SimpleValidator($data, $rules);

            if ($validator->fails()) {
                return new View('site.discipline-add', [
                    'errors' => $validator->errors(),
                    'old'    => $data
                ]);
            }

            // Сохранение в БД
            if (Discipline::create(['name' => $data['name']])) {
                return new View('site.discipline-add', [
                    'message' => 'Дисциплина успешно добавлена'
                ]);
            }

            return new View('site.discipline-add', [
                'message' => 'Ошибка при добавлении дисциплины'
            ]);
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

        // Фильтр по кафедре
        if ($request->get('department_id')) {
            $query->where('department_id', $request->get('department_id'));
        }

        // Поиск по ФИО и должности
        if ($request->get('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('lastname', 'like', "%$search%")
                    ->orWhere('firstname', 'like', "%$search%")
                    ->orWhere('middlename', 'like', "%$search%")
                    ->orWhere('position', 'like', "%$search%");
            });
        }

        $staff = $query->get();
        $departments = Department::all();

        return new View('site.staff-list', [
            'staff' => $staff,
            'departments' => $departments,
            'selectedDepartment' => $request->get('department_id'),
            'search' => $request->get('search')
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

            // Правила валидации
            $rules = [
                'name'     => ['not_empty'],
                'login'    => ['not_empty', 'unique:users,login'],
                'password' => ['not_empty', 'min:6'],
            ];

            //Валидатор
            $validator = new SimpleValidator($data, $rules, [
                'name'     => 'Имя',
                'login'    => 'Логин',
                'password' => 'Пароль',
            ]);

            if ($validator->fails()) {
                return new View('site.deanstaff-add', [
                    'errors' => $validator->errors(),
                    'old'    => $data
                ]);
            }

            // Подготовка данных
            $data['role'] = 'dean_staff';
            $data['password'] = md5($data['password']);

            // Сохранение
            if (User::create($data)) {
                return new View('site.deanstaff-add', [
                    'message' => 'Сотрудник деканата успешно добавлен'
                ]);
            }

            return new View('site.deanstaff-add', [
                'message' => 'Ошибка при добавлении сотрудника'
            ]);
        }

        return new View('site.deanstaff-add');
    }




}