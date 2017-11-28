<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
    <meta name="viewport" content="initial-scale=1">
	<title> CRUD With JavaScript</title>
	<link rel="stylesheet" href="<?php echo base_url().'assets/bootstrap.min.css'; ?>">
	<script type="text/javascript" src="<?php echo base_url().'assets/jquery.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/bootstrap.min.js'; ?>"></script>
	        <style type="text/css">
		body {	
			font-size: 1em;
			line-height: 1.5;
		}

		/*basic typography*/
		a,
		a:visited {
			text-decoration: underline;
		}

		a:hover {
			text-decoration: none;
		}

		p {
			font-family: Georgia, serif;
			color: #3e3c3c;
		}

		h1 {
			font-size: 3em;
			line-height: 1;
			letter-spacing: -0.05em;
			color: #252424;
			font-family: Helvetica, Arial, sans-serif;
		}

		/*strucutral*/
		section {
			width: 100%;
			max-width: 140em;
			margin: 0 auto;
		}

		footer {
			width: 95%;
			max-width: 50em;
			padding: 4em 0;
			margin: 4em auto;
			border-top: 1px solid #ccc;
		}

		/*once the viewport reaches 35ems width, make the base font size a wee bit bigger*/
		@media only screen and (min-width: 25em) {

			body {
				font-size: 1.5em;
			}
			
			section,
			footer {
				width: 100%;
			}
			
			h1 {
				font-size: 3em;
				color: #53bd84;
			}
			
		}
		</style>
</head>
<body onload="muatDaftarData();">
<section>
	<div class="col-md-8 col-md-offset-2" ng-controller="listContactCtrl">
		<div class="page-header">
			<h1> Website CRUD With Javascript </h1>
			<ul class="nav nav-tabs nav-justified">
				<li> <a id="nav-list-data" href="javascript:void(0
				);" onclick="gantiMenu('list-data');"> List Data </a> </li>
				<li> <a id="nav-tambah-data" href="javascript:void(0
				);" onclick="gantiMenu('tambah-data');"> Tambah Data </a> </li> 
			</ul>
		</div>

		<div id="tambah-data" class="well" style="display: none;">
			<form id="form-data">

				<div id="name-group" class="form-group">
					<label class="control-label"> Nama : </label>
					<input type="text" class="form-control" id="nama" name="nama" placeholder="masukan nama"> 
					<br>
				</div>

				<div id="alamat-group" class="form-group">
					<label class="control-label"> Alamat : </label>
					<input type="text" class="form-control" id="alamat" name="alamat" placeholder="masukan alamat">
					<br>
				</div>

				<div id="ket-group" class="form-group">
					<label class="control-label"> Keterangan : </label>
					<textarea name="ket" id="ket" class="form-control" placeholder="masukan keterangan"></textarea>
					<br>
				</div>

				<input type="button" value="Simpan" onclick="simpanData();" class="btn btn-info">
				<input type="reset" value="Cancel" onclick="" class="btn btn-warning">
			
			</form>
		</div>

		<div id="edit-data" class="well" style="display: none;">
			<form id="eform-data">
				
				<div id="name-group" class="form-group" style="display: none;">
					<label class="control-label"> Id Data : </label>
					<input type="text" class="form-control" id="eid_data" name="nama" placeholder="">
					<br>
				</div>
				
				<div id="name-group" class="form-group">
					<label class="control-label"> Nama : </label>
					<input type="text" class="form-control" id="enama" name="nama" placeholder="masukan nama">
					<br>
				</div>

				<div id="alamat-group" class="form-group">
					<label class="control-label"> Alamat : </label>
					<input type="text" class="form-control" id="ealamat" name="alamat" placeholder="masukan alamat">
					<br>
				</div>

				<div id="ket-group" class="form-group">
					<label class="control-label"> Keterangan : </label>
					<textarea class="form-control" id="eket" name="ket" placeholder="masukan keterangan"></textarea>
					<br>
				</div>

				<input type="button" value="Simpan" onclick="simpanEditData();" class="btn btn-info">
				<input type="reset" value="Cancel" onclick="" class="btn btn-warning">
				<input type="button" value="Back" onclick="gantiMenu('list-data');" class="btn btn-danger">
			</form>
		</div>
		
		<div id="list-data" class="well">
			Tidak ada data.. 
		</div>

	</div>
	</section>
</body>

