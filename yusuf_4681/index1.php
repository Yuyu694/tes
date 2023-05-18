<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "yu";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));
	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if(isset($_GET['hal']) == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE materi set
												materi = '$_POST[tmateri]',
											 	deksmat = '$_POST[tdeksmat]'
											 WHERE id = '$_GET[id_materi]'
										   ");
			if($edit) //jika edit sukses
			{
				header('Location: index1.php?id='.$_GET['id'].'&status=create_success');
			}
			else
			{
				header('Location: index1.php?id='.$_GET['id'].'&status=gagal');
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO materi (materi, deksmat, id_mhs)
										  VALUES ('$_POST[tmateri]', 
										  		 '$_POST[tdeksmat]',
												 '$_GET[id]')
										 ");
			if($simpan) //jika simpan sukses
			{
				header('Location: index1.php?id='.$_GET['id'].'&status=create_success');
			}
			else
			{
				header('Location: index1.php?id='.$_GET['id'].'&status=gagal');
			}
		}


		
	}

	if (isset($_GET['id'])) {
		$id_mhs = $_GET['id'];
	}

	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM materi WHERE id = '$_GET[id_materi]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
				$vmateri = $data['materi'];
				$vdeksmat = $data['deksmat'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM materi WHERE id = '$_GET[id_materi]' ");
			if($hapus){
				header('Location: index1.php?id='.$_GET['id'].'&status=create_success');
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>CRUD 2020 PHP & MySQL + Bootstrap 4</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/css1/style1.scss">
</head>
<body>
<div class="container">

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Mata Kuliah & Materi Mahasiswa
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Materi</label>
	    		<input type="text" name="tmateri" value="<?=@$vmateri?>" class="form-control" placeholder="Input Materi" required>
	    	</div>
	    	<div class="form-group">
				<label>Deksripsi Materi</label>
				<input type="text" name="tdeksmat" value="<?=@$vdeksmat?>" class="form-control" placeholder="Input Materi" required>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Materi & Deksripsi
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Materi</th>
	    		<th>Deksripsi Materi</th>
	    		<th>Aksi</th>
	    	</tr>
	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from materi WHERE id_mhs=$_GET[id] order by id_mhs desc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['materi']?></td>
	    		<td><?=$data['deksmat']?></td>
	    		<td>
				<a href="index1.php?hal=edit&id=<?=$data['id_mhs']?>&id_materi=<?=$data['id']?>" class="btn btn-warning"> Edit </a>
				<a href="index1.php?hal=hapus&id=<?=$data['id_mhs']?>&id_materi=<?=$data['id']?>" 
                       onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
	    		</td>
	    	</tr>
	    <?php endwhile; //penutup perulangan while ?>
	    </table>
		<a href="index.php" class="previous">&laquo; Home</a>
	  </div>
	</div>
	<!-- Akhir Card Tabel -->

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>