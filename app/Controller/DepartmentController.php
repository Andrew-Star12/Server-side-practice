<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Department;
use Src\Validator\SimpleValidator;

class DepartmentController
{
    public function addDepartment(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            $validator = new SimpleValidator($data, [
                'name' => ['not_empty', 'min:2']
            ]);

            if ($validator->fails()) {
                return new View('site.department-add', [
                    'errors' => $validator->errors(),
                    'old'    => $data
                ]);
            }

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
}
