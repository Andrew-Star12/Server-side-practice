<?php
namespace Controller;

use FileUploader\FileUploader;
use Src\View;
use Src\Request;
use Model\Staff;
use Model\Department;
use Src\Validator\SimpleValidator;

class StaffController
{
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
    public function editStaff($id, Request $request): string
    {
        $staff = Staff::find($id);
        if (!$staff) {
            return new View('errors.404', ['message' => 'Сотрудник не найден']);
        }

        $departments = Department::all();

        if ($request->method === 'POST') {
            $data = $request->all();

            $validator = new SimpleValidator($data, [
                'lastname'      => ['not_empty', 'min:2'],
                'firstname'     => ['not_empty', 'min:2'],
                'gender'        => ['not_empty'],
                'birthdate'     => ['not_empty'],
                'position'      => ['not_empty'],
                'department_id' => ['not_empty'],
            ]);

            if ($validator->fails()) {
                return new View('site.staff-edit', [
                    'staff'       => $staff,
                    'departments' => $departments,
                    'errors'      => $validator->errors(),
                    'old'         => $data
                ]);
            }

            $staff->update($data);

            return new View('site.staff-edit', [
                'staff'       => $staff->fresh(),
                'departments' => $departments,
                'message'     => 'Данные сотрудника успешно обновлены'
            ]);
        }

        return new View('site.staff-edit', [
            'staff'       => $staff,
            'departments' => $departments,
        ]);
    }

    public function listStaff(Request $request): string
    {
        $query = Staff::with('department');

        if ($request->get('department_id')) {
            $query->where('department_id', $request->get('department_id'));
        }

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
}
