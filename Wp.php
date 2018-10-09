<?php
/**
 *
 */
class Wp
{
  private $db;
  function __construct()
  {
    $this->db = new PDO('mysql:host=localhost; dbname=wp', "root", "");
  }

  public function get_data_kriteria(){
    $stmt = $this->db->prepare("SELECT*FROM kriteria ORDER BY id_kriteria");
    $stmt->execute();
		return $this->fetch($stmt);
  }

  public function get_data_alternative(){
    $stmt = $this->db->prepare("SELECT*FROM mahasiswa ORDER BY id_mahasiswa");
    $stmt->execute();
		return $this->fetch($stmt);
  }

  public function get_data_nilai_id($id){
    $stmt = $this->db->prepare("SELECT*FROM nilai WHERE id_mahasiswa='$id' ORDER BY id_kriteria");
    $stmt->execute();
		return $this->fetch($stmt);
  }

  public function fetch($query){
    while ($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
      $data[]= $fetch;
    }
    return $data;
  }

  public function get_data_mahasiswa(){
    $stmt = $this->db->prepare("SELECT * FROM mahasiswa ORDER BY id_mahasiswa");
    $stmt->execute();
		return $this->fetch($stmt);
  }

  public function total_s($bobot_baru){
    $data_mahasiswa_array=array();
    $total_s=0;
    $s=1;
      $mahasiswa = $this->get_data_mahasiswa();
      foreach ($mahasiswa as $data_mahasiswa) {
     $data_mahasiswa_arrays['nama_mahasiswa']=$data_mahasiswa['nama_mahasiswa'];

    $index_bobot=0;
    $index_nilai=0;
    $nilai_s=0;
    $data_nilai_id = $this->get_data_nilai_id($data_mahasiswa['id_mahasiswa']);
      foreach ($data_nilai_id as $data_nilai) {

       $data_mahasiswa_arrays['nilai'] = $data_nilai['nilai'];
       $data_mahasiswa_arrays['bobot'] = $bobot_baru[$index_bobot++];
       $pangkat=pow($data_nilai['nilai'],$bobot_baru[$index_nilai++]);
       $data_mahasiswa_arrays['pangkat'] = $pangkat;

           if ($nilai_s!=0) {
             $nilai_s=$nilai_s*$pangkat;
           }else{
             $nilai_s=$pangkat;
           }
         }
         array_push($data_mahasiswa_array,$data_mahasiswa_arrays);

      $total_s=$total_s+$nilai_s;
      }

      return $total_s;
  }

}

 ?>
