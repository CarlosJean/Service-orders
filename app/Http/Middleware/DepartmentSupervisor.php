<?php

namespace App\Http\Middleware;

use App\Enums\SystemRoles;
use App\Repositories\EmployeeRepository;
use App\Repositories\MenuRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentSupervisor
{
    public function __construct(
        protected EmployeeRepository $employeeRepository,
        protected MenuRepository $menuRepository
    ) {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = auth()->id();
        $employee = $this->employeeRepository->employeeByUserId($userId);

        $roleId = $employee['roleId'];

        $this->menuRepository->userHasSubmenu($roleId, $request->url());

        return $next($request);
    }
}
