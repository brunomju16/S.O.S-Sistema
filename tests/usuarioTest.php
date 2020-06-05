<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;


class UsuarioTest extends TestCase
{
    use TestCaseTrait;

    public function getConnection()
    {
      $pdo = new PDO("mysql:host=127.0.0.1;dbname=sos_sistemas","root", "");
      return $this->createDefaultDBConnection($pdo,'sos_sistemas');
    }

    public function getDataSet()
    {
       return $this->createXMLDataSet('tests/usuarios.xml');
    }

    public function testListaUsuarios()
    {
        $conn = $this->getConnection()->getConnection();
        $query = $conn->query('SELECT * FROM usuarios');
        $lista = $query->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(1,$lista);

       


    }



}
