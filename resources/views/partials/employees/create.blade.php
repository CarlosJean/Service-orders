<form action="registro-empleado" method="post" class="p-1">
    @csrf
    <div class="row">
        <div class="col-6 form-group">
            <label for="txtIdentification">Documento de identificación</label>
            <input type="text" name="identification" id="txtIdentification" class="form-control" placeholder="Escriba el número de identificación" value="<?= old('identification') ?>">
            @if($errors->first('identification'))
            <span class="text-danger">
                <?= $errors->first('identification') ?>
            </span>
            @endif
        </div>
        <div class="col-6 form-group">
            <label for="txtEmail">Correo electrónico</label>
            <input type="email" name="email" id="txtEmail" class="form-control" placeholder="Escriba el correo electrónico" value="<?= old('email') ?>">
            @if($errors->first('email'))
            <span class="text-danger">
                <?= $errors->first('email') ?>
            </span>
            @endif
        </div>
        <div class="col-6 form-group">
            <label for="txtNames">Nombres del empleado</label>
            <input type="text" name="names" id="txtNames" class="form-control" placeholder="Nombres" value="<?= old('names') ?>">
            @if($errors->first('names'))
            <span class="text-danger">
                <?= $errors->first('names') ?>
            </span>
            @endif
        </div>
        <div class="col-6 form-group">
            <label for="txtLastNames">Apellidos del empleado</label>
            <input type="text" name="last_names" id="txtLastNames" class="form-control" placeholder="Apellidos" value="<?= old('last_names') ?>">
            @if($errors->first('last_names'))
            <span class="text-danger">
                <?= $errors->first('last_names') ?>
            </span>
            @endif
        </div>
        <div class="col-6 form-group">
            <label for="txtRole">Rol</label>
            <select id="slcRole" name="role_id" class="form-select">
                <option value="">Seleccione un rol</option>
                @foreach($roles as $role)
                @if($role-> id == old('role_id'))
                <option value="{{$role['id']}}" selected>{{$role['name']}}</option>
                @else
                <option value="{{$role['id']}}">{{$role['name']}}</option>
                @endif
                @endforeach
            </select>
            @if($errors->first('role_id'))
            <span class="text-danger">
                <?= $errors->first('role_id') ?>
            </span>
            @endif
        </div>
        <div class="col-6 form-group">
            <label for="txtDepartment">Departamento</label>
            <select id="slcDepartment" name="department_id" class="form-select">
                <option value="">Seleccione un departamento</option>
                @foreach($departments as $department)
                @if($department-> id == old('department_id'))
                <option value="{{$department['id']}}" selected>{{$department['name']}}</option>
                @else
                <option value="{{$department['id']}}">{{$department['name']}}</option>
                @endif
                @endforeach
            </select>
            @if($errors->first('department_id'))
            <span class="text-danger">
                <?= $errors->first('department_id') ?>
            </span>
            @endif
        </div>
        <div class="col-6 form-group m-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="create_user" checked>
                <label class="form-check-label" for="flexCheckDefault">
                    Crear usuario para este empleado
                </label>
            </div>
        </div>
        <div class="col-12 form-group">
            <div class="row justify-content-end">
                <button class="col-2 btn btn-secondary" type="reset">Limpiar</button>
                <div class="col-2">
                    <input type="submit" value="Guardar" class="btn btn-primary w-100">
                </div>
            </div>
        </div>
    </div>
</form>