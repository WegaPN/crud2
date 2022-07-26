<!DOCTYPE html>
<html>
<head>
    <title>CRUD</title>
</head>
<body>

<?php

$koneksi = mysqli_connect("localhost","root","kopi","kasir") or die(mysqli_error());

function tambah($koneksi){
    
    if (isset($_POST['btn_simpan'])){
        $id = time();
        $nm_makanan = $_POST['nm_makanan'];
        $harga = $_POST['harga'];
        $quantity = $_POST['quantity'];
        $tgl_pesanan = $_POST['tgl_pesanan'];
        
        if(!empty($nm_makanan) && !empty($harga) && !empty($quantity) && !empty($tgl_pesanan)){
            $sql = "INSERT INTO tabel_panen (id,nama_makanan, hasil_panen, lama_tanam, tanggal_panen) VALUES(".$id.",'".$nm_makanan."','".$harga."','".$quantity."','".$tgl_pesanan."')";
            $simpan = mysqli_query($koneksi, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: index.php');
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
        <form action="" method="POST">
            <fieldset>
                <legend><h2>Tambah data</h2></legend>
                <label>Nama makanan <input type="text" name="nm_makanan" /></label> <br>
                <label>harga panen <input type="number" name="harga" /> kg</label><br>
                <label>quantity tanam <input type="number" name="quantity" /> bulan</label> <br>
                <label>Tanggal panen <input type="date" name="tgl_pesanan" /></label> <br>
                <br>
                <label>
                    <input type="submit" name="btn_simpan" value="Simpan"/>
                    <input type="reset" name="reset" value="Besihkan"/>
                </label>
                <br>
                <p><?php echo isset($pesan) ? $pesan : "" ?></p>
            </fieldset>
        </form>
    <?php
}

function tampil_data($koneksi){
    $sql = "SELECT * FROM tabel_panen";
    $query = mysqli_query($koneksi, $sql);
    
    echo "<fieldset>";
    echo "<legend><h2>Data Panen</h2></legend>";
    
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>ID</th>
            <th>Nama makanan</th>
            <th>harga Panen</th>
            <th>quantity Tanam</th>
            <th>Tanggal Panen</th>
            <th>Tindakan</th>
          </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['nama_makanan']; ?></td>
                <td><?php echo $data['hasil_panen']; ?> Kg</td>
                <td><?php echo $data['lama_tanam']; ?> bulan</td>
                <td><?php echo $data['tanggal_panen']; ?></td>
                <td>
                    <a href="index.php?aksi=update&id=<?php echo $data['id']; ?>&nama=<?php echo $data['nama_makanan']; ?>&harga=<?php echo $data['hasil_panen']; ?>&quantity=<?php echo $data['lama_tanam']; ?>&tanggal=<?php echo $data['tanggal_panen']; ?>">Ubah</a> |
                    <a href="index.php?aksi=delete&id=<?php echo $data['id']; ?>">Hapus</a>
                </td>
            </tr>
        <?php
    }
    echo "</table>";
    echo "</fieldset>";
}

function ubah($koneksi){
    // ubah data
    if(isset($_POST['btn_ubah'])){
        $id = $_POST['id'];
        $nm_makanan = $_POST['nm_makanan'];
        $harga = $_POST['harga'];
        $quantity = $_POST['quantity'];
        $tgl_pesanan = $_POST['tgl_pesanan'];
        
        if(!empty($nm_makanan) && !empty($harga) && !empty($quantity) && !empty($tgl_pesanan)){
            $perubahan = "nama_makanan='".$nm_makanan."',hasil_panen=".$harga.",lama_tanam=".$quantity.",tanggal_panen='".$tgl_pesanan."'";
            $sql_update = "UPDATE tabel_panen SET ".$perubahan." WHERE id=$id";
            $update = mysqli_query($koneksi, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: index.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    

    if(isset($_GET['id'])){
        ?>
            <a href="index.php"> &laquo; Home</a> | 
            <a href="index.php?aksi=create"> (+) Tambah Data</a>
            <hr>
            
            <form action="" method="POST">
            <fieldset>
                <legend><h2>Ubah data</h2></legend>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
                <label>Nama makanan <input type="text" name="nm_makanan" value="<?php echo $_GET['nama'] ?>"/></label> <br>
                <label>harga <input type="number" name="harga" value="<?php echo $_GET['harga'] ?>"/> Rp</label><br>
                <label>quantity tanam <input type="number" name="quantity" value="<?php echo $_GET['quantity'] ?>"/> </label> <br>
                <label>Tanggal pesanan <input type="date" name="tgl_pesanan" value="<?php echo $_GET['tanggal'] ?>"/></label> <br>
                <br>
                <label>
                    <input type="submit" name="btn_ubah" value="Simpan Perubahan"/> atau <a href="index.php?aksi=delete&id=<?php echo $_GET['id'] ?>"> Hapus Data</a>!
                </label>
                <br>
                <p><?php echo isset($pesan) ? $pesan : "" ?></p>
                
            </fieldset>
            </form>
        <?php
    }
    
}

function hapus($koneksi){
    if(isset($_GET['id']) && isset($_GET['aksi'])){
        $id = $_GET['id'];
        $sql_hapus = "DELETE FROM tabel_panen WHERE id=" . $id;
        $hapus = mysqli_query($koneksi, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                header('location: index.php');
            }
        }
    }
    
}

if (isset($_GET['aksi'])){
    switch($_GET['aksi']){
        case "create":
            echo '<a href="index.php"> &laquo; Home</a>';
            tambah($koneksi);
            break;
        case "read":
            tampil_data($koneksi);
            break;
        case "update":
            ubah($koneksi);
            tampil_data($koneksi);
            break;
        case "delete":
            hapus($koneksi);
            break;
        default:
            echo "<h3>Aksi <i>".$_GET['aksi']."</i> tidaka ada!</h3>";
            tambah($koneksi);
            tampil_data($koneksi);
    }
} else {
    tambah($koneksi);
    tampil_data($koneksi);
}
?>
</body>
</html>