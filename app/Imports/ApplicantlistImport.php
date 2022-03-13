<?php

namespace App\Imports;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ApplicantlistImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
         return new User([
            'id'     => $row['id'],
            'firstName'    => $row['email'], 
            'lastName'    => $row['email'], 
            'username'    => $row['email'], 
            'rolesId'    => $row['email'], 
            'email'    => $row['email'], 
            'password' => \Hash::make($row['password']),
        ]);
    }
}
