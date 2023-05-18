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
		if($_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE mahasiswa set
											 	matkul = '$_POST[tmatkul]',
											 	deks = '$_POST[tdeks]',
												kode = '$_POST[tkode]',
												dosen = '$_POST[tdosen]'
											 WHERE id_mhs = '$_GET[id]'
										   ");
			if($edit) //jika edit sukses
			{
				header('Location: index.php?id='.$_GET['id'].'&status=create_success');
			}
			else
			{
				header('Location: index.php?id='.$_GET['id'].'&status=gagal');
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO mahasiswa (matkul, deks, kode, dosen)
										  VALUES ('$_POST[tmatkul]', 
										  		 '$_POST[tdeks]',
												'$_POST[tkode]',
												'$_POST[tdosen]')
										 ");
			if($simpan) //jika simpan sukses
			{
				header('Location: index.php?id='.$_GET['id'].'&status=create_success');
			}
			else
			{
				header('Location: index.php?id='.$_GET['id'].'&status=gagal');
			}
		}


		
	}


	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id_mhs = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
				$vmatkul = $data['matkul'];
				$vdeks = $data['deks'];
				$vkode = $data['kode'];
				$vdosen = $data['dosen'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id_mhs = '$_GET[id]' ");
			if($hapus){
				header('Location: index.php?id='.$_GET['id'].'&status=create_success');
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
	    		<label>Mata Kuliah</label>
	    		<input type="text" name="tmatkul" value="<?=@$vmatkul?>" class="form-control" placeholder="Input Mata Kuliah" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Deksripsi</label>
	    		<input type="text" name="tdeks" value="<?=@$vdeks?>" class="form-control" placeholder="Input Deksripsi" required>
	    	</div>
			<div class="form-group">
	    		<label>Kode</label>
	    		<input type="text" name="tkode" value="<?=@$vkode?>" class="form-control" placeholder="Input Kode" required>
	    	</div>
			<div class="form-group">
	    		<label>Dosen</label>
	    		<input type="text" name="tdosen" value="<?=@$vdosen?>" class="form-control" placeholder="Input Nama Dosen" required>
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
	    Daftar Mata Kuliah & Deksripsi
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Mata Kuliah</th>
	    		<th>Deksripsi</th>
				<th>Kode</th>
	    		<th>Dosen</th>
	    		<th>Aksi</th>
	    	</tr>
	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from mahasiswa order by id_mhs desc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['matkul']?></td>
	    		<td><?=$data['deks']?></td>
				<td><?=$data['kode']?></td>
	    		<td><?=$data['dosen']?></td>
	    		<td>
	    			<a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning"> Edit </a>
					<a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" 
	    			   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
					<a href="index1.php?id=<?= $data['id_mhs']?>"> Daftar Materi </a>
	    		</td>
	    	</tr>
	    <?php endwhile; //penutup perulangan while ?>
	    </table>
	  </div>
	</div>
	<!-- Akhir Card Tabel -->


</body>
</html>