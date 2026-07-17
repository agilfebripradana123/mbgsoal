<?php
    if($gambarnya->gambar==null){

    echo 'Gambar Tidak tersedia';
    }else{
    ?>

    <img src="<?=base_url();?>assets/gambar/<?=$gambarnya->gambar;?>" alt="Photo Profil" 
    class="img-thumbnail" width="200px" height="250px">
    <?php
}
?>