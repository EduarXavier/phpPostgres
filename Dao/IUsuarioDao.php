<?php

namespace Dao;

use modelos\Persona;

interface IUsuarioDao
{
    public function verUsuario(int $id) : ?Persona;
    public function findByDocumento(?string $documento): ?Persona;
    public function verClientes() : ?array;
    public function verUsuarios() : ?array;
    public function addUsuario(Persona $usuario): ?bool;
    public function actualizarUsuario(Persona $usuario): ?bool;
    public  function eliminarUsuario(int $id): ?bool;
    public function login(string $correo, string $clave): ?Persona;

}