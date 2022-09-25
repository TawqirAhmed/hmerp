<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Artisan;

class BackupInfoController extends Controller
{
    public function our_backup_database()
    {

        //ENTER THE RELEVANT INFO BELOW
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $backup_name        = "mybackup.sql";
        $tables             = array("advancedsalestoapprove","alltotals","approvedadvancedsales","approvedsales","civils","civilsbalance","civilsview","customers","failed_jobs","icts","ictsbalance","ictsview","mhins","mhouts","migrations","occs","occsbalance","occsview","others","othersbalance","othersview","password_resets","productout","products","productspurchase","profits","salestoapprove","stockouts","suppliers","supplies","suppliesbalance","suppliesview","users","user_roles"); //here your tables...

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();


        $output = '';
        foreach($tables as $table)
        {
         $show_table_query = "SHOW CREATE TABLE " . $table . "";
         $statement = $connect->prepare($show_table_query);
         $statement->execute();
         $show_table_result = $statement->fetchAll();

         foreach($show_table_result as $show_table_row)
         {
          $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
         }
         $select_query = "SELECT * FROM " . $table . "";
         $statement = $connect->prepare($select_query);
         $statement->execute();
         $total_row = $statement->rowCount();

         for($count=0; $count<$total_row; $count++)
         {
          $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
          $table_column_array = array_keys($single_result);
          $table_value_array = array_values($single_result);
          $output .= "\nINSERT INTO $table (";
          $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
          $output .= "'" . implode("','", $table_value_array) . "');\n";
         }
        }
        $file_name = 'ERP_database_backup_on_' . date('y-m-d') . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
           header('Pragma: public');
           header('Content-Length: ' . filesize($file_name));
           ob_clean();
           flush();
           readfile($file_name);
           unlink($file_name);


    }

    public function lol()
    {
      return view('auth.passwords.lol');
    }



    public function backupdb () {
      $DbName             = env('DB_DATABASE');
      $get_all_table_query = "SHOW TABLES ";
      $result = DB::select(DB::raw($get_all_table_query));

      $prep = "Tables_in_$DbName";
      foreach ($result as $res){
          $tables[] =  $res->$prep;
      }



      $connect = DB::connection()->getPdo();

      $get_all_table_query = "SHOW TABLES";
      $statement = $connect->prepare($get_all_table_query);
      $statement->execute();
      $result = $statement->fetchAll();


      $output = '';
      foreach($tables as $table)
      {
          $show_table_query = "SHOW CREATE TABLE " . $table . "";
          $statement = $connect->prepare($show_table_query);
          $statement->execute();
          $show_table_result = $statement->fetchAll();

          foreach($show_table_result as $show_table_row)
          {
              $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
          }
          $select_query = "SELECT * FROM " . $table . "";
          $statement = $connect->prepare($select_query);
          $statement->execute();
          $total_row = $statement->rowCount();

          for($count=0; $count<$total_row; $count++)
          {
              $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
              $table_column_array = array_keys($single_result);
              $table_value_array = array_values($single_result);
              $output .= "\nINSERT INTO $table (";
              $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
              $output .= "'" . implode("','", $table_value_array) . "');\n";
          }
      }
      $file_name = 'HMG_ERP_database_backup_on_' . date('y-m-d') . '.sql';
      $file_handle = fopen($file_name, 'w+');
      fwrite($file_handle, $output);
      fclose($file_handle);
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . basename($file_name));
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file_name));
      ob_clean();
      flush();
      readfile($file_name);
      unlink($file_name);

  }

  public function download(){

     Artisan::call('backup:run');
     // return redirect()->back();
      $path = storage_path('app/HMG-ERP/*');
     $latest_ctime = 0;
     $latest_filename = '';
     $files = glob($path);
     foreach($files as $file)
     {
             if (is_file($file) && filectime($file) > $latest_ctime)
             {
                     $latest_ctime = filectime($file);
                     $latest_filename = $file;
             }
     }
     return response()->download($latest_filename);
 }


}




// "advancedsalestoapprove","alltotals","approvedadvancedsales","approvedsales","civils","civilsbalance","civilsview","customers","failed_jobs","icts","ictsbalance","ictsview","mhins","mhouts","migrations","occs","occsbalance","occsview","others","othersbalance","othersview","password_resets","productout","products","productspurchase","profits","salestoapprove","stockouts","suppliers","supplies","suppliesbalance","suppliesview","users","user_roles"
