<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Discipline;
use Model\Staff;
use Model\Department;
use Model\DisciplineStaff;
use Src\Validator\SimpleValidator;

class DisciplineController
{
    public function addDiscipline(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            $validator = new SimpleValidator($data, [
                'name' => ['not_empty', 'min:2']
            ]);

            if ($validator->fails()) {
                return new View('site.discipline-add', [
                    'errors' => $validator->errors(),
                    'old'    => $data
                ]);
            }

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

    public function listDisciplines(Request $request): string
    {
        $departmentId = $request->get('department_id');

        $query = Discipline::with(['staff']);

        if ($departmentId) {
            $query->whereHas('staff', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $disciplines = $query->get();
        $departments = Department::all();

        return new View('site.discipline-list', [
            'disciplines' => $disciplines,
            'departments' => $departments,
            'selectedDepartmentId' => $departmentId
        ]);
    }
}
