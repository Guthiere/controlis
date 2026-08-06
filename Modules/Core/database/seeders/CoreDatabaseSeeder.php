<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\AdministrativeStructure;
use Modules\Core\Models\Position;
use Modules\Core\Models\Employee;
use Spatie\Permission\Models\Role;

class CoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Estructura Administrativa Base (Sede Central)
        $sedeCentral = AdministrativeStructure::create([
            'nombre' => 'Sede Central',
            'tipo' => 'Sede',
            'parent_id' => null,
        ]);

        $departamentoIT = AdministrativeStructure::create([
            'nombre' => 'Departamento de TI',
            'tipo' => 'Departamento',
            'parent_id' => $sedeCentral->id,
        ]);

        // 2. Crear Puestos iniciales
        $puestoAdmin = Position::create([
            'nombre' => 'Administrador de Sistemas',
            'administrative_structure_id' => $departamentoIT->id,
        ]);

        // 3. Crear Empleado Inicial (Vinculado al puesto)
        Employee::create([
            'dni' => '12345678',
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'email' => 'juan.perez@controlis.com',
            'telefono' => '999888777',
            'position_id' => $puestoAdmin->id,
        ]);

        // 4. SEED DE ROLES (Fase 2)
        $this->seedRoles();
    }

    /**
     * Seed the essential roles and permissions for the ecosystem.
     */
    private function seedRoles(): void
    {
        // 1. Definición de Permisos funcionales
        $permissions = [
            'requests.create',
            'requests.view_own',
            'requests.view',
            'requests.approve',
            'payments.process',
            'structure.manage',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::findOrCreate($permission, 'web');
        }

        // 2. Definición de Roles y sus permisos asociados (Matriz de Responsabilidad)
        $rolePermissions = [
            'Administrador'  => ['*'],
            'Jefe_Inmediato' => ['requests.view', 'requests ' . 'approve'],
            'Tesorería'      => ['payments.process', 'requests.view'],
            'Empleado'       => ['requests.create', 'requests.view_own'],
        ];

        foreach ($rolePermissions as $roleName => $perms) {
            $role = \Spatie\Permission\Models\Role::findOrCreate($roleName, 'web');

            if (!in_array('*', $perms)) {
                $role->syncPermissions($perms);
            } else {
                // Para el Admin, asignamos todos los permisos creados para asegurar acceso total
                $allPerms = \Spatie\Permission\Models\Permission::all();
                $role->syncPermissions($allPerms);
            }
        }
    }
}