<script type="text/javascript">
	function gantiMenu(menu){
		if (menu == "list-data"){
			muatDaftarData();
			$('#tambah-data').hide();
			$('#list-data').fadeIn();
		$('#edit-data').hide();
		}
		else if (menu == "tambah-data"){
					$('#tambah-data').fadeIn();
					$('#list-data').hide();
					$('#edit-data').hide();
		}
		else if (menu == "edit-data"){
			$('#edit-data').fadeIn();
			$('#tambah-data').hide();
			$('#list-data').hide();
		}
	}

	function muatDaftarData(){
		if (localStorage.daftar_data && localStorage.id_data){

			daftar_data = JSON.parse(localStorage.getItem('daftar_data'));

			var data_app = "";

			if (daftar_data.length > 0) {
				data_app = '<table class="table">';
				data_app += '<thead>'+
									'<th>ID</th>'+
									'<th>Nama</th>'+
									'<th>Alamat</th>'+
									'<th>Keterangan</th>'+
									'<th>Aksi</th>'+
									'</thead><tbody>';

			for (i in daftar_data){
				data_app += '<tr>';
				data_app += '<td>'+ daftar_data[i].id_data + ' </td>'+
							'<td>'+ daftar_data[i].nama + ' </td>'+
							'<td>'+ daftar_data[i].alamat + ' </td>'+
							'<td>'+ daftar_data[i].ket + ' </td>'+
							'<td colspan="2"><a class="btn btn-danger" href="javascript:void(0)" onclick="hapusData(\''+daftar_data[i].id_data+'\')">Hapus</a> ' +
							'<a class="btn btn-warning" href="javascript:void(0)" onclick="editData(\''+daftar_data[i].id_data+'\')">Edit</a></td>';
				data_app += '</tr>';
			}

			data_app += '</tbody></table>';

			}

			else {
				data_app = "Tidak ada data.. ";
			}

			$('#list-data').html(data_app);
			$('#list-data').hide();
			$('#list-data').fadeIn(100);
		}
	}

	
		function editData(id){
		
            if (localStorage.daftar_data && localStorage.id_data){
                daftar_data = JSON.parse(localStorage.getItem('daftar_data'));			
				idx_data = 0;
                for (i in daftar_data){
                    if (daftar_data[i].id_data == id){
						$("#eid_data").val(daftar_data[i].id_data);
						$("#enama").val(daftar_data[i].nama);
						$("#ealamat").val(daftar_data[i].alamat);
						$("#eket").val(daftar_data[i].ket);
						daftar_data.splice(idx_data, 1);
                    }
                    idx_data ++;
                }
				gantiMenu('edit-data');
				
            }
			
		}

	function simpanData(){
		nama = $('#nama').val();
		alamat = $('#alamat').val();
		ket = $('#ket').val();

		if (localStorage.daftar_data && localStorage.id_data){
			daftar_data = JSON.parse(localStorage.getItem('daftar_data'));
			id_data = parseInt(localStorage.getItem('id_data'));
		}
		else {
			daftar_data = [];
			id_data = 0;
		}

		id_data ++;
		daftar_data.push({'id_data':id_data, 'nama':nama, 'alamat':alamat, 'ket':ket});
		localStorage.setItem('daftar_data', JSON.stringify(daftar_data));
		localStorage.setItem('id_data', id_data);
		document.getElementById('form-data').reset();
		gantiMenu('list-data');

		return false;
	}

	function simpanEditData(){
            id_data = $('#eid_data').val();
            nama = $('#enama').val();
            alamat = $('#ealamat').val();
            ket = $('#eket').val();
            
            daftar_data.push({'id_data':id_data, 'nama':nama, 'alamat':alamat, 'ket':ket});
            localStorage.setItem('daftar_data', JSON.stringify(daftar_data));
            document.getElementById('eform-data').reset();
            gantiMenu('list-data');
            
            return false;
        }

	function hapusData(id){
		if (localStorage.daftar_data && localStorage.id_data){
			daftar_data = JSON.parse(localStorage.getItem('daftar_data'));

			idx_data = 0;
			var isConfirmed = confirm("Are you sure to delete this data?");
			for (i in daftar_data){
				if (isConfirmed, daftar_data[i].id_data == id){
					daftar_data.splice(idx_data, 1);
				}
				idx_data ++;
			}

			localStorage.setItem('daftar_data', JSON.stringify(daftar_data));
			muatDaftarData();
		}
	}
</script>
</html>