<?php


namespace App\Http\Interfaces;


interface RepositoryInterface
{

    public function index();

    public function create(array $data);

    public function update(array $data, $id);

    public function edit($id);

    public function destroy($id);
}
