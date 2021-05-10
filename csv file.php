?php
//index.php
$connect = mysqli_connect("localhost", "root", "", "testing");
$message = '';

if(isset($_POST["upload"]))
{
 if($_FILES['passenger detail_file']['name'])
 {
  $filename = explode(".", $_FILES['passenger detail_file']['name']);
  if(end($filename) == "csv")
  {
   $handle = fopen($_FILES['passenger detail_file']['tmp_name'], "r");
   while($data = fgetcsv($handle))
   {
    $passenger detail_id = mysqli_real_escape_string($connect, $data[0]);
    $passenger detail_category = mysqli_real_escape_string($connect, $data[1]);  
                $passenger detail_name = mysqli_real_escape_string($connect, $data[2]);
    $passenger detail_price = mysqli_real_escape_string($connect, $data[3]);
    $query = "
     UPDATE daily_passenger detail 
     SET passenger detail_category = '$passenger detail_category', 
     passenger detail_name = '$passenger detail_name', 
     passenger detail_price = '$passenger detail_price' 
     WHERE passenger detail_id = '$passenger detail_id'
    ";
    mysqli_query($connect, $query);
   }
   fclose($handle);
   header("location: index.php?updation=1");
  }
  else
  {
   $message = '<label class="text-danger">Please Select CSV File only</label>';
  }
 }
 else
 {
  $message = '<label class="text-danger">Please Select File</label>';
 }
}

if(isset($_GET["updation"]))
{
 $message = '<label class="text-success">passenger detail Updation Done</label>';
}

$query = "SELECT * FROM daily_passenger detail";
$result = mysqli_query($connect, $query);
?> <!DOCTYPE html>
<html>
 <head>
  <title>CSV to Database</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
   <h2 align="center">Update Mysql Database through Upload CSV File using PHP</a></h2>
   <br />
   <form method="post" enctype='multipart/form-data'>
    <p><label>Please Select File(Only CSV Formate)</label>
    <input type="file" name="passenger detail_file" /></p>
    <br />
    <input type="submit" name="upload" class="btn btn-info" value="Upload" />
   </form>
   <br />
   <?php echo $message; ?>
   <h3 align="center">Deals of the Day</h3>
   <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped">
     <tr>
      <th>Category</th>
      <th>passenger detail Name</th>
      <th>passenger detail Price</th>
     </tr>
     <?php
     while($row = mysqli_fetch_array($result))
     {
      echo '
      <tr>
       <td>'.$row["passenger detail_category"].'</td>
       <td>'.$row["passenger detail_name"].'</td>
       <td>'.$row["passenger detail_price"].'</td>
      </tr>
      ';
     }
     ?>
    </table>
   </div>
  </div>
 </body>
</html>
