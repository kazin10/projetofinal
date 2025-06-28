<?php
   
   $dbHost = 'LocalHost';
   $dbUsername = 'root';
   $dbPassword = '';
   $dbName = 'login-usuarios';

   $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

   // if($conexao->connect_errno)
   // {
   //  echo "Error";
   // }
   // else
   // {
   //  echo "Conexão efetuada com sucesso";
   // }
?>